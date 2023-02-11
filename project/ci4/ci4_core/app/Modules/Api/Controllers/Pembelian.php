<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Pembelian  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->barang      = $this->db->table("barang");
        $this->faktur      = $this->db->table("faktur");
        $this->kasir      = $this->db->table("detail_pembelian");
        $this->fakturModel = new \App\Modules\Api\Models\FakturModel();
        $this->w2ui =  new W2ui();
        date_default_timezone_set("Asia/Jakarta");

    }
    private function supplier($id)
    {
        $query = $this->db->table("supplier")->select("nama_supplier")
                ->where("id",$id)->get()->getRow();
        return($query->nama_supplier);
    }
    
    public function all()
    {	
        $fields = $this->db->getFieldNames("faktur");
        $request =  $this->request->getGet("request");
        $where = [
            "mode"=>"pembelian"
        ];
        if(isset($_GET["tgl_mulai"])){
            $where = [
                "mode"=>"pembelian",
                "date >="=>$this->request->getGet("tgl_mulai"),
                "date <="=>$this->request->getGet("tgl_selesai"),
            ];
        }
        $join = ["supplier","faktur.supplier_id = supplier.id"];
        $result = $this->w2ui->result($this->fakturModel->where($where), $fields, $request);
        $pembelian =  $this->db->table("faktur")->selectSum("grand_total")->where($where)->get()->getResultArray();
        $terjual =  $this->db->table("faktur")->selectSum("terjual")->where($where)->get()->getResultArray();
        $i=0;
        $data=[];
        if(!empty($result["records"])){
        foreach($result["records"] as $row) {
            $data[$i]["supplier"] = $this->supplier($row["supplier_id"]);
            foreach($fields as $col){
                $data[$i]["recid"] = $row["id"];
                $data[$i][$col] = $row[$col];
            }

            $i++;
        }
        }
        $resp["records"] = ($data);
        $resp["total"] = '-1';
        $resp["status"] = "success";
        $resp["data"] = [
            "grand_total"=>$pembelian[0]["grand_total"],
            "terjual"=>$terjual[0]["terjual"],
        ];
        return $this->respond($resp);

    }
    public function detail($id=null)
    {
        helper('bilangan');
        $faktur = $this->faktur->where('faktur.id',$id)
        ->join("supplier","supplier.id = faktur.supplier_id")
        ->get()->getRow();

        $pembelian = $this->db->table("detail_pembelian")
        ->where('faktur',$faktur->faktur)
        ->get()->getResult();

        $resp = [
            "status"=>"success",
            "total"=>'-1',
            "records"=>$pembelian,
            "faktur"=>$faktur,
        ];
        return $this->respond($resp);
    }

    public function insert()
    {
        $data = $this->request->getPost("data");
        $trx = $this->request->getPost("insert");

        $master = [];
        foreach($data as $row){
            unset($row["recid"]);
            unset($row["harga_beli"]);
            unset($row["amount"]);
            unset($row["disc"]);
            unset($row["diskon"]);
            $master[] =  $row;
            $this->kasir->insert($row); // insert
            $this->db->query("UPDATE barang SET stok = stok+".$row["qty"]." WHERE kode_barang='".$row["kode_barang"]."' ");
        }
        $insert = $this->faktur->insert($trx);
        if($insert){
            $response=[
                "success"=>true,
                "message"=>"Success"
            ];
        }else{
            $response=[
                "success"=>false,
                "message"=>"Failed"
            ]; 
        }
        return $this->respond($response);
    }
    

}