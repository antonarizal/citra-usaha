<?php 
    $subroutes->add('piutang/all', 'Piutang::all');
    $subroutes->add('piutang/pembayaran', 'Piutang::pembayaran');
    $subroutes->add('piutang/riwayatPiutang', 'Piutang::riwayatPiutang');
    $subroutes->add('piutang/detailpembayaran/(:num)', 'Piutang::detailPembayaran/$1');
    $subroutes->add('piutang/remove', 'Piutang::remove');
    $subroutes->add('piutang/detail/(:num)', 'Piutang::detail/$1');
    $subroutes->add('piutang/riwayat/(:num)', 'Piutang::riwayat/$1');
    $subroutes->add('piutang/bayar/(:num)', 'Piutang::bayar/$1');
