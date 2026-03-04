<?php
    //MSIS Framework versión 1.0.0
    //Desarrollado por MSIS
    //Marzo 2022

    //Requerir el archivo de la clase Framework.php
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL);

    require_once 'app/classes/Framework.php';

    //Ejecutar el framework
    Framework::fly();