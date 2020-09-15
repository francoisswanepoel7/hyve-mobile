<?php
namespace hyvemobile\api\model;
use Nette\Database\Connection;

abstract class Model
{
    protected array $params;
    protected DBO $dbo;
    protected int $filter;


    function __construct(string $method, string $key, DBO $dbo, array $req_params)
    {
        $this->dbo = $dbo;
        $this->params = [];

        switch ($method) {
            case 'GET':
                if (array_key_exists($key, $_GET)) {
                    $this->params[] = filter_var ($_GET[$key], $this->filter);
                } else {
                    if (!empty($req_params)) {
                        foreach ($req_params as $req_param) {
                            $this->params[] = filter_var($req_param, $this->filter);
                        }
                    }
                }
                break;
            case 'POST':
                if (empty($_POST)) {
                    $unfiltered_params = json_decode(file_get_contents('php://input'), true);
                    if (is_array($unfiltered_params) && array_key_exists(0, $unfiltered_params)) {
                        foreach ($unfiltered_params as $unfiltered_section) {
                            $keys = array_keys($unfiltered_section);
                            $data = [];
                            foreach ($keys as $k) {
                                $data[$k] = filter_var($unfiltered_section[$k], FILTER_SANITIZE_STRING);
                            }
                            $this->params[]= $data;
                        }
                    }
                }
                break;
            default:
                break;
        }
    }

    /**
     * @return array
     */
    public function getParams() : array {
        return $this->params;
    }

    /**
     * @return string
     */
    public static function getNamespace() : string {
        return 'hyvemobile\\api\model\\';
    }

    abstract function process();

}
