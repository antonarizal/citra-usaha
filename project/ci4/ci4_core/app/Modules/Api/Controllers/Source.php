<?php

//namespace App\Controllers;

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\Datatables;

class Source  extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function __construct()
    {
       // $datatables = new Datatables();
       $this->db = \Config\Database::connect();
       


    }

    public function tes()
    {
        phpinfo();
    
    }
    

    public function data()
    {
        $data= $this->db->table('tbArtic')->limit(100)->get()->getResultArray();
        return $this->respond($data);


    }
        
    
}
