<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Kasir  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        // $this->KasirModel = new \App\Modules\Kasir\Models\KasirModel();
        // $this->BarangModel = new \App\Modules\Kasir\Models\BarangModel();
        $this->kasir = $this->db->table('detail_penjualan');
        $this->faktur = $this->db->table('faktur');
        $this->barang = $this->db->table('barang');
        $this->w2ui =  new W2ui();
        date_default_timezone_set("Asia/Jakarta");

    }

    public function index()
    {		
    }

    public function data()
    {		
        $builder = $this->db->table($this->KasirModel->table);
        $data['count'] = $builder->countAll();
        return $this->respond($data);
    }
    public function kasirPenjualanExists($req){
		// mengecek apakah data sudah ada di kasir penjualan
        // $subquery = $db->table('countries')->select('name')->where('id', 1);

		$data = $this->db->table("detail_penjualan")->select()
				->getWhere(["id_barang"=>$req->id_barang,"faktur"=>$req->faktur])
				->getNumRows();
		//return $data > 0 ? true : false;
		return $data > 0 ? true : false;
	}

    public function insert()
    {
        $data = $this->request->getPost("data");
        $trx = $this->request->getPost("insert");

        $master = [];
        foreach($data as $row){
            unset($row["recid"]);
            unset($row["amount"]);
            unset($row["disc1"]);
            unset($row["disc2"]);
            $list = (object) $row;
            $insertKasir = $this->kasirPenjualanExists($list) == false ? $this->kasir->insert($row) : false;
            if($insertKasir){
                $this->db->query("UPDATE barang SET stok = stok-".$row["qty"]." WHERE kode_barang='".$row["kode_barang"]."' ");
            }
        }
        $isExist = $this->faktur->where("faktur",$trx["faktur"])->get()->getNumRows();
        $insert = !$isExist ? $this->faktur->insert($trx) : false;
        if($insert){
            $response=[
                "success"=>true,
                "message"=>"Success",
                "isExist"=>$isExist
            ];
        }else{
            $response=[
                "success"=>false,
                "message"=>"Failed",
                "isExist"=>$isExist

            ]; 
        }
        return $this->respond($response);
    }
    
    
    public function all()
    {		
        $fields = $this->db->getFieldNames($this->KasirModel->table);
        $request =  $this->request->getGet('request');
        $where = ["status"=>1];
        $data = $this->w2ui->result($this->KasirModel, $fields, $request, $where );
        return $this->respond($data);
    }

}
