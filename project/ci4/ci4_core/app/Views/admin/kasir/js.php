<script>
var base_url = '<?=base_url()?>';
var module = '<?=$module?>';
var header = '<?=$header?> ';
var rand = '<?=$rand?>';
var name = 'grid_<?=$rand?>';
var config = {
    grid: {
        name: name,
        style: 'border: 1px solid #ccc',
        header: "Kasir Penjualan",
        url: base_url + '/api/' + module + '/all',
        method: 'GET',
        reorderRows: false,
        autoLoad: true,
        show: {
            header: false,
            toolbar: false,
            footer: true,
            toolbarReload: false,
            toolbarAdd: false,
            toolbarDelete: false,
            toolbarSave: false,
            toolbarEdit: false,
            lineNumbers: true,
            selectColumn: true,
            toolbarSearch: false,


        },
        limit: 20,
        multiSearch: false,
        toolbar: {
            items: [ ],
            onLoad: function(event) {

            },

            onClick: function(event) {
                switch (event.target) {
                    case 'import':
                        var id = w2ui[name].getSelection();
                        console.log(id);
                }
            }
        },

        searches: [{
                field: 'nama_pelanggan',
                label: 'Nama Pelanggan',
                type: 'text'
            },
            {
                field: 'email',
                label: 'Email',
                type: 'text'
            },
            {
                field: 'no_hp',
                label: 'No HP',
                type: 'text'
            }
        ],
        columns: [{
                field: 'kode_barang',
                text: 'Kode Barang',
                size: '15%',
                sortable: true
            },
            {
                field: 'nama_barang',
                text: 'Nama Barang',
                size: '30%',
                sortable: true
            },
            {
                field: 'harga_jual',
                text: 'Harga Jual',
                size: '120px'
            },
            {
                field: 'qty',
                text: 'Jumlah',
                size: '10%'
            },
            {
                field: 'satuan',
                text: 'Satuan',
                size: '10%'
            },
            {
                field: 'diskon',
                text: 'Diskon(%)',
                size: '10%'
            },
            {
                field: 'harga',
                text: 'Total Harga',
                size: '120px'
            },
        ],

        onAdd: function(event) {
            add()
        },
        onEdit: function(event) {
            var id = w2ui[name].getSelection();
            console.log(id);
            edit(id)
        },
        onDelete: function(event) {
            var id = w2ui[name].getSelection();
            console.log(id);
            loadData()


        },
        onSave: function(event) {
            w2alert('save');
        },

    }
};



$(function() {
    $("#barcode").focus();
    $('#grid_' + rand).w2grid(config.grid);
    loadData()
});

function loadData() {
    $.get(base_url + '/api/' + module + '/data', function(resp) {
        $('#count').html('Total : ' + resp.count)
    })
}

function add() {
    w2popup.load({
        url: base_url + '/admin/' + module + '/add/',
        showMax: false,
        modal: false
    })

}

function edit(id) {
    w2popup.load({
        url: base_url + '/admin/' + module + '/edit/' + id,
        showMax: false,
        modal: false
    })
    $.get(base_url + '/api/' + module + '/show/' + id, function(resp) {

        $('#nama_pelanggan').val(resp.nama_pelanggan)
        $('#nama_pelanggan').focus()
        $('#alamat').val(resp.alamat)
        $('#no_hp').val(resp.no_hp)
        $('#email').val(resp.email)
        $('#id').val(resp.id)

    })
}


function create() {
    var formData = {
        nama_pelanggan: $('#nama_pelanggan').val(),
        alamat: $('#alamat').val(),
        no_hp: $('#no_hp').val(),
        email: $('#email').val(),
    };
    if ((formData.nama_pelanggan) == '') {
        w2alert('Nama pelanggan kosong').ok(() => {
            $('#nama_pelanggan').focus()
            loadData()
        });

        return false;
    }

    $.post(base_url + '/index.php/api/' + module + '/create/', formData, function(resp) {
        if (resp.success) {
            w2alert('<i class="fa  fa-check-circle"></i>&nbsp; ' + resp.message).ok(() => {
                $('.form-input').val('')
                loadData();
                w2ui[name].reload();

            });

        } else {
            w2alert('<i class="fa  fa-times-circle"></i>&nbsp; ' + resp.message)

        }

    })

}

function update() {
    var formData = {
        nama_pelanggan: $('#nama_pelanggan').val(),
        alamat: $('#alamat').val(),
        no_hp: $('#no_hp').val(),
        email: $('#email').val(),
    };
    if ((formData.nama_pelanggan) == '') {
        w2alert('Nama pelanggan kosong').ok(() => {
            $('#nama_pelanggan').focus()
        });

        return false;
    }
    $.post(base_url + '/index.php/api/' + module + '/update/' + $('#id').val(), formData, function(resp) {
        if (resp.success) {
            w2alert('<i class="fa  fa-check-circle"></i>&nbsp; ' + resp.message).ok(() => {
                $('#nama_pelanggan').focus()
                w2ui[name].reload();

            });

        } else {
            w2alert('<i class="fa  fa-times-circle"></i>&nbsp; ' + resp.message)

        }

    })

}
</script>