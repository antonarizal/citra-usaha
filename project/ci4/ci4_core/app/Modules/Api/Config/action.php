<?php
	$subroutes->add('action/truncate/(:any)', 'Action::truncate/$1');
	$subroutes->add('action/delete_transaksi/(:any)', 'Action::delete_transaksi/$1');
	$subroutes->add('action/dashboard/', 'Action::dashboard');
	$subroutes->add('action/chart/', 'Action::chart');
	$subroutes->add('action/decode/', 'Action::decode');
