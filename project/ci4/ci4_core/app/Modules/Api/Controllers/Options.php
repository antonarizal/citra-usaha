<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Options  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->options      = $this->db->table("options");
        $this->w2ui =  new W2ui();

    }
    public function getdata($option_name)
    {
        $data =  $this->options->select("option_value")->where("option_name",$option_name)
                ->get()->getRow();
        return($data->option_value);
    }
    public function toko()
    {
        $data = [
            "nama_toko"=>$this->getdata("nama_toko"),
            "alamat"=>$this->getdata("alamat"),
            "no_telp"=>$this->getdata("no_telp"),
        ];
        return $this->respond($data);
    }
    public function cetak()
    {
        $data = [
            "default_ukuran_kertas"=>$this->getdata("default_ukuran_kertas"),
            "printer_font_weight"=>$this->getdata("printer_font_weight"),
            "printer_font_size"=>$this->getdata("printer_font_size"),
            "printer_font_family"=>$this->getdata("printer_font_family"),
            "printer_footer_text"=>$this->getdata("printer_footer_text"),
            "printer_margin_top"=>$this->getdata("printer_margin_top"),
            "printer_margin_left"=>$this->getdata("printer_margin_left"),
            "printer_width"=>$this->getdata("printer_width"),
        ];
        return $this->respond($data);
    }
    
    public function save()
    {
        $req = $this->request->getPost();
        foreach($req as $name=>$value){
            $data = [
                "option_value"=>$value
            ];
            $update = $this->options->where("option_name",$name)->update($data);
        }
        $response = [
            "success"=> $update ? true : false,
            "message"=> $update ? "Data berhasil disimpan" : "Gagal",
        ];
        return $this->respond($response);
    }
    public function tes()
    {
        $dompdf = new \Dompdf\Dompdf(); 

        echo "tes";
    }
    
    

}