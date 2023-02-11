<?php

namespace App\Libraries;
use App\Libraries\Tabletext;

class Cetak58mm
{

   public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->faktur = $this->db->table("faktur");
        $this->kasir = $this->db->table("kasir_penjualan");
    }
    public function result($options, $faktur, $penjualan)
    {
        helper("bilangan");
        $lebar= 10;
        $lebar_kolom = 23 + $lebar;
        $lebar_nama = 1 + $lebar;
        $th=new Tabletext($lebar_kolom,2,"","",""," ");
        $tf=new Tabletext($lebar_kolom,2,"","",""," ");
        $tp=new Tabletext($lebar_kolom,5,"","-"," ");
        
        
        $th->setColumnLength(0, $lebar_nama)
        ->setColumnLength(1, 4)
        ->setColumnLength(2, 5)
        ->setColumnLength(3, 10)
        ->setUseBodySpace(false);
            
        
        $tf->setColumnLength(0, $lebar_nama)
        ->setColumnLength(1, 4)
        ->setColumnLength(2, 5)
        ->setColumnLength(3, 10)
        ->setUseBodySpace(false);
            
        $tp->setColumnLength(0, $lebar_nama)
            ->setColumnLength(1, 4)
            ->setColumnLength(2, 5)
            ->setColumnLength(3, 10)
            ->setUseBodySpace(false);
        
        $th	
        ->addColumn(" ".$options->get("nama_toko"), 4,"center")
        ->commit("body")
        ->addColumn(" ".$options->get("alamat"), 4,"center")
        ->commit("body")
        ->addColumn(" ".$options->get("no_telp"), 4,"center")
        ->commit("body")
        ->addLine("body")
        ->addColumn(" No : ".$faktur->faktur, 4,"left")
        ->commit("body");
        $th	
        ->addColumn(" Tgl : ".date_format(date_create($faktur->date),'d/m/Y') . ' '.date('H:i:s'), 4,"left")
        ->commit("body");
        
        $tp	
        ->addColumn("HARGA", 1,"left")
        ->addColumn("QTY", 1,"left")
        ->addColumn("DISC", 1,"center")
        ->addColumn("TOTAL", 1,"center")
        ->commit("header")
        ;
        
        $i=1;
        foreach($penjualan as $row){
            $row=(object) $row;	
            $tp	
            ->addColumn($row->nama_barang, 4,"left")
            ->commit("body");
            $tp	
            ->addColumn(angkaFormat($row->harga_jual), 1,"left")
            ->addColumn($row->qty, 1,"left")
            ->addColumn($row->disc ."%", 1,"right")
            ->addColumn(angkaFormat($row->total), 1,"right")
            ->commit("body");
            $i++;
        }
        
        $tp	
        ->addColumn("SUB TOTAL : ", 3,"right")
        ->addColumn(angkaFormat($faktur->total), 1,"right")
        ->commit("footer")
        ;
        $tp	
        ->addColumn("DISKON (-$faktur->disc%) : ", 3,"right")
        ->addColumn(angkaFormat(-$faktur->diskon), 1,"right")
        ->commit("footer")
        ;
        $tp	
        ->addColumn("PAJAK ($faktur->pjk%) : ", 3,"right")
        ->addColumn(angkaFormat($faktur->pajak), 1,"right")
        ->commit("footer")
        ;
        
        $tp	
        ->addColumn("GRAND TOTAL : ", 3,"right")
        ->addColumn(angkaFormat($faktur->pemasukan), 1,"right")
        ->commit("footer")
        ;
        
        $tp	
        ->addColumn("TUNAI : ", 3,"right")
        ->addColumn(angkaFormat($faktur->dibayar), 1,"right")
        ->commit("footer")
        ->addLine("footer")
        ->addColumn("KEMBALI : ", 3,"left")
        ->addColumn(angkaFormat($faktur->kembali), 1,"right")
        ->commit("footer")
        ;
        $fText =  $options->get("printer_show_footer") ? $options->get("printer_footer_text") : "";
        $fText =  explode("\n",$fText);
        foreach($fText as $txt){
            $tf	
            ->addColumn(trim($txt),4,"center")
            ->commit("body");
        }
        
        $text = $th->getText() . $tp->getText(). $tf->getText();
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

    }
    
}