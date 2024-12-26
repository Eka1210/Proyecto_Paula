<?php
define('IMAGES_DIR', $_SERVER['DOCUMENT_ROOT'] . '/images/');

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Protect Reservations Pages
function isAuth() : void{
    if(!isset($_SESSION['login'])){
        header('Location: /');
    }
}

function isAdmin() : void{
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }
}

function validateORredirect(string $url){
    $id = $_GET['id'] ?? null;
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if(!$id) {
        header("Location: $url");
    }

    return $id;
}

function inArray($element, $array){
    foreach($array as $el){
        if($el->id === $element->id){
            return true;
        }
    }
    return false;
}


function showNotification($code){
    switch($code){
        case 1:
            $message = 'Creado Exitosamente';
            break;
        case 2:
            $message = 'Actualizado Exitosamente';
            break;
        case 3:
            $message = 'Eliminado Exitosamente';
            break;
        case 4:
            $message = 'Permiso Asignado Exitosamente';
            break;
        case 5:
            $message = "Pedido Realizado Exitosamente";
            break;
        default:
            $message = False;
            break;
    }

    return $message;
}

function showErrors($code){
    switch($code){
        case 1:
            $message = 'No se puede eliminar el producto';
            break;
        case 2:
            $message = "No se puede realizar un pedido vacío";
            break;
        default:
            $message = False;
            break;
    }

    return $message;
}
