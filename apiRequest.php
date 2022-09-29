<?php

include 'config/config.php';

/**
 * Esta clase permite hacer una consulta a la API de Twitter
 * @author Miguel Ángel García López
 * @version 1.0
 */
class TwitterApiRequest
{

    /**
     * curl handle
     * @var object
     * @access private
     */
    private $handle;

    /**
     * curl options
     * @var array
     * @access private
     */
    private $optionsArray = [];

    /**
     * Enlace para la consulta a la API
     * @var string
     * @access protected
     */
    protected $url;

    /**
     * Método de petición HTTP
     * @var string
     * @access protected
     */
    protected $method;

    /**
     * Bearer token
     * @var string
     * @access private
     */
    private $bToken = "";
    /**
     * Constructor de la clase, inicializa la sesión cURL
     */
    function __construct()
    {
        $this->initSession();
        $this->optionsArray = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
        ];
    }

    /**
     * Destructor de la clase, finaliza la sesión cURL
     */
    function __destruct()
    {
        $this->endSession();
    }

    /**
     * Inicia la sesión cURL
     */
    private function initSession()
    {
        $this->handle = curl_init();
    }

    /**
     * Configura múltiples opciones para una transferencia cURL
     * @param $url API url endpoint
     * @param $method método HTTP
     */
    public function setArrayOptions($url, $method)
    {
        $this->url = $url;
        $this->method = $method;
        curl_setopt($this->handle, CURLOPT_URL, $url);
        $this->setMethod($method);
        curl_setopt_array($this->handle, $this->optionsArray);
    }

    /**
     * Establece el tipo de método para la petición HTTP a la API
     * @param $method método HTTP
     * @access private
     */
    private function setMethod($method)
    {
        if ($method == "POST") {
            curl_setopt($this->handle, CURLOPT_POST, true);
            curl_setopt($this->handle, CURLOPT_HTTPHEADER, ["Authorization: Bearer $this->bToken"]);
        } else if ($method == "GET") {
            curl_setopt($this->handle, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($this->handle, CURLOPT_HTTPHEADER, ["Authorization: Bearer $this->bToken"]);
        }
    }

    /**
     * Realiza la petición a la API
     * @access protected
     * @return string resultado de la petición
     */
    public function sendRequest()
    {
        $result = curl_exec($this->handle);
        return $result;
    }

    private function endSession()
    {
        curl_close($this->handle);
    }
}
