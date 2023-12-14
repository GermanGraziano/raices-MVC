<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController {
    public static function index(Router $router) {

        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        //Muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin',
                [
                        'propiedades' => $propiedades,
                        'resultado' => $resultado,
                        'vendedores' => $vendedores,
                ],);
    }

    public static function crear(Router $router) {

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
          // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();


        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //Crea una nueva instancia
            $propiedad = new Propiedad($_POST['propiedad']);
    
            /**SUBIDA DE ARCHIVOS */
    
            //Generar un nombre unico
            $nombreImagen = md5( uniqid( rand(),true ) ). ".jpg";
    
            //Setear la imagen
            //Realiza un resize a la imagen con intervention
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $imagen = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
    
            // Validar
           $errores = $propiedad->validar();
    
            if (empty($errores)) {
    
                 //Crear carpeta
                if(!is_dir(CARPETA_IMAGENES)){
                    mkdir(CARPETA_IMAGENES);
                }
    
                //Guarda la imagen el el servidor
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);
       
                //Guardar en la base de datos
               $propiedad -> guardar(); 
    
            }
        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores,
        ]);
    }


    public static function actualizar(Router $router) {
        $id = validarORedireccionar('/admin');
        $vendedores = Vendedor::all();
        $propiedad = Propiedad::find($id);
          // Arreglo con mensajes de errores
          $errores = Propiedad::getErrores();

          if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //asignar los atributos
            $args = $_POST['propiedad'];
    
            $propiedad->sincronizar($args);
    
            // Validacion
            $errores = $propiedad->validar();
    
            //subida de archivos
    
            //Generar un nombre unico
            $nombreImagen = md5( uniqid( rand(),true ) ). ".jpg";
    
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $imagen = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
    
            if (empty($errores)) {
                if($_FILES['propiedad']['tmp_name']['imagen']){
                //Almacenar la imagen
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                // Actualizar
                $propiedad->guardar();
                }
            }
        }
    

        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores,
        ]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if($id) {
    
                $tipo = $_POST['tipo'];
    
                if(validarTipoContenido($tipo)){
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                } 
            }
        }
    
    }
    
   
}