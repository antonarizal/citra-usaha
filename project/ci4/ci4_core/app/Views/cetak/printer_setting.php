<form id="post">
    <div class="modal-header">
        <p class="modal-title" style="font-weight:bold">Pengaturan Cetak Nota</p>
    </div>
    <table class="table table-sm text-sm">

        <tr>
            <td style="width:200px">Default Ukuran Kertas</td>
            <td>
                <select name="default_ukuran_kertas" type="number" class="w2ui-input w2field ">
                    <?php 
                        foreach($options->ukuran_kertas() as $ukuran)
                        {
                            $selected = ($options->get("default_ukuran_kertas") == $ukuran['value']) ? "selected" : "";
                            echo "<option value='".$ukuran['value']."' ".$selected.">".$ukuran['label']."</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td style="width:200px">Margin Atas (mm)</td>
            <td>
                <input name="printer_margin_top" type="number" class="w2ui-input w2field " value="<?=$options->get("printer_margin_top")?>">
            </td>
        </tr>
            <tr>
            <td style="width:200px">Margin Kiri (mm)</td>
            <td>
                <input name="printer_margin_left" type="number" class="w2ui-input w2field " value="<?=$options->get("printer_margin_left")?>">
            </td>
        </tr>
        <tr>
            <td style="width:200px">Font Huruf Tebal</td>
            <td>
                <input name="printer_font_bold" type="checkbox"  value="1" <?=$options->get("printer_font_bold") ? "checked" : ""?>>
            </td>
        </tr>
        <tr>
            <td style="width:200px">Tampilkan Logo</td>
            <td>
                <input name="printer_show_logo" type="checkbox"  value="1" <?=$options->get("printer_show_logo") ? "checked" : ""?>>
            </td>
        </tr>
        <tr>
            <td style="width:200px">Tampilkan Tulisan Footer</td>
            <td>
                <input name="printer_show_footer" type="checkbox"  value="1" <?=$options->get("printer_show_footer") ? "checked" : ""?>>
                
            </td>
        </tr>
        <tr>
            <td style="width:200px" colspan=2>Tulisan Footer <br>
                <textarea name="printer_footer_text" type="text" class="form-control " style="height:100px"><?=$options->get("printer_footer_text")?></textarea>
            </td>
        </tr>
    </table>


    </div>
    <div class="modal-footer">
        <input type="submit" value="Simpan Data" class="btn btn-sm btn-primary" />
        <a href="javascript:void(0)" class="btn btn-sm btn-default" data-dismiss="modal" aria-label="Close">Batal</a>

    </div>
</form>

<script>
var api_url = '<?=base_url("index.php/".$module."/api//")?>';
$(document).ready(function() {
    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });


    $("#post").submit(function(e) {
        var default_ukuran_kertas = $("select[name=default_ukuran_kertas]").val();
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: api_url + '/set_printer_setting',
            type: 'POST',
            data: formData,
            success: function(data) {
                if(data.success){
                    toastr.success(data.message);
                    $("#print").val(default_ukuran_kertas)
                }
                else{
                    w2alert(data.message);
                }
            },
            error: function(data) {
                $.Notification.autoHideNotify('error', 'top right', 'Gagal', 'Data Gagal Disimpan');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


</script>
