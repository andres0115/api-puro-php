<?php
/*Mapear la url ingresada en el navegador
1. controlador
2. método
3. parámetro
Ejemplo artiulo/actualizar/4
*/

class Core
{
    protected $controladorActual = 'paginas';
    protected $metodoActual = 'index';
    protected $parametros = [];

    //Inicializamos el constructor
    public function __construct()
    {
        //print_r(($this->getUrl()));
        //Instaciar el metodo url
        $url = $this->getUrl();

        //buscamos en controladores si el controlador existe
        if (!empty($url) && isset($url[0]) && (file_exists('../App/Controllers/' . ucwords($url[0]) . '.php'))) {
            //Si existe se setea como controlador por defecto
            $this->controladorActual = ucwords($url[0]);

            //unset indice 0
            unset($url[0]);
        }
        //requerir el controlador
        require_once '../App/Controllers/' . $this->controladorActual . '.php';
        $this->controladorActual = new $this->controladorActual;

        //Chequear la segunda parte del la url que seria el metodo

        if (!empty($url) && isset($url[1]) && method_exists($this->controladorActual, $url[1])) {
            if (method_exists($this->controladorActual, $url[1])) {
                //chequeamos el metodo
                $this->metodoActual = $url[1];
                //unset indice 1
                unset($url[1]);
            }
        }
        //probar traer metodos
        //echo $this->metodoActual;

        //Obtener los parametros
        $this->parametros = $url ? array_values($url) : [];

        //Lllamar callback con parametros array
        call_user_func_array([$this->controladorActual, $this->metodoActual], $this->parametros);
    }

    public function getUrl()
    // echo $_GET['url'];
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}
