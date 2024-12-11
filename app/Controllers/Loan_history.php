<?php
namespace App\Controllers;

// use App\Models\BBModel
 use App\Models\M_Loan_Req;
 use App\Models\M_List_Loan;
class Loan_history extends BaseController
{

	public function __construct()
    {
        // session_start();
       $this->validation =  \Config\Services::validation();
        $this->MLR = new M_Loan_Req();
         $this->MLL = new M_List_Loan();
   
    }

    public function index()
	{  
       
        $data =[
            'titletab'=>'LOAN TEL-U JAKARTA',
            'activehistory'=>'active-custom',
            'content'=>'Peminjam/loan_history',
            // 'content'=>'riwayat_penggajian/home',
             'datacontent'      => [
                        'data_loan'=>$this->MLR->GetLoanHistory(),
                        'detail_loan'=>$this->MLR->GetDetailLoan()
                ]
            ];
       //print_r($data['datacontent']['dataperdepartemen']);
           //echo $kolom;

        // if(in_groups('customer')){
        //     redirect->to('')
        // }
       
        echo view('headnav', $data);
	}

}