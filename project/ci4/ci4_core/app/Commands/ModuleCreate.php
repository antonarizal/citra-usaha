<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/**
 * Create an Module in HMVC
 *
 * @package App\Commands
 * @author Mufid Jamaluddin <https://github.com/MufidJamaluddin/Codeigniter4-HMVC>
 */
class ModuleCreate extends BaseCommand
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
    protected $name        = 'module:create';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Create CodeIgniter HMVC Modules in app/Modules folder';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage        = 'module:create [ModuleName] [Options]';

    /**
     * the Command's Arguments
     *
     * @var array
     */
    protected $arguments    = [ 'ModuleName' => 'Module name to be created' ];

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
            CLI::error("Module name must be set!");
            return;
        }

        $this->module_name = ucfirst($this->module_name);

        $module_folder         = $params['-f'] ?? CLI::getOption('f');
        $this->module_folder   = ucfirst($module_folder ?? 'Modules');

        $view_folder         = $params['-v'] ?? CLI::getOption('v');
        $this->view_folder   = $view_folder ?? 'Views';

        mkdir(APPPATH .  $this->module_folder . '/' . $this->module_name);

        try
        {
            $this->createConfig();
            $this->createController();
            $this->createApi();
            $this->createModel();
            $this->createView();

            CLI::write('Module created!');
        }
        catch (\Exception $e)
        {
            CLI::error($e);
        }
    }

    /**
     * Create Config File
     */
    protected function createConfig()
    {
        $configPath = APPPATH .  $this->module_folder . '/' . $this->module_name . '/Config';

        mkdir($configPath);

        if (!file_exists($configPath . '/Routes.php'))
        {
            $routeName = strtolower($this->module_name);

            $template = "<?php

if(!isset(\$routes))
{ 
    \$routes = \Config\Services::routes(true);
}

\$routes->group('$routeName', ['namespace' => 'App\Modules\\$this->module_name\\Controllers'], function(\$subroutes){

	/*** Route for Dashboard ***/
	\$subroutes->add('', 'Dashboard::index');
	\$subroutes->add('dashboard', 'Dashboard::index');

});";

            file_put_contents($configPath . '/Routes.php', $template);
        }
        else
        {
            CLI::error("Can't Create Routes Config! Old File Exists!");
        }
    }

    /**
     * Create Controller File
     */
    protected function createController()
    {
        $controllerPath = APPPATH .  $this->module_folder . '/' . $this->module_name . '/Controllers';

        mkdir($controllerPath);

        if (!file_exists($controllerPath . '/Load.php'))
        {
$template = "<?php namespace App\Modules\\$this->module_name\Controllers;

    use CodeIgniter\Controller;

    class Load extends Controller
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
                'moduleName' =>  '".($this->module_name)."',
                'module' =>  '".strtolower($this->module_name)."',
                'title' =>  '$this->module_name',
                'header' =>  'Data $this->module_name',
                'viewpath' =>  [\"view\"],
                'rand' =>  date('YmdHis'),
                'data' => '',

            ];
            echo view('view',\$data);

        }

        public function add()
        {
            \$data = [
                'moduleName' =>  '".($this->module_name)."',
                'module' =>  '".strtolower($this->module_name)."',
                'title' =>  '$this->module_name',
                'header' =>  'Data $this->module_name',
                'viewpath' =>  [\"add\"],
                'rand' =>  date('YmdHis'),
                'data' => '',

            ];
            echo view('view',\$data);

        }


        public function edit(\$id=null)
        {
            \$data = [
                'moduleName' =>  '".($this->module_name)."',
                'module' =>  '".strtolower($this->module_name)."',
                'title' =>  '$this->module_name',
                'header' =>  'Data $this->module_name',
                'viewpath' =>  [\"edit\"],
                'rand' =>  date('YmdHis'),
                'data' => '',

            ];
            echo view('view',\$data);
        }


        public function detail(\$id=null)
        {
            \$data = [
                'moduleName' =>  '".($this->module_name)."',
                'module' =>  '".strtolower($this->module_name)."',
                'title' =>  '$this->module_name',
                'header' =>  'Data $this->module_name',
                'viewpath' =>  [\"detail\"],
                'rand' =>  date('YmdHis'),
                'data' => '',

            ];
            echo view('view',\$data);

        }

        public function print(\$id=null)
        {
            \$data = [
                'moduleName' =>  '".($this->module_name)."',
                'module' =>  '".strtolower($this->module_name)."',
                'title' =>  '$this->module_name',
                'header' =>  'Data $this->module_name',
                'viewpath' =>  [\"print\"],
                'rand' =>  date('YmdHis'),
                'data' => '',

            ];
            echo view('view',\$data);

        }

        public function import(\$id=null)
        {
            \$data = [
                'moduleName' =>  '".($this->module_name)."',
                'module' =>  '".strtolower($this->module_name)."',
                'title' =>  '$this->module_name',
                'header' =>  'Data $this->module_name',
                'viewpath' =>  [\"import\"],
                'rand' =>  date('YmdHis'),
                'data' => '',

            ];
            echo view('view',\$data);

        }

        public function excel(\$id=null)
        {
            \$data = [
                'moduleName' =>  '".($this->module_name)."',
                'module' =>  '".strtolower($this->module_name)."',
                'title' =>  '$this->module_name',
                'header' =>  'Data $this->module_name',
                'viewpath' =>  [\"excel\"],
                'rand' =>  date('YmdHis'),
                'data' => '',

            ];
            echo view('view',\$data);

        }



    }
";
            file_put_contents($controllerPath . '/Load.php', $template);
        }
        else
        {
            CLI::error("Can't Create Controller! Old File Exists!");
        }
    }

    
    /**
     * Create Controller File
     */
    protected function createApi()
    {
        $controllerPath = APPPATH .  'Modules/'.$this->module_name.'/Controllers';
        $modelName = $this->module_name."Model";
        $model = strtolower($this->module_name);

        //mkdir($controllerPath);

        if (!file_exists($controllerPath . '/' . $this->module_name . '/Api.php'))
        {
            $template = "<?php

namespace App\Modules\\$this->module_name\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Api  extends ResourceController
{

    public function __construct()
    {
        \$this->db      = \Config\Database::connect();
        \$this->".$modelName." = new \App\Modules\\$this->module_name\Models\\".$modelName."();
        \$this->builder = \$this->db->table(\$this->".$modelName."->table);
        \$this->w2ui =  new W2ui();

    }

    public function index()
    {		
        \$$modelName = new \App\Modules\Api\Models\\$modelName();
        //\$$model = $".$modelName."->findAll();
        //\$$model = $".$modelName."->find(\$id);
        //\$$model = $".$modelName."->find([1,2,3]);
        //\$$model = $".$modelName."->where('status',1)->findAll();
        //\$$model = $".$modelName."->findAll(\$limit, \$offset);
        //\$$model = $".$modelName."->save(\$data);
        //return \$this->respond(\$$model);
    }

    public function data()
    {		
        \$builder = \$this->db->table(\$this->".$modelName."->table);
        \$data['count'] = \$builder->countAll();
        return \$this->respond(\$data);
    }
    
    public function all()
    {		
        \$fields = \$this->db->getFieldNames(\$this->".$modelName."->table);
        \$request =  \$this->request->getGet('request');
        \$data = \$this->w2ui->result(\$this->".$modelName.", \$fields, \$request );
        return \$this->respond(\$data);
    }

    public function show(\$id = null)
    {
        \$data = \$this->".$modelName."->where('id', \$id)->first();
        return \$this->respond(\$data);
    }

    public function create()
    {
        \$request = \$this->request->getPost();
        if(!empty(\$this->request->getPost('request'))){
            \$request = json_decode(\$this->request->getPost('request'))->record;
        }

        \$$model = \$this->".$modelName."->insert(\$request);
        if(\$$model){
            \$data['success']=true;
            \$data['status']='success';
            \$data['message']='Data berhasil disimpan!';
        }else{
            \$data['success']=false;
            \$data['status']='failed';
            \$data['message']='Data gagal disimpan!';
        }
        return \$this->respond(\$data);

    }

    public function update(\$id = null)
    {
        \$request = \$this->request->getPost();
        \$pelanggan = \$this->".$modelName."->update(\$id,\$request);
        if(\$pelanggan){
            \$data['success']=true;
            \$data['status']='success';
            \$data['message']='Data berhasil disimpan!';
        }else{
            \$data['success']=false;
            \$data['status']='failed';
            \$data['message']='Data gagal disimpan!';
        }
        return \$this->respond(\$data);

    }
    
    public function save(\$id = null)
    {
        // Defined as a model property
        //\$primaryKey = 'id';

        // Does an insert()
        // \$data = [ ];

        //\$$model = $".$modelName."->save(\$data);
        // \$data = [
        //     'id'       => 3,
        // ];
        //\$$model = $".$modelName."->save(\$data);
    }

    public function delete(\$id = null)
    {
        //\$data = [];
        //\$$model = $".$modelName."->delete(\$id);
        //\$$model = $".$modelName."->delete(\$data);
        //An array of primary keys can be passed in as the first parameter to delete multiple records at once
        //\$$model = $".$modelName."->where('id', \$id)->delete();
        //Cleans out the database table by permanently removing all rows that have ‘deleted_at IS NOT NULL’.
        //\$$model = $".$modelName."->purgeDeleted(); 
        
    }
    
    public function datatables()
    {
        \$db = db_connect();
        \$datatables = new Datatables();
        \$table = \"user\";
        \$fields = \$db->getFieldNames(\$table);
        \$search=\$fields;
        \$order=array(NULL);
		\$order=(\$fields);
		\$where = array(\"\"); 
        \$params=array(
            \"table\"=>\$table,
            \"column\"=>array(
                \"order\"=>\$order,
                \"search\"=>\$search,
                ),
            \"order\" => array('id' => 'desc'),
            \"where\" => \$where
            );

        \$list = \$datatables->get_datatables(\$params);
        \$data = array();
        \$no = \$_POST['start'];
        \$data = \$list;
        \$output = array(
				'draw' => \$_POST['draw'],
				'recordsTotal' => \$datatables->count_all(\$params),
				'recordsFiltered' => \$datatables->count_filtered(\$params),
				'data' => \$data,
		);
        return \$this->response->setJson(\$output);
        // echo json_encode(\$output);
    }
}
";
            file_put_contents($controllerPath . '/Api.php', $template);
        }
        else
        {
            CLI::error("Can't Create Controller! Old File Exists!");
        }
    }
    /**
     * Create Models File
     */
    protected function createModel()
    {
        $modelPath = APPPATH .  $this->module_folder . '/' . $this->module_name . '/Models';
        $modelName = $this->module_name."Model";

        mkdir($modelPath);

        if (!file_exists($modelPath . '/'.$modelName.'.php')) {
            $template = "<?php 
            namespace App\Modules\\$this->module_name\\Models;
            use CodeIgniter\Model;
            
            class $modelName  extends Model
            {
                protected \$DBGroup          = 'default';
                protected \$table            = '".strtolower($this->module_name)."';
                protected \$primaryKey       = 'id';
                protected \$useAutoIncrement = true;
                protected \$insertID         = 0;
                protected \$returnType       = 'array';
                protected \$useSoftDeletes   = false;
                protected \$protectFields    = true;
                protected \$allowedFields    = [];
            
                // Dates
                protected \$useTimestamps = false;
                protected \$dateFormat    = 'datetime';
                protected \$createdField  = 'created_at';
                protected \$updatedField  = 'updated_at';
                protected \$deletedField  = 'deleted_at';
            
                // Validation
                protected \$validationRules      = [];
                protected \$validationMessages   = [];
                protected \$skipValidation       = false;
                protected \$cleanValidationRules = true;
            
                // Callbacks
                protected \$allowCallbacks = true;
                protected \$beforeInsert   = [];
                protected \$afterInsert    = [];
                protected \$beforeUpdate   = [];
                protected \$afterUpdate    = [];
                protected \$beforeFind     = [];
                protected \$afterFind      = [];
                protected \$beforeDelete   = [];
                protected \$afterDelete    = [];
            }";

            file_put_contents($modelPath . '/'.$this->module_name.'Model.php', $template);
        }
        else
        {
            CLI::error("Can't Create UserEntity! Old File Exists!");
        }

//         if (!file_exists($modelPath . '/UserModel.php'))
//         {

//             $template = "<?php namespace App\Modules\\$this->module_name\\Models;

// class UserModel
// {
//     public function getUsers()
//     {
//         return [
//             UserEntity::of('PL0001', 'Mufid Jamaluddin'),
//             UserEntity::of('PL0002', 'Andre Jhonson'),
//             UserEntity::of('PL0003', 'Indira Wright'),
//         ];
//     }
// }";
//             file_put_contents($modelPath . '/UserModel.php', $template);
//         }
//         else
//         {
//             CLI::error("Can't Create UserModel! Old File Exists!");
//         }
    }

    /**
     * Create View
     */
    protected function createView()
    {
        
        if($this->view_folder !== $this->module_folder)
            $view_path = APPPATH .  $this->module_folder . '/' . $this->module_name .'//Views/';
        else
            $view_path = APPPATH .  $this->module_folder . '/' . $this->module_name .'//Views/';

        mkdir($view_path);

        if (!file_exists(APPPATH .  $this->module_folder . '/' . strtolower($this->module_name).'/Views/view.php'))
        {
$view = '
<?php 
include "form.php";
include "grid.php";
include "modal.php";
include "js.php";
?>';
$grid = '<div class="content-wrapper">
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
';
$js = "<script>
var base_url = '<?=base_url()?>';
var load_url = '<?=base_url(\"index.php/\".\$module.\"/load/\")?>';
var api_url = '<?=base_url(\"index.php/\".\$module.\"/api/\")?>';
var module = '<?=\$module?>';
var header = '<?=\$header?> ';
var rand = '<?=\$rand?>';
var name = 'grid_<?=\$rand?>';
var config = {
    grid: {
        name: name,
        style: 'border: 1px solid #ccc',
        header: header,
        url: api_url+'/all/',
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
    $.get(api_url +'/data', function(resp) {
        $('#count').html('Total : ' + resp.count)
    })
}
function add() {
    $('#modal').modal('show');
    $('#loadModal').load(load_url+'/add/')
}

function edit(id) {
    $('#modal').modal('show');
    $('#loadModal').load(load_url+'/edit/'+id)

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

    $.post(api_url + '/create/', formData, function(resp) {
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
    $.post(api_url + '/update/' + $('#id').val(), formData, function(resp) {
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
$modal ='<div class="modal fade" id="modal">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div id="loadModal"></div>
    </div>
</div>
</div>';
$add ='
<form id="post">
    <div class="modal-header">
        <p class="modal-title" style="font-weight:bold">Tambah Data</p>
    </div>
    <table class="table table-sm text-sm">
        <tr>
            <td style="width:150px">Nama '.$this->module_name.'</td>
            <td>
                <input type="hidden" name="id" class="w2ui-input w2field" id="id">
                <input type="text" name="nama_pengguna" class="input-required w2ui-input w2field" id="nama_pengguna"
                    required autocomplete=off style="width:100%">
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
$("#post").on(\'submit\', (function(e) {
    e.preventDefault();
    $.ajax({
        url: api_url + \'/create/\',
        type: \'POST\',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            toastr.success(data.message)
            w2ui[name].reload();
            loadData()
            $("#modal").modal("hide");
        },
        error: function(data) {}
    });

}));
</script>
';
$form ='
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
            <form id="post">
                <table class="table table-sm text-sm">
                <tr>
                    <td style="width:200px">Nama</td>
                    <td>
                        <input type="text" name="nama" id="nama" class="input-required w2ui-input w2field" 
                            required autocomplete=off style="width:100%">
                        
                    </td>
                </tr>
                </table>
            </form>
        </div>
    </div>
</div>
</section>
</div>

<script>
$("#post").on(\'submit\', (function(e) {
    e.preventDefault();
    $.ajax({
        url: api_url + \'/insert/\',
        type: \'POST\',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            toastr.success(data.message)
        },
        error: function(data) {}
    });

}));
</script>
';
$edit ='
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
                <input type="text" name="nama" class="input-required w2ui-input w2field" id="nama" required autocomplete=off style="width:100%">
                </td>
            </tr>
        </table>
    </div>
    <div rel="buttons">
        <input type="submit" value="Simpan Data" class="btn btn-sm btn-primary" onclick="update()"/>
    </div>
</form>
<script>
var id=<?=$id?>;
$.get(api_url+\'/show/\'+id,function(resp){
    $("input[name=\'id\']").val(resp.id)
})
$("#post").on(\'submit\', (function(e) {
    e.preventDefault();
    $.ajax({
        url: api_url + \'/update/\'+id,
        type: \'POST\',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            toastr.success(data.message)
            w2ui[name].reload();
            loadData()
        },
        error: function(data) {}
    });

}));
</script>';
        $import ='';

            file_put_contents($view_path . '/form.php', $form);
            file_put_contents($view_path . '/grid.php', $grid);
            file_put_contents($view_path . '/add.php', $add);
            file_put_contents($view_path . '/edit.php', $edit);
            file_put_contents($view_path . '/import.php', $import);
            file_put_contents($view_path . '/modal.php', $modal);
            file_put_contents($view_path . '/js.php', $js);
            file_put_contents($view_path . '/view.php', $view);

        }
        else
        {
            CLI::error("Can't Create View! Old File Exists!");
        }
    }

}