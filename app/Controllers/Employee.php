<?php

namespace App\Controllers;

use App\Controllers\BaseController;


class Employee extends BaseController
{

    public function index()
    {
         if (session()->nip_emp==null || session()->type!='superadmin'){
                return redirect()->to(base_url(''));
            }
          $data = [
                'titlePage' => 'Data Employee',
                'dataRole'=>$this->LM->getByNip(session()->nip_emp)
              
            ];
       return view('partials/navbar', $data);
        // print_r(session()->get());
    }

     public function dataJson()
    {
      
            // $periode = $this->request->getPost("periode");
            $lists = $this->EM->get_datatables();
            //print_r($lists);
            $data = [];
            //$no = $this->request->getPost("start");

            foreach ($lists as $val) {
               // $no++;
                $row = [];
                 $row[]=' <button type="button" onclick="modaleMyunit(\''.$val['nip_emp'].'\')" class="btn btn-outline-dark  btn-xs" title="Edit">
                            <i class="fa-solid fa-pencil"></i>
                         </button>
                         <button type="button" onclick="window.open(\''.base_url('login/tes_login_as/'.$val['nik_emp']).'\', \'_blank\')"  class="btn btn-warning  btn-xs" data-title="'.($val['nik_emp']==null?'NIK is Empty':'Login As').'" '.($val['nik_emp']==null?'disabled':'').'>
                           <i class="fa-solid fa-person-through-window"></i>
                         </button>';
                $row[]='<span class="currency">'.$val['nip_emp'].'</span>';
                $row[]='<span class="currency">'.$val['name_emp'].'</span>';
                 $row[]='<span class="currency">'.$val['nik_emp'].'</span>';
                $row[]=' <span>'.$val['unit_emp'].'</span>';
                $row[]=' <span>'.$val['no_tlp'].'</span>';
                $row[]=' <span class="tb-amount">'.$val['email'].' </span>';
               
                
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $this->EM->count_all(),
                "recordsFiltered" => $this->EM->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
 
    }





}