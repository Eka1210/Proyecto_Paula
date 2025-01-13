<?php

namespace Controllers;

use MVC\Router;


class ReportController
{

    public static function reporte(Router $router)
    {

        $router->render('/reportes/reporte');
    }
}
