<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Konversi  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->w2ui =  new W2ui();

    }

    public function satuan()
    {	
        $data = $this->db->table("tbKonversi")->get()->getResult();
        $response = [
            "success"=>true,
            "data"=>$data,
        ];
        return $this->respond($response);

    }

}