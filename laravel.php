<?php
require_once dirname(__file__) . "/vendor/autoload.php";


require_once "conf2.php";
use \Illuminate\Database\Capsule\Manager as Capsule;
use \Illuminate\Pagination\LengthAwarePaginator;




$capsule = new Capsule;

$capsule->addConnection(array(
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => $admin_db_user,
    'username' => $admin_db_db,
    'password' => $admin_db_pass,
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
    ));

$capsule->setAsGlobal();
$capsule->bootEloquent();


use Illuminate\Database\Eloquent\Model as Eloquent;

class Laravel extends Eloquent
{
    public function __construct()
    {
        // define os diretórios onde estarão armazenadas as views e o cache
        $path = [$_SERVER["DOCUMENT_ROOT"] . '/template/', $_SERVER["DOCUMENT_ROOT"] .
            '/templates/', $_SERVER["DOCUMENT_ROOT"] . '/views/'];
        $cachePath = $_SERVER["DOCUMENT_ROOT"] . '/templates_c';

        $compiler = new \Xiaoler\Blade\Compilers\BladeCompiler($cachePath);
        $engine = new \Xiaoler\Blade\Engines\CompilerEngine($compiler);
        $finder = new \Xiaoler\Blade\FileViewFinder($path);
        $finder->addExtension('php');
        $this->factory = new \Xiaoler\Blade\Factory($engine, $finder);
    }


    public function blade($path, $vars = [])
    {
        echo $this->factory->make($path, $vars);
    }
    
    
    public function view($path, $vars = [])
    {
        echo $this->factory->make($path, $vars);
    }
    public function exists($path)
    {
        return $this->factory->exists($path);
    }
    public function share($key, $value)
    {
        return $this->factory->share($key, $value);
    }
    public function render($path, $vars = [])
    {
        return $this->factory->make($path, $vars)->render();
    }

}
