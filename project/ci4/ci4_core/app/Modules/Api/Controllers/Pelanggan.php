<?php
namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Pelanggan  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->pelangganModel = new \App\Modules\Api\Models\PelangganModel();
        $this->pelanggan = $this->db->table($this->pelangganModel->table);
        $this->w2ui =  new W2ui();

    }


    public function index()
    {		
        //$pelanggan = $this->pelangganModel->findAll();
        //$pelanggan = $this->pelangganModel->find($id);
        //$pelanggan = $this->pelangganModel->find([1,2,3]);
        //$pelanggan = $this->pelangganModel->where('status',1)->findAll();
        //$pelanggan = $this->pelangganModel->findAll($limit, $offset);
        //$pelanggan = $this->pelangganModel->save($data);
        //return $this->respond($pelanggan);
    }

    public function data()
    {		
        $pelanggan = $this->db->table($this->pelangganModel->table);
        $data["count"] =$pelanggan->countAll();
        return $this->respond($data);
    }
    
    public function all()
    {		
        $fields = $this->db->getFieldNames($this->pelangganModel->table);
        $request =  $this->request->getGet("request");
        $data = $this->w2ui->result($this->pelangganModel, $fields, $request );
        return $this->respond($data);
    }


    public function show($id = null)
    {
        $data = $this->pelangganModel->where('id', $id)->first();
        return $this->respond($data);
    }

    public function create()
    {
        $request = $this->request->getPost();
        if(!empty($this->request->getPost("request"))){
            $request = json_decode($this->request->getPost("request"))->record;
        }
        $pelanggan = $this->pelangganModel->insert($request);
        if($pelanggan){
            $data["success"]=true;
            $data["status"]="success";
            $data["message"]="Data berhasil disimpan!";
        }else{
            $data["success"]=false;
            $data["status"]="failed";
            $data["message"]="Gagal!";
        }
        return $this->respond($data);
    }

    public function insert()
    {
        $data = $this->request->getPost();
        unset($data["insert"]);
        $request = (object)$this->request->getPost();
        if($request->insert){
            $result = $this->pelanggan->insert($data);
        }else{
            $this->pelanggan->where('id', $request->id);
            $result = $this->pelanggan->update($data);
        }   
        if($result){
            $data["success"]=true;
            $data["status"]="success";
            $data["message"]="Data berhasil diperbaharui!";
        }else{
            $data["success"]=false;
            $data["status"]="failed";
            $data["message"]="Gagal!";
        }
        return $this->respond($data);
    }

    public function update($id = null)
    {
        $request = $this->request->getPost();
        $pelanggan = $this->pelangganModel->update($id,$request);
        if($pelanggan){
            $data["success"]=true;
            $data["status"]="success";
            $data["message"]="Data berhasil diperbaharui!";
        }else{
            $data["success"]=false;
            $data["status"]="failed";
            $data["message"]="Gagal!";
        }
        return $this->respond($data);

    }

    public function save($id = null)
    {
        $request = $this->request->getPost();
        // Defined as a model property
        $primaryKey = 'id';
        // Does an insert()
        // $data = [ ];
        $pelanggan = $this->pelangganModel->save($request);
        return $this->respond($pelanggan);
        // $data = [
        //     'id'       => 3,
        // ];
        //$pelanggan = $this->pelangganModel->save($data);
    }

    public function delete($id = null)
    {
        //$data = [];
        //$pelanggan = $this->pelangganModel->delete($id);
        //$pelanggan = $this->pelangganModel->delete($data);
        //An array of primary keys can be passed in as the first parameter to delete multiple records at once
        //$pelanggan = $this->pelangganModel->where('id', $id)->delete();
        //Cleans out the database table by permanently removing all rows that have ‘deleted_at IS NOT NULL’.
        //$pelanggan = $this->pelangganModel->purgeDeleted(); 
        
    }
    public function remove()
    {
        $request = (object)$this->request->getPost();
        $this->pelanggan->where('id', $request->id);
        $delete = $this->pelanggan->delete();
        if($delete ){
            $data["success"]=true;
            $data["status"]="success";
            $data["message"]="Data berhasil diperbaharui!";
        }else{
            $data["success"]=false;
            $data["status"]="failed";
            $data["message"]="Gagal!";
        }
        return $this->respond($data);
    }
    public function truncate()
    {
        $result = $this->pelanggan->truncate();
        if($result){
            $data['success']=true;
            $data['status']='success';
            $data['message']='Data berhasil dikosongkan!';
        }else{
            $data['success']=false;
            $data['status']='failed';
            $data['message']='Data gagal dikosongkan!';
        }
        return $this->respond($data);
    }
    
}
