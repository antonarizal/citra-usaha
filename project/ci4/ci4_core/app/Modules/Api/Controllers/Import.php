<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\Files\File;

class Import  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();

    }

    public function index()
    {		
        $KategoriModel = new \App\Modules\Api\Models\KategoriModel();
        //$kategori = $KategoriModel->findAll();
        //$kategori = $KategoriModel->find($id);
        //$kategori = $KategoriModel->find([1,2,3]);
        //$kategori = $KategoriModel->where('status',1)->findAll();
        //$kategori = $KategoriModel->findAll($limit, $offset);
        //$kategori = $KategoriModel->save($data);
        //return $this->respond($kategori);
    }

    public function data()
    {		
        $builder = $this->db->table($this->KategoriModel->table);
        $data['count'] = $builder->countAll();
        return $this->respond($data);
    }
    
    public function all()
    {		
        $fields = $this->db->getFieldNames($this->KategoriModel->table);
        $request =  $this->request->getGet('request');
        $data = $this->w2ui->result($this->KategoriModel->orderBy('id', 'desc'), $fields, $request );
        return $this->respond($data);
    }

    public function show($id = null)
    {
        $data = $this->KategoriModel->where('id', $id)->first();
        return $this->respond($data);
    }

    public function create()
    {
        $request = $this->request->getPost();
        $model = $this->KategoriModel->insert($request);
        if($model){
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
        $request = $this->request->getPost();
        $pelanggan = $this->KategoriModel->insert($request);
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

        //$kategori = $KategoriModel->save($data);
        // $data = [
        //     'id'       => 3,
        // ];
        //$kategori = $KategoriModel->save($data);
    }

    public function delete($id = null)
    {
        //$data = [];
        //$kategori = $KategoriModel->delete($id);
        //$kategori = $KategoriModel->delete($data);
        //An array of primary keys can be passed in as the first parameter to delete multiple records at once
        //$kategori = $KategoriModel->where('id', $id)->delete();
        //Cleans out the database table by permanently removing all rows that have ‘deleted_at IS NOT NULL’.
        //$kategori = $KategoriModel->purgeDeleted(); 
        
    }
    
    public function datatables()
    {
        $db = db_connect();
        $datatables = new Datatables();
        $table = "user";
        $fields = $db->getFieldNames($table);
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
