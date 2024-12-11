<?php

namespace App\Controllers;
// use App\Models\CategoryDocModel;

class Home extends BaseController
{
   
    public function index()
    {
          if (session()->nip_emp==null){
                return redirect()->to(base_url('Signin'));
            }
            //print_r(session()->get());
              $data = [
                'titlePage' => 'Dashboards',
                'dataRole'=>$this->LM->getByNip(session()->nip_emp)
              
            ];
       return view('partials/navbar', $data);
    }

    public function contentHome()
    {
        if (session()->nip_emp==null){
                return redirect()->to(base_url('Signin'));
            }
            
        $routes = $this->request->getPost('routes');
         $contenView='<div style="padding-top:250px;">under development</div>';
        if ($routes=='/' || $routes==''){
              $data = [
                'titlePage' => 'Dashboards',
                // 'dataSum'=>$this->CDM->GetSumarryDashboard(),
            ];
             $contenView=view('main/dashboard/index_spa', $data);
        }else if($routes=='UserAdmin'){
            $data = [
                   'titlePage' => 'User Admin',
               ];
           $_SERVER['REQUEST_URI']=='/UserAdmin';
           $contenView=view('main/user_new/index_spa', $data);
       }else if($routes=='listInventaris'){
            $data = [
                'titlePage' => 'List Inventaris',
            ];
        $_SERVER['REQUEST_URI']=='/listInventaris';
        $contenView=view('main/list_inventaris/index_spa', $data);
       }else if($routes=='loanCart'){
            $data = [
                'titlePage' => 'Loan Cart',
            ];
        $_SERVER['REQUEST_URI']=='/loanCart';
        $contenView=view('main/loan_cart/index_spa', $data);
       }else if($routes=='LoanProcess'){
                $data = [
                    'titlePage' => 'Loan Process',
                ];
            $_SERVER['REQUEST_URI']=='/LoanProcess';
            $contenView=view('main/loan_process/index_spa', $data);
       }else if($routes=='DataEmployee'){
                $data = [
                    'titlePage' => 'Data Employee',
                ];
            $_SERVER['REQUEST_URI']=='/DataEmployee';
            $contenView=view('main/dataemployee/index_spa', $data);
        }

       

       echo json_encode(array('status' => 'ok;', 'text' => '', 'contentView'=>$contenView));
    }

    public function modalMyunit()
    {
        if (session()->nip_emp==null){
            return false;
        }

      $dataDocs=$this->LM->getAllData();
      $dataEmp=$this->EM->getByNip($this->request->getPost('id'));

       echo json_encode(array('status' => 'ok;', 'data'=>$dataDocs, 'dataEmp'=>$dataEmp));
    }

      public function updateMyunit()
    {
    
   
      if (session()->nip_emp==null){
            return false;
        }

        $this->validation->setRules([
                'Myunit' =>
                [
                    'label'  => 'Unit',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => ' {field} mohon diisi',
                    ],
                ],
                
            ]);
       $isDataValid = $this->validation->withRequest($this->request)->run();


       if ($isDataValid) {
        $dataDetail = array(
                'unit_role_name'                => $this->request->getPost('Myunit'),

        );

        $dataCommon = array(
                'unit_emp'                => $this->request->getPost('Myunit'),

        );
        
         $this->LM->updateDataUnit($dataCommon,  $dataDetail, $this->request->getPost('nip_emp'));
    
        $callback=json_encode(array('status' => 'ok;', 'text' => ''));
         

        echo $callback;
        } else {
            $validation = $this->validation;
            $error=$validation->getErrors();
            $dataname=$_POST;
                  //print_r($error);
            echo json_encode(array('status' => 'error;', 'text' => '', 'data'=>$error,'dataname'=>$dataname));
        }
    
     }

     public function show_asset()
     {
         $data = $this->MLA->GetShowAsset($this->request->getPost('search'));
        //  print_r($data);
        //  die();
         if ($this->MLA->GetListAsset()) {
             echo json_encode(array('status' => 'ok;', 'text' => '', 'data' => $data));
         }
     }

     public function tescanQR(){
        echo view("tesqr");
     }

     
 

}
