<?php

namespace App\Libraries;
use App\Libraries\Tabletext;

class CetakCustom
{

   public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->faktur = $this->db->table("faktur");
        $this->kasir = $this->db->table("kasir_penjualan");
    }
    public function result($options, $faktur, $penjualan)
    {
        date_default_timezone_set('Asia/Jakarta'); 
        helper("bilangan");
        $lebar= $options->get("printer_width");
        $lebar_kolom = 51 + $lebar;
        $lebar_nama = 10 + $lebar;
        $th=new Tabletext($lebar_kolom,2,"","",""," ");
        $tf=new Tabletext($lebar_kolom,2,"","",""," ");
        $tp=new Tabletext($lebar_kolom,5,"","_"," ");
        
        $th->setColumnLength(0, $lebar_kolom)
        ->setUseBodySpace(false);
            
        $tf->setColumnLength(0, $lebar_kolom)
        ->setUseBodySpace(false);
            
            
        $tp->setColumnLength(0, 5)
        ->setColumnLength(1, $lebar_nama)
        ->setColumnLength(2, 4)
        ->setColumnLength(3, 9)
        ->setColumnLength(4, 9)
        ->setColumnLength(5, 9)
        ->setUseBodySpace(false);
        
        $th	
        ->addColumn(" ".$options->get("nama_toko"),1,"center")
        ->commit("body")
        ->addColumn(" ".$options->get("alamat"), 1,"center")
        ->commit("body")
        ->addColumn(" ".$options->get("no_telp"), 1,"center")
        ->commit("body")
        ->addLine("body")
        ->addColumn(" NO. NOTA  : ".$faktur->faktur, 1,"left")
        ->commit("body");
        $th	
        ->addColumn(" TGL.      : ".date_format(date_create($faktur->date),'d/m/Y') . ' '.date('H:i:s'), 1,"left")
        ->commit("body");
        $th	
        ->addColumn(" PELANGGAN : ".$faktur->nama_pelanggan, 1,"left")
        ->commit("body");
        

        $tp	
        ->addColumn("NO", 1,"center")
        ->addColumn("NAMA BRG", 1,"left")
        ->addColumn("QTY", 1,"center")
        ->addColumn("HARGA", 1,"right")
        ->addColumn("DISKON", 1,"right")
        ->addColumn("TOTAL", 1,"right")
        ->commit("header")
        ;
        
        $i=1;
        foreach($penjualan as $row){
            $row=(object) $row;	
            // if($row->jenis == "barang"){
                $tp	
                ->addColumn($i.".", 1,"center")
                ->addColumn($row->nama_barang, 5,"left")
                ->commit("body");
                $tp	
                ->addColumn("", 1,"center")
                ->addColumn("", 1,"left")
                ->addColumn($row->qty, 1,"center")
                ->addColumn(angkaFormat($row->harga_jual), 1,"right")
                ->addColumn('-'.angkaFormat($row->diskon), 1,"right")
                ->addColumn(angkaFormat($row->total), 1,"right")
                ->commit("body");
            // }else{

            //     $jasa = " + ";
            //     $qty = "";
            //     $harga = "";
            //     $tp	
            //     ->addColumn($i.".", 1,"center")
            //     ->addColumn($jasa .($row->nama_barang), 2,"left")
            //     ->addColumn($qty, 1,"center")
            //     ->addColumn($qty, 1,"center")
            //     ->addColumn(angkaFormat($row->total), 1,"right")
            //     ->commit("body");
            // }
            $i++;

        }
        
        $tp	
        ->addColumn(" TOTAL", 2,"left")
        ->addColumn($faktur->terjual, 1,"center")
        ->addColumn("", 2,"right")
        ->addColumn(angkaFormat($faktur->total), 1,"right")
        ->commit("footer");
        $tp	
        ->addColumn(" DIBAYAR ", 2,"left")
        ->addColumn("", 1,"center")
        ->addColumn("", 2,"right")
        ->addColumn(angkaFormat($faktur->dibayar), 1,"right")
        ->commit("footer");
        // $tp	
        // ->addLine("footer")
        // ->addColumn($options->get("printer_show_footer") ? $options->get("printer_footer_text") : "", 5,"center")
        // ->commit("footer")
        // ;
        $fText =  $options->get("printer_show_footer") ? $options->get("printer_footer_text") : "";
        $fText =  explode("\n",$fText);
        foreach($fText as $txt){
            $tf	
            ->addColumn(trim($txt),1,"center")
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
        // echo ($text);
        return ($text);

    }
    
}