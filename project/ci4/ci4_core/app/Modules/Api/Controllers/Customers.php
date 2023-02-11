<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Customers  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->customer      = $this->db->table("tbCus");
        $this->w2ui =  new W2ui();

    }
    public function insert()
    {
        $data = $this->request->getPost();
        unset($data["insert"]);
        $request = (object)$this->request->getPost();
        if($request->insert){
            $this->customer->insert($data);
        }else{
            $this->customer->where('cusid', $request->cusid);
            $this->customer->update($data);
        }   
    }
    public function remove()
    {
        $request = (object)$this->request->getPost();
        $this->customer->where('cusid', $request->cusid);
        $this->customer->delete();
    }
    

    public function all()
    {	
        $request = json_decode($this->request->getGet("request"));
        $search = isset($request->search) ? $request->search[0] : false;
        $result = $this->customer;
        if($search){
            $result = $result->like($search->field, $search->value);
        }
        $data = $result->orderBy("cusid","desc")->get()->getResult();
        $i=1;
        if($data)
        {
            foreach($data as $dt){
                $usr = (array) $dt;
                $resp[$i-1]["id"]=$i;
                foreach(array_keys($usr) as $col){
                    $resp[$i-1][$col] =  $usr[$col];
                }
                $i++;
            }
        }else{
            $resp = [];
        }

        $response = [
            "success"=>true,
            "data"=>$resp,
            "request"=>$request,
            "search"=>$search,
        ];
        return $this->respond($response);

    }

    
    public function index()
    {
        // $data = $this->db->table("tbCus")->select("cusid,customer,address, subcity, city")->limit(20)->get()->getResultArray();
        $data = $this->db->query("SELECT  TOP 20 *  FROM tbCus ")->getResult();
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
    public function search()
    {	
        $keyword =  $this->request->getGet("keyword");
        // $data = $this->db->table("tbCus")->select("cusid,customer,address, subcity, city")
        // ->like("customer",$keyword)
        // ->limit(20)->get()->getResultArray();
        $data = $this->db->query("SELECT TOP 20 cusid,customer,address, subcity, city  FROM tbCus WHERE customer LIKE '%$keyword%' ")->getResult();

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
        $result=$this->customer->limit(1)->orderBy("cusid","desc")->get()->getRow();
        $id = (intVal($result->cusid)) + 1;
        $id =  sprintf("%05d",$id);
        return $this->respond(["id"=>$id]);
    
    }
    

}