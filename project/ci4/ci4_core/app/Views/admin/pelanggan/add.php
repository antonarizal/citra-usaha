<div id="popup" style="width: 750px; height: 400px; overflow: hidden">
    <div rel="title">
        Tambah Pelanggan
    </div>
    <div rel="body">
        <table class="table">
            <tr>
                <td style="width:200px">Nama Pelanggan</td><td><input type="text" id="nama_pelanggan" class="w2ui-input w2field form-input" value=""  required autocomplete=off style="width:100%">
                </td>
            </tr>
            <tr>
                <td>Alamat</td><td><input type="text" id="alamat" class="w2ui-input w2field form-input" value=""  required autocomplete=off style="width:100%">
                </td>
            </tr>
            <tr>
                <td>No HP</td><td><input type="text" id="no_hp" class="w2ui-input w2field form-input" value=""  required autocomplete=off style="width:100%">
                </td>
            </tr>
            <tr>
                <td>Email</td><td><input type="text" id="email" class="w2ui-input w2field form-input" value=""  required autocomplete=off style="width:100%">
                </td>
            </tr>
        </table>
        
    </div>
    <div rel="buttons">
    <input type="submit" value="Simpan Data" class="btn btn-sm btn-primary" onclick="create()"/>
    </div>
</div>