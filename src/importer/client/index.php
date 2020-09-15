<?php
namespace hyvemobile\importer\client;
use hyvemobile\utils\Env;
use hyvemobile\utils\Importer;
include "../../../vendor/autoload.php";


Env::loadEnv();
(new Importer($_ENV['CSV_FILE']))->process();





