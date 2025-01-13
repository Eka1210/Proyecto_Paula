<?php

namespace Controllers;

use MVC\Router;


class WishListController
{

    public static function list(Router $router)
    {

        $router->render('/wishlist');
    }
}
