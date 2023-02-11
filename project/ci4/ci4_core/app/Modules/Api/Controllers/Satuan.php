<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Satuan  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->SatuanModel = new \App\Modules\Api\Models\SatuanModel();
        $this->builder = $this->db->table($this->SatuanModel->table);
        $this->satuan = $this->db->table('satuan');
        $this->w2ui =  new W2ui();

    }


    public function index()
    {
        $result = $this->satuan->get()->getResult();
        return $this->respond($result);
    
    }
    
    public function data()
    {		
        $builder = $this->db->table($this->SatuanModel->table);
        $data['count'] = $builder->countAll();
        return $this->respond($data);
    }
    
    public function all()
    {		
        $fields = $this->db->getFieldNames($this->SatuanModel->table);
        $request =  $this->request->getGet('request');
        $data = $this->w2ui->result($this->SatuanModel->orderBy('id', 'desc'), $fields, $request );
        return $this->respond($data);
    }

    public function satuan()
    {		
        $fields = $this->db->getFieldNames($this->SatuanModel->table);
        $request =  $this->request->getGet('request');
        $data = $this->w2ui->result($this->SatuanModel->orderBy('id', 'desc'), $fields, $request );
        return $this->respond($data);
    }

    public function show($id = null)
    {
        $data = $this->SatuanModel->where('id', $id)->first();
        return $this->respond($data);
    }

    public function create()
    {
        $request = $this->request->getPost();
        $pelanggan = $this->SatuanModel->insert($request);
        if($pelanggan){
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

    public function insert()
    {
        $data = $this->request->getPost();
        unset($data["insert"]);
        $request = (object)$this->request->getPost();
        if($request->insert){
            $this->satuan->insert($data);
        }else{
            $this->satuan->where('id', $request->id);
            $this->satuan->update($data);
        }   
    }
    public function update($id = null)
    {
        $request = $this->request->getPost();
        $pelanggan = $this->SatuanModel->insert($request);
        if($pelanggan){
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
    
    public function save($id = null)
    {
        // Defined as a model property
        //$primaryKey = 'id';

        // Does an insert()
        // $data = [ ];

        //$satuan = $SatuanModel->save($data);
        // $data = [
        //     'id'       => 3,
        // ];
        //$satuan = $SatuanModel->save($data);
    }

    public function delete($id = null)
    {
        //$data = [];
        //$satuan = $SatuanModel->delete($id);
        //$satuan = $SatuanModel->delete($data);
        //An array of primary keys can be passed in as the first parameter to delete multiple records at once
        //$satuan = $SatuanModel->where('id', $id)->delete();
        //Cleans out the database table by permanently removing all rows that have ‘deleted_at IS NOT NULL’.
        //$satuan = $SatuanModel->purgeDeleted(); 
        
    }
    public function remove()
    {
        $request = (object)$this->request->getPost();
        $this->satuan->where('id', $request->id);
        $this->satuan->delete();
    }
}
