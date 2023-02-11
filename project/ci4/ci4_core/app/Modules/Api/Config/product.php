<?php 
    $subroutes->add('product/retail', 'Product::retail');
    $subroutes->add('product/jasa', 'Product::jasa');
	$subroutes->add('product/detail/(:alphanum)', 'Product::detail/$1');
	$subroutes->add('product/barcode/(:alphanum)', 'Product::barcode/$1');
	$subroutes->add('product/grosir', 'Product::grosir');
	$subroutes->add('product/retail/search/', 'Product::retail_search');
	$subroutes->add('product/jasa/search/', 'Product::jasa_search');
	$subroutes->add('product/jasa/changeprice/(:alphanum)', 'Product::gantihargajasa/$1');
	$subroutes->add('product/grosir/search/', 'Product::grosir_search');