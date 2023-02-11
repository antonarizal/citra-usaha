<!-- CSS Code: Place this code in the document's head (between the <head> -- </head> tags) -->
<title><?=$title?></title>
<style>
  body{
    font-family:Arial;

  }
  p{
    font-size:11px;
    line-height:5px;
  }
  h3{
    font-size:18px;
    line-height:5px;
  }
  .table-sm{
    font-size:12px;
    font-family: Arial;
  }
table.customTable {
  width: 100%;
  background-color: #FFFFFF;
  border-collapse: collapse;
  border-width: 1px;
  border-color: #CCCCCC;
  border-style: solid;
  color: #000000;
  font-family:arial!important;

}

table.customTable td, table.customTable th {
  border-width: 1px;
  border-color: #CCCCCC;
  border-style: solid;
  padding: 5px;
  font-size:11px;
  font-family:arial!important;

}

table.customTable thead {
  background-color: #FFFFFF;
}
</style>
<?php 
$request = (object) $request;
?>
<!-- HTML Code: Place this code in the document's body (between the <body> tags) where the table should appear -->
<div  style="border-bottom:1px dashed;padding-bottom:5px;">
  <h3><?=$options->get("nama_toko")?></h3>
  <p><?=$options->get("alamat")?></p>
  <p><?=$options->get("no_telp")?></p>
</div>
<h3>Laporan Penjualan</h3>
  <table class="table-sm">
    <tr>
      <td>Periode tgl.</td><td>: <?= date_format(date_create(($request->tgl_mulai)),"d-m-Y");?></td>
      <td>s/d tgl.</td><td><?= date_format(date_create(($request->tgl_selesai)),"d-m-Y")?></td>
    </tr>
    <tr>
      <td>Tgl Cetak</td> <td  colspan=3>: <?= date("d-m-Y H:i:s")?></td>
    </tr>
  </table>
  
<table class="customTable">
  <thead>
    <tr>
      <th>No</th>
      <th>Faktur</th>
      <th>Tanggal</th>
      <th>Nama Pelanggan</th>
      <th>Pembayaran</th>
      <th  style="text-align:right">Total</th>
      <th  style="text-align:right">Laba</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $i=1;
foreach($faktur as $row)
{
?>
<tr>
  <td style="width:50px;text-align:center"><?=$i?>.</td>
  <td><?=$row->faktur?></td>
  <td><?=$row->date?></td>
  <td><?=$row->nama_pelanggan?></td>
  <td><?=$row->pembayaran?></td>
  <td  style="text-align:right"><?=angkaFormat($row->pemasukan)?></td>
  <td  style="text-align:right"><?=angkaFormat($row->laba_rugi)?></td>
</tr>

<?php
$i++;
}
?>
  </tbody>
  <tfoot>
    <tr>
      <th colspan=6 style="text-align:right">Total Penjualan</th>
      <th  style="text-align:right"><?=angkaFormat($total)?></th>
    </tr>
    <tr>
      <th colspan=6 style="text-align:right">Total Laba</th>
      <th  style="text-align:right"><?=angkaFormat($laba)?></th>
    </tr>
  </tfoot>
</table>
<!-- Generated at CSSPortal.com -->
