<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Barang  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->barang      = $this->db->table("barang");
        $this->barangModel = new \App\Modules\Api\Models\BarangModel();
        $this->w2ui =  new W2ui();

    }
    public function all()
    {	
        $fields = $this->db->getFieldNames("barang");
        $request =  $this->request->getGet("request");
        $data = $this->w2ui->result($this->barangModel, $fields, $request );
        return $this->respond($data);

    }

    public function search()
    {	
        $keyword =  $this->request->getGet("keyword");
        // $data = $this->db->table("tbCus")->select("plu,barang,address, subcity, city")
        // ->like("barang",$keyword)
        // ->limit(20)->get()->getResultArray();
        $data = $this->db->query("SELECT TOP 20 plu,barang,address, subcity, city  FROM tbCus WHERE barang LIKE '%$keyword%' ")->getResult();

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
    public function getId()
    {
        $result=$this->barang->limit(1)->orderBy("plu","desc")->get()->getRow();
        $id = (intVal($result->plu)) + 1;
        $id =  sprintf("%05d",$id);
        return $this->respond(["id"=>$id]);
    
    }
    
    public function create()
    {
        helper("bilangan");
        $request = $this->request->getPost();
        $request["harga_beli"] = angka($request["harga_beli"]);
        $request["harga_jual"] = angka($request["harga_jual"]);
        $response = $this->barangModel->insert($request);
        if($response){
            $data['success']=true;
            $data['status']='success';
            $data['message']='Data berhasil disimpan!';
        }else{
            $data['success']=false;
            $data['status']='failed';
            $data['message']='Data gagal disimpan!';
        }
        return $this->respond($data);

    }
    
    public function update($id = null)
    {
        helper("bilangan");
        $request = $this->request->getPost();
        $request["harga_beli"] = angka($request["harga_beli"]);
        $request["harga_jual"] = angka($request["harga_jual"]);
        $response = $this->barangModel->update($id,$request);
        if($response){
            $data['success']=true;
            $data['status']='success';
            $data['message']='Data berhasil disimpan!';
        }else{
            $data['success']=false;
            $data['status']='failed';
            $data['message']='Data gagal disimpan!';
        }
        return $this->respond($data);

    }

}