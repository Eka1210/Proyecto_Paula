<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;
use Model\Cart;
use Classes\Subject;
use Classes\Email;
use Model\Productsxcart;
use Model\Sale;
use Model\Wishlist;
use Model\Client;

class LoginController {
    public static function index(Router $router){
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario();
            $auth->sincronizar($_POST);
            $alertas = $auth->validateLogin();


            if(empty($alertas['error'])){
                $user = Usuario::where('email', $auth->email);
                if($user){
                    if($user->verificarPassword($auth->password)){
                        session_start();
                        $cart = Cart::where('userID', $user->id);
                        if(!$cart){
                            $cart = new Cart(['userId' => $user->id]);
                            $cart->crearC();
                        }
                        $_SESSION['userId'] = $user->id;
                        $_SESSION['username'] = $user->username;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['login'] = true;

                        if($user->admin == 1){
                            $_SESSION['admin'] = true;
                            header('Location: /admin');
                        } else{
                            header('Location: /');
                        }
                    }
                } else{
                    Usuario::setAlerta('error', 'El usuario no existe');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function register(Router $router) {
        $user = new Usuario();
        $alertas = [];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sincronizar datos del formulario
            $user->sincronizar($_POST);
    
            // Verificar si el usuario ya existe
            $result = $user->exists();
            if ($result->num_rows) {
                $alertas = Usuario::getAlertas();
            } else {
                // Validar registro (sintaxis, contraseñas, etc.)
                $alertas = $user->validateRegister();
    
                // Si no hay errores, proceder al registro
                if (empty($alertas['error'])) {
                    $user->hashPassword();
                    $user->generateToken();
    
                    // Crear el sujeto
                    $subject = new Subject();
    
                    // Agregar observadores
                    $emailNotifier = new Email();
                    $subject->attach($emailNotifier);
    
                    // Simular un evento de registro de usuario
                    $userData = [
                        'email' => $user->email,
                        'name' => $user->username,
                        'token' => $user->token,
                    ];
    
                    $subject->notifyObservers('user_registered', $userData);
    
                    // Guardar el usuario en la base de datos
                    $result = $user->guardar();
                    if ($result) {
                        header('Location: /mensaje');
                        exit;
                    } else {
                        Usuario::setAlerta('error', 'Hubo un problema al guardar el usuario');
                        $alertas = Usuario::getAlertas();
                    }
                }
            }
        }
    
        // Renderizar la vista con los datos y alertas
        $router->render('auth/register', [
            'user' => $user,
            'alertas' => $alertas
        ]);
    }

    public static function forgot(Router $router){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validateEmail();

            if(empty($alertas)){
                $user = Usuario::where('email', $auth->email);
                if($user && $user->verified === "1"){
                    $user->generateToken();
                    $user->guardar();

                    // Crear el sujeto
                    $subject = new Subject();

                    // Agregar observadores
                    $emailNotifier = new Email();

                    $subject->attach($emailNotifier);

                    // Simular un evento de registro de usuario
                    $userData = [
                        'email' => $user->email,
                        'name' => $user->username,
                        'token' => $user->token,
                    ];

                    $subject->notifyObservers('password_reset', $userData);

                    Usuario::setAlerta('success', 'Revisa tu correo para recuperar tu contraseña');
                } else{
                    Usuario::setAlerta('error', 'El usuario no existe o no está verificado');
                }
            }

        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/forgot', [
            'alertas' => $alertas
        ]);
    }

    public static function changePassword(Router $router){
        isAuth();
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validateEmail();


            if(empty($alertas)){
                $user = Usuario::where('email', $auth->email);
                if($user && $user->verified === "1"){
                    $user->generateToken();
                    $user->guardar();

                    // Crear el sujeto
                    $subject = new Subject();

                    // Agregar observadores
                    $emailNotifier = new Email();

                    $subject->attach($emailNotifier);

                    // Simular un evento de registro de usuario
                    $userData = [
                        'email' => $user->email,
                        'name' => $user->username,
                        'token' => $user->token,
                    ];

                    $subject->notifyObservers('password_reset', $userData);

                    Usuario::setAlerta('success', 'Revisa tu correo para recuperar tu contraseña');
                } else{
                    Usuario::setAlerta('error', 'El usuario no existe o no está verificado');
                }
            }

        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/change', [
            'alertas' => $alertas
        ]);
    }

    public static function reset(Router $router){
        $error = false;
        $alertas = [];
        $token = s($_GET['token'] ?? null);
        $user = Usuario::where('token', $token);
        if(empty($user) || $token === ''){
            Usuario::setAlerta('error', 'Token Inválido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $password = new Usuario($_POST);
            $alertas = $password->comparePasswords($_POST['password'], $_POST['password2']);
            if(empty($alertas['error'])){
                $alertas = $password->validatepassword($_POST['password']);
                if(empty($alertas['error'])){
                    $user->password = $password->password;
                    $user->hashPassword();
                    $user->token = '';
                    $result = $user->guardar();
                    if($result){
                        header('Location: /cuenta?result=2');
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/reset', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function verificar(Router $router){
        $alertas = [];
        $token= s($_GET['token'] ?? null);
        $user = Usuario::findToken('token', $token);

        if(!$user){
           Usuario::setAlerta('error', 'El token no es válido');
        } else{
            $user->verified = 1;
            $user->token = '';
            $user->guardar();
            Usuario::setAlerta('success', 'El usuario se verificó correctamente');
            $client = new Client(['userID' => $user->id, 'marketing' => 0]);
            $client->guardar();
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/verificar', [
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje', [
        ]);
    }

    public static function logout(Router $router){
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    public static function cuenta(Router $router){
        isAuth();
        $result = $_GET['result'] ?? null;

        $id = $_SESSION['userId'];
        $user = Usuario::find($id);
        $client = Client::findClient($id);

        $router->render('cuenta/cuenta', [
            'user' => $user,
            'client' =>$client,
            'result' => $result
        ]);
    }

    public static function actualizarCuenta(Router $router){
        isAuth();
        $alertas = [];
        $alertasC = [];
        $id = $_SESSION['userId'];
        $user = Usuario::find($id);
        $client = Client::findClient($id);

        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $user->sincronizar($_POST);
            $alertas = $user->validateUpdate();
            if(empty($alertas['error']) ){
                $result = $user->exists2($id);
                if($result){
                    $alertas = Usuario::getAlertas();
                } else{
                    $client->sincronizar($_POST);
                    $alertas = $client->validate();
                    if(empty($alertas['error'])){
                        $user->guardar();
                        $client->guardar();
                        header('Location: /cuenta?result=2');
                    }
                    else{
                        $alertas = Client::getAlertas();
                    }
                }
            }
        }
        $router->render('cuenta/actualizarCuenta', [
            'user' => $user,
            'client' => $client,
            'alertas' =>$alertas
        ]);
        
}

    public static function eliminarCuenta(Router $router){
        isAuth();
        $id = $_SESSION['userId'];
        $user = Usuario::find($id);
        $client = Client::findClient($id);

        $cart = Cart::where('userId', $id);
        $products = Productsxcart::whereAll('cartID', $cart->id);
        foreach($products as $product){
            $product->eliminar();
        }
        $cart->eliminar();
        
        $sales = Sale::whereAll('userId', $id);
        foreach($sales as $sale){
            $sale->removeUser();
        }

        $wishlist = Wishlist::whereAll('userID', $id);
        foreach($wishlist as $wL){
            $wL->eliminarPorUserID($id);
        }

        $client->eliminar();
        $user->eliminar();

        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    
}