<?php 
    $subroutes->add('hutang/all', 'Hutang::all');
    $subroutes->add('hutang/remove', 'Hutang::remove');
    $subroutes->add('hutang/detail/(:num)', 'Hutang::detail/$1');
    $subroutes->add('hutang/bayar/(:num)', 'Hutang::bayar/$1');
