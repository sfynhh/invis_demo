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
        
        echo view('partials/login/index');
            
        
    }

    public function processLogin()  {
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
        $acc      =  array('username' => $this->request->getPost('username', FILTER_SANITIZE_STRING),'password' => $this->request->getPost('password', FILTER_SANITIZE_STRING));
        $getToken = GetToken($acc);
        $cekErrorApi=true;
        if (isset($getToken->token)){
            $cekusername = true;
            $cekpasword = true;
         

        }else{
            if (isset($getToken->message)){

               
                if (strpos($getToken->message, "password") !== false) {
                
                    $cekpasword=false;
                    $cekusername=null;
                } else {
                    $cekusername = false;
                    $cekpasword=null;
                
                }
            }else{
                $cekusername = null;
                    $cekpasword=null;
                    $cekErrorApi=false;
            }
        }
        
        $checkTUJ=null;
        if($cekusername && $cekpasword && $cekErrorApi){
            $profile  = GetProfile($getToken->token);
            $position = GetPosition($profile->identitynumber, $getToken->token );
            $contact  = GetContact($profile->identitynumber, $getToken->token );
            
            if(strpos($position[0]->positionname, "JAKARTA") !== false || $position[0]->positionname==null){
                $checkAuth=true; 

            }else{
                $checkAuth=false;
                $checkTUJ=false;
            }
        }else{
             $checkAuth=false;
        }

        if ($isDataValid && $checkAuth) {
            $profile  = GetProfile($getToken->token);
            $position = GetPosition($profile->identitynumber, $getToken->token );
            $contact  = GetContact($profile->identitynumber, $getToken->token );
            $email ='';
             $wa ='';
              $phone ='';
            foreach ($contact as $value) {
                if ($value->id_contacttype==8 ){
                  $wa = $value->account_value;
                }else if($value->id_contacttype==11 ){
                  $phone = $value->account_value;
                }else if ($value->id_contacttype==1 ){
                    if (strpos($value->account_value, "@gmail.com") !== false){
                        $email=$value->account_value;
                    }else{
                        $email=$profile->user.'@telkomuniversity.ac.id';
                    }
                }
            }



           

            if ($position[0]->stucturalpositionname==null){
                $jumlahrole=1;
                 if ($position[0]->worklocationparent==null){
                        $unitEmp=$position[0]->worklocationname;
                    }else{
                        $unitEmp=$position[0]->worklocationparent;
                    }
                }else{
                 $jumlahrole=2;
                      if($position[0]->structuralworklocationparent==null){
                        $unitEmp=$position[0]->structuralworklocationname;
                     }else{
                        $unitEmp=$position[0]->structuralworklocationparent;
                     }
                }

             $dataEmp=array(
                'nip_emp'=> $profile->numberid,
                'name_emp'=>$profile->fullname,
                'nik_emp'=>$profile->identitynumber,
                'photo_url'=>$profile->photo,
                'worklocation_name'=>$position[0]->worklocationname,
                'unit_emp'=>$unitEmp,
                'email'=>$email,
                'position'=>'Pegawai',
                'no_tlp'=>isset($wa)?$wa:$phone,
                
             );
           

             $checkData=$this->LM->Chekdata($profile->numberid);
             if(count($checkData)==0){
                $this->LM->addEmployee($dataEmp);
                
             }else{
                 $getDataPgw=$this->LM->getDataEmpByNip($profile->numberid);
                if($position[0]->employmentstatusname!='MAGANG' || !isset($getDataPgw['unit_emp']) ){
                  $this->LM->updateEmployee($dataEmp,$profile->numberid );  
                }

             }

             if ($jumlahrole==2){
                if(strpos($position[0]->stucturalpositionname, 'KETUA PROGRAM')!==false){
                    $dataRole = [
                                [   
                                    'id_role_tetap' => $profile->numberid.'-1',
                                    'nip_pgw_role' => $profile->numberid,
                                    'unit_role_name'  => $position[0]->structuralworklocationname,
                                    'type_role'  => 'kaprodi',
                                ]
                            ];
                }else{

                $dataRole = [
                                [   
                                     'id_role_tetap' => $profile->numberid.'-1',
                                    'nip_pgw_role' => $profile->numberid,
                                    'unit_role_name'  => $position[0]->structuralworklocationparent==null?$position[0]->structuralworklocationname:$position[0]->structuralworklocationparent,
                                    'type_role'  => (strpos($position[0]->stucturalpositionname, 'KEPALA BAGIAN')!==false)?'kepala bagian':'staff',
                                ],
                                [
                                     'id_role_tetap' => $profile->numberid.'-2',
                                    'nip_pgw_role' => $profile->numberid,
                                    'unit_role_name'  => $position[0]->worklocationparent==null? $position[0]->worklocationname : $position[0]->worklocationparent,
                                    'type_role'  => 'dosen',
                                ],
                            ];
                }
        

             }else{

                if (strpos($position[0]->positionname, 'KEPALA BAGIAN')!==false){
                    $type_role='kepala bagian';
                 }else if(strpos($position[0]->positionname, 'DOSEN')!==false){
                     $type_role='dosen';
                 }else{
                     $type_role='staff';
                 }
                 
                 $getDataPgw=$this->LM->getDataEmpByNip($profile->numberid);
                 $dataRole = [
                            [
                                'id_role_tetap' => $profile->numberid.'-1',
                                'nip_pgw_role' => $profile->numberid,
                                'unit_role_name'  => $getDataPgw['unit_emp'],
                                'type_role'  => $type_role
                            ],
                        ];
             }


             $getDataPgw=$this->LM->getDataEmpByNip($profile->numberid);
             $checkDataAdmin=$this->LM->getDataAdminByIdEmp($getDataPgw['id']);

                if ($position[0]->employmentstatusname!='MAGANG' || isset($getDataPgw['unit_emp'])){
                    $this->LM->deleteRole($profile->numberid);
                    $this->LM->addRole($dataRole);
                }
             

             $dataEmp['unit_emp']=$position[0]->employmentstatusname!='MAGANG' ?$dataRole[0]['unit_role_name']:$getDataPgw['unit_emp'];
             $dataEmp['id_role_tetap']=$dataRole[0]['id_role_tetap'];
             if(count($checkDataAdmin)==0){
                $dataEmp['type'] = $dataRole[0]['type_role'];
             }else{
                $dataEmp['type'] =  $checkDataAdmin[0]['type'];
             }

             if ($dataEmp['type'] == 'superadmin'){
                    $dataEmp['token']=$getToken->token;
             }
             
             if (count($checkDataAdmin)!=0){
              $dataEmp['id']=$checkDataAdmin[0]['id'];
             }
             $dataEmp['status_pgw']=$position[0]->employmentstatusname;
             session()->set($dataEmp);
            //print_r(session()->get());
            return redirect()->to(base_url(''));
        } else {

            $data['validation'] = $this->validation;
            $data['cekusername'] = $cekusername;
            $data['cekerrorapi']=$cekErrorApi;
            $data['cekpasword'] = $cekpasword;
            $data['checkTUJ'] = $checkTUJ;
            //print_r($data['validation']->getErrors());
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

    public function tes_login_as($nip)
    {
        if (session()->nip_emp==null || session()->type!='superadmin'){
                return redirect()->to(base_url(''));
            }
            
            // $acc      =  array('username' => 'sofyanhadihidayat','password' => 'Hady@2024');
            // $getToken = GetToken($acc);

     
           
                $profile  = GetProfile(session()->token);
                $position = GetPosition($nip,session()->token );
                $contact  = GetContact($nip,session()->token);
                $email ='';
                 $wa ='';
                  $phone ='';
                foreach ($contact as $value) {
                    if ($value->id_contacttype==8 ){
                      $wa = $value->account_value;
                    }else if($value->id_contacttype==11 ){
                      $phone = $value->account_value;
                    }else if ($value->id_contacttype==1 ){
                        if (strpos($value->account_value, "@gmail.com") !== false){
                            $email=$value->account_value;
                        }else{
                            $email=$profile->user.'@telkomuniversity.ac.id';
                        }
                    }
                }

                if ($position[0]->stucturalpositionname==null){
                    $jumlahrole=1;
                     if ($position[0]->worklocationparent==null){
                            $unitEmp=$position[0]->worklocationname;
                        }else{
                            $unitEmp=$position[0]->worklocationparent;
                        }
                    }else{
                     $jumlahrole=2;
                     if($position[0]->structuralworklocationparent==null){
                        $unitEmp=$position[0]->structuralworklocationname;
                     }else{
                        $unitEmp=$position[0]->structuralworklocationparent;
                     }
                      
                    }

                 $dataEmp=array(
                    'nip_emp'=> $position[0]->employeeidentifynumber,
                    'name_emp'=>$position[0]->fullname,
                    'unit_emp'=>$unitEmp,
                    'email'=>$email,
                    'photo_url'=>$position[0]->photourl,
                    'position'=>'Pegawai',
                    'no_tlp'=>isset($wa)?$wa:$phone,
                    
                 );
               

                 // $checkData=$this->LM->Chekdata($profile->numberid);
                 // if(count($checkData)==0){
                 //    $this->LM->addEmployee($dataEmp);
                    
                 // }else{
                 //     $getDataPgw=$this->LM->getDataEmpByNip($profile->numberid);
                 //    if($position[0]->employmentstatusname!='MAGANG' || !isset($getDataPgw['unit_emp']) ){
                 //      $this->LM->updateEmployee($dataEmp,$profile->numberid );  
                 //    }

                 // }

                 if ($jumlahrole==2){
                    if(strpos($position[0]->stucturalpositionname, 'KETUA PROGRAM')!==false){
                        $dataRole = [
                                    [   
                                        'id_role_tetap' => $position[0]->employeeidentifynumber.'-1',
                                        'nip_pgw_role' => $position[0]->employeeidentifynumber,
                                        'unit_role_name'  => $position[0]->structuralworklocationname,
                                        'type_role'  => 'kaprodi',
                                    ]
                                ];
                    }else{

                    $dataRole = [
                                    [   
                                         'id_role_tetap' => $position[0]->employeeidentifynumber.'-1',
                                        'nip_pgw_role' => $position[0]->employeeidentifynumber,
                                        'unit_role_name'  => $position[0]->structuralworklocationparent==null?$position[0]->structuralworklocationname:$position[0]->structuralworklocationparent,
                                        'type_role'  => (strpos($position[0]->stucturalpositionname, 'KEPALA BAGIAN')!==false)?'kepala bagian':'staff',
                                    ],
                                    [
                                         'id_role_tetap' => $position[0]->employeeidentifynumber.'-2',
                                        'nip_pgw_role' => $position[0]->employeeidentifynumber,
                                        'unit_role_name'  => $position[0]->worklocationparent==null? $position[0]->worklocationname : $position[0]->worklocationparent,
                                        'type_role'  => 'dosen',
                                    ],
                                ];
                    }
            

                 }else{
                     if (strpos($position[0]->positionname, 'KEPALA BAGIAN')!==false){
                        $type_role='kepala bagian';
                     }else if(strpos($position[0]->positionname, 'DOSEN')!==false){
                         $type_role='dosen';
                     }else{
                         $type_role='staff';
                     }
                     $getDataPgw=$this->LM->getDataEmpByNip($position[0]->employeeidentifynumber);
                    
                     $dataRole = [
                                [
                                    'id_role_tetap' => $position[0]->employeeidentifynumber.'-1',
                                    'nip_pgw_role' => $position[0]->employeeidentifynumber,
                                    'unit_role_name'  => $getDataPgw['unit_emp'],
                                    'type_role'  => $type_role
                                ],
                            ];
                 }


                 $getDataPgw=$this->LM->getDataEmpByNip($position[0]->employeeidentifynumber);

                 $checkDataAdmin=$this->LM->getDataAdminByIdEmp($getDataPgw['id']);

                //  $this->LM->deleteRole($position[0]->employeeidentifynumber);
                //  $this->LM->addRole($dataRole);

                 $dataEmp['unit_emp']=$dataRole[0]['unit_role_name'];
                 $dataEmp['id_role_tetap']=$dataRole[0]['id_role_tetap'];
                 if(count($checkDataAdmin)==0){
                    $dataEmp['type'] = $dataRole[0]['type_role'];
                 }else{
                    $dataEmp['type'] =  $checkDataAdmin[0]['type'];
                 }
                 
                 if (count($checkDataAdmin)!=0){
                  $dataEmp['id']=$checkDataAdmin[0]['id'];
                 }
                 $dataEmp['status_pgw']=$position[0]->employmentstatusname;
                 session()->set($dataEmp);
                //print_r(session()->get());
                return redirect()->to(base_url(''));
       
    }


    public function redirect(){
        $token=$_GET['token'];
        $profile  = GetProfile($token);
        $position = GetPosition($profile->identitynumber, $token );
        $contact  = GetContact($profile->identitynumber, $token );
                
        if(strpos($position[0]->positionname, "JAKARTA") !== false || $position[0]->positionname==null){
               
                $email ='';
                 $wa ='';
                  $phone ='';
                foreach ($contact as $value) {
                    if ($value->id_contacttype==8 ){
                      $wa = $value->account_value;
                    }else if($value->id_contacttype==11 ){
                      $phone = $value->account_value;
                    }else if ($value->id_contacttype==1 ){
                        if (strpos($value->account_value, "@gmail.com") !== false){
                            $email=$value->account_value;
                        }else{
                            $email=$profile->user.'@telkomuniversity.ac.id';
                        }
                    }
                }


                if ($position[0]->stucturalpositionname==null){
                    $jumlahrole=1;
                     if ($position[0]->worklocationparent==null){
                            $unitEmp=$position[0]->worklocationname;
                        }else{
                            $unitEmp=$position[0]->worklocationparent;
                        }
                    }else{
                     $jumlahrole=2;
                          if($position[0]->structuralworklocationparent==null){
                            $unitEmp=$position[0]->structuralworklocationname;
                         }else{
                            $unitEmp=$position[0]->structuralworklocationparent;
                         }
                    }

                 $dataEmp=array(
                    'nip_emp'=> $profile->numberid,
                    'name_emp'=>$profile->fullname,
                    'nik_emp'=>$profile->identitynumber,
                    'photo_url'=>$profile->photo,
                    'worklocation_name'=>$position[0]->worklocationname,
                    'unit_emp'=>$unitEmp,
                    'email'=>$email,
                    'position'=>'Pegawai',
                    'no_tlp'=>isset($wa)?$wa:$phone,
                    
                 );
               

                 $checkData=$this->LM->Chekdata($profile->numberid);
                 if(count($checkData)==0){
                    $this->LM->addEmployee($dataEmp);
                    
                 }else{
                     $getDataPgw=$this->LM->getDataEmpByNip($profile->numberid);
                    if($position[0]->employmentstatusname!='MAGANG' || !isset($getDataPgw['unit_emp']) ){
                      $this->LM->updateEmployee($dataEmp,$profile->numberid );  
                    }

                 }

                 if ($jumlahrole==2){
                    if(strpos($position[0]->stucturalpositionname, 'KETUA PROGRAM')!==false){
                        $dataRole = [
                                    [   
                                        'id_role_tetap' => $profile->numberid.'-1',
                                        'nip_pgw_role' => $profile->numberid,
                                        'unit_role_name'  => $position[0]->structuralworklocationname,
                                        'type_role'  => 'kaprodi',
                                    ]
                                ];
                    }else{

                    $dataRole = [
                                    [   
                                         'id_role_tetap' => $profile->numberid.'-1',
                                        'nip_pgw_role' => $profile->numberid,
                                        'unit_role_name'  => $position[0]->structuralworklocationparent==null?$position[0]->structuralworklocationname:$position[0]->structuralworklocationparent,
                                        'type_role'  => (strpos($position[0]->stucturalpositionname, 'KEPALA BAGIAN')!==false)?'kepala bagian':'staff',
                                    ],
                                    [
                                         'id_role_tetap' => $profile->numberid.'-2',
                                        'nip_pgw_role' => $profile->numberid,
                                        'unit_role_name'  => $position[0]->worklocationparent==null? $position[0]->worklocationname : $position[0]->worklocationparent,
                                        'type_role'  => 'dosen',
                                    ],
                                ];
                    }
            

                 }else{

                    if (strpos($position[0]->positionname, 'KEPALA BAGIAN')!==false){
                        $type_role='kepala bagian';
                     }else if(strpos($position[0]->positionname, 'DOSEN')!==false){
                         $type_role='dosen';
                     }else{
                         $type_role='staff';
                     }

                     $dataRole = [
                                [
                                    'id_role_tetap' => $profile->numberid.'-1',
                                    'nip_pgw_role' => $profile->numberid,
                                    'unit_role_name'  => $position[0]->worklocationparent==null? $position[0]->worklocationname : $position[0]->worklocationparent,
                                    'type_role'  => $type_role
                                ],
                            ];
                 }


                 $getDataPgw=$this->LM->getDataEmpByNip($profile->numberid);
                 $checkDataAdmin=$this->LM->getDataAdminByIdEmp($getDataPgw['id']);

                    if ($position[0]->employmentstatusname!='MAGANG' || isset($getDataPgw['unit_emp'])){
                        $this->LM->deleteRole($profile->numberid);
                        $this->LM->addRole($dataRole);
                    }
                 

                 $dataEmp['unit_emp']=$position[0]->employmentstatusname!='MAGANG' ?$dataRole[0]['unit_role_name']:$getDataPgw['unit_emp'];
                 $dataEmp['id_role_tetap']=$dataRole[0]['id_role_tetap'];
                 if(count($checkDataAdmin)==0){
                    $dataEmp['type'] = $dataRole[0]['type_role'];
                 }else{
                    $dataEmp['type'] =  $checkDataAdmin[0]['type'];
                 }
                 
                 if (count($checkDataAdmin)!=0){
                  $dataEmp['id']=$checkDataAdmin[0]['id'];
                 }
                 $dataEmp['status_pgw']=$position[0]->employmentstatusname;
                 session()->set($dataEmp);
                //print_r(session()->get());
                return redirect()->to(base_url(''));

        }

    }

}