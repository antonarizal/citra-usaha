<?php

	$subroutes->add('pelanggan/all/', 'Pelanggan::all');
	$subroutes->add('pelanggan/remove/', 'Pelanggan::remove');
	$subroutes->add('pelanggan/insert/', 'Pelanggan::insert');
	$subroutes->add('pelanggan/create/', 'Pelanggan::create');
	$subroutes->add('pelanggan/getid/', 'Pelanggan::getId');
	$subroutes->add('pelanggan/index/', 'Pelanggan::index');
	$subroutes->add('pelanggan/search/', 'Pelanggan::search');
	$subroutes->add('pelanggan/truncate/', 'Pelanggan::truncate');