<?php
namespace App\Controllers;


class Loan_status extends BaseController
{


    public function index()
	{  
       
        if (session()->nip_emp==null){
            return redirect()->to(base_url(''));
            }
        $data = [
                'titlePage' => 'List Inventaris',
                'dataRole'=>$this->LM->getByNip(session()->nip_emp)
            
            ];
        return view('partials/navbar', $data);
	}

    public function dataJson()
    {
      
        if (session()->nip_emp==null){
            return redirect()->to(base_url(''));
            }

            // $periode = $this->request->getPost("periode");
            $lists = $this->MLR->get_datatables();
            //print_r($lists);
            $data = [];
            //$no = $this->request->getPost("start");

            foreach ($lists as $val) {
               // $no++;
                $row = [];
                $btn='
                         <button type="button" onclick="endedLoan(\''.$val['id_loan'].'\')" class="btn btn-outline-'.(($val['status']==0)?'success':'dark').' btn-xs" title="Edit" '.(($val['status']==0)?'':'disabled').'>
                           <i class="fa-solid fa-right-to-bracket"></i>
                         </button>';
                
                  
                $row[]=$btn;
            
                $row[]=$val['id_loan'];
                $row[]=$val['name'];
                $row[]=$val['unit'];
                $row[]= date('d M Y', strtotime($val['tanggal_pinjam']));
                $row[]= date('d M Y', strtotime($val['tanggal_kembali']));
                $getDetailLoan = $this->MLR->GetDetailLoan($val['id_loan']);
                 $li ='';
                 foreach ($getDetailLoan as $value) {
                    $li .='<li>'.$value['asset_name'].'</li>';
                 }
                $row[]='<ul>'.$li.'
                        </ul>
                        ';
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $this->MLR->count_all(),
                "recordsFiltered" => $this->MLR->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
 
    }


    public function Accept_asset(){
         $id = $this->request->getPost('id');
          
        $detail_loan=$this->MLR->GetDetailByidloan($id);
        //print_r($detail_loan);
        foreach ($detail_loan as $dl) {
            $this->MLL->Update_unit_plus($dl['jumlah_unit_loan'], $dl['id_asset_loan']);
        }

        if($this->MLR->Edit_Loan(array('tanggal_masuk'=>date("Y-m-d"), 'status'=>1), $id)){
        echo json_encode(array('status' => 'ok;', 'text' => ''));
        }
    }

}