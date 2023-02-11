<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('api', ['namespace' => 'App\Modules\Api\Controllers'], function($subroutes){

	$subroutes->add('lokasi/gudang', 'Lokasi::gudang');
	$subroutes->add('konversi/satuan', 'Konversi::satuan');
	$subroutes->add('options/toko', 'Options::toko');
	$subroutes->add('options/save', 'Options::save');
	$subroutes->add('options/cetak', 'Options::cetak');
	$subroutes->add('options/tes', 'Options::tes');
	//penjualan
	$subroutes->add('kasir/insert', 'Kasir::insert');
	$subroutes->add('retur/penjualan/insert', 'ReturPenjualan::insert');
	$subroutes->add('retur/penjualan/remove', 'ReturPenjualan::remove');
	$subroutes->add('retur/penjualan/all', 'ReturPenjualan::all');
	$subroutes->add('retur/penjualan/detail/(:num)', 'ReturPenjualan::detail/$1');
	$subroutes->add('penjualan/all', 'Penjualan::all');
	$subroutes->add('penjualan/remove', 'Penjualan::remove');
	$subroutes->add('penjualan/detail/(:num)', 'Penjualan::detail/$1');
	//pembelian
	$subroutes->add('retur/pembelian/insert', 'ReturPembelian::insert');
	$subroutes->add('retur/pembelian/all', 'ReturPembelian::all');
	$subroutes->add('retur/pembelian/remove', 'ReturPembelian::remove');
	$subroutes->add('retur/pembelian/detail/(:num)', 'ReturPembelian::detail/$1');
	$subroutes->add('pembelian/all', 'Pembelian::all');
	$subroutes->add('pembelian/insert', 'Pembelian::insert');
	$subroutes->add('pembelian/detail/(:num)', 'Pembelian::detail/$1');
	//laporan
	$subroutes->add('laporan/penjualan/(:any)', 'Laporan::penjualan/$1');
	$subroutes->add('laporan/pembelian/(:any)', 'Laporan::pembelian/$1');
	$subroutes->add('laporan/piutang', 'Laporan::piutang');
	$subroutes->add('laporan/kas', 'Laporan::kas');

	$subroutes->add('cetak/print', 'Cetak::print');
	$subroutes->add('cetak/piutang', 'Cetak::piutang');
	$subroutes->add('cetak/custom', 'Cetak::custom');

	$subroutes->add('maintenance/penjualan', 'Maintenance::penjualan');
	$subroutes->add('maintenance/updatepenjualan', 'Maintenance::updatepenjualan');

	include 'jasa.php';	
	include 'kategori.php';	
	include 'satuan.php';	
	include 'barang.php';
	include 'product.php';
	include 'pelanggan.php';
	include 'salesman.php';
	include 'supplier.php';
	include 'piutang.php';
	include 'hutang.php';
	include 'user.php';
	include 'action.php';
	// include 'mutasi.php';


});