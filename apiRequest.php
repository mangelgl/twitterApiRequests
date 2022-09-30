<?php

use TwitterApiRequest as GlobalTwitterApiRequest;

include 'config/config.php';

/**
 * Esta clase permite hacer una consulta a la API de Twitter
 * @author Miguel Ángel García López
 * @version 1.0
 */
class TwitterApiRequests
{

    /**
     * curl handle
     * @var object
     * @access private
     */
    protected $handle;

    /**
     * curl options
     * @var array
     * @access private
     */
    protected $optionsArray = [];

    /**
     * Enlace para la consulta a la API
     * @var string
     * @access protected
     */
    public $url;

    /**
     * Método de petición HTTP
     * @var string
     * @access protected
     */
    public $metodo;

    /**
     * Bearer token
     * @var string
     * @access private
     */
    private $bToken;

    /**
     * Class constructor
     */
    function __construct()
    {
        // Inicia la sesión cURL
        $this->handle = $this->initSession();
        // Inicializa las keys
        $this->setAuth();
    }

    /**
     * Class destructor
     */
    function __destruct()
    {
        $this->endSession();
    }

    /**
     * Inicia la sesión cURL
     * @return CurlHandle
     */
    private function initSession()
    {
        return curl_init();
    }

    /**
     * Configura múltiples opciones para una transferencia cURL
     */
    private function setCurlOptions()
    {

        $this->optionsArray = [
            CURLOPT_CONNECTTIMEOUT => 30, // The number of seconds to wait while trying to connect
            CURLOPT_MAXCONNECTS => 2, // The maximum amount of persistent connections that are allowed
            CURLOPT_FOLLOWLOCATION => true, // Follows any Location: that the server sends as part of the HTTP Header
            CURLOPT_RETURNTRANSFER => true, // Return the transfer as a string of the return value
            CURLOPT_TIMEOUT => 30, // The maximum number of seconds to allow cURL functions to execute.
            CURLOPT_URL => $this->url,
        ];
        curl_setopt_array($this->handle, $this->optionsArray);
    }

    /**
     * Establece la dirección al endpoint al que realizar la petición
     * @param string url del endpoint al que realizar la petición
     */
    public function setApiEndpoint(string $url)
    {
        $this->url = $url;
    }

    /**
     * Obtiene las keys necesarias y las configura para la transferencia cURL 
     */
    private function setAuth()
    {
        global $bearerToken;
        $this->bToken = $bearerToken;
        curl_setopt($this->handle, CURLOPT_HTTPHEADER, ["Authorization: Bearer $this->bToken"]);
    }

    /**
     * Realiza la petición a la API
     * @access protected
     * @return string|boolean resultado de la petición o false en caso de fallo
     */
    public function sendRequest()
    {
        $this->setCurlOptions();
        return curl_exec($this->handle);
    }

    /**
     * Finaliza la sesión cURL
     */
    private function endSession()
    {
        curl_close($this->handle);
    }
}
