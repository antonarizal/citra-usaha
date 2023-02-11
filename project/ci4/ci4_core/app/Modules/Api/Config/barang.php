<?php 
    $subroutes->add('barang/all', 'Barang::all');
    $subroutes->add('barang/stok', 'Barang::stok');
    $subroutes->add('barang/create', 'Barang::create');
    $subroutes->add('barang/update/(:num)', 'Barang::update/$1');
    $subroutes->add('barang/getdata', 'Barang::getdata');
    $subroutes->add('barang/truncate', 'Barang::truncate');