<?php

namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class M_Loan_Req extends Model
{

    protected $table      = 'loan';
    protected $column_order = array(null,null,null, null, null, null);
    protected $column_search = array('asset_name');
    protected $order = array('' => '');
    protected $request;
    protected $db;
    protected $dt;
    // protected $allowedFields = ['id_jabatan', 'id_departemen','nama_jabatan'];


    function __construct(RequestInterface $request)
    {
        parent::__construct();
        // $this->db = db_connect();
        $this->request = $request;
 
        $this->dt = $this->db->table($this->table);
    }
    private function _get_datatables_query()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }
 
        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }
    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1){
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        }
            // $this->dt->where('status', 0);
            $this->dt->orderBy('status', 'ASC');
            $this->dt->orderBy('tanggal_kembali', 'DESC');
       
        $query = $this->dt->get();
      
        return $query->getResultArray();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();

        $this->dt->orderBy('status', 'ASC');
        $this->dt->orderBy('tanggal_kembali', 'DESC');

        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        $tbl_storage = $this->db->table($this->table);
        // $tbl_storage->where('status', 0);

        return $tbl_storage->countAllResults();
    }

    public function GetLoan()
    {   $builder = $this->db->table($this->table);
        $builder->where('status', 0);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function GetLoanHistory()
    {   $builder = $this->db->table($this->table);
        $builder->where('status', 1);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function GetDetailLoan($id_loan)
    {   $builder = $this->db->table('detail_loan');
        $builder->join('ms_asset', 'detail_loan.id_asset_loan=ms_asset.id_asset');
        $builder->where('id_loan_detail', $id_loan);
        $query = $builder->get();
        return $query->getResultArray();    
    }

    public function GetDetailByidloan($id)
    {   $builder = $this->db->table('detail_loan');
        $builder->where('id_loan_detail', $id);
        $query = $builder->get();
        return $query->getResultArray();
    }

    

    // public function cek_list($id_asset,$nip)
    // {   $builder = $this->db->table($this->table);
    //     $builder->join('ms_asset', 'ms_asset.id_asset=list_loan.id_asset_list');
    //     $builder->where('nip_peminjam', $nip);
    //     $builder->where('id_asset_list', $id_asset);
    //     $builder->where('status', 0);
    //     $query = $builder->get();
    //     return $query->getRowArray();
    // }

    // public function countlist($nip){
    //     $sql ='SELECT count(*) as count_list from list_loan WHERE nip_peminjam=? and status=0';
    //     return $this->db->query($sql, array($nip))->getRowArray();
    // }


    // public function id_loan_req_new()
    // {
    //     $builder = $this->db->table('loan');
    //     $builder->selectMax('id_loan', 'hsl');
    //     $query = $builder->get()->getResult();
    //     foreach ($query as $data) :
    //         $jml_data = $data->hsl;
    //     endforeach;
    //     if (isset($jml_data)){
    //        $id_asset = 'LR';
    //         $code = substr($jml_data, 2);
    //         $id_asset = $id_asset . ((int)$code+1) ;  
    //     }else{

    //         $id_asset = 'LR1';  
    //     }
        
    //     return $id_asset;
    // }

     public function Edit_Loan($data, $id)
    {
        $query = $this->db->table($this->table)->update($data, array('id_loan' => $id));
        return $query;
    }

    // public function Up_List_Loan($data, $id)
    // {
    //     $query = $this->db->table($this->table)->set('jumlah_unit', 'jumlah_unit+'.$data,false)->where('id_list_loan', $id)->update();
    //     return $query;
    // }

    //   public function Update_unit($data, $id)
    // {
    //     $query = $this->db->table('ms_asset')->set('amount_asset', 'amount_asset-'.$data,false)->where('id_asset', $id)->update();
    //     return $query;
    // }

    //   public function Update_status($nip, $id_asset)
    // {
    //     $query = $this->db->table('list_loan')->update(Array('status'=>1), array('nip_peminjam' => $nip, 'status'=>0, 'id_asset_list'=>$id_asset));
    //     return $query;
    // }


    // public function Add_loan_req($data)
    // {
    //     $query = $this->db->table('loan')->insert($data);
    //     return $query;
    // }

    //  public function Add_loan_detail($id_loan, $id_asset, $jumlah)
    // {
    //     $query = $this->db->table('detail_loan')->insert(Array('id_loan_detail'=>$id_loan,'id_asset_loan'=>$id_asset, 'jumlah_unit_loan'=> $jumlah));
    //     return $query;
    // }

    // public function deleteList($id)
    // {
    //     $query = $this->db->table($this->table)->delete(array('id_list_loan' => $id));
    //     return 
 }
