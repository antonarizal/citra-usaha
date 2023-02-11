<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Piutang  extends ResourceController
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
        return($query->nama_pelanggan);

    
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
            $faktur[] = $this->faktur($id);
            $deleted = $this->db->table("detail_penjualan")->delete(["faktur"=>$faktur]);
            $deleted = $this->db->table("faktur")->delete(["keterangan"=>$faktur]);
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
            "mode"=>"penjualan",
            "pembayaran"=>"kredit"
        ];
        if(isset($_GET["tgl_mulai"])){
            $where = [
                "mode"=>"penjualan",
                "pembayaran"=>"kredit",
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
    public function pembayaran()
    {
        $fields = $this->db->getFieldNames("faktur");
        $request =  $this->request->getGet("request");
        $where = [
            "mode"=>"bayar_piutang",
        ];
        if(isset($_GET["tgl_mulai"])){
            $where = [
                "mode"=>"bayar_piutang",
                "date >="=>$this->request->getGet("tgl_mulai"),
                "date <="=>$this->request->getGet("tgl_selesai"),
            ];
        }
        $result = $this->w2ui->result($this->fakturModel->where($where), $fields, $request);
        $pemasukan =  $this->db->table("faktur")->selectSum("pemasukan")->where($where)->get()->getResultArray();
        $terjual =  $this->db->table("faktur")->selectSum("terjual")->where($where)->get()->getResultArray();
        $i=0;
        $data=[];
        if(!empty($result["records"])){
        foreach($result["records"] as $row) {
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
    public function riwayatPiutang()
    {
        $keterangan = $this->request->getGet("fakturpj");
        $fields = $this->db->getFieldNames("faktur");
        $request =  $this->request->getGet("request");
        $where = [
            "mode"=>"bayar_piutang",
            "keterangan"=>$keterangan,
        ];
        if(isset($_GET["tgl_mulai"])){
            $where = [
                "mode"=>"bayar_piutang",
                "keterangan"=>$keterangan,
                "date >="=>$this->request->getGet("tgl_mulai"),
                "date <="=>$this->request->getGet("tgl_selesai"),
            ];
        }
        $result = $this->w2ui->result($this->fakturModel->where($where), $fields, $request);
        $pemasukan =  $this->db->table("faktur")->selectSum("pemasukan")->where($where)->get()->getResultArray();
        $terjual =  $this->db->table("faktur")->selectSum("terjual")->where($where)->get()->getResultArray();
        $i=0;
        $data=[];
        if(!empty($result["records"])){
        foreach($result["records"] as $row) {
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

    public function detailPembayaran($id=null)
    {
        helper('bilangan');
        $fakturPembayaran = $this->faktur->where('faktur.id',$id)
        ->get()->getRow();

        $fakturPenjualan = $this->faktur->where('faktur.faktur',$fakturPembayaran->keterangan)
        ->join("pelanggan","pelanggan.id = faktur.pelanggan_id")
        ->get()->getRow();


        // $fakturPembayaran = $this->faktur->where('faktur.id',$id)
        // ->join("pelanggan","pelanggan.id = faktur.pelanggan_id")
        // ->get()->getRow();

        $resp = [
            "status"=>"success",
            "total"=>'-1',
            "fakturPembayaran"=>$fakturPembayaran,
            "fakturPenjualan"=>$fakturPenjualan,
        ];

        return $this->respond($resp);
    }    

    public function riwayat($id=null)
    {

        $fields = $this->db->getFieldNames("faktur");
        $request =  $this->request->getGet("request");
        $where = [
            "mode"=>"bayar_piutang",
            "keterangan"=>$this->request->getGet("fakturpj"),
        ];
        $result = $this->w2ui->result($this->fakturModel->where($where), $fields, $request);
        $i=0;
        $resp["records"] = ($result);
        $resp["total"] = '-1';
        $resp["status"] = "success";

        return $this->respond($resp);
    }


    public function bayar($id = null)
    {
        helper('bilangan');
        $request = (object)$this->request->getPost();

        $data_input = [
            "faktur"=>$request->faktur,
            "keterangan"=>$request->faktur_penjualan,
            "user_id"=>$request->user_id,
            "pelanggan_id"=>$request->pelanggan_id,
            "pembayaran"=>"tunai",
            "date"=>$request->date,
            "total"=>angka($request->dibayar),
            "mode"=>"bayar_piutang",
            "grand_total"=>angka($request->dibayar),
            "pemasukan"=>angka($request->dibayar),

        ];
        $bayar = $this->faktur->insert($data_input);
        if($bayar){
            $dibayar = angka($request->dibayar) + angka($request->hutang_dibayar);
            $data_update = [
                'hutang_sisa' => angka($request->sisa_sekarang),
                'hutang_dibayar' => $dibayar,
            ];
            $update_faktur = $this->faktur->where('id', $id)->update($data_update);
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
}