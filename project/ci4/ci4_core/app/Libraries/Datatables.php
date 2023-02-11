<?php

namespace App\Libraries;

class Datatables
{
    public function __construct()
    {
        // parent::__construct();
        // $builder = db_connect();
		$this->db = db_connect();
		// $this->builder = $builder->table("tbl_students");
    }
    private function _get_datatables_query($data)
    {
        $table          = $data["table"];
        $column_order   = $data["column"]["order"];
        $column_search  = $data["column"]["search"];
        $order          = $data["order"];
        $where          = $data["where"];
        $builder = $this->db->table($table);

        if($where)
        {
            foreach ($where as $item=>$value) 
            {
                $builder->where($item,$value);
            }
        }

 

        $i = 0;
       foreach ($column_search as $item) 
        {
            
            if(isset($_POST['search']['value']))
            {
                $words = explode(' ',$_POST['search']['value']);                 
                if($i===0)
                {
                    $builder->groupStart(); 
                    $builder->like($item, $_POST['search']['value']);
                }
                else
                {

                    $builder->orGroupStart();
                    foreach($words as $word){
                                $builder->like($item, $word);
                    }
                    $builder->groupEnd();

                }
                if(count($column_search) - 1 == $i) 
                    $builder->groupEnd();
            }
            $i++;
        }
        //print_r($db);
        if(isset($_POST['order'])) 
        {
            $builder->orderBy($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($order))
        {
            $order = $order;
            $builder->orderBy(key($order), $order[key($order)]);
        }
    }
   
    public function get_datatables($data)
    {
        $table          = $data["table"];
        // $this->_get_datatables_query($data);
        $column_order   = $data["column"]["order"];
        $column_search  = $data["column"]["search"];
        $order          = $data["order"];
        $where          = $data["where"];
        $builder = $this->db->table($table);

        if($where!=array(""))
        {
            foreach ($where as $item=>$value) 
            {
                $builder->where($item,$value);
            }
        }

 

        $i = 0;
       foreach ($column_search as $item) 
        {
            
            if(isset($_POST['search']['value']))
            {
                $words = explode(' ',$_POST['search']['value']);                 
                if($i===0)
                {
                    $builder->groupStart(); 
                    $builder->like($item, $_POST['search']['value']);
                }
                else
                {

                    $builder->orGroupStart();
                    foreach($words as $word){
                                $builder->like($item, $word);
                    }
                    $builder->groupEnd();

                }
                if(count($column_search) - 1 == $i) 
                    $builder->groupEnd();
            }
            $i++;
        }
        //print_r($db);
        if(isset($_POST['order'])) 
        {
            $builder->orderBy($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($order))
        {
            $order = $order;
            $builder->orderBy(key($order), $order[key($order)]);
        }
        if($_POST['length'] != -1)
        $builder->limit($_POST['length'], $_POST['start']);
        $query = $builder->get();
        return $query->getResult();
    }
   
    public function count_filtered($data)
    {
        $table=$data["table"];
        $builder = $this->db->table($table);
        $this->_get_datatables_query($data);
        $query = $builder->countAllResults();
        return $query;
    }
   
    public function count_all($data)
    {
        $table=$data["table"];
        $builder = $this->db->table($table);
       return $builder->countAllResults();
    }
}