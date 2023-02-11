<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Product  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->BarangModel = new \App\Modules\Api\Models\BarangModel();
        $this->builder = $this->db->table($this->BarangModel->table);
        $this->w2ui =  new W2ui();

    }

    public function retail()
    {
        $fields = [
            "id",
            "kode_barang" , 
            "nama_barang" , 
            "harga_jual" , 
            "harga_beli" , 
            "satuan" , 
            "stok" , 
    ];
        $data = $this->db->table("barang")->select($fields)->limit(20)->get()->getResultArray();

        $response = [
            "status" => "success",
            "message"=> "Ok",
            "currentPage"=>1,
            "lastPage"=> 1,
            "totalData"=> count($data),
            "data" => $data,
        ];
        return $this->respond($response, 200);
        
    }

    public function jasa()
    {
        $fields = [
            "id",
            "kode_jasa" , 
            "nama_jasa" , 
            "harga" 
    ];
        $data = $this->db->table("jasa")->select($fields)->limit(20)->get()->getResultArray();

        $response = [
            "status" => "success",
            "message"=> "Ok",
            "currentPage"=>1,
            "lastPage"=> 1,
            "totalData"=> count($data),
            "data" => $data,
        ];
        return $this->respond($response, 200);
        
    }

    public function retail_search()
    {
        $keyword =  $this->request->getGet("keyword");
        $fields = [
            "id",
            "kode_barang" , 
            "nama_barang" , 
            "harga_jual" , 
            "harga_beli" , 
            "satuan" , 
            "stok" , 
    ];
        $data = $this->db->table("barang")
        ->select($fields)
        ->like("nama_barang",$keyword)
        ->limit(20)->get()->getResultArray();
        
        $response = [
            "status" => "success",
            "message"=> "Ok",
            "currentPage"=>1,
            "lastPage"=> 1,
            "totalData"=> count($data),
            "data" => $data,
        ];
        return $this->respond($response, 200);
        
    }

    public function jasa_search()
    {
        $keyword =  $this->request->getGet("keyword");
        $fields = [
            "id",
            "kode_jasa" , 
            "nama_jasa" , 
            "harga" 
    ];
        $data = $this->db->table("jasa")
        ->select($fields)
        ->like("nama_jasa",$keyword)
        ->limit(20)->get()->getResultArray();
        
        $response = [
            "status" => "success",
            "message"=> "Ok",
            "currentPage"=>1,
            "lastPage"=> 1,
            "totalData"=> count($data),
            "data" => $data,
        ];
        return $this->respond($response, 200);
        
    }

    public function gantihargajasa($id)
    {
        $result = $this->db->table("jasa")
                ->where("id",$id)
                ->update(["harga"=>$this->request->getPost("harga")]);
        if($result){
            $response = [
                "success" => true,
                "status" => "success",
                "message"=> "Ok",
            ];
        }else{
            $response = [
                "success" => false,
                "status" => "error",
                "message"=> "Gagal",
            ];
        }
        return $this->respond($response, 200);
        
    
    }
    
    public function barcode($barcode)
    {
        $data = $this->db->table("barang")->where("kode_barang",$barcode)->get()->getRowArray();
        if(!$data){
            $response = [
                "status" => "error",
                "success" => false,
                "message"=> "Barang tidak ditemukan",
                "data" => [],
            ];
            return $this->respond($response, 200);
        }
        $response = [
            "success" => true,
            "status" => "success",
            "message"=> "Ok",
            "data" => $data,
        ];
        return $this->respond($response, 200);
        
    
    }
    
    
    public function grosir()
    {


        $fields = [
            "id",
            "nama_barang" , 
            "price1" , 
            "stock" , 
            "stock1" , 
            "stock2" , 
            "stock3" , 
            "stock4" , 
            "stock5" , 
            "stock6" , 
            "stock7" , 
            "pack3" , 
            "ipack1" , 
            "keypack1" , 
            "ikeypack1" , 
    ];
        // $data = $this->db->table("tbArtic")->select($fields)->limit(20)->get()->getResultArray();
        $fields = implode(",",$fields);
        $data = $this->db->query("SELECT TOP 15 $fields  FROM tbArtic")->getResult();
        $x=0;
        $response = [
            "status" => "success",
            "message"=> "Ok",
            "currentPage"=>1,
            "lastPage"=> 1,
            "totalData"=> count($data),
            "data" => $data,
        ];
        return $this->respond($response, 200);
        
    }

    public function grosir_search()
    {
        $keyword = $this->request->getGet("keyword");
        $fields = [
            "id",
            "nama_barang" , 
            "price1" , 
            "stock" , 
            "stock1" , 
            "stock2" , 
            "stock3" , 
            "stock4" , 
            "stock5" , 
            "stock6" , 
            "stock7" , 
            "pack3" , 
            "ipack1" , 
            "keypack1" , 
            "ikeypack1" , 
    ];
        // $data = $this->db->table("tbArtic")->select($fields)
        // ->like("nama_barang",$keyword)
        // ->limit(20)->get()->getResultArray();
        $fields = implode(",",$fields);
        $data = $this->db->query("SELECT TOP 15 $fields  FROM tbArtic WHERE nama_barang LIKE '%$keyword%'")->getResult();
        $x=0;
        $response = [
            "status" => "success",
            "message"=> "Ok",
            "currentPage"=>1,
            "lastPage"=> 1,
            "totalData"=> count($data),
            "data" => $data,
        ];
        return $this->respond($response, 200);
        
    }
    
}
