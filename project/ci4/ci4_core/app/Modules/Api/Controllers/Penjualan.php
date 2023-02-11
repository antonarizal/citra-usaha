<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Penjualan  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->barang      = $this->db->table("barang");
        $this->faktur      = $this->db->table("faktur");
        $this->fakturModel = new \App\Modules\Api\Models\FakturModel();
        $this->w2ui =  new W2ui();
        date_default_timezone_set("Asia/Jakarta");

    }
    private function pelanggan($id)
    {
        $query = $this->db->table("pelanggan")->select("nama_pelanggan")
                ->where("id",$id)->get()->getRow();
        if($query){
            return($query->nama_pelanggan);

        }
   
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
            $deleted = $this->db->table("detail_penjualan")->delete(["faktur"=>$faktur]);
            
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
    
    
    public function all()
    {	
        $fields = $this->db->getFieldNames("faktur");
        $request =  $this->request->getGet("request");
        $where = [
            "mode"=>"penjualan"
        ];
        if(isset($_GET["tgl_mulai"])){
            $where = [
                "mode"=>"penjualan",
                "date >="=>$this->request->getGet("tgl_mulai"),
                "date <="=>$this->request->getGet("tgl_selesai"),
            ];
        }
        $join = ["pelanggan","faktur.pelanggan_id = pelanggan.id"];
        $result = $this->w2ui->result($this->fakturModel->where($where), $fields, $request);
        $pemasukan =  $this->db->table("faktur")->selectSum("pemasukan")->where($where)->get()->getResultArray();
        $terjual =  $this->db->table("faktur")->selectSum("terjual")->where($where)->get()->getResultArray();
        $i=0;
        $data=[];
        if(!empty($result["records"])){
            foreach($result["records"] as $row) {
                $data[$i]["pelanggan"] = $this->pelanggan($row["pelanggan_id"]);
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
            "pemasukan"=>$pemasukan[0]["pemasukan"],
            "terjual"=>$terjual[0]["terjual"],
        ];
        return $this->respond($resp);

    }
    public function detail($id=null)
    {
        helper('bilangan');
        $faktur = $this->faktur->where('faktur.id',$id)
        ->join("pelanggan","pelanggan.id = faktur.pelanggan_id")
        ->get()->getRow();

        $penjualan = $this->db->table("detail_penjualan")
        ->where('faktur',$faktur->faktur)
        ->get()->getResult();

        $resp = [
            "status"=>"success",
            "total"=>'-1',
            "records"=>$penjualan,
            "faktur"=>$faktur,
        ];

        return $this->respond($resp);


    }


}