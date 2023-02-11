<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/**
 * Create an Module in HMVC
 *
 * @package App\Commands
 * @author Mufid Jamaluddin <https://github.com/MufidJamaluddin/Codeigniter4-HMVC>
 */
class ApiCreate extends BaseCommand
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
    protected $name        = 'api:create';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Create CodeIgniter HMVC API in app/API folder';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage        = 'api:create [AdminName] [Options]';

    /**
     * the Command's Arguments
     *
     * @var array
     */
    protected $arguments    = [ 'AdminName' => 'Api name to be created' ];

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
            $this->createModel();
            CLI::write('Api Module created!');
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
        $controllerPath = APPPATH .  'Modules/Api/Controllers';
        $modelName = $this->module_name."Model";
        $model = strtolower($this->module_name);

        //mkdir($controllerPath);

        if (!file_exists($controllerPath . '/' . $this->module_name . '.php'))
        {
            $template = "<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class $this->module_name  extends ResourceController
{

    public function __construct()
    {
        \$this->db      = \Config\Database::connect();
        \$this->".$modelName." = new \App\Modules\Api\Models\\".$modelName."();
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
        \$pelanggan = \$this->".$modelName."->insert(\$request);
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

    public function update(\$id = null)
    {
        \$request = \$this->request->getPost();
        \$pelanggan = \$this->".$modelName."->insert(\$request);
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
            file_put_contents($controllerPath . '/'.$this->module_name.'.php', $template);
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
        $modelPath = APPPATH .  'Modules/Api/Models';

        // mkdir($modelPath);
        $modelName = $this->module_name."Model";

        if (!file_exists($modelPath . '/'.$this->module_name.'.php')) {
            $template = "<?php 
namespace App\Modules\Api\Models;
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
}


";

            file_put_contents($modelPath . '/'.$this->module_name.'Model.php', $template);
        }
        else
        {
            CLI::error("Can't Create $this->module_name! Old File Exists!");
        }

    }
 

}