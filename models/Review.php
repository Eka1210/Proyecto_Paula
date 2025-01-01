<?php 
namespace Model;

class Review extends ActiveRecord{
    protected static $tabla = 'review';
    protected static $columnasDB = ['id','create_time', 'review', 'productID', 'rating', 'userID'];

    public $id;
    public $create_time;
    public $review;
    public $productID;
    public $rating;
    public $userID;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->create_time = $args['create_time'] ?? ''; 
        $this->review = $args['review'] ?? '';
        $this->productID = $args['productID'] ?? null;
        $this->rating = $args['rating'] ?? null; 
        $this->userID = $args['userID'] ?? null;
    }

}