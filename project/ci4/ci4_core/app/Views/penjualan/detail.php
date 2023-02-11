
<form id="post">
    <div class="modal-header">
        <p class="modal-title" style="font-weight:bold">Data Penjualan</p>
    </div>
    <table class="table table-sm text-sm">
        <tr>
            <td style="width:150px">No Faktur</td>
            <td> : <?=$faktur->faktur?>
            </td>
            <td style="width:150px">Pelanggan</td>
            <td> : <?=$faktur->nama_pelanggan?>
            </td>
        </tr>
        <tr>
            <td style="width:150px">Tanggal</td>
            <td> : <?=$faktur->date?>
            </td>
            <td style="width:150px">Alamat</td>
            <td> : <?=$faktur->alamat?>
            </td>
        </tr>
    </table>
    <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Satuan</th>
                <th>Disc</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($penjualan as $row):?>
            <tr>
                <td><?=$no++?></td>
                <td><?=$row->kode_barang?></td>
                <td><?=$row->nama_barang?></td>
                <td><?=angkaFormat($row->harga)?></td>
                <td><?=$row->qty?></td>
                <td><?=$row->satuan?></td>
                <td><?=$row->diskon?>%</td>
                <td><?=angkaFormat($row->total)?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" style="text-align:right">Total</td>
                <td><?=angkaFormat($faktur->total)?></td>
            </tr>
        </tfoot>
    </table>
    
    </div>
    <div class="modal-footer">
        <a href="javascript:hapusTransaksi(<?=$id?>)" class="btn btn-sm btn-danger btn-sm" >Hapus</a>
        <a href="javascript:void(0)" class="btn btn-sm btn-default" data-dismiss="modal" aria-label="Close">Batal</a>
    </div>
</form>
<script>
    var id = <?=$id?>;

    function hapusTransaksi(id)
    {
        $.post(api_url + '/delete/'+id,function(resp){
            if(resp.success){
                $("#modal").modal("hide")
                w2alert("Data berhasil dihapus")
                .ok(function(){
                    load(load_url,'transaksi_penjualan')

                })

            }

        })
    }

</script>

