<?php
namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Supplier  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->supplierModel = new \App\Modules\Api\Models\supplierModel();
        $this->supplier = $this->db->table($this->supplierModel->table);
        $this->w2ui =  new W2ui();

    }

    public function data()
    {		
        $supplier = $this->db->table($this->supplierModel->table);
        $data["count"] =$supplier->countAll();
        return $this->respond($data);
    }
    
    public function all()
    {		
        $fields = $this->db->getFieldNames($this->supplierModel->table);
        $request =  $this->request->getGet("request");
        $data = $this->w2ui->result($this->supplierModel, $fields, $request );
        return $this->respond($data);
    }


    public function show($id = null)
    {
        $data = $this->supplierModel->where('id', $id)->first();
        return $this->respond($data);
    }

    public function create()
    {
        $request = $this->request->getPost();
        if(!empty($this->request->getPost("request"))){
            $request = json_decode($this->request->getPost("request"))->record;
        }
        $supplier = $this->supplierModel->insert($request);
        if($supplier){
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
            $this->supplier->insert($data);
        }else{
            $this->supplier->where('id', $request->id);
            $this->supplier->update($data);
        }   
    }

    public function update($id = null)
    {
        $request = $this->request->getPost();
        $supplier = $this->supplierModel->update($id,$request);
        if($supplier){
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
        $supplier = $this->supplierModel->save($request);
        return $this->respond($supplier);
        // $data = [
        //     'id'       => 3,
        // ];
        //$supplier = $this->supplierModel->save($data);
    }

    public function delete($id = null)
    {
        //$data = [];
        //$supplier = $this->supplierModel->delete($id);
        //$supplier = $this->supplierModel->delete($data);
        //An array of primary keys can be passed in as the first parameter to delete multiple records at once
        //$supplier = $this->supplierModel->where('id', $id)->delete();
        //Cleans out the database table by permanently removing all rows that have ‘deleted_at IS NOT NULL’.
        //$supplier = $this->supplierModel->purgeDeleted(); 
        
    }
    public function remove()
    {
        $request = (object)$this->request->getPost();
        $this->supplier->where('id', $request->id);
        $this->supplier->delete();
    }

    public function datatables()
    {
        $db = db_connect();
        $datatables = new Datatables();
        $table = "user";
        $fields = $this->db->getFieldNames($table);
        $search=$fields;
        $order=array(NULL);
		$order=($fields);
		$where = array(""); 
        $params=array(
            "table"=>$table,
            "column"=>array(
                "order"=>$order,
                "search"=>$search,
                ),
            "order" => array('id' => 'desc'),
            "where" => $where
            );

        $list = $datatables->get_datatables($params);
        $data = array();
        $no = $_POST['start'];
        $data = $list;
        $output = array(
				'draw' => $_POST['draw'],
				'recordsTotal' => $datatables->count_all($params),
				'recordsFiltered' => $datatables->count_filtered($params),
				'data' => $data,
		);
        return $this->response->setJson($output);
        // echo json_encode($output);
    }
}
