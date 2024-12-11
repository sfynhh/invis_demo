<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class M_List_asset extends Model
{
    protected $table      = 'ms_asset';
    protected $column_order = array(null,null,null, null, null, null);
    protected $column_search = array('asset_name');
    protected $order = array('' => '');
    protected $request;
    protected $db;
    protected $dt;

    public function GetListAsset()
    {   $builder = $this->db->table($this->table);
        $builder->select($this->table.'.*, (SELECT SUM(ll.jumlah_unit) FROM list_loan ll WHERE ll.id_asset_list=ms_asset.id_asset and ll.status=0) as loan_cart_amount');
        $query = $builder->get();
        return $query->getResultArray();
    }


    public function GetListAssetbyID($id)
    {   $builder = $this->db->table($this->table);
        $builder->select($this->table.'.*, (SELECT SUM(ll.jumlah_unit) FROM list_loan ll WHERE ll.id_asset_list=ms_asset.id_asset and ll.status=0) as loan_cart_amount');
        $builder->where('ms_asset.id_asset', $id);
        $query = $builder->get();
        return $query->getRowArray();
    }

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
            $this->dt->orderBy('asset_name', 'ASC');
       
        $query = $this->dt->get();
      
        return $query->getResultArray();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();

            
            $this->dt->orderBy('asset_name', 'ASC');

        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        $tbl_storage = $this->db->table($this->table);

        return $tbl_storage->countAllResults();
    }

    public function GetShowAsset($param)
    {   
        if($param=='all'){
            $builder = $this->db->table($this->table);
            $builder->select($this->table.'.*, (SELECT SUM(ll.jumlah_unit) FROM list_loan ll WHERE ll.id_asset_list=ms_asset.id_asset and ll.status=0) as loan_cart_amount');
            $query = $builder->get();
            return $query->getResultArray();
        }else{
            $builder = $this->db->table($this->table);
            $builder->select($this->table.'.*, (SELECT SUM(ll.jumlah_unit) FROM list_loan ll WHERE ll.id_asset_list=ms_asset.id_asset and ll.status=0) as loan_cart_amount');
            $builder->like('asset_name', $param);
            $builder->orLike('asset_location', $param);
            $query = $builder->get();
            return $query->getResultArray();
        }
        
    }

    public function getDatabyId($id)
    {  
        return $this->where(['id_asset' => $id])->first();
    }


    public function id_asset()
    {
       $sql="SELECT substr(id_asset, 2) as max_id FROM `ms_asset` ORDER by id_asset desc";
        $run = $this->db->query($sql)->getResultArray();
        // print_r($run);
        if(count($run)>0){
        $id_max=max($run);

        $newidmax=$id_max['max_id']+1;
        }else{

        $newidmax=1;
        }
        

        $newid='A'.$newidmax;
        return $newid;
    }

    public function Add_asset($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query;
    }

    

    public function Edit_asset($data, $id)
    {
        $query = $this->db->table($this->table)->update($data, array('id_asset' => $id));
        return $query;
    }

    public function deleteasset($id)
    {
        $query = $this->db->table($this->table)->delete(array('id_asset' => $id));
        return $query;
    }
 }
