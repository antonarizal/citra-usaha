<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class ReturPembelian  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        // $this->KasirModel = new \App\Modules\Kasir\Models\KasirModel();
        // $this->BarangModel = new \App\Modules\Kasir\Models\BarangModel();
        $this->retur = $this->db->table('retur_pembelian');
        $this->faktur = $this->db->table('faktur');
        $this->barang = $this->db->table('barang');
        $this->fakturModel = new \App\Modules\Api\Models\FakturModel();
        $this->w2ui =  new W2ui();

    }

    private function supplier($id)
    {
        $query = $this->db->table("supplier")->select("nama_supplier")
                ->where("id",$id)->get()->getRow();
        return($query->nama_supplier);

    
    }
    public function insert()
    {
        $data = $this->request->getPost("data");
        $trx = $this->request->getPost("insert");
        $master = [];
        foreach($data as $row){
            unset($row["recid"]);
            $master[] =  $row;
            $insert = $this->retur->insert($row);
            $this->db->query("UPDATE barang SET stok = stok-".($row["qty"])." WHERE kode_barang='".$row["kode_barang"]."' ");
        }
        if($insert){
            $insert = $this->faktur->insert($trx);

        }
        // $insert = false;
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

    public function data()
    {		
        $builder = $this->db->table($this->KasirModel->table);
        $data['count'] = $builder->countAll();
        return $this->respond($data);
    }

    public function all()
    {	
        $fields = $this->db->getFieldNames("faktur");
        $request =  $this->request->getGet("request");
        $where = [
            "mode"=>"retur_pembelian"
        ];
        if(isset($_GET["tgl_mulai"])){
            $where = [
                "mode"=>"retur_pembelian",
                "date >="=>$this->request->getGet("tgl_mulai"),
                "date <="=>$this->request->getGet("tgl_selesai"),
            ];
        }
        $join = ["supplier","faktur.supplier_id = supplier.id"];
        $result = $this->w2ui->result($this->fakturModel->where($where), $fields, $request);
        $grand_total =  $this->db->table("faktur")->selectSum("grand_total")->where($where)->get()->getResultArray();
        $terjual =  $this->db->table("faktur")->selectSum("terjual")->where($where)->get()->getResultArray();
        $i=0;
        $data=[];
        if(!empty($result["records"])){

        foreach($result["records"] as $row) {
            $data[$i]["supplier"] = $this->supplier($row["supplier_id"]);
            foreach($fields as $col){
                $data[$i][$col] = $row[$col];
                $data[$i]["recid"] = $row["id"];
            }

            $i++;
        }
        }
        $resp["records"] = ($data);
        $resp["total"] = '-1';
        $resp["status"] = "success";
        $resp["data"] = [
            "grand_total"=>$grand_total[0]["grand_total"],
            "terjual"=>$terjual[0]["terjual"],
        ];
        return $this->respond($resp);

    }
    
    private function faktur($id)
    {
        $query = $this->db->table("faktur")->select("faktur")
                ->where("id",$id)->get()->getRow();
        if($query){
            return($query->faktur);

        }
   
    }
    public function remove()
    {
        $req = json_decode($this->request->getGet("request"));
        foreach($req->recid as $id){
            $faktur = $this->faktur($id);
            // $deleted = $this->faktur->delete(["faktur"=>$faktur]);
            $deleted = $this->db->table("retur_pembelian")->delete(["faktur"=>$faktur]);
            
        }
        if($deleted){
            return $this->all();
        }else{
            $resp=[
                "success"=>true,
                "status"=>true,
                "message"=>"Data berhasil dihapus",
            ];
            $this->respond($resp);
        }
    }
}
