<?php

namespace Model;

class Promotion extends ActiveRecord
{
    protected static $tabla = 'promotions';
    protected static $columnasDB = ['id', 'description', 'percentage', 'active', 'start_time', 'end_time', 'name'];

    public $id;
    public $description;
    public $percentage;
    public $active;
    public $start_time;
    public $end_time;
    public $name;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->description = $args['description'] ?? '';
        $this->percentage = $args['percentage'] ?? null;
        $this->active = $args['active'] ?? null;
        $this->start_time = $args['start_time'] ?? null;
        $this->end_time = $args['end_time'] ?? null;
        $this->name = $args['name'] ?? '';
    }
}
