<?php

namespace App\Models;

use CodeIgniter\Model;

class M_List_Loan extends Model
{
    protected $table      = 'list_loan';
    protected $primaryKey = 'id_list_loan';
    // protected $allowedFields = ['id_jabatan', 'id_departemen','nama_jabatan'];

    public function GetListLoan()
    {
        $builder = $this->db->table($this->table);
        $builder->join('ms_asset', 'ms_asset.id_asset=list_loan.id_asset_list');
        $builder->where('status', 0);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function GetAssetByid($id)
    {
        $builder = $this->db->table('ms_asset');
        $builder->where('id_asset', $id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function cek_list($id_asset)
    {
        $builder = $this->db->table($this->table);
        $builder->join('ms_asset', 'ms_asset.id_asset=list_loan.id_asset_list');
        $builder->where('id_asset_list', $id_asset);
        $builder->where('status', 0);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function countlist()
    {
        $sql = 'SELECT count(*) as count_list from list_loan WHERE status=0';
        return $this->db->query($sql)->getRowArray();
    }


    public function id_loan_req_new()
    {
        $sql="SELECT substr(l.id_loan, 3) as max_id FROM loan l ORDER by id_loan desc;";
        $run = $this->db->query($sql)->getResultArray();
        // print_r($run);
        if(count($run)>0){
        $id_max=max($run);

        $newidmax=$id_max['max_id']+1;
        }else{

        $newidmax=1;
        }
        

        $newid='LR'.$newidmax;
        return $newid;
    }

    public function Add_List_Loan($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query;
    }

    public function Up_List_Loan($data, $id)
    {
        $query = $this->db->table($this->table)->set('jumlah_unit', 'jumlah_unit+' . $data, false)->where('id_list_loan', $id)->update();
        return $query;
    }

    public function Update_unit($data, $id)
    {
        $query = $this->db->table('ms_asset')->set('amount_asset', 'amount_asset-' . $data, false)->where('id_asset', $id)->update();
        return $query;
    }

    public function Update_unit_plus($data, $id)
    {
        $query = $this->db->table('ms_asset')->set('amount_asset', 'amount_asset+' . $data, false)->where('id_asset', $id)->update();
        return $query;
    }


    public function Update_status($id_asset)
    {
        $query = $this->db->table('list_loan')->update(array('status' => 1), array('status' => 0, 'id_asset_list' => $id_asset));
        return $query;
    }


    public function Add_loan_req($data)
    {
        $query = $this->db->table('loan')->insert($data);
        return $query;
    }

    public function Add_loan_detail($id_loan, $id_asset, $jumlah)
    {
        $query = $this->db->table('detail_loan')->insert(array('id_loan_detail' => $id_loan, 'id_asset_loan' => $id_asset, 'jumlah_unit_loan' => $jumlah));
        return $query;
    }

    public function deleteList($id)
    {
        $query = $this->db->table($this->table)->delete(array('id_list_loan' => $id));
        return $query;
    }
}
