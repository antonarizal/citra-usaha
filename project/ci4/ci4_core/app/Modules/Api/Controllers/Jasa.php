<?php
namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Jasa  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->jasaModel = new \App\Modules\Api\Models\JasaModel();
        $this->jasa = $this->db->table($this->jasaModel->table);
        $this->w2ui =  new W2ui();

    }


    public function index()
    {		
        //$pelanggan = $this->jasaModel->findAll();
        //$pelanggan = $this->jasaModel->find($id);
        //$pelanggan = $this->jasaModel->find([1,2,3]);
        //$pelanggan = $this->jasaModel->where('status',1)->findAll();
        //$pelanggan = $this->jasaModel->findAll($limit, $offset);
        //$pelanggan = $this->jasaModel->save($data);
        //return $this->respond($pelanggan);
    }

    public function data()
    {		
        $pelanggan = $this->db->table($this->jasaModel->table);
        $data["count"] =$pelanggan->countAll();
        return $this->respond($data);
    }
    
    public function all()
    {		
        $fields = $this->db->getFieldNames($this->jasaModel->table);
        $request =  $this->request->getGet("request");
        $data = $this->w2ui->result($this->jasaModel, $fields, $request );
        return $this->respond($data);
    }


    public function show($id = null)
    {
        $data = $this->jasaModel->where('id', $id)->first();
        return $this->respond($data);
    }

    public function create()
    {
        $request = $this->request->getPost();
        if(!empty($this->request->getPost("request"))){
            $request = json_decode($this->request->getPost("request"))->record;
        }
        $pelanggan = $this->jasaModel->insert($request);
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
        helper("bilangan");

        $data = $this->request->getPost();
        unset($data["insert"]);
        $data["harga"] = angka($data["harga"]);

        $request = (object)$this->request->getPost();
        if($request->insert){
            $response = $this->jasa->insert($data);
        }else{
            $this->jasa->where('id', $request->id);
            $response = $this->jasa->update($data);
        }  
        if($response){
            $resp['success']=true;
            $resp['status']='success';
            $resp['message']='Data berhasil disimpan!';
        }else{
            $resp['success']=false;
            $resp['status']='failed';
            $resp['message']='Data gagal disimpan!';
        }
        return $this->respond($resp); 
    }

    public function update($id = null)
    {
        $request = $this->request->getPost();
        $pelanggan = $this->jasaModel->update($id,$request);
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
        $pelanggan = $this->jasaModel->save($request);
        return $this->respond($pelanggan);
        // $data = [
        //     'id'       => 3,
        // ];
        //$pelanggan = $this->jasaModel->save($data);
    }

    public function delete($id = null)
    {
        //$data = [];
        //$pelanggan = $this->jasaModel->delete($id);
        //$pelanggan = $this->jasaModel->delete($data);
        //An array of primary keys can be passed in as the first parameter to delete multiple records at once
        //$pelanggan = $this->jasaModel->where('id', $id)->delete();
        //Cleans out the database table by permanently removing all rows that have ‘deleted_at IS NOT NULL’.
        //$pelanggan = $this->jasaModel->purgeDeleted(); 
        
    }
    public function truncate()
    {
        $result = $this->jasa->truncate();
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
    public function remove()
    {
        $request = (object)$this->request->getPost();
        $this->jasa->where('id', $request->id);
        $delete = $this->jasa->delete();
        if($delete ){
            $data["success"]=true;
            $data["status"]="success";
            $data["message"]="Data berhasil dihapus!";
        }else{
            $data["success"]=false;
            $data["status"]="failed";
            $data["message"]="Gagal!";
        }
        return $this->respond($data);    }
}
