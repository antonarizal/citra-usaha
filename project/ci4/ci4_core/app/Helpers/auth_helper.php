<?php

function is_login(){

    $session = session();
    if(!$session->has('isLogin')){
        return redirect()->to('/auth/login');
    }
    
}

?>