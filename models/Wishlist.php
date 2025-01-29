<?php

namespace Model;

class Wishlist extends ActiveRecord
{
    protected static $tabla = 'wishlist';
    protected static $columnasDB = ['create_time', 'userID', 'productID'];

    public $create_time;
    public $userID;
    public $productID;

    public function __construct($args = [])
    {
        $this->create_time = $args['create_time'] ?? '';
        $this->userID = $args['userID'] ?? null;
        $this->productID = $args['productID'] ?? null;
    }

    public static function isLiked($productId, $userId)
    {
        $lists = self::all();
        foreach ($lists as $list) {
            if ($list->productID == $productId && $list->userID == $userId) {
                return true;
            }
        }

        return false;
    }
}
