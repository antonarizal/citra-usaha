<?php

	$subroutes->add('customers/all/', 'Customers::all');
	$subroutes->add('customers/remove/', 'Customers::remove');
	$subroutes->add('customers/insert/', 'Customers::insert');
	$subroutes->add('customers/getid/', 'Customers::getId');
	$subroutes->add('customers/index/', 'Customers::index');
	$subroutes->add('customers/search/', 'Customers::search/');