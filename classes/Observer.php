<?php
namespace Classes;

interface Observer {
    public function notify($event, $data);
}