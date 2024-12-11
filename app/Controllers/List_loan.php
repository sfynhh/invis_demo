<?php

namespace App\Controllers;

// use App\Models\BBModel

class List_loan extends BaseController
{


    public function index()
    {
        //session()->fullname;
        if (session()->nip_emp==null){
            return redirect()->to(base_url(''));
            }
        $data = [
                'titlePage' => 'Loan Cart',
                'dataRole'=>$this->LM->getByNip(session()->nip_emp)
            
            ];
        return view('partials/navbar', $data);
    }

    public function callDataCart(){

        if (session()->nip_emp==null){
            return redirect()->to(base_url(''));
            }
         
            $dataCart =$this->MLL->GetListLoan();
           
            echo json_encode(array('status' => 'ok;', 'text' => '', 'data' => $dataCart)); 


    }

    public function Add_requested()
    {
       
            if (session()->nip_emp==null){
                return redirect()->to(base_url(''));
                }
            $this->validation->setRules([
                'pic' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'PIC cannot blank',
                    ]
                ],
                'unit' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Unit tidak boleh kosong'
                    ]
                ],
                'contact' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'contact status cannot blank',
                       
                    ]
                ],
                'loanDuration'=>[
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Loan Duration status cannot blank',
                       
                    ]
                ]
    
    
    
            ]);
    
            
    
            $isDataValid = $this->validation->withRequest($this->request)->run();
            if ($isDataValid) {
                
                $detailCart = $this->request->getPost('detailCart');
                $id_loanNew = $this->MLL->id_loan_req_new();
                $dateDuration=explode(" to ", $this->request->getPost('loanDuration'));
                $dataPic=explode("|", $this->request->getPost('pic'));
                // print_r($dateDuration);
                // print_r($dataPic);
            

                $data_loan = array(
                    'id_loan' => $id_loanNew,
                    'nip' => $dataPic[0],
                    'name' => $dataPic[3],
                    'unit' => $this->request->getPost('unit'),
                    'no_telepon' => $this->request->getPost('contact'),
                    'tanggal_pinjam' => date('Y-m-d',strtotime($dateDuration[0])),
                    'tanggal_kembali' => date('Y-m-d',strtotime($dateDuration[1])),
                );

                for ($i = 0; $i < count($detailCart); $i++) {
                    $dataDetail=explode("|", $detailCart[$i]);

                    $this->MLL->Add_loan_detail($id_loanNew, $dataDetail[0], $dataDetail[1]);
                    $this->MLL->Update_unit($dataDetail[1], $dataDetail[0]);
                    $this->MLL->Update_status( $dataDetail[0]);
                }


                if ($this->MLL->Add_loan_req($data_loan)) {

                    echo json_encode(array('status' => 'ok;', 'text' => ''));
                }

              
            } else {
                $validation = $this->validation;
                $error = $validation->getErrors();
                $dataname = $_POST;
                $dataname['detailCart']="detailCart";
                //print_r($error);
                echo json_encode(array('status' => 'error;', 'text' => '', 'data' => $error, 'dataname' => $dataname));
            }

           


            
       
    }

    public function deleteList()
    {
        $id_list = $this->request->getPost('id_list');

        if ($this->MLL->DeleteList($id_list)) {
            $count_list = $this->MLL->countlist();
            session()->set(array('countlist' => $count_list['count_list']));
            echo json_encode(array('status' => 'ok;', 'text' => ''));
        }
    }

    public function Add_ListLoan()
    {

        if (session()->nip_emp==null){
            return redirect()->to(base_url(''));
            }


        $cek_list = $this->MLL->cek_list($this->request->getPost('id_asset'));
        $maxamount = $this->MLL->GetAssetByid($this->request->getPost('id_asset'));
        // print($maxamount);
        // die();
        $this->validation->setRules([
            'amount' => [
                'rules' => 'required|is_natural_no_zero|less_than_equal_to[' . $maxamount['amount_asset'] . ']',
                'errors' => [
                    'required' => 'Amount cannot blank',
                    'is_natural_no_zero' => 'enter amount more than 0',
                    'less_than_equal_to' => 'Amount cannot exceed available unit'
                ]
            ],

        ]);

        $isDataValid = $this->validation->withRequest($this->request)->run();
        if ($isDataValid) {


            $data = array(
                'id_asset_list' => $this->request->getPost('id_asset'),
                'jumlah_unit' => $this->request->getPost('amount'),
                
                'status' => 0
            );

            if (isset($cek_list)) {
                $action = $this->MLL->Up_List_Loan($this->request->getPost('amount'), $cek_list['id_list_loan']);
            } else {
                $action = $this->MLL->Add_List_Loan($data);
            }

            if ($action) {
                // $count_list = $this->MLL->countlist(session()->nip);
                // session()->set(array('countlist' => $count_list['count_list']));
                echo json_encode(array('status' => 'ok;', 'text' => '', 'data' => $data));
            }
        } else {
            $validation = $this->validation;
            $error = $validation->getErrors();
            $dataname = $_POST;
            //print_r($error);
            echo json_encode(array('status' => 'error;', 'text' => '', 'data' => $error, 'dataname' => $dataname));
        }
    }
    
    public function addLoanListbyQr($id){

          if (session()->nip_emp==null){
            return redirect()->to(base_url(''));
            }
            $dataInventaris=$this->MLA->GetListAssetbyID($id);
            // value.amount_asset - value.loan_cart_amount 
            $cekStock=($dataInventaris['amount_asset']-$dataInventaris['loan_cart_amount'])<=0?false:true;
            if ($cekStock){
                $data = array(
                    'id_asset_list' => $id,
                    'jumlah_unit' => 1, 
                    
                    'status' => 0
                );
                $cek_list = $this->MLL->cek_list($id);
                if (isset($cek_list)) {
                    $action = $this->MLL->Up_List_Loan(1, $cek_list['id_list_loan']);
                } else {
                    $action = $this->MLL->Add_List_Loan($data);
                }
                echo json_encode(array('status' => 'ok;', 'text' => '', 'data' => ''));
            }else{
                echo json_encode(array('status' => 'error;', 'text' => '', 'data' => ''));
            }

           

    }



}
