<?php

namespace App\Controllers;

use App\Models\LoginModel;


class Login extends BaseController
{
    protected $validation ;
    protected $session;
    protected $email;
    protected $LM ;
    
    public function __construct()
    {
        // session_start();
         $this->validation =  \Config\Services::validation();
         $this->session = \Config\Services::session();
        $this->email = \Config\Services::email();
       
        $this->LM = new LoginModel();
        if (base_url('')!='http://localhost:8080/'){

           helper('cookie');
           set_cookie('my_cookie', 'nilai_cookie', 3600, '', '', false, true);
        }
        $response = service('response');

        // Tambahkan header HSTS
        $response->setHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->setHeader('X-Frame-Options', 'DENY');
   
    }

    public function index()
    {   

     if (session()->nip_emp!=null){
                return redirect()->to(base_url(''));
        }
        
        echo view('partials/Login/index');
            
        
    }

    public function processLogin()  {
        // echo "eeror";
        // die();
        $this->validation->setRules([

            'username' => [
                'rules' => 'required|alpha_numeric',
                'errors' => [
                    'required' => 'username tidak boleh kosong',
                    'alpha_numeric'=>'username tidak boleh mengandung character khusus'
                ],
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'password tidak boleh kosong',

                ],

            ],

        ]);

        $isDataValid = $this->validation->withRequest($this->request)->run();
      

        if ($isDataValid) {
        

             $dataEmp=array(
                'nip_emp'=> '24010002',
                'name_emp'=>'Sofyan Hadi Hidayat',
                'nik_emp'=>'6715265121r5617235',
                'photo_url'=>'',
                'worklocationname'=>'TUJ',
                'unit_emp'=>'DUKUNGAN TEKNOLOGI INFORMASI KAMPUS JAKARTA',
                'email'=>'SOFYAN@GMAIIL.COM',
                'position'=>'Pegawai',
                'no_tlp'=>'081461216787',
                
             );
           


        
           
             
                $dataEmp['id']=5;
                   
               $dataEmp['type'] =  'superadmin';
                session()->set($dataEmp);
                //print_r(session()->get());
                return redirect()->to(base_url(''));
             
            
        } else {

            $data['validation'] = $this->validation;
            // echo "sukses";
              echo view('partials/login/index', $data);
        }
    }


     public function Logout()
    {
          

        session()->destroy();
        return redirect()->to(base_url(''));
    }

    public function changeRole(){
        if (session()->nip_emp==null){
                return redirect()->to(base_url('Signin'));
            }

        $idRole = $this->request->getPost('idRole');
        $typeRole =$this->request->getPost('typeRole');

        $dataRole =$this->LM->getRoleByid($idRole, $typeRole);

        $dataEmp['type']      = $dataRole['type_role'];
        $dataEmp['unit_emp']  = $dataRole['unit_role_name'];
        $dataEmp['id_role_tetap']=$dataRole['id_role_tetap'];

        session()->set($dataEmp);

        echo json_encode(array('status' => 'ok;', 'text' => ''));

    }

}