<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Kategori  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->kategori      = $this->db->table("kategori");
        $this->kategoriModel = new \App\Modules\Api\Models\KategoriModel();

        $this->w2ui =  new W2ui();

    }
    public function insert()
    {
        $data = $this->request->getPost();
        unset($data["insert"]);
        $request = (object)$this->request->getPost();
        if($request->insert){
            $this->kategori->insert($data);
        }else{
            $this->kategori->where('id', $request->id);
            $this->kategori->update($data);
        }   
    }
    public function remove()
    {
        $request = (object)$this->request->getPost();
        $this->kategori->where('id', $request->id);
        $this->kategori->delete();
    }

    public function index()
    {
        $result = $this->kategori->get()->getResult();
        return $this->respond($result);
    
    }
    public function all()
    {
        $request = json_decode($this->request->getGet("request"));
        $search = isset($request->search) ? $request->search[0] : false;
        $result = $this->kategori;
        if($search){
            $result = $result->like($search->field, $search->value);
        }
        $data = $result->orderBy("id","desc")->get()->getResult();
        $i=1;
        if($data)
        {
            $resp = $data;
        }else{
            $resp = [];
        }

        $response = [
            "success"=>true,
            "data"=>$resp,
            "request"=>$request,
            "search"=>$search,
        ];
        return $this->respond($resp);

    }

    
    public function kategori()
    {
        $fields = $this->db->getFieldNames("kategori");
        $request =  $this->request->getGet("request");
        $data = $this->w2ui->result($this->kategoriModel, $fields, $request );
        return $this->respond($data);
    }
    public function search()
    {	
        $keyword =  $this->request->getGet("keyword");
        // $data = $this->db->table("tbCus")->select("cat,kategori,address, subcity, city")
        // ->like("kategori",$keyword)
        // ->limit(20)->get()->getResultArray();
        $data = $this->db->query("SELECT TOP 20 cat,kategori,address, subcity, city  FROM tbCus WHERE kategori LIKE '%$keyword%' ")->getResult();

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
        $result=$this->kategori->limit(1)->orderBy("id","desc")->get()->getRow();
        $id = (intVal($result->id)) + 1;
        $id =  sprintf("%04d",$id);
        return $this->respond(["id"=>$id]);
    
    }
    
}