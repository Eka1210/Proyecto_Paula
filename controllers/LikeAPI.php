<?php

namespace Controllers;

use MVC\Router;
use Model\Product;
use Model\Wishlist;


class APIGifts
{

    public static function like1($productId)
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
        $lists = Wishlist::all();
        $userId = $_SESSION['userId'] ?? null;
        if ($userId) {
            foreach ($lists as $list) {
                if ($list->productID == $productId && $list->userID == $userId) {
                    $list->eliminar();
                }
            }
        }
    }

    public static function like_dislike($productId)
    {
        $userId = $_SESSION['userId'] ?? null;
        $wishlistElement = self::findWishList($productId);

        if ($userId) {
            if ($wishlistElement != null) {
                self::dislike($productId);
            } else {
                self::like($productId);
            }
        }
    }

    public static function heartfunction(Router $router)
    {
        $userId = $_SESSION['userId'] ?? null;

        if ($userId) {

            self::like($_POST['productLiked']);

            // self::like_dislike($_POST['productLiked']);
            header('Location: /productos');
        }

        $router->render('/productos');
    }
}
