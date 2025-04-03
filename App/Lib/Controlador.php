<?php
//Controlador Principal
//Se encarga de cargar los modelos y las vistas

class Controlador
{

    //cargar modelo
    public function modelo($modelo)
    {
        //Carga modelo
        require_once '../App/Models/' . $modelo . '.php';
        //Instanciar el modelo
        return new $modelo;
    }
    //cargar vista
    public function vista($vista, $datos = [])
    {
        //chequear si el archivo vista existe
        if (file_exists('../App/Views/' . $vista . '.php')) {
            require_once '../App/Views/' . $vista . '.php';
        } else {
            // si el archivo de la vista no existe
            die('La vista no existe');
        }
    }
}
