<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;

class PaginasController {

    public static function index(Router $router){
       
        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio'=> $inicio,
        ]);
    }

    public static function nosotros( Router $router){
        $router->render('paginas/nosotros', []);
    }

    public static function propiedades(Router $router){
        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades',[
            'propiedades'=> $propiedades,
        ]);
    }

    public static function propiedad(Router $router){
        $id = validarORedireccionar('/propiedades');
        $propiedad = Propiedad::find($id); 

        $router->render('paginas/propiedad', [
            'propiedad'=>$propiedad,
        ]);
    }

    public static function blog(Router $router){
        $router->render('paginas/blog');
    }

    public static function entrada(Router $router){
        $router->render('paginas/entrada');
    }

    public static function contacto(Router $router){

       //$respuestas = $_POST['contacto'],
       
       
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // enviar con PHPMailer
            // Crear una instancia de PHP Mailer
            //$mail = new PHPMailer()

            // COnfigurar SMTP
            //$mail->isSMTP();
           // $mail->Host='',
           // $mail->SMTPAuth= true;
           // $mail->Username = '';
           // $mail->Password ='';
           // $mail->SMTPSecure = 'tls';
           // $mail->Port = 2525;

           // Configurar el contenido del mail
            //$mail->setFrom('admin@bienesraices.com');
            //$mail->addAddress('admin@bienesraices.com');
            //$mail->Subject = 'Tienes un Nuevo Mensaje';

            //Habilitar HTML
            //$mail->isHTML(true);
            //$mail->CharSet = 'UTF-8';

            //Definir el contenido
            //$contenido ='<html>;
            //$contenido .= '<p>Tienes un nuevo mensaje<p>'
            //$contenido .= '<p>Nombre: ' . $respuestas['nombre'] . ' </p>';
            //$contenido .= '<p>Email: ' . $respuestas['email'] . ' </p>';
            //$contenido .= '<p>Teléfono: ' . $respuestas['telefono'] . ' </p>';
            //$contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . ' </p>';
            //$contenido .= '<p>Vende o compra: ' . $respuestas['tipo'] . ' </p>';
            //$contenido .= '<p>Precio o presupuesto: ' . $respuestas['precio'] . ' </p>';
            //$contenido .= '<p>Prefiere ser contactado por: ' . $respuestas['contacto'] . ' </p>';
            //$contenido .= '<p>Fecha contacto: ' . $respuestas['fecha'] . ' </p>';
            //$contenido .= '<p>Hora: ' . $respuestas['hora'] . ' </p>';

            //$contenido .= '<html>';
            //$mail->Body = $contenido;

            //Enviar el email
            //if($mail->send()) {
                //echo "Mensaje enviado correctamente";
            //}else{
              //  echo "El mensaje no se pudo enviar";
            //}
        }
        $router->render('paginas/contacto', [

        ]);
    }

}