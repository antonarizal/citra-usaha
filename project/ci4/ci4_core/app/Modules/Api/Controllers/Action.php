<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Action  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->barang      = $this->db->table("barang");
        $this->barangModel = new \App\Modules\Api\Models\BarangModel();
        $this->w2ui =  new W2ui();
        date_default_timezone_set("Asia/Jakarta");

    }

    public function decode()
    {
        $url = "http://127.0.0.1:8899//api/barang/all?request=%7B%22limit%22%3A20%2C%22offset%22%3A0%2C%22searchLogic%22%3A%22OR%22%2C%22search%22%3A%5B%7B%22field%22%3A%22nama_barang%22%2C%22type%22%3A%22text%22%2C%22operator%22%3A%22begins%22%2C%22value%22%3A%22baju%22%7D%5D%2C%22sort%22%3A%5B%7B%22field%22%3A%22id%22%2C%22direction%22%3A%22desc%22%7D%5D%7D";
        echo urldecode($url);
    
    }
    
    public function truncate($table)
    {
        $result = $this->db->table($table)->truncate();
        if($result){
            $data['success']=true;
            $data['status']='success';
            $data['message']='Data berhasil dikosongkan!';
        }else{
            $data['success']=false;
            $data['status']='failed';
            $data['message']='Data gagal dikosongkan!';
        }
        return $this->respond($data);

    }
    
    public function delete_transaksi($mode)
    {
        if($mode == "transaksi"){
            $result = $this->db->table("faktur")->truncate();
            $result = $this->db->table("detail_pembelian")->truncate();
            $result = $this->db->table("detail_penjualan")->truncate();
            $result = $this->db->table("retur_pembelian")->truncate();
            $result = $this->db->table("retur_penjualan")->truncate();

        }else{
            $result = $this->db->table("faktur")->where("mode",$mode)->delete();

        }
        if($result){
            $data['success']=true;
            $data['status']='success';
            $data['message']='Data berhasil dikosongkan!';
        }else{
            $data['success']=false;
            $data['status']='failed';
            $data['message']='Data gagal dikosongkan!';
        }
        return $this->respond($data);

    }
    public function chart()
    {
        for($i=1; $i<13 ; $i++){
            $m = str_pad($i,2,"0",STR_PAD_LEFT);
            $y = date("Y");
            // $date[]["month"]=$m;
            // $date[]["month"]=$m;
            $penjualan= $this->db->query("SELECT SUM(grand_total) FROM faktur WHERE mode ='penjualan' AND strftime('%m',date) = '$m' AND strftime('%Y',date) = '$y'")->getRowArray()["SUM(grand_total)"];
            $pj[] = round($penjualan/1000);
            $laba= $this->db->query("SELECT SUM(laba_rugi) FROM faktur WHERE mode ='penjualan' AND strftime('%m',date) = '$m' AND strftime('%Y',date) = '$y'")->getRowArray()["SUM(laba_rugi)"];
            $lb[] = $laba != null ? ($laba/1000) : 0;


        }
        $data = [
            "penjualan"=>$pj,
            "laba"=>$lb,
        ];
        return $this->respond($data);
    
    }
    
    public function dashboard()
    {
        $d = date("Y-m-d");
        $m = date("m");
        $y = date("Y");
        $pj_day = $this->db->query("SELECT SUM(grand_total) FROM faktur WHERE mode ='penjualan' AND date = '$d'")->getRowArray()["SUM(grand_total)"];
        $pj_month = $this->db->query("SELECT SUM(grand_total) FROM faktur WHERE mode ='penjualan' AND strftime('%m',date) = '$m' AND strftime('%Y',date) = '$y'")->getRowArray()["SUM(grand_total)"];
        $pj_year = $this->db->query("SELECT SUM(grand_total) FROM faktur WHERE mode ='penjualan' AND strftime('%Y',date) = '$y'")->getRowArray()["SUM(grand_total)"];
        $pj_all = $this->db->query("SELECT SUM(grand_total) FROM faktur WHERE mode ='penjualan'")->getRowArray()["SUM(grand_total)"];

        $rpj_day = $this->db->query("SELECT SUM(grand_total) FROM faktur WHERE mode ='retur_penjualan' AND date = '$d'")->getRowArray()["SUM(grand_total)"];
        $rpj_month = $this->db->query("SELECT SUM(grand_total) FROM faktur WHERE mode ='retur_penjualan' AND strftime('%m',date) = '$m' AND strftime('%Y',date) = '$y'")->getRowArray()["SUM(grand_total)"];
        $rpj_year = $this->db->query("SELECT SUM(grand_total) FROM faktur WHERE mode ='retur_penjualan' AND strftime('%Y',date) = '$y'")->getRowArray()["SUM(grand_total)"];
        $rpj_all = $this->db->query("SELECT SUM(grand_total) FROM faktur WHERE mode ='retur_penjualan'")->getRowArray()["SUM(grand_total)"];

        $bpiu_day = $this->db->query("SELECT SUM(grand_total) FROM faktur WHERE mode ='bayar_piutang' AND date = '$d'")->getRowArray()["SUM(grand_total)"];
        $bpiu_month = $this->db->query("SELECT SUM(grand_total) FROM faktur WHERE mode ='bayar_piutang' AND strftime('%m',date) = '$m' AND strftime('%Y',date) = '$y'")->getRowArray()["SUM(grand_total)"];
        $bpiu_year = $this->db->query("SELECT SUM(grand_total) FROM faktur WHERE mode ='bayar_piutang' AND strftime('%Y',date) = '$y'")->getRowArray()["SUM(grand_total)"];
        $bpiu_all = $this->db->query("SELECT SUM(grand_total) FROM faktur WHERE mode ='bayar_piutang'")->getRowArray()["SUM(grand_total)"];
        

        $laba_day = $this->db->query("SELECT SUM(laba_rugi) FROM faktur WHERE mode ='penjualan' AND date = '$d'")->getRowArray()["SUM(laba_rugi)"];
        $laba_month = $this->db->query("SELECT SUM(laba_rugi) FROM faktur WHERE mode ='penjualan' AND strftime('%m',date) = '$m' AND strftime('%Y',date) = '$y'")->getRowArray()["SUM(laba_rugi)"];
        $laba_year = $this->db->query("SELECT SUM(laba_rugi) FROM faktur WHERE mode ='penjualan' AND strftime('%Y',date) = '$y'")->getRowArray()["SUM(laba_rugi)"];
        $laba_all = $this->db->query("SELECT SUM(laba_rugi) FROM faktur WHERE mode ='penjualan'")->getRowArray()["SUM(laba_rugi)"];

        $terjual_day = $this->db->query("SELECT SUM(terjual) FROM faktur WHERE mode ='penjualan' AND date = '$d'")->getRowArray()["SUM(terjual)"];
        $terjual_month = $this->db->query("SELECT SUM(terjual) FROM faktur WHERE mode ='penjualan' AND strftime('%m',date) = '$m' AND strftime('%Y',date) = '$y'")->getRowArray()["SUM(terjual)"];
        $terjual_year = $this->db->query("SELECT SUM(terjual) FROM faktur WHERE mode ='penjualan' AND strftime('%Y',date) = '$y'")->getRowArray()["SUM(terjual)"];
        $terjual_all = $this->db->query("SELECT SUM(terjual) FROM faktur WHERE mode ='penjualan'")->getRowArray()["SUM(terjual)"];

        $data = [
            "penjualan"=>[
                "day"=>$pj_day,
                "month"=>$pj_month,
                "year"=>$pj_year,
                "all"=>$pj_all,
            ],
            "laba"=>[
                "day"=>$laba_day,
                "month"=>$laba_month,
                "year"=>$laba_year,
                "all"=>$laba_all,
            ],
            "terjual"=>[
                "day"=>$terjual_day,
                "month"=>$terjual_month,
                "year"=>$terjual_year,
                "all"=>$terjual_all,
            ],
            "retur_penjualan"=>[
                "day"=>$rpj_day,
                "month"=>$rpj_month,
                "year"=>$rpj_year,
                "all"=>$rpj_all,
            ],
            "bayar_piutang"=>[
                "day"=>$bpiu_day,
                "month"=>$bpiu_month,
                "year"=>$bpiu_year,
                "all"=>$bpiu_all,
            ]

        ];
        return $this->respond($data);


    }
    
    
}