<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Maintenance  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->barang      = $this->db->table("barang");
        $this->faktur      = $this->db->table("faktur");
        $this->fakturModel = new \App\Modules\Api\Models\FakturModel();
        $this->w2ui =  new W2ui();
        date_default_timezone_set("Asia/Jakarta");

    }
    public function penjualan()
    {
        $date = $this->request->getPost("date");
        $faktur = $this->request->getPost("faktur");
        helper('bilangan');
        $faktur = $this->faktur->like('faktur', $faktur, 'after')
        ->where("date",$date)
        ->get()->getResult();
        //'PJ.071222'
        $resp = [
            "status"=>"success",
            "total"=>count($faktur),
            "records"=>$faktur,
        ];

        return $this->respond($resp);
    }

    public function updatepenjualan()
    {
        $date = $this->request->getPost("date");
        $sdate = $this->request->getPost("sdate");
        $faktur = $this->request->getPost("faktur");
        $faktur = $this->faktur->like('faktur', $faktur, 'after')
        ->where("date",$date)
        ->update(["date"=>$sdate]);
        //'PJ.071222'
        $resp = [
            "message"=>"Berhasil",
            "status"=>"success",
            "success"=>$faktur,
        ];

        return $this->respond($resp);
    }


}