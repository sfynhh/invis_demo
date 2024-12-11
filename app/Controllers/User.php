<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoginModel;
use App\Models\UserModel;

class User extends BaseController
{
  
    protected $validation ;
    protected $session;
    protected $email;
    protected $req ;
    protected $LM ;
    protected $UM ;

    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->req = \Config\Services::request();
        $this->email = \Config\Services::email();
        $this->LM = new LoginModel();
        $this->UM = new UserModel($this->req);
        $response = service('response');

        // Tambahkan header HSTS
        $response->setHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->setHeader('X-Frame-Options', 'DENY');
    }
    public function index()
    {
        if (session()->nip_emp==null || (session()->type!='superadmin' && session()->type!='admin prodi')){
                return redirect()->to(base_url(''));
            }
          $data = [
                'titlePage' => 'User Admin',
                'dataRole'=>$this->LM->getByNip(session()->nip_emp)
              
            ];
       return view('partials/navbar', $data);
       
    }

     public function dataJson()
    {
      
            // $periode = $this->request->getPost("periode");
            $lists = $this->UM->get_datatables();
            //print_r($lists);
            $data = [];
            //$no = $this->request->getPost("start");

            foreach ($lists as $val) {
               // $no++;
                $row = [];
            
                $row[]='<span class="currency">'.$val['nip_emp'].'</span>';
                $row[]='<span class="currency">'.$val['name_emp'].'</span>';
                $row[]=' <span>'.$val['type'].'</span>';
                $btn='<button type="button" onclick="deletedata(\''.$val['Admin_name'].'|'.$val['type'].'\')" class="btn btn-outline-danger  btn-xs" title="Delete">
                     <i class="fa-solid fa-trash"></i>
                      </button>';
                if ($val['type']=='superadmin'){
                    $btn='';
                    if (session()->type=='superadmin'){
                        $btn='<button type="button" onclick="deletedata(\''.$val['Admin_name'].'|'.$val['type'].'\')" class="btn btn-outline-danger  btn-xs" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                        </button>';
                    }
                }
                  
                     $row[]=$btn;
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $this->UM->count_all(),
                "recordsFiltered" => $this->UM->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
 
    }

  public function simpanData()
    {
          if (session()->nip_emp==null){
                return redirect()->to(base_url('Siak/Signin'));
            }

       
        $this->validation->setRules([
               'nip' => [
                    'label' => 'Nama Admin',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                
                'userType' => [
                    'label' => 'Type',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],

                
            ]);

        $isDataValid = $this->validation->withRequest($this->request)->run();


        if (!$isDataValid) {
            // dd('fail');
              $validation = $this->validation;
            $error=$validation->getErrors();
           
            $dataname=$_POST;
                  
            echo json_encode(array('status' => 'error;', 'text' => '', 'data'=>$error,'dataname'=>$dataname));
        }else {
              $adminName  = $this->request->getPost('nip');
                $userType   = $this->request->getPost('userType');
 
            $this->UM->createUser(array(
                'type'      => $userType,
                'Admin_name'=> $adminName,
            ));
            $callback=json_encode(array('status' => 'ok;', 'text' => ''));
            echo $callback;
        }
    }

    public function deleteUser()
    {

         if (session()->id==null){
            return false;
        }
     
        $id = explode('|',$this->request->getPost('id')) ;
        $this->LM->deleteUser($id);

        echo json_encode(array('status' => 'ok;', 'text' => ''));

    }


     public function getPgwId()
    {
        $s = $this->request->getPost('searchTerm');
        $dbs = $this->UM->getNip($s);

        $result = array();
        foreach ($dbs as $db)
            $result[] = array(
                'id' => $db->id_emp,
                'text' => $db->name_emp.'( '.$db->nip_emp.')'
            );

        echo json_encode($result);
    }

    public function getNipNim()
    {
        $s = $this->request->getPost('searchTerm');
        $dbs = $this->UM->getNipNim($s);

        $result = array();
        foreach ($dbs as $db)
            $result[] = array(
                'id' => $db->nip_nim.'|'.$db->unit.'|'.$db->phone.'|'.$db->fullname,
                'text' => $db->fullname.' - '.$db->status.' ( '.$db->nip_nim.')'
            );

        echo json_encode($result);
    } 
}