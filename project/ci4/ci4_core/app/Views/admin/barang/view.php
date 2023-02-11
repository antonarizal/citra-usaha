<div class="content-wrapper">
            <div class="content-header" style="background:#fff;padding:10px;margin-bottom:20px;">
                <div class="container-fluid">
                <div class="row ">
                  <div class="col-sm-6">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="#">Admin</a></li>
                      <li class="breadcrumb-item active"><?=$title?></li>
                    </ol>
                  </div><!-- /.col -->
                </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="grid_<?=$rand?>" style="width: 100%; height: 600px;overflow:hidden"></div>
                            <span style="float:right" id="count"></span>
        
                        </div>
                    </div>
                </div>
        </section>
        </div>
        
        <?php 
        // include "modal.php";
        include "js.php";
        ?>