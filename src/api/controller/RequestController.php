<?php
namespace hyvemobile\api\controller;

class RequestController
{
    protected array $endpointMethod = [
        'contacts' => 'GET',
        'contact' => 'POST',
        'timezone' => 'GET'
    ];

    protected string $endpoint;
    protected string $method;


    protected $param;

    public function parseURI() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );

        if (is_array($uri) && array_key_exists(1, $uri)) {
            if (array_key_exists($uri[1], $this->endpointMethod) && $this->endpointMethod[$uri[1]] === $_SERVER['REQUEST_METHOD']) {
                $this->endpoint = $uri[1];
                $this->method = $_SERVER['REQUEST_METHOD'];
                $this->param = (array_key_exists(2, $uri)) ? array_slice($uri, 2) : [];
                return;
            }
        }
//        header("HTTP/1.1 404 Not Found");
        echo "Hyve Mobile API";
        exit();
    }

    public function getEndpoint() {
        return $this->endpoint;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getParam()
    {
        return $this->param;
    }

    public function response(string $data) {
        header("Content-Type: application/json; charset=UTF-8");
        echo $data;
        die();
    }

}
