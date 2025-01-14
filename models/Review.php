<?php 
namespace Model;

class Review extends ActiveRecord{
    protected static $tabla = 'review';
    protected static $columnasDB = ['id','create_time', 'review', 'productID', 'rating'];

    public $id;
    public $create_time;
    public $review;
    public $productID;
    public $rating;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->create_time = $args['create_time'] ?? ''; 
        $this->review = $args['review'] ?? '';
        $this->productID = $args['productID'] ?? null;
        $this->rating = $args['rating'] ?? null; 
    }

}