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
<h3><?=$title?></h3>
  <table class="table-sm">
    <tr>
      <td>Periode tgl.</td><td>: <?= date_format(date_create(($request->dateStart)),"d-m-Y");?></td>
      <td>s/d tgl.</td><td><?= date_format(date_create(($request->dateEnd)),"d-m-Y")?></td>
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
      <th>Tagihan</th>
      <th>Dibayar</th>
      <th>Sisa</th>
      <th>Jatuh Tempo</th>
      <th>Nama Pelanggan</th>
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
  <td><?=angkaFormat($row->hutang)?></td>
  <td><?=angkaFormat($row->hutang_dibayar)?></td>
  <td><?=angkaFormat($row->hutang_sisa)?></td>
  <td><?=$row->tempo?></td>
  <td><?=$row->nama_pelanggan?></td>
</tr>

<?php
$i++;
}
?>
  </tbody>
</table>
<!-- Generated at CSSPortal.com -->
