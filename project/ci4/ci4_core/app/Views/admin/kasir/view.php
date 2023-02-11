<div class="content-wrapper">
    <div class="content-header" style="background:#fff;padding:10px;margin-bottom:20px;">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active"><?=$title?> Penjualan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="row">

                        <div class="col-md-12">
                            <input readonly type="text" style="color:red;font-weight:bold;text-align:right;font-size:30px;width:100%" name="total"
                                id="subtotal" class="w2ui-input" value="100000" required autocomplete=off>
                            <div id="form" style="width: 100%;margin-top:20px;margin-bottom:10px">

                                <div class="w2ui-page page-0">
                                    <div class="w2ui-column col-0 text-sm">
                                        <div class="w2ui-field w2ui-span6" style="">
                                            <label>Scan Barcode</label>
                                            <div>
                                                <input placeholder="Cari barang" class="w2ui-input" id="kode_barang"
                                                    name="kode_barang" style="width: 300px" tabindex="2" type="text" />
                                                Harga <input class="w2ui-input" id="harga" name="harga"
                                                    style="width: 100px" tabindex="2" type="text" />
                                                Jumlah <input class="w2ui-input" id="harga" name="harga"
                                                    style="width: 100px" tabindex="2" type="text" />
                                                Diskon(%) <input class="w2ui-input" id="harga" name="harga"
                                                    style="width: 100px" tabindex="2" type="text" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="grid_<?=$rand?>" style="width: 100%; height: 200px;overflow:hidden"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="form2" style="width: 100%;margin-top:20px">
                                <div class="w2ui-page page-0">
                                    <div class="w2ui-column col-0 text-sm">
                                        <div class="w2ui-field w2ui-span6" style="">
                                            <label>Tanggal</label>
                                            <div>
                                                <input class="w2ui-input" type="date" id="first_name" name="first_name"
                                                    style="width: 300px" tabindex="2" value="<?=date("Y-m-d")?>" />
                                            </div>
                                        </div>
                                        <div class="w2ui-field w2ui-span6" style="">
                                            <label>Faktur</label>
                                            <div>
                                                <input class="w2ui-input" id="last_name" name="last_name"
                                                    style="width: 300px" tabindex="2" type="text" />
                                            </div>
                                        </div>

                                        <div class="w2ui-field w2ui-span6" style="">
                                            <label>Catatan</label>
                                            <div>
                                                <textarea class="w2ui-input" id="comments" name="comments"
                                                    style="width: 300px; height: 60px" tabindex="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="form_3" style="width: 100%;margin-top:20px">
                                <div class="w2ui-page page-0">
                                    <div class="w2ui-column col-0 text-sm">
                                        <div class="w2ui-field w2ui-span6" style="">
                                            <label>Pelanggan</label>
                                            <div>
                                                <input class="w2ui-input" id="first_name" name="first_name"
                                                    style="width: 300px" tabindex="2" type="text" />
                                            </div>
                                        </div>
                                        <div class="w2ui-field w2ui-span6" style="">
                                            <label>Pembayaran</label>
                                            <div>
                                                <label><input checked id="last_name" name="pembayaran" tabindex="2"
                                                        type="radio" /> Tunai </label>
                                                <label>
                                                    <input id="last_name" name="pembayaran" tabindex="2" type="radio" />
                                                    Kredit
                                                </label>
                                            </div>
                                        </div>
                                        <div class="w2ui-field w2ui-span6" style="">
                                            <label>Tempo</label>
                                            <div>
                                                <label><input class="w2ui-input" id="last_name" name="last_name"
                                                        style="width: 160px" tabindex="2" type="text" /> Hari
                                                </label>
                                            </div>
                                        </div>
                                        <div class="w2ui-field w2ui-span6" style="">
                                            <label>Jatuh Tempo</label>
                                            <div>
                                                <input class="w2ui-input" id="last_name" name="last_name"
                                                    style="width: 300px" tabindex="2" type="date" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">

                        <div id="toolbar" style="padding: 2px"></div>

                    </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
$(function() {
    var subtotal = $("#subtotal").val()
    $("#subtotal").val(numeral(subtotal).format('0,0'))
    $('#form').w2form({
        name: 'form1',
        fields: [{
                field: 'first_name',
                type: 'text',
            },
            {
                field: 'last_name',
                type: 'text',
            },
            {
                field: 'comments',
                type: 'text'
            }
        ],
    });
    $('#toolbar').w2toolbar({
        name: 'toolbar',
        style   : 'border: 1px solid #ccc',
        panels  : [
        { type: 'top', size: 40 },
        { type: 'preview', size: 200 },
        ],
        items: [

            { type: 'spacer' },
            { type: 'button', id: 'item1', text: 'Simpan', icon: 'fa fa-save' },
            { type: 'button', id: 'item2', text: 'Batal', icon: 'fa fa-times' },
            { type: 'button', id: 'item7', text: 'Bayar', icon: 'fa fa-check' }
        ],
        onClick: function (event) {
            console.log('Target: '+ event.target, event);
        }
    });
});
</script>
<?php 
        // include "modal.php";
        include "js.php";
        ?>