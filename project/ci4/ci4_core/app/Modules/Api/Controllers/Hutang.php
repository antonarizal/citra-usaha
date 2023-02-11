<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Hutang  extends ResourceController
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
    private function supplier($id)
    {
        $query = $this->db->table("supplier")->select("nama_supplier")
                ->where("id",$id)->get()->getRow();
        return($query->nama_supplier);

    
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
            "mode"=>"pembelian",
            "pembayaran"=>"kredit"
        ];
        if(isset($_GET["tgl_mulai"])){
            $where = [
                "mode"=>"pembelian",
                "pembayaran"=>"kredit",
                "date >="=>$this->request->getGet("tgl_mulai"),
                "date <="=>$this->request->getGet("tgl_selesai"),
            ];
        }
        $join = ["supplier","faktur.supplier_id = supplier.id"];
        $result = $this->w2ui->result($this->fakturModel->where($where), $fields, $request);
        $pemasukan =  $this->db->table("faktur")->selectSum("pemasukan")->where($where)->get()->getResultArray();
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
            "pemasukan"=>$pemasukan[0]["pemasukan"],
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


    public function bayar($id = null)
    {
        helper('bilangan');
        $request = (object)$this->request->getPost();

        $data_input = [
            "faktur"=>$request->faktur,
            "keterangan"=>$request->faktur_pembelian,
            "user_id"=>$request->user_id,
            "supplier_id"=>$request->supplier_id,
            "pembayaran"=>"tunai",
            "date"=>$request->date,
            "total"=>angka($request->dibayar),
            "mode"=>"bayar_hutang",
            "grand_total"=>angka($request->dibayar),
            "pengeluaran"=>angka($request->dibayar),

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