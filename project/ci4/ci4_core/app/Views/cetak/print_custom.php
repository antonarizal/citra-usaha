<style>
	@page {
  margin: 0;
}
@media print {
  html, body {
    width: 210mm;
  }
  /* ... the rest of the rules ... */
}
</style>
<body onLoad="window.print();" style="width:16cm!important;font-weight:<?=$options->get("printer_font_bold") ? "bold" : "normal"?>;margin-top:<?=$options->get("printer_margin_top") ?>mm;margin-left:<?=$options->get("printer_margin_left") ?>mm">
<?php
use App\Libraries\Tabletext;

$lebar= 8;
$lebar_kolom = 70 + $lebar;
$lebar_nama = 24 + $lebar;
$th=new Tabletext($lebar_kolom,2,"","",""," ");
$tp=new Tabletext($lebar_kolom,5,"","-"," ");


$th->setColumnLength(0, $lebar_kolom)
->setUseBodySpace(false);
	
$tp->setColumnLength(0, 5)
	->setColumnLength(1, $lebar_nama)
	->setColumnLength(2, 10)
	->setColumnLength(3, 12)
	->setColumnLength(4, 13)
	->setUseBodySpace(false);

$th	
->addColumn("*** NOTA PENJUALAN ***", 1,"center")
->commit("body")
->addLine("body")
->addColumn($options->get("nama_toko"), 1,"center")
->commit("body")
->addColumn($options->get("alamat"), 1,"center")
->commit("body")
->addColumn($options->get("no_telp"), 1,"center")
->commit("body")
->addLine("body")
->addColumn(" No : ".$faktur->faktur, 1,"left")
->commit("body");
$th	
->addColumn(" Tgl : ".date_format(date_create($faktur->date),'d/m/Y') . ' '.date('H:i:s'), 1,"left")
->commit("body");

$tp	
->addColumn("NO", 1,"center")
->addColumn("NAMA BARANG", 1,"left")
->addColumn("QTY", 1,"center")
->addColumn("HARGA", 1,"right")
->addColumn("TOTAL", 1,"right")
->commit("header")
;

$i=1;
foreach($penjualan as $row){
    $row=(object) $row;	
    if($row->jenis =="barang"){
        $jasa = "";
        $qty = $row->qty;
        $harga = angkaFormat($row->harga_jual);
        $diskon = $row->diskon * $row->harga_jual / 100;
        $harga_asli = $row->qty * $row->harga_jual;
        $tp	
        ->addColumn($i . ".", 1,"right")
        ->addColumn($jasa .($row->nama_barang), 1,"left")
        ->addColumn($qty, 1,"center")
        ->addColumn($harga, 1,"right")
        ->addColumn(angkaFormat($harga_asli), 1,"right")
        ->commit("body");
        if($row->diskon > 0){
          $tp	
          ->addColumn(" ", 1,"right")
          ->addColumn(" - DISKON (".$row->diskon."%)", 1,"left")
          ->addColumn("", 1,"center")
          ->addColumn("", 1,"right")
          ->addColumn("-".angkaFormat($diskon), 1,"right")
          ->commit("body");
  
        }

    }else{
        $jasa = " + ";
        $qty = "";
        $harga = "";
        $tp	
        ->addColumn($i . ".", 1,"right")
        ->addColumn($jasa .($row->nama_barang), 1,"left")
        ->addColumn($qty, 1,"center")
        ->addColumn($harga, 1,"right")
        ->addColumn(angkaFormat($row->total), 1,"right")
        ->commit("body");
    }

    $i++;
}

$tp	
->addColumn("JUMLAH TOTAL : ", 2,"left")
->addColumn($faktur->terjual, 1,"center")
->addColumn(angkaFormat($faktur->total), 2,"right")
->commit("footer")
;



?>

<?php
echo "<pre>";
echo $th->getText() . 
$tp->getText();
echo "</pre>";
?>
<pre style="font-size:12px;font-family:arial;text-align:center">
<?=$options->get("printer_show_footer") ? $options->get("printer_footer_text") : ""?>
</pre>
</body>