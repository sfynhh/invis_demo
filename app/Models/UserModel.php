<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = "users_admin";
    protected $column_order = array(null,null,null, null, null, null);
    protected $column_search = array('name_emp');
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

        $this->dbi = \Config\Database::connect('dbSiak');

 
        // $this->tbi = $this->db->table('student');
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
            $this->dt->join('employe_master', 'users_admin.Admin_name=employe_master.id_emp');
            $this->dt->orderBy('nip_emp', 'ASC');
       
        $query = $this->dt->get();
      
        return $query->getResultArray();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        
    
             $this->dt->join('employe_master', 'users_admin.Admin_name=employe_master.id_emp');
            
            $this->dt->orderBy('nip_emp', 'ASC');

        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        $tbl_storage = $this->db->table($this->table);

        return $tbl_storage->countAllResults();
    }
     public function getUsersAll()
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
       $builder->join('employe_master', 'users_admin.Admin_name=employe_master.id_emp');
        // $builder->join('ms_unit', 'master_pegawai.id_unit_pgw=ms_unit.kode_unit', 'left');
       
        $builder->orderBy('users_admin.id_users_admin', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    
    }

  public function getNip($nip)
  {


        $sql ="SELECT * FROM employe_master  where nip_emp like ? or  name_emp like ? and position='Pegawai' and unit_emp is not null order by nip_emp limit 15";
        
        return $query = $this->db->query($sql, ["%".$nip."%","%".$nip."%"])->getResult();
    }

    public function getNipNim($s)
    {
  
        $sql ="SELECT * FROM (SELECT s.numberid as nip_nim ,s.fullname as fullname, 'MHW' As status, s.phone, s.studyprogram as unit FROM student s  where s.permission_loan =1 and (s.id_student  like ? or  s.fullname  like ? )
        UNION 
        SELECT em.nip_emp, em.name_emp, 'EMP', em.no_tlp, em.unit_emp  FROM employe_master em where em.nip_emp  like ? or  em.name_emp  like ? ) as DEM order by DEM.fullname limit 15";
          
          return $query = $this->dbi->query($sql, ["%".$s."%","%".$s."%","%".$s."%","%".$s."%"])->getResult();
      }

    public function createUser($data)
    {
        $query = $this->dt->insert($data);
        return $query;
    }
}