<?php
namespace hyvemobile\api;
use hyvemobile\api\model\Model;
use hyvemobile\api\model\DBO;
use hyvemobile\api\controller\RequestController;
use hyvemobile\utils\Env;
use hyvemobile\api\model\Timezone;
include "../../vendor/autoload.php";
Env::loadEnv();
$req_controller = new RequestController();
$req_controller->parseURI();
$dbo = new DBO($_ENV['DSN'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
$model_name = ( Model::getNamespace().ucfirst($req_controller->getEndpoint()) );
$model = new $model_name($req_controller->getMethod(),$model_name::$key, new DBO($_ENV['DSN'], $_ENV['DB_USER'], $_ENV['DB_PASS']), $req_controller->getParam());
$req_controller->response($model->process());
