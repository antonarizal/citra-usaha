<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/**
 * Create an Module in HMVC
 *
 * @package App\Commands
 * @author Mufid Jamaluddin <https://github.com/MufidJamaluddin/Codeigniter4-HMVC>
 */
class AdminCreate extends BaseCommand
{
    /**
     * The group the command is lumped under
     * when listing commands.
     *
     * @var string
     */
    protected $group       = 'Development';

    /**
     * The Command's name
     *
     * @var string
     */
    protected $name        = 'admin:create';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Create CodeIgniter HMVC Admin in app/Admin folder';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage        = 'admin:create [AdminName] [Options]';

    /**
     * the Command's Arguments
     *
     * @var array
     */
    protected $arguments    = [ 'AdminName' => 'Module name to be created' ];

    /**
     * the Command's Options
     *
     * @var array
     */
    protected $options      = [
        '-f' => 'Set module folder inside app path (default Modules)',
        '-v' => 'Set view folder inside app path (default Views/modules/)',
    ];

    /**
     * Module Name to be Created
     */
    protected $module_name;


    /**
     * Module folder (default /Modules)
     */
    protected $module_folder;


    /**
     * View folder (default /View)
     */
    protected $view_folder;


    /**
     * Run route:update CLI
     */
    public function run(array $params)
    {
        helper('inflector');

        $this->module_name = $params[0];

        if(!isset($this->module_name))
        {
            CLI::error("Admin Module name must be set!");
            return;
        }

        $this->module_name = ucfirst($this->module_name);

        $module_folder         = $params['-f'] ?? CLI::getOption('f');
        $this->module_folder   = ucfirst($module_folder ?? 'Modules');

        $view_folder         = $params['-v'] ?? CLI::getOption('v');
        $this->view_folder   = $view_folder ?? 'Views';

        // mkdir(APPPATH .  $this->module_folder . '/' . $this->module_name);

        try
        {
            // $this->createConfig();
            $this->createController();
            // $this->createModel();
            $this->createView();

            CLI::write('Admin Module created!');
        }
        catch (\Exception $e)
        {
            CLI::error($e);
        }
    }


    /**
     * Create Controller File
     */
    protected function createController()
    {
        $controllerPath = APPPATH .  'Modules/Admin/Controllers';

        //mkdir($controllerPath);

        if (!file_exists($controllerPath . '/' . $this->module_name . '.php'))
        {
            $template = "<?php namespace App\Modules\Admin\Controllers;

use CodeIgniter\Controller;

class $this->module_name extends Controller
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        \$this->session = session();


    }

    public function index()
	{
		\$data = [
		    'module' =>  '".strtolower($this->module_name)."',
		    'title' =>  '$this->module_name',
		    'header' =>  'Data $this->module_name',
		    'rand' =>  date('YmdHis'),
            'data' => '',

        ];

		//return view('admin/layout/index', \$data);
		return view('admin/" . strtolower($this->module_name) . "/view', \$data);
	}

    public function add()
	{
		\$data = [
		    'title' =>  '$this->module_name',
            'data' => '',
        ];

		return view('admin/" . strtolower($this->module_name) . "/add', \$data);

	}


    public function edit(\$id=null)
	{
		\$data = [
		    'title' =>  '$this->module_name',
            'data' => '',
        ];

		return view('admin/" . strtolower($this->module_name) . "/edit', \$data);

	}


    public function detail(\$id=null)
	{
		\$data = [
		    'title' =>  'Detail $this->module_name',
            'data' => '',
        ];

		return view('admin/" . strtolower($this->module_name) . "/detail', \$data);

	}

    public function print(\$id=null)
	{
		\$data = [
		    'title' =>  'Print $this->module_name',
            'data' => '',
        ];

		return view('admin/" . strtolower($this->module_name) . "/print', \$data);

	}

    public function import(\$id=null)
	{
		\$data = [
		    'title' =>  'Import $this->module_name',
            'view' => 'admin/" . strtolower($this->module_name) . "/import',
            'data' => '',
        ];

		return view('admin/" . strtolower($this->module_name) . "/import', \$data);

	}

    public function excel(\$id=null)
	{
		\$data = [
		    'title' =>  'Excel',
            'view' => 'admin/" . strtolower($this->module_name) . "/excel',
            'data' => '',
        ];

		return view('admin/" . strtolower($this->module_name) . "/excel', \$data);

	}



}
";
            file_put_contents($controllerPath . '/'.$this->module_name.'.php', $template);
        }
        else
        {
            CLI::error("Can't Create Controller! Old File Exists!");
        }
    }

    /**
     * Create View
     */
    protected function createView()
    {
        
        if($this->view_folder !== $this->module_folder)
            $view_path = APPPATH."/Views/admin/".strtolower($this->module_name);
        else
            $view_path = APPPATH."/Views/admin/".strtolower($this->module_name);

        mkdir($view_path);

        if (!file_exists(APPPATH."/Views/admin/".strtolower($this->module_name).'/view.php'))
        {
            $view = '<div class="content-wrapper">
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
        ?>';
$js = "<script>
var base_url = '<?=base_url()?>';
var module = '<?=\$module?>';
var header = '<?=\$header?> ';
var rand = '<?=\$rand?>';
var name = 'grid_<?=\$rand?>';
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
    $.get(base_url + '/api/'+module+'/data', function(resp) {
        $('#count').html('Total : ' + resp.count)
    })
}
function add() {
    w2popup.load({
        url: base_url + '/admin/'+module+'/add/',
        showMax: false,
        modal: false
    })

}

function edit(id) {
    w2popup.load({
        url: base_url + '/admin/'+module+'/edit/' + id,
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
            w2alert('<i class=\"fa  fa-check-circle\"></i>&nbsp; ' + resp.message).ok(() => {
                $('.form-input').val('')
                loadData();
                w2ui[name].reload();

            });

        } else {
            w2alert('<i class=\"fa  fa-times-circle\"></i>&nbsp; ' + resp.message)

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
            w2alert('<i class=\"fa  fa-check-circle\"></i>&nbsp; ' + resp.message).ok(() => {
                $('#nama_pelanggan').focus()
                w2ui[name].reload();

            });

        } else {
            w2alert('<i class=\"fa  fa-times-circle\"></i>&nbsp; ' + resp.message)

        }

    })

}
</script>";
$modal ='';
$add ='
<div id="popup" style="width: 750px; height: 400px; overflow: hidden">
    <div rel="title">
        Tambah '.$this->module_name.'
    </div>
    <div rel="body">
        <table class="table">
            <tr>
                <td style="width:200px">Nama</td><td><input type="text" name="nama" id="nama" class="w2ui-input w2field form-input" value=""  required autocomplete=off style="width:100%">
                </td>
            </tr>
        </table>
    </div>
    <div rel="buttons">
    <input type="submit" value="Simpan Data" class="btn btn-sm btn-primary" onclick="create()"/>
    </div>
</div>';
$edit ='<div id="popup" style="width: 750px; height: 400px; overflow: hidden">
<form id="editData">
    <div rel="title">
        Edit '.$this->module_name.'
    </div>
    <div rel="body">
        <table class="table">
            <tr>
                <td style="width:200px">Nama</td>
                <td>
                <input type="hidden" name="id" class="w2ui-input w2field" id="id" >
                <input type="text" name="nama" class="input-required w2ui-input w2field" id="nama" required
                        autocomplete=off style="width:100%">

                </td>
            </tr>
        </table>
    </div>
    <div rel="buttons">
        <input type="submit" value="Simpan Data" class="btn btn-sm btn-primary" onclick="update()"/>
    </div>
</form>
</div>';
$import ='';

file_put_contents($view_path . '/view.php', $view);
file_put_contents($view_path . '/add.php', $add);
file_put_contents($view_path . '/edit.php', $edit);
file_put_contents($view_path . '/import.php', $import);
file_put_contents($view_path . '/modal.php', $modal);
file_put_contents($view_path . '/js.php', $js);
}
else
{
CLI::error("Can't Create View! Old File Exists!");
}


}

}