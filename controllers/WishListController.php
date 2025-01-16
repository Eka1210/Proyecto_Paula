<?php

namespace Controllers;

use MVC\Router;
use Model\Product;
use Model\Wishlist;

class WishListController
{

    public function list(Router $router)
    {
        $userId = $_SESSION['userId'] ?? null;

        if ($userId) {
        }


        $router->render('wishlist/wishlist');
    }

    public static function like($productId)
    {
        $userId = $_SESSION['userId'] ?? null;


        if ($userId) {
            $wishlist = new Wishlist();
            $wishlist->userID = $userId;
            $wishlist->productID = $productId;
            date_default_timezone_set('America/Costa_Rica');
            $wishlist->create_time = date('Y-m-d H:i:s');
            $wishlist->guardar();
        }
    }

    public static function findWishList($productId)
    {
        $lists = Wishlist::all();
        $userId = $_SESSION['userId'] ?? null;
        if ($userId) {
            foreach ($lists as $list) {
                if ($list->productID == $productId && $list->userID == $userId) {
                    return $list;
                }
            }
        }
        return null;
    }

    public static function dislike($productId)
    {
        $userId = $_SESSION['userId'] ?? null;
        $wishlistElement = self::findWishList($productId);

        if ($userId && $wishlistElement) {
            $wishlistElement->eliminar();
        }
    }

    public static function heartfunction($productId)
    {
        $userId = $_SESSION['userId'] ?? null;
        $wishlistElement = self::findWishList($productId);

        if ($userId) {
            if ($wishlistElement) {
                $wishlistElement->eliminar();
            } else {
                self::like($productId);
            }
        }
    }
}
