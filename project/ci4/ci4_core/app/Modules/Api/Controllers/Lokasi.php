<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Lokasi  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->w2ui =  new W2ui();

    }

    public function gudang()
    {	
        // $data = $this->db->table("tbLok")->limit(7)->get()->getResult();
        $query = $this->db->query("SELECT TOP 8 *  FROM tbLok");
        $data = $query->getResult();

        $response = [
            "success"=>true,
            "data"=>$data,
        ];
        return $this->respond($response);

    }

}