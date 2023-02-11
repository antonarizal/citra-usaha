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
                switch (event.target) {
                    case 'import':
                        var id = w2ui[name].getSelection();
                        console.log(id);

                        // alert(id);
                        // $.get(base_url+"/pelanggan/delete/"+id,
                        // function(data, status){
                        // 	w2ui['grid'].select(id);
                        // 	w2ui['grid'].delete(true);
                        // });
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
                field: 'id',
                text: 'ID',
                size: '50px',
                sortable: true,
                attr: 'align=center'
            },
            {
                field: 'nama_pelanggan',
                text: 'Nama Pelanggan',
                size: '30%',
                sortable: true
            },
            {
                field: 'alamat',
                text: 'Alamat',
                size: '30%',
                sortable: true
            },
            {
                field: 'email',
                text: 'Email',
                size: '40%'
            },
            {
                field: 'no_hp',
                text: 'No HP',
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
    $('#grid_' + rand).w2grid(config.grid);
    loadData()
});

function loadData(){
    $.get(base_url + '/api/pelanggan/data', function(resp) {
        $('#count').html('Total : ' + resp.count)
    })
}
function add() {
    w2popup.load({
        url: base_url + '/admin/pelanggan/add/',
        showMax: false,
        modal: false
    })
    $('#nama_pelanggan').val('')
    $('#nama_pelanggan').focus()

}

function edit(id) {
    w2popup.load({
        url: base_url + '/admin/pelanggan/edit/' + id,
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
    if ((formData.nama_pelanggan) == "") {
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