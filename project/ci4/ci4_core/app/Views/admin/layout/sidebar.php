<?php
include("sidebar_array.php");
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-olive elevation-4">
    <!-- Brand Logo -->
    <a href="<?=base_url("admin/panel")?>" class="brand-link">
        <span class="brand-text font-weight-light">DIVAPOS V3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu"
                data-accordion="false">

                <?php

                foreach ($nav as $row){
                    $row=(object) $row;

                ?>
                <li class="nav-item">
                    <a href="javascript:void(0)" onClick="load('<?=base_url("admin/".$row->parent)?>','<?=$row->parent?>');" class="nav-link <?=base_url("index.php/admin/".$row->parent) == current_url() ? "active" : ""?>" id="nav_<?=$row->parent?>">
                        <i class="fas far <?=$row->icons?> nav-icon"></i>
                        <p><?=ucwords($row->parent)?> </p>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>