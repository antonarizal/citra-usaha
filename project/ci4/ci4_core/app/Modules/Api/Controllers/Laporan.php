<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;
use App\Libraries\Options;

class Laporan  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->barang      = $this->db->table("barang");
        $this->faktur      = $this->db->table("faktur");
        $this->fakturModel = new \App\Modules\Api\Models\FakturModel();
        $this->w2ui =  new W2ui();
        $this->options = new Options;
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
    public function penjualan($pembayaran)
    {	
        
        helper("bilangan");
        $request = (object)$this->request->getPost();
        if($pembayaran != "all"){
        $this->faktur->where('pembayaran',$pembayaran);
        }
        $this->faktur
        ->where('mode','penjualan')
        ->where('date >=',$request->tgl_mulai)
        ->where('date <=',$request->tgl_selesai)
        ->join('pelanggan', 'pelanggan.id = faktur.pelanggan_id');
        $result = $this->faktur->get()->getResult();

        $total = $this->db->table("faktur")->selectSum('pemasukan');
        if($pembayaran != "all"){
            $total->where('pembayaran',$pembayaran);
        }

        $total = $total->where('mode','penjualan')
        ->where('date >=',$request->tgl_mulai)
        ->where('date <=',$request->tgl_selesai)
        ->get()->getRow();

        $laba = $this->db->table("faktur")->selectSum('laba_rugi');
        if($pembayaran != "all"){
            $laba->where('pembayaran',$pembayaran);
        }
        $laba = $laba->where('mode','penjualan')
        ->where('date >=',$request->tgl_mulai)
        ->where('date <=',$request->tgl_selesai)
        ->get()->getRow();

        $data = [
            'title' =>  'Laporan Penjualan',
            'date' =>  date('d-m-Y'),
            'time' =>  date('H:i:s'),
            'data' => $result,
            'request' => $request,
            'total' => $total->pemasukan,
            'laba' => $laba->laba_rugi,
            'options' =>  [
                "nama_toko"=>$this->options->get("nama_toko"),
                "alamat"=>$this->options->get("alamat"),
                "no_telp"=>$this->options->get("no_telp"),
            ],

        ];
        return $this->respond($data);
        // print_r($request);
    }
    public function pembelian($pembayaran)
    {	
        helper("bilangan");
        $request = (object)$this->request->getPost();
        if($pembayaran != "all"){
        $this->faktur->where('pembayaran',$pembayaran);
        }
        $this->faktur
        ->where('mode','pembelian')
        ->where('date >=',$request->tgl_mulai)
        ->where('date <=',$request->tgl_selesai)
        ->join('supplier', 'supplier.id = faktur.supplier_id');
        $result = $this->faktur->get()->getResult();

        $total = $this->db->table("faktur")->selectSum('pemasukan');
        if($pembayaran != "all"){
            $total->where('pembayaran',$pembayaran);
        }

        $total = $total->where('mode','pembelian')
        ->where('date >=',$request->tgl_mulai)
        ->where('date <=',$request->tgl_selesai)
        ->get()->getRow();

        $laba = $this->db->table("faktur")->selectSum('laba_rugi');
        if($pembayaran != "all"){
            $laba->where('pembayaran',$pembayaran);
        }
        $laba = $laba->where('mode','pembelian')
        ->where('date >=',$request->tgl_mulai)
        ->where('date <=',$request->tgl_selesai)
        ->get()->getRow();

        $data = [
            'title' =>  'Laporan Pembelian',
            'date' =>  date('d-m-Y'),
            'time' =>  date('H:i:s'),
            'data' => $result,
            'request' => $request,
            'total' => $total->pemasukan,
            'laba' => $laba->laba_rugi,
            'options' =>  [
                "nama_toko"=>$this->options->get("nama_toko"),
                "alamat"=>$this->options->get("alamat"),
                "no_telp"=>$this->options->get("no_telp"),
            ],

        ];
        return $this->respond($data);
        // print_r($request);
    }
    public function kas()
    {	
        helper("bilangan");
        $request = (object)$this->request->getPost();
        $this->faktur
        ->where('date >=',$request->tgl_mulai)
        ->where('date <=',$request->tgl_selesai);
        $result = $this->faktur->get()->getResult();

        $total_pemasukan = $this->db->table("faktur")->selectSum('pemasukan');
        $total_pemasukan = $total_pemasukan->where('date >=',$request->tgl_mulai)
        ->where('date <=',$request->tgl_selesai)
        ->get()->getRow();
        $total_pengeluaran = $this->db->table("faktur")->selectSum('pengeluaran');
        $total_pengeluaran = $total_pengeluaran->where('date >=',$request->tgl_mulai)
        ->where('date <=',$request->tgl_selesai)
        ->get()->getRow();


        $data = [
            'title' =>  'Laporan Kas',
            'date' =>  date('d-m-Y'),
            'time' =>  date('H:i:s'),
            'data' => $result,
            'request' => $request,
            'pemasukan' => $total_pemasukan->pemasukan,
            'pengeluaran' => $total_pengeluaran->pengeluaran,
            'options' =>  [
                "nama_toko"=>$this->options->get("nama_toko"),
                "alamat"=>$this->options->get("alamat"),
                "no_telp"=>$this->options->get("no_telp"),
            ],

        ];
        return $this->respond($data);
        // print_r($request);
    }
}