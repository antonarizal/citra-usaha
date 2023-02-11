<?php
namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\Options;
use App\Libraries\Cetak58mm;
use App\Libraries\CetakPiutang;
use App\Libraries\CetakCustom;

class Cetak  extends ResourceController
{
    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->barang      = $this->db->table("barang");
        $this->fakturModel = new \App\Modules\Api\Models\FakturModel();
        $this->faktur = $this->db->table("faktur");
        $this->kasir = $this->db->table("detail_penjualan");
        $this->options = new Options;
        $this->Cetak58mm = new Cetak58mm;
        $this->CetakPiutang = new CetakPiutang;
        $this->CetakCustom = new CetakCustom;

    }
    private function pelanggan($id)
    {
        $query = $this->db->table("pelanggan")->select("nama_pelanggan")
                ->where("id",$id)->get()->getRow();
        return($query->nama_pelanggan);

    
    }
    public function print()
    {
        $faktur = $this->request->getGet("faktur");
        $type = $this->request->getGet("type");
        $this->db      = \Config\Database::connect();
        $getFaktur = $this->faktur->select()->where("faktur",$faktur)->get()->getRow();
        $getKasir = $this->kasir->select()->where("faktur",$faktur)->get()->getResult();

        helper("bilangan");
        // $data = [
        //     'moduleName' =>  'Kasir',
        //     'module' =>  'kasir',
        //     'title' =>  'Kasir',
        //     'header' =>  'Data Kasir',
        //     'options' =>  $this->options,
        //     'viewpath' =>  ["print_".$type],
        //     'rand' =>  date('YmdHis'),
        //     'faktur' => $this->faktur->select()->where("faktur",$faktur)->get()->getRow(),
        //     'penjualan' => $this->kasir->select()->where("faktur",$faktur)->get()->getResult(),
        // ];
        $result = ($this->Cetak58mm->result($this->options,$getFaktur,$getKasir));
        return $this->respond($result);

    }
    public function piutang()
    {
        $faktur = $this->request->getGet("faktur");
        $fakturPj = $this->request->getGet("fakturpj");
        $type = $this->request->getGet("type");
        $this->db      = \Config\Database::connect();
        $getFakturBayar = $this->faktur->select()->where("faktur",$faktur)->get()->getRow();
        $getFaktur = $this->faktur->select()->where("faktur",$fakturPj)->get()->getRow();
        // $getFaktur = $this->kasir->select()->where("faktur",$faktur)->get()->getResult();
        helper("bilangan");
        $result = ($this->CetakPiutang->result($this->options,$getFakturBayar,$getFaktur));
        // return $this->respond($result);
        return $this->respond($result);
    }
    public function returPenjualan()
    {
        $faktur = $this->request->getGet("faktur");
        $fakturPj = $this->request->getGet("fakturpj");
        $type = $this->request->getGet("type");
        $this->db      = \Config\Database::connect();
        $getFakturBayar = $this->faktur->select()->where("faktur",$faktur)->get()->getRow();
        $getFaktur = $this->faktur->select()->where("faktur",$fakturPj)->get()->getRow();
        // $getFaktur = $this->kasir->select()->where("faktur",$faktur)->get()->getResult();
        helper("bilangan");
        $result = ($this->CetakPiutang->result($this->options,$getFakturBayar,$getFaktur));
        // return $this->respond($result);
        return $this->respond($result);
    }
    public function custom()
    {
        $faktur = $this->request->getGet("faktur");
        $type = $this->request->getGet("type");
        $this->db      = \Config\Database::connect();
        $getFaktur = $this->faktur->where('faktur.faktur',$faktur)
        ->join("pelanggan","pelanggan.id = faktur.pelanggan_id")
        ->get()->getRow();
        $getKasir = $this->kasir->select()->where("faktur",$faktur)->get()->getResult();
        helper("bilangan");
        if($this->options->get("default_ukuran_kertas") == "custom"){
            $result = ($this->CetakCustom->result($this->options,$getFaktur,$getKasir));
        }elseif($this->options->get("default_ukuran_kertas") == "58mm"){
            $result = ($this->Cetak58mm->result($this->options,$getFaktur,$getKasir));

        }
        return $this->respond($result);
    }
}