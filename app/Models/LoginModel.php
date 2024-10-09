<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table      = 'users_admin';
    // protected $table2      = 'customer';

        public function createUser($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query;
    }

    public function getUsers($username)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
       $builder->join('employe_master', 'users_admin.Admin_name=employe_master.id_emp');
        // $builder->join('ms_unit', 'master_pegawai.id_unit_pgw=ms_unit.kode_unit', 'left');
        $builder->where('username', $username);
        $builder->orderBy('users_admin.id_users_admin', 'ASC');
        $query = $builder->get();
        return $query->getRowArray();
    
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

     public function getDataAdminByIdEmp($id)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
        // $builder->join('ms_unit', 'master_pegawai.id_unit_pgw=ms_unit.kode_unit', 'left');
        $builder->where('Admin_name', $id);
        $builder->orderBy('users_admin.id_users_admin', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    
    }


      public function getDataSession($username)
    {
        $builder = $this->db->table($this->table);
        $builder->select('employe_master.*, users_admin.type');
       $builder->join('employe_master', 'user_admin.Admin_name=employe_master.id_emp');
        // $builder->join('ms_unit', 'master_pegawai.id_unit_pgw=ms_unit.kode_unit', 'left');
        $builder->where('username', $username);
        $builder->orderBy('users_admin.id_users_admin', 'ASC');
        $query = $builder->get();
        return $query->getRowArray();
    }
    public function Chekdata($nip)
    {
        $builder = $this->db->table('employe_master');
        $builder->select('*');

        $builder->where('nip_emp', $nip);
        $query = $builder->get();
        return $query->getResultArray();
    }

      public function getDataEmpByNip($nip)
    {
        $builder = $this->db->table('employe_master');
        $builder->select('*');

        $builder->where('nip_emp', $nip);
        $query = $builder->get();
        return $query->getRowArray();
    }

     public function addEmployee($data)
    {
        $query = $this->db->table('employe_master')->insert($data);
        return $query;
    }

      public function addRole($data)
    {
        $query = $this->db->table('detail_role')->insertBatch($data);
        return $query;
    }

    public function updateEmployee($data, $id)
    {
        $query = $this->db->table('employe_master')->update($data, array('nip_emp' => $id));
        return $query;
    }

     public function getOwner($owner)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
         $builder->join('employe_master', 'users_admin.Admin_name=employe_master.id_emp');
        $builder->where('type', $owner);
        $query = $builder->get();
        return $query->getResultArray();
    }

     public function deleteUser($id)
    {
        $query = $this->db->table($this->table)->delete(array('Admin_name' => $id[0], 'type'=>$id[1]));
        return $query;
    }

     public function deleteRole($id)
    {
        $query = $this->db->table('detail_role')->delete(array('nip_pgw_role' => $id));
        return $query;
    }

     public function getByNip($id)
    {   
       
         
        $sql ="SELECT Admin_name as id_role_tetap, type as type_role from users_admin join employe_master on users_admin.Admin_name=employe_master.id_emp
               where nip_emp=?";
        
        return $query = $this->db->query($sql, [$id, $id])->getResultArray();

        
    }

       public function getAllData()
    {
        return $this->db->table('unit_master')->get()->getResultArray();
    }

      public function updateDataUnit($dataEmp, $dataDetail, $nip_emp)
    {
        $query =  $this->db->table('employe_master')->update($dataEmp, array('nip_emp' => $nip_emp));
        $query2 =  $this->db->table('detail_role')->update($dataDetail, array('nip_pgw_role' => $nip_emp));
        return $query2;
    }
    


}