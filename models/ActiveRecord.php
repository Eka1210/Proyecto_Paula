<?php

namespace Model;

class ActiveRecord
{

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];

    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje)
    {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Validación
    public static function getAlertas()
    {
        return static::$alertas;
    }

    public function validar()
    {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function consultarSQL($query)
    {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    // Registros - CRUD
    public function guardar()
    {
        $resultado = '';
        if (!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    // Todos los registros
    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    public static function deleteByProduct2($productId) {
        // Eliminar todas las relaciones de categorías con el producto especificado
        $query = "DELETE FROM optionsxproduct WHERE productID = $productId";
        $resultado = self::$db->query($query);
        return $resultado;
    }
    public static function all2($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE productID = " . $id;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla  . " WHERE id = " . $id;
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function find2($nombre)
    {
        $query = "SELECT id FROM " . static::$tabla  . " WHERE nombre = '$nombre'";
        $result = self::$db->query($query);
        return ($result);
    }
    public static function find3($nombre)
    {
        $query = "SELECT id FROM " . static::$tabla  . " WHERE name = '$nombre'";
        $result = self::$db->query($query);
        return ($result);
    }

    public static function find4($id)
    {
        $query = "SELECT * FROM " . static::$tabla  . " WHERE userID = " . $id;
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function find5($id)
    {
        $query = "SELECT * FROM " . static::$tabla  . " WHERE userId = " . $id;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite)
    {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $limite;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // crea un nuevo registro
    public function crear()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        // debuguear($query);

        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
            'resultado' =>  $resultado,
            'id' => self::$db->insert_id
        ];
    }

    // Actualizar el registro
    public function actualizar()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .=  join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Eliminar un Registro por su ID
    public function eliminar()
    {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public function eliminar2()
    {
        $query = "DELETE FROM "  . static::$tabla . " WHERE productID = " . self::$db->escape_string($this->productID) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public function eliminarPorUserID($userID)
    {
        $query = "DELETE FROM "  . static::$tabla . " WHERE userID = " . $userID . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public static function deleteByProduct($productId)
    {
        // Eliminar todas las relaciones de categorías con el producto especificado
        $query = "DELETE FROM categoriesxproduct WHERE productID = $productId";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public static function deleteOp($optionID)
    {
        $query = "DELETE FROM optionsxproduct WHERE optionID = $optionID";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public static function deleteFromCart($productId, $cartId)
    {
        $query = "DELETE FROM productsxcart WHERE productID = $productId AND cartID = $cartId";
        $resultado = self::$db->query($query);
        return  $resultado;
    }

    public static function deleteCustomFromCart($productId, $cartId, $values)
    {
        $query = "DELETE FROM productsxcart WHERE productID = $productId AND cartID = $cartId AND customization = '" . $values . "'" ;
        $resultado = self::$db->query($query);
        return  $resultado;
    }

    public static function where($column, $value)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE $column = '$value'";
        // debuguear($query);
        $result = self::consultarSQL($query);
        return array_shift($result); // Get the first element of the array
    }

    public static function findToken($column, $value)
    {
        $query = "SELECT * FROM users WHERE token LIKE '%$value%'";
        // debuguear($query);
        $result = self::consultarSQL($query);
        return array_shift($result); // Get the first element of the array
    }

    public static function findClient($value)
    {
        $query = "SELECT * FROM clients WHERE userID = $value";
        // debuguear($query);
        $result = self::consultarSQL($query);
        return array_shift($result); // Get the first element of the array
    }

    public static function whereAll($column, $value)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE $column = '$value'";
        // debuguear($query);
        $result = self::consultarSQL($query);
        return $result; // Get the first element of the array
    }

    public function setImage($image)
    {
        // Delete the previous image
        if (!is_null($this->id)) {
            $this->deleteImage();
        }

        if ($image) {
            $this->imagen = $image;
        }
    }

    public function setImage2($image)
    {
        // Delete the previous image
        if (!is_null($this->id)) {
            $this->deleteImage2();
        }

        if ($image) {
            $this->imagen = $image;
        }
    }

    public function deleteImage()
    {
        if (!empty($this->imagen) and $this->imagen!='') {
            $filePath = IMAGES_DIR . $this->imagen;

            if (file_exists($filePath) && is_file($filePath)) {
                unlink($filePath);
            } else {
                error_log("El archivo no existe o no es un archivo válido: $filePath");
            }
        } else {
            error_log("El campo 'imagen' está vacío para el objeto con ID: $this->id");
        }
    }
    public function deleteImage2()
    {
        if (!empty($this->imagen)) {
            error_log($this->imagen);
            $filePath = __DIR__ . '/../public' . $this->imagen;
            unlink($filePath);
            $this->imagen = '';
        } else {
            error_log("El campo 'imagen' está vacío para el objeto con ID: $this->id");
        }
    }


    public static function categoria($id)
    {
        $query = "SELECT * FROM " . static::$tabla  . " WHERE categoryID = " . $id . " LIMIT 1";
        $resultado = self::consultarSQL($query);
        if (!empty($resultado)) {
            return false;
        }
        return true;
    }

    public static function findCategoria($productId)
    {
        $query = "SELECT c.nombre
                FROM categoriesxproduct cp 
                INNER JOIN categories c ON cp.categoryID = c.id 
                WHERE cp.productID = " . $productId;
        
        $resultado = self::consultarSQL($query);
        
        // Si hay un resultado, devolver el nombre de la categoría
        if (!empty($resultado)) {
            return $resultado[0]->name; // Obtener solo el primer resultado
        }
        
        return null; // Si no hay categoría, retornar null
    }

    public static function makeAdmin($column, $value)
    {
        if ($column == 'username') {
            $query = "UPDATE users SET admin = 1 WHERE username = '$value'";
        } else {
            $query = "UPDATE users SET admin = 1 WHERE email = '$value'";
        }
        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public static function unmakeAdmin($column, $value)
    {
        if ($column == 'username') {
            $query = "UPDATE users SET admin = 0 WHERE username = '$value'";
        } else {
            $query = "UPDATE users SET admin = 0 WHERE email = '$value'";
        }
        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }
    // Funciones Pedidos

    public static function allSale($pedidoId)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE salesID = " . $pedidoId;
        $resultado = self::consultarSQL($query);
        return  $resultado;
    }

    public static function isClientBuy($clientID,$productID)
    {
        $query = "
            SELECT sales.id
            FROM sales
            INNER JOIN productsxsale ON sales.id = productsxsale.salesID
            WHERE sales.userId = " . $clientID . "  AND productsxsale.productID = " . $productID ." LIMIT 1";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }


    // Funciones Carrito

    public static function allCart($cartId)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE cartID = " . $cartId;
        $resultado = self::consultarSQL($query);
        return  $resultado;
    }

    public static function findProductInCart($productId, $cartId)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE cartID = " . $cartId . " AND productID = " . $productId;
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }

    public static function findProductInCart2($productId, $cartId, $values)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE cartID = " . $cartId . " AND productID = " . $productId . " AND customization ='" . $values . "'";
        error_log($query);
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }

    public static function findProductInCart3($productId, $cartId, $values)
    {
        $values = addslashes($values);
        $query = "SELECT * FROM " . static::$tabla . " WHERE cartID = " . $cartId . " AND productID = " . $productId . " AND customization ='" . $values . " '";
        error_log($query);
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }


    public static function findCustomProductInCart($productId, $cartId, $customization)
    {
        // Escapar el JSON para evitar problemas de inyección SQL
        $customizationEscaped = addslashes($customization);
        $customization = json_encode($customizationArray);

        $query = "SELECT * FROM " . static::$tabla . " WHERE cartID = " . $cartId . " AND productID = " . $productId . " AND customization = " . self::$db->escape_string($customization);
        $resultado = self::consultarSQL($query);
    
        return array_shift($resultado);
    }

    public function actualizarProductInCart()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        // Iterar para agregar cada campo y valor
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }
        // Validar que existan valores para actualizar
        if (empty($valores)) {
            throw new \Exception("No hay valores para actualizar el registro.");
        }
        // Validar que cartID y productID estén configurados
        if (empty($this->cartID) || empty($this->productID)) {
            throw new \Exception("cartID o productID no están configurados.");
        }
        // Construir la consulta SQL
        $query = "UPDATE " . static::$tabla . " SET " . join(', ', $valores) .
            " WHERE cartID = '" . self::$db->escape_string($this->cartID) . "'" .
            " AND productID = '" . self::$db->escape_string($this->productID) . "'" .
            " LIMIT 1";
        // Ejecutar la consulta
        $resultado = self::$db->query($query);
        // Retornar el resultado
        return $resultado;
    }

    public function actualizarCustomProductInCart()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
    
        // Iterar para agregar cada campo y valor
        $valores = [];
        foreach ($atributos as $key => $value) {
            if($key != 'customization'){
                $valores[] = "{$key}='" . self::$db->escape_string($value) . "'";
            }
        }
    
        // Validar que existan valores para actualizar
        if (empty($valores)) {
            throw new \Exception("No hay valores para actualizar el registro.");
        }
    
        // Validar que cartID, productID y customization estén configurados
        if (empty($this->cartID) || empty($this->productID)) {
            throw new \Exception("cartID o productID no están configurados.");
        }
    
        // Construir la consulta SQL
        $query = "UPDATE " . static::$tabla . " SET " . join(', ', $valores) .
            " WHERE cartID = '" . self::$db->escape_string($this->cartID) . "'" .
            " AND productID = '" . self::$db->escape_string($this->productID) . "'" .
            " AND customization = '" . self::$db->escape_string($this->customization) . "'" .
            " LIMIT 1";
    
        // Ejecutar la consulta
        $resultado = self::$db->query($query);
    
        // Retornar el resultado
        return $resultado;
    }

    public static function deleteByPromotion($promotionId)
    {
        // Eliminar todas las relaciones de promociones con el producto especificado
        $query = "DELETE FROM productxpromotion WHERE promotionID = $promotionId";
        $resultado = self::$db->query($query);
        return $resultado;
    }


    public static function findlike($user, $productId)
    {
        $query = "SELECT id FROM " . static::$tabla . " WHERE userID = " . $user . " AND productID = " . $productId;
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }
    public function eliminarLike($user, $prod)
    {
        $query = "DELETE FROM "  . static::$tabla . " WHERE userID = " . $user . " AND productID = " . $prod . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public static function getSales($start, $end)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE fecha BETWEEN '$start' AND '$end'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Funciones Checkout

    public static function getActivePromotions()
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE active = 1 AND start_time <= NOW() AND end_time >= NOW()";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function isProductPromotion($productID,$promocionID)
    {
        $query = "SELECT id FROM " . static::$tabla . " WHERE promotionID = " . $promocionID . " AND productID = " . $productID . " LIMIT 1";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

}
