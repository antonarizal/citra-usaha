<?php
foreach($viewpath as $view){
    include(APPPATH.'/Modules/'.$moduleName.'/Views/'.$view.'.php');
}
?>
