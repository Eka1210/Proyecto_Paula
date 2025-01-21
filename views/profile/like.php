<?php

use Model\Product;
use Model\Wishlist;

$userId = $_SESSION['userId'] ?? null;
$wishlistElement = findWishList($_GET['productLiked']);
$productId = $_GET['productLiked'];

if ($userId) {
    if ($wishlistElement != null) {
        dislike($productId);
    } else {
        like($productId);
    }
} else {
    header('Location: /login');
}

function dislike($productId)
{
    $lists = Wishlist::all();
    $userId = $_SESSION['userId'] ?? null;
    if ($userId) {
        foreach ($lists as $list) {
            if ($list->productID == $productId && $list->userID == $userId) {
                $list->eliminarLike($userId, $productId);
            }
        }
    }
}
function like($productId)
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


function findWishList($productId)
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
