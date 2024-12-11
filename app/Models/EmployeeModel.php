<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table = "employe_master";
    protected $column_order = array('nip_emp',null,null, null, null,null);
    protected $column_search = array('name_emp', 'nip_emp');
    protected $order = array('' => '');
    protected $request;
    protected $db;
    protected $dt;
 
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
            $this->dt->where('position','Pegawai');
            $this->dt->orderBy('nip_emp', 'ASC');
       
        $query = $this->dt->get();
      
        return $query->getResultArray();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        
    
             $this->dt->where('position','Pegawai');
            
            $this->dt->orderBy('nip_emp', 'ASC');

        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        $tbl_storage = $this->db->table($this->table);

        return $tbl_storage->countAllResults();
    }

     public function getByNip($id)
    {
        $builder = $this->dt;
        $builder->select('*');
         
        $builder->where('nip_emp', $id);
        $query = $builder->get();
        return $query->getRowArray();
    }

     public function getByUnit($unitEmp)
    {
       $sql ="SELECT * FROM employe_master
                        join detail_role on employe_master.nip_emp=detail_role.nip_pgw_role  
                        where (nip_emp!='00000'  and  nip_emp!='11111' and  nip_emp!='22222') and position='Pegawai' and unit_emp is not null and unit_role_name=? order by nip_emp";
        
        return $query = $this->db->query($sql, [$unitEmp])->getResultArray();
    }

    
}
