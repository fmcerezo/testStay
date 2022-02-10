<?php

/**
 * @author Francisco Manuel Cerezo González <franciscomanuelcerezo@gmail.com>
 * @package TestStay
 */
namespace TestStay;

use TestStay\controllers\BookingController;

require 'config/autoload.php';
require 'config/parameters.php';

if (isset($_GET['PATH_INFO'])) {
    $peticion = explode('/', $_GET['PATH_INFO']);
    $recurso = array_shift($peticion);
    
    $metodo = strtolower($_SERVER['REQUEST_METHOD']);
    switch ($metodo)
    {
        case 'get':
            if ('getCsv' == $recurso) {
                BookingController::getCsv();
            } else {
                http_response_code(404);
            }
            break;

        default:
            // Método no aceptado
            http_response_code(405);
    }
} else {
    http_response_code(404);
}
    