<?php

namespace App\Libraries;
use App\Libraries\Tabletext;

class CetakPiutang
{

   public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->faktur = $this->db->table("faktur");
        $this->kasir = $this->db->table("kasir_penjualan");
    }
    public function result($options, $fakturbayar, $faktur)
    {
        helper("bilangan");
        $lebar= $options->get("printer_width");
        $lebar_kolom = 52 + $lebar;
        $lebar_nama = 1 + $lebar;
        $th=new Tabletext($lebar_kolom,2,"","",""," ");
        $tp=new Tabletext($lebar_kolom,5,"","_"," ");
        
        
        $th->setColumnLength(0, $lebar_kolom)
        ->setUseBodySpace(false);
            
        $tp->setColumnLength(0, 5)
        ->setColumnLength(1, $lebar_nama)
        ->setColumnLength(2, 4)
        ->setColumnLength(3, 9)
        ->setColumnLength(4, 6)
        ->setColumnLength(5, 12)
        ->setUseBodySpace(false);
        
        $th	
        ->addColumn(" ".$options->get("nama_toko"), 1,"center")
        ->commit("body")
        ->addColumn(" ".$options->get("alamat"), 1,"center")
        ->commit("body")
        ->addColumn(" ".$options->get("no_telp"), 1,"center")
        ->commit("body")
        ->addColumn(" NOTA PEMBAYARAN PIUTANG", 1,"left")
        ->commit("body")
        ->addColumn(" No Nota Penjualan : ".$faktur->faktur, 1,"left")
        ->commit("body")
        ->addColumn(" No Nota Piutang   : ".$fakturbayar->faktur, 1,"left")
        ->commit("body");        
        $th	
        ->addColumn(" Tgl Bayar         : ".date_format(date_create($faktur->date),'d/m/Y') . ' '.date('H:i:s'), 1,"left")
        ->commit("body");
        $th	
        ->addColumn("", 1,"left")
        ->commit("body");
        $th	
        ->addColumn(" PEMBAYARAN CICILAN : ", 1,"left")
        ->commit("body");
        $th	
        ->addColumn(" Rp.".angkaFormat($fakturbayar->grand_total), 1,"left")
        ->commit("body");
        
        $tp	
        ->addColumn("TOTAL PIUTANG : ", 5,"left")
        ->addColumn(" Rp.".angkaFormat($faktur->hutang), 2,"right")
        ->commit("header")
        ;
        $tp	
        ->addColumn("TOTAL PIUTANG DIBAYAR : ", 5,"left")
        ->addColumn(" Rp.".angkaFormat($faktur->hutang_dibayar), 2,"right")
        ->commit("body")
        ;
        $tp	
        ->addColumn("SISA PIUTANG : ", 5,"left")
        ->addColumn(" Rp.".angkaFormat($faktur->hutang_sisa), 2,"right")
        ->commit("footer")
        ;
        $text = $th->getText() . $tp->getText();
        $resp = [
            "success"=>true,
            "data"=>$text,
            "printer"=>[
                "font_weight"=> $options->get("printer_font_weight"),
                "font_family"=> $options->get("printer_font_family"),
                "font_size"=> $options->get("printer_font_size"),
                "margin_top"=> $options->get("printer_margin_top"),
                "margin_left"=> $options->get("printer_margin_left"),
            ]
        ];
        return ($resp);
        // echo $text;
    }
    
}