<style>
	@page {
  size: A4;
  margin: 0;
}
@media print {
  html, body {
    width: 210mm;
  }
  /* ... the rest of the rules ... */
}
</style>
<?php
use App\Libraries\Tabletext;

$lebar= 8;
$lebar_kolom = 92 + $lebar;
$lebar_nama = 32 + $lebar;
$th=new Tabletext($lebar_kolom,2,"","","");
$tp=new Tabletext($lebar_kolom,6);
$tpf=new Tabletext($lebar_kolom,6);
$tx=new Tabletext($lebar_kolom,6,"","","");
$tf=new Tabletext($lebar_kolom,2,"","","");

$th->setColumnLength(0, 50)
	->setColumnLength(1, 47)
	->setUseBodySpace(false);
$tp->setColumnLength(0, 5)
	->setColumnLength(1, $lebar_nama)
	->setColumnLength(2, 6)
	->setColumnLength(3, 15) 
	->setColumnLength(4, 12)
	->setColumnLength(5, 15)
	->setUseBodySpace(false);
$tpf->setColumnLength(0, 5)
	->setColumnLength(1, $lebar_nama)
	->setColumnLength(2, 6)
	->setColumnLength(3, 15) 
	->setColumnLength(4, 12)
	->setColumnLength(5, 15)
	->setUseBodySpace(false);
$tf->setColumnLength(0, 50)
	->setColumnLength(1, 47)
	->setUseBodySpace(false);
   
$th
->addColumn(" ".('nama_toko'), 1,"left")
->addColumn("FAKTUR PJL :".$faktur->faktur, 1,"left")
->commit("body")
;   
$th
->addColumn(" ".str_replace("\n"," ",('alamat')), 1,"left")
->addColumn("TANGGAL    :".date_format(date_create($faktur->date),"d/m/Y"), 1,"left")
->commit("body")
;

$th
->addColumn(" ".str_replace("\n"," ",('no_hp')), 1,"left")
->addColumn("JTH TEMPO  :".$faktur->tempo, 1,"left")
->commit("body")
;

$th
->addColumn("", 1,"left")
->addColumn("PELANGGAN  :".$faktur->pelanggan_id, 1,"left")
->commit("body");
    
$th
->addColumn("", 1,"left")
->addColumn($faktur->id, 1,"left")
->commit("body");
    
$tp	->addColumn("No. ", 1,"center")
->addColumn("NAMA BARANG", 1,"center")
->addColumn("QTY", 1,"center")
->addColumn("HARGA", 1,"center")
->addColumn("DISC", 1,"center")
->addColumn("TOTAL", 1,"center")
->commit("header")
;

$i=1;
foreach($penjualan as $row){
    $row=(object) $row;	
    $tp	->addColumn(($i).".", 1)
    ->addColumn($row->nama_barang, 1,"left")
    ->addColumn($row->qty, 1,"center")
    ->addColumn(rupiah($row->harga_jual), 1,"right")
    ->addColumn($row->diskon ."%", 1,"right")
    ->addColumn(rupiah($row->total), 1,"right")
    ->commit("body");
    $i++;
}

$tp	->addColumn("", 4,"center")
->addColumn("SUB TOTAL", 1,"left")
->addColumn(rupiah($faktur->total), 1,"right")
->commit("footer")
;
$tp	->addColumn("", 4,"center")
->addColumn("DISKON ($faktur->disc%)", 1,"left")
->addColumn(rupiah($faktur->diskon), 1,"right")
->commit("footer")
;
$tp	->addColumn("", 4,"center")
->addColumn("POTONGAN", 1,"left")
->addColumn(rupiah($faktur->voucher), 1,"right")
->commit("footer")
;
$tp	->addColumn("", 4,"center")
->addColumn("PAJAK ($faktur->pjk%)", 1,"left")
->addColumn(rupiah($faktur->pajak), 1,"right")
->commit("footer")
;

$tp	->addColumn("", 4,"center")
->addColumn("GRAND TOTAL", 1,"left")
->addColumn(rupiah($faktur->pemasukan), 1,"right")
->commit("footer")
;

$tp	->addColumn("", 4,"center")
->addColumn("DIBAYAR", 1,"left")
->addColumn(rupiah($faktur->dibayar), 1,"right")
->commit("footer")
;


// $tf	->addColumn("TERBILANG : ", 1,"right")
// ->addColumn("- ".strtoupper(terbilang($pemasukan)) ." RUPIAH", 1,"left")
// ->commit("footer");

$tf	->addColumn("(PENERIMA)", 1,"center")
->addColumn("(DISERAHKAN OLEH)", 1,"center")
->commit("footer");
$tf	->addColumn("", 1,"left")->addColumn("", 1,"left")->commit("footer");
$tf	->addColumn("", 1,"left")->addColumn("", 1,"left")->commit("footer");
$tf	->addColumn("", 1,"left")->addColumn("", 1,"left")->commit("footer");
$tf	->addColumn("__________________________________", 1,"center")
    ->addColumn("__________________________________", 1,"center")
->commit("footer");


?>

<?php
echo "<pre>";
echo $th->getText() . 
$tp->getText().
$tf->getText()
;
echo "</pre>";
?>
