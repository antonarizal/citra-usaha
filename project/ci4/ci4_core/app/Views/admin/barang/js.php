<script>
var base_url = '<?=base_url()?>';
var module = '<?=$module?>';
var header = '<?=$header?> ';
var rand = '<?=$rand?>';
var name = 'grid_<?=$rand?>';
var config_barang = {
    grid: {
        name: name,
        style: 'border: 1px solid #ccc',
        header: header,
        url: base_url + '/api/' + module + '/all',
        method: 'GET',
        reorderRows: false,
        autoLoad: true,
        show: {
            header: true,
            toolbar: true,
            footer: true,
            toolbarReload: false,
            toolbarAdd: true,
            toolbarDelete: true,
            toolbarSave: false,
            toolbarEdit: true,
            lineNumbers: true,
            selectColumn: true

        },
        limit: 20,
        multiSearch: false,
        toolbar: {
            items: [{
                    type: 'break'
                },
                {
                    type: 'button',
                    id: 'kategori',
                    text: 'Kategori',
                    icon: 'fa fa-th'
                },
                {
                    type: 'button',
                    id: 'satuan',
                    text: 'Satuan',
                    icon: 'fa fa-tag'
                },
                {
                    type: 'break'
                },
                {
                    type: 'button',
                    id: 'import',
                    text: 'Import Data',
                    icon: 'fa fa-upload'
                },
                {
                    type: 'button',
                    id: 'export',
                    text: 'Export Excel',
                    icon: 'fa fa-file-excel'
                },
                {
                    type: 'button',
                    id: 'empty',
                    text: 'Kosongkan',
                    icon: 'fa fa-ban'
                }
            ],
            onLoad: function(event) {

            },

            onClick: function(event) {
                if (event.target == 'kategori') {
                    openPopup('kategori');
                }
                if (event.target == 'satuan') {
                    openPopup('satuan');
                }
                // switch (event.target) {
                //     case 'kategori':
                //         openKategori();
                //     case 'satuan':
                //         openSatuan();
                //     case 'import':
                //         var id = w2ui[name].getSelection();
                // }
            }
        },

        searches: [{
                field: 'nama_barang',
                label: 'Nama Barang',
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
                field: 'id',
                text: 'ID',
                size: '50px',
                sortable: true,
                attr: 'align=center'
            },
            {
                field: 'kode_barang',
                text: 'Kode Barang',
                size: '20%',
                sortable: true
            },
            {
                field: 'nama_barang',
                text: 'Nama Barang',
                size: '30%',
                sortable: true
            },
            {
                field: 'satuan',
                text: 'Satuan',
                size: '10%',
                sortable: true
            },
            {
                field: 'kategori_barang',
                text: 'Kategori',
                size: '30%',
                sortable: true
            },
            {
                field: 'harga_beli',
                text: 'Harga Beli',
                size: '20%',
                sortable: true
            },
            {
                field: 'harga_jual',
                text: 'Harga Jual',
                size: '20%'
            },
            {
                field: 'stok',
                text: 'Stok',
                size: '10%'
            },
            {
                field: 'terjual',
                text: 'Terjual',
                size: '10%'
            },
            {
                field: 'expiredDate',
                text: 'Expired',
                size: '10%'
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
    $('#grid_' + rand).w2grid(config_barang.grid);
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

function addCategory() {
    w2prompt({
            label: 'Tambah Kategori',
            value: '',
            attrs: 'style="width: 200px"',
            title: w2utils.lang('Notification'),
            ok_text: w2utils.lang('Simpan'),
            ok_class: 'ok-class',
            cancel_text: w2utils.lang('Batal'),
            cancel_class: 'cancel-class',
            width: 300,
            height: 180
        })
        .change((event) => {
            console.log('change', event)
        })
        .ok((value) => {
            console.log('simpan, value=', value)
        })
        .cancel(() => {
            console.log('batal')
        });
}



function openPopup(mode) {
    const rdm = (Math.random() + 1).toString(36).substring(7);
    const layout_r = 'layout_' + rdm
    const grid_r = 'grid_' + rdm
    console.log(rdm)
    const config_kategori = {
        layout_mode: {
            name: layout_r,
            padding: 4,
            panels: [{
                type: 'left',
                size: '100%',
                resizable: true,
                minSize: 300
            }, ]
        },
        grid_mode: {
            name: grid_r,
            style: 'border: 1px solid #efefef',
            url: base_url + '/api/' + mode + '/all',
            show: {
                toolbar: true,
                footer: true,
                toolbarReload: false,
                toolbarColumns: false,
                toolbarSearch: false,
                searchAll: false,
                toolbarInput: false,
                toolbarAdd: true,
                toolbarEdit: false,
                toolbarDelete: true
            },
            columns: [{
                    field: 'id',
                    text: 'ID',
                    size: '50px',
                    sortable: true,
                    searchable: true
                },
                {
                    field: mode,
                    text: mode,
                    size: '33%',
                    sortable: true,
                    searchable: true
                },
            ],
            onAdd: function(event) {
                w2prompt({
                        label: 'Tambah : ',
                        value: '',
                        attrs: 'style="width: 200px"',
                        title: w2utils.lang('Notification'),
                        ok_text: w2utils.lang('Save'),
                        cancel_text: w2utils.lang('Cancel'),
                        width: 400,
                        height: 150
                    })
                    .change(function(event) {
                        console.log('change', event);
                    })
                    .ok(function(event) {
                        console.log(event)
                        if (mode == 'kategori') {
                            $.post(base_url + '/api/' + mode + '/create/', {
                                    kategori: event,
                                },
                                function(data, status) {
                                    w2ui[grid_r].reload();
                                });
                        }
                        else {
                            $.post(base_url + '/api/' + mode + '/create/', {
                                    satuan: event,
                                },
                                function(data, status) {
                                    w2ui[grid_r].reload();
                                });
                        }

                    });
            },
        },


    };

    $(function() {
        // initialization in memory
        $().w2layout(config_kategori.layout_mode);
        $().w2grid(config_kategori.grid_mode);
    });

    w2popup.open({
        title: mode,
        width: 500,
        height: 600,
        showMax: false,
        body: '<div id="main" style="position: absolute; left: 2px; right: 2px; top: 0px; bottom: 3px;"></div>',
        onOpen: function(event) {
            event.onComplete = function() {
                $('#w2ui-popup #main').w2render(layout_r);
                w2ui[layout_r].html('left', w2ui[grid_r]);
            };
        }

    })

}
</script>