<div id="popup" style="width: 750px; height: 400px; overflow: hidden">
<form id="editData">
    <div rel="title">
        Edit Barang
    </div>
    <div rel="body">
        <table class="table">
            <tr>
                <td style="width:200px">Nama Pelanggan</td>
                <td>
                <input type="hidden" name="id" class="w2ui-input w2field" id="id" >
                <input type="text" name="nama_pelanggan" class="input-required w2ui-input w2field" id="nama_pelanggan" required
                        autocomplete=off style="width:100%">

                </td>
            </tr>
        </table>
    </div>
    <div rel="buttons">
        <input type="submit" value="Simpan Data" class="btn btn-sm btn-primary" onclick="update()"/>
    </div>
</form>
</div>