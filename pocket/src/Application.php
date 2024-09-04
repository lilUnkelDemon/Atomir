<?php namespace Atomir\AtomirCore;

use Atomir\AtomirCore\Database\Database;
use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;


class Application
{

    public Router $router;
    public static $ROOT_DIR;

    public static $app;

    public Database $db;

    public function __construct(string $rootDir)
    {
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;
        $whoops = new Run();
        $handler = new PrettyPageHandler();
        $handler->setPageTitle("[Atomir Exception] There was an error.");

        if ($_ENV['APP_ENV'] === 'development'){
            $whoops->pushHandler($handler);
        }else{
            $whoops->pushHandler(function($e){
                echo 'Something went wrong! Please try again later.';
            });
        }
        // Register Whoops as the default exception handler
        $whoops->register();

        $this->router = new Router();
        $this->db = new Database();
    }


    public function run()
    {
        echo $this->router->resolve();
    }
}