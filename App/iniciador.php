<?php

//Cargar librerias
require_once '../App/config/config.php';

require_once '../App/Helpers/url_helper.php';


//require_once '../App/Lib/Controlador.php';
//require_once '../App/Lib/BaseConexion.php';
//require_once '../App/Lib/Core.php';

//AUTOLODAD PHP

// Habilitar la visualización de errores (solo en desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($nombreClase) {
    require_once 'Lib/' . $nombreClase . '.php';
});
