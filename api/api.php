<?php
header('Content-Type: application/json; charset=ISO-8859-1');
date_default_timezone_set('America/Bogota');
//BASE DE DATOS
require("../config/database.php");
require("./functions.php");

$action = (isset($_GET['action']) && $_GET['action'] != NULL) ? $_GET['action'] : 'Vacio';

switch($action){
    case 'save_libro':
        
        $idlib =  (isset($_POST['idlib']) && $_POST['idlib'] != NULL) ? $_POST['idlib'] : 'Vacio';
        $nombre_libro =  (isset($_POST['nombre_libro']) && $_POST['nombre_libro'] != NULL) ? $_POST['nombre_libro'] : 'Vacio';
        $fecha_ingreso = date("Y-m-d");
        $estado = "0";

        $num_libros = $pdo->prepare("SELECT count(*) as total FROM libros WHERE idlib = :idlib");
        $num_libros->bindParam(":idlib", $idlib);
        if ($num_libros->execute()) {
            $count = $num_libros->fetchColumn();
            if ($count < 1) {
                $registro = $pdo->prepare("INSERT INTO libros (idlib, nombre_libro, fecha_ingreso, estado) VALUES (:idlib, :nombre_libro, :fecha_ingreso, :estado)");
                $registro->bindParam(':idlib', $idlib);
                $registro->bindParam(':nombre_libro', $nombre_libro);
                $registro->bindParam(':fecha_ingreso', $fecha_ingreso);
                $registro->bindParam(':estado', $estado);
                if($registro->execute()){
                    echo json_encode(array("success" => "true", "message" => "Libro guardado con exito."));
                }else{
                    echo json_encode(array("success" => "false", "error" => "Error al guardar nuevo libro."));
                }

            }else{
                echo json_encode(array("success" => "false", "error" => "IDLIB ya se encuentra en uso, intente nuevamente."));
            }
        }else{
            echo json_encode(array("success" => "false", "error" => "Error interno del vervidor."));
        }

    break;
    case 'edit_libro':
        
        $idlib =  (isset($_POST['idlib']) && $_POST['idlib'] != NULL) ? $_POST['idlib'] : 'Vacio';
        $nombre_libro =  (isset($_POST['nombre_libro']) && $_POST['nombre_libro'] != NULL) ? $_POST['nombre_libro'] : 'Vacio';
        $fecha_ingreso = date("Y-m-d");
        $estado = "0";

        $num_libros = $pdo->prepare("SELECT count(*) as total FROM libros WHERE idlib = :idlib");
        $num_libros->bindParam(":idlib", $idlib);
        if ($num_libros->execute()) {
            $count = $num_libros->fetchColumn();
            if ($count < 1) {
                echo json_encode(array("success" => "false", "error" => "IDLIB no encontrado."));
            }else{
                $update = $pdo->prepare("UPDATE libros SET nombre_libro = :nombre_libro WHERE idlib = :idlib");
                $update->bindParam(':nombre_libro', $nombre_libro);
                $update->bindParam(':idlib', $idlib);
                if($update->execute()){
                    echo json_encode(array("success" => "true", "message" => "Actualizado con exito"));
                }else{
                    echo json_encode(array("success" => "false", "error" => "Error interno del vervidor."));
                }
            }
        }else{
            echo json_encode(array("success" => "false", "error" => "Error interno del vervidor."));
        }

    break;
    case 'get_books':
        require( 'ssp.class.php' );
        require("../config/database.php");

        $sql_details = array(
            'user' => $usuario,
            'pass' => $pass,
            'db'   => $database,
            'host' => $hostname
        );

        $table = 'libros';
        $primaryKey = 'id';
        $columns = array(
            
            array( 'db' => 'id', 'dt' => 'id' ),
            array( 'db' => 'idlib',  'dt' => 'idlib' ),
            array( 'db' => 'nombre_libro',     'dt' => 'nombre_libro' ),
            array( 'db' => 'fecha_ingreso',     'dt' => 'fecha_ingreso' ),
            array( 'db' => 'estado',     'dt' => 'estado' ),
            array("", "dt" => 'actions')
        );
        
         
        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
        );
    break;
    case 'get_prestamos':

        
        $prestamos = [];
        
        $num_prestamos = $pdo->prepare("SELECT count(*) as total FROM prestamos");
        if ($num_prestamos->execute()) {
            $count = $num_prestamos->fetchColumn();
            if ($count > 0) {

                $val_prestamos = $pdo->prepare("SELECT prestamos.id, prestamos.idlib, libros.nombre_libro, prestamos.identificacion, prestamos.nombre, prestamos.apellido, prestamos.fecha_nacimiento, prestamos.telefono, prestamos.fecha_ingreso, fecha_limite, prestamos.estado_prestamo
                FROM prestamos
                INNER JOIN libros
                ON prestamos.idlib = libros.idlib");
                if ($val_prestamos->execute()) {
                    $prestamos["data"] = $val_prestamos->fetchAll();


                    echo json_encode($prestamos);
                }else{
                    echo json_encode(array("success" => "false", "error" => "Error interno del servidor."));
                }


            }else{
                echo json_encode(array("data" => ""));
            }
        }else{
            echo json_encode(array("success" => "false", "error" => "Error interno del servidor."));
        }

    break;
    case 'edit_prestamos':
        
        $idlib =  (isset($_POST['idlib']) && $_POST['idlib'] != NULL) ? $_POST['idlib'] : 'Vacio';
        $estado_prestamo =  (isset($_POST['estado_prestamo']) && $_POST['estado_prestamo'] != NULL) ? $_POST['estado_prestamo'] : 'Vacio';
        $identificacion =  (isset($_POST['identificacion']) && $_POST['identificacion'] != NULL) ? $_POST['identificacion'] : 'Vacio';
        $nombre =  (isset($_POST['nombre']) && $_POST['nombre'] != NULL) ? $_POST['nombre'] : 'Vacio';
        $apellido =  (isset($_POST['apellido']) && $_POST['apellido'] != NULL) ? $_POST['apellido'] : 'Vacio';
        $fecha_nacimiento =  (isset($_POST['fecha_nacimiento']) && $_POST['fecha_nacimiento'] != NULL) ? $_POST['fecha_nacimiento'] : 'Vacio';
        $telefono =  (isset($_POST['telefono']) && $_POST['telefono'] != NULL) ? $_POST['telefono'] : 'Vacio';
        $fecha_limite =  (isset($_POST['fecha_limite']) && $_POST['fecha_limite'] != NULL) ? $_POST['fecha_limite'] : 'Vacio';

        if($estado_prestamo == "ACTIVO"){
            $estado = 1;
        }else{
            $estado = 0;
        }
        $prestamos = [];
        
        $num_prestamos = $pdo->prepare("SELECT count(*) as total FROM prestamos WHERE idlib = :idlib");
        $num_prestamos->bindParam(":idlib", $idlib);
        if ($num_prestamos->execute()) {
            $count = $num_prestamos->fetchColumn();
            if ($count > 0) {

                if(count_idlib($idlib) > 40){
                    if(getWeekday($fecha_limite) == 7){
                        echo json_encode(array("success" => "false", "error" => "No puede establecer la fecha el dia domingo,   le sugiero: </br>" . fecha_max()));
                    }else{
                        if(compare_date($fecha_limite,fecha_max())){
                            echo json_encode(array("success" => "false", "error" => "La fecha de entrega de este libro debe     ser máximo 5 días, le sugiero: </br>" . fecha_max()));
                        }else{
                            $val_prestamos = $pdo->prepare("UPDATE prestamos, libros    
                            SET 
                                prestamos.estado_prestamo = '$estado_prestamo',
                                prestamos.identificacion = '$identificacion',
                                prestamos.nombre = '$nombre',
                                prestamos.apellido = '$apellido',
                                prestamos.fecha_nacimiento = '$fecha_nacimiento',
                                prestamos.telefono = '$telefono',
                                prestamos.fecha_limite = '$fecha_limite',
                                libros.estado = '$estado'
                            WHERE 
                                prestamos.idlib = '$idlib' AND libros.idlib = '$idlib'");
                            if ($val_prestamos->execute()) {
                                echo json_encode(array("success" => "true", "message" => "Editado satisfactoriamente."));
                            }else{
                                echo json_encode(array("success" => "false", "error" => "Error interno del servidor."));
                            }
                        }
                }
            }else{
                $val_prestamos = $pdo->prepare("UPDATE prestamos, libros    
                SET 
                    prestamos.estado_prestamo = '$estado_prestamo',
                    prestamos.identificacion = '$identificacion',
                    prestamos.nombre = '$nombre',
                    prestamos.apellido = '$apellido',
                    prestamos.fecha_nacimiento = '$fecha_nacimiento',
                    prestamos.telefono = '$telefono',
                    prestamos.fecha_limite = '$fecha_limite',
                    libros.estado = '$estado'
                WHERE 
                    prestamos.idlib = '$idlib' AND libros.idlib = '$idlib'");
                if ($val_prestamos->execute()) {
                    echo json_encode(array("success" => "true", "message" => "Editado satisfactoriamente."));
                }else{
                    echo json_encode(array("success" => "false", "error" => "Error interno del servidor."));
                }
            }

    

            }else{
                echo json_encode(array("success" => "false", "error" => "IDLIB no se encuentra en la base de datos."));
            }
        }else{
            echo json_encode(array("success" => "false", "error" => "Error interno del servidor."));
        }

    break;
    case 'autocomplete':
        $term = (isset($_GET['term']) && $_GET['term'] != NULL) ? $_GET['term'] : 'Vacio';
        $cliente = [];
        
        $num_libros = $pdo->prepare("SELECT count(*) as total FROM libros WHERE idlib  LIKE '%".$term."%'");
        if ($num_libros->execute()) {
            $count = $num_libros->fetchColumn();
            if ($count < 1) {
                echo json_encode(array(["nombre_libro" => "NO EXISTE ID", "success" => "false"]));
            }else{
                $val_libros = $pdo->prepare("SELECT * FROM libros WHERE idlib LIKE '%".$term."%' ORDER BY id LIMIT 0 ,1");
                if ($val_libros->execute()) {
                    foreach($val_libros->fetchAll() as $row){
                        $cliente["value"] = $row["nombre_libro"];
                        $cliente["nombre_libro"] = $row["nombre_libro"];
                        $cliente["idlib"] = $row["idlib"];
                        $cliente["estado"] = $row["estado"];
                        $cliente["success"] = "true";
                    }
                    echo json_encode([$cliente]);
                }else{
                    echo json_encode(array("success" => "false", "error" => "Error interno del servidor."));
                }
            }
        }else{
            echo json_encode(array("success" => "false", "error" => "Error interno del servidor."));
        }

       
    break;
    case 'save_prestamo':

        
        $idlib =  (isset($_POST['idlib']) && $_POST['idlib'] != NULL) ? $_POST['idlib'] : 'Vacio';
        $identificacion =  (isset($_POST['identificacion']) && $_POST['identificacion'] != NULL) ? $_POST['identificacion'] : 'Vacio';
        $nombre =  (isset($_POST['nombre']) && $_POST['nombre'] != NULL) ? $_POST['nombre'] : 'Vacio';
        $apellido =  (isset($_POST['apellido']) && $_POST['apellido'] != NULL) ? $_POST['apellido'] : 'Vacio';
        $fecha_nacimiento =  (isset($_POST['fecha_nacimiento']) && $_POST['fecha_nacimiento'] != NULL) ? $_POST['fecha_nacimiento'] : 'Vacio';
        $telefono =  (isset($_POST['telefono']) && $_POST['telefono'] != NULL) ? $_POST['telefono'] : 'Vacio';
        $fecha_limite =  (isset($_POST['fecha_limite']) && $_POST['fecha_limite'] != NULL) ? $_POST['fecha_limite'] : 'Vacio';
        $fecha_ingreso = date("Y-m-d");
        $estado_prestamo = "ACTIVO";
        $libros = [];
        $estado = 1;

        //VERIFICO SI EL ID EXISTE EN LA BASE DE DATOS
        $num_libros = $pdo->prepare("SELECT count(*) as total FROM libros WHERE idlib = :idlib");
        $num_libros->bindParam(":idlib", $idlib);
        if ($num_libros->execute()) {
            $count = $num_libros->fetchColumn();
            if ($count > 0) {
                //CONSULTO ESTADO DEL LIBRO
                $val_libros = $pdo->prepare("SELECT * FROM  libros WHERE idlib = :idlib");
                $val_libros->bindParam(":idlib", $idlib);
                if ($val_libros->execute()) {

                    $libros = $val_libros->fetchAll();
                    if($libros[0]["estado"] == 1){
                        echo json_encode(array("success" => "false", "error" => "Este libro ya se encuentra prestado."));
                    }else{
                        if(check_plaindrome($idlib)){
                            echo json_encode(array("success" => "false", "error" => "Los libros palíndromos solo se pueden utilizar en la
                            biblioteca."));
                        }else{
                            //Verificando si los dígitos numéricos que componen el IDLIB suman más de 40
                            if(count_idlib($idlib) > 40){

                                if(getWeekday($fecha_limite) == 7){
                                    echo json_encode(array("success" => "false", "error" => "No puede establecer la fecha el dia domingo, le sugiero: </br>" . fecha_max()));
                                }else{
                                    if(compare_date($fecha_limite,fecha_max())){
                                        echo json_encode(array("success" => "false", "error" => "La fecha de entrega de este libro debe ser máximo 5 días, le sugiero: </br>" . fecha_max()));
                                    }else{
                                        $registro = $pdo->prepare("INSERT INTO prestamos (idlib, identificacion, nombre, apellido, fecha_nacimiento, telefono, fecha_limite, estado_prestamo) VALUES (:idlib, :identificacion, :nombre, :apellido, :fecha_nacimiento, :telefono, :fecha_limite, :estado_prestamo)");
                                        $registro->bindParam(':idlib', $idlib);
                                        $registro->bindParam(':identificacion', $identificacion);
                                        $registro->bindParam(':nombre', $nombre);
                                        $registro->bindParam(':apellido', $apellido);
                                        $registro->bindParam(':fecha_nacimiento', $fecha_nacimiento);
                                        $registro->bindParam(':telefono', $telefono);
                                        $registro->bindParam(':fecha_limite', $fecha_limite);
                                        $registro->bindParam(':estado_prestamo', $estado_prestamo);
                                        if($registro->execute()){
                                            //update
                                            $update = $pdo->prepare("UPDATE libros SET estado = :estado WHERE idlib = :idlib");
                                            $update->bindParam(':estado', $estado);
                                            $update->bindParam(':idlib', $idlib);
                                            if($update->execute()){
                                                echo json_encode(array("success" => "true", "message" => "Prestamo guardado con exito."));
                                            }else{
                                                echo json_encode(array("success" => "false", "error" => "Error al guardar nuevo prestamo."));
                                            }
                                            
                                        }else{
                                            echo json_encode(array("success" => "false", "error" => "Error al guardar nuevo prestamo."));
                                        }

                                       


                                    }
                                }

                            }else{

                                $registro = $pdo->prepare("INSERT INTO prestamos (idlib, identificacion, nombre, apellido, fecha_nacimiento, telefono, fecha_limite, estado_prestamo) VALUES (:idlib, :identificacion, :nombre, :apellido, :fecha_nacimiento, :telefono, :fecha_limite, :estado_prestamo)");
                                $registro->bindParam(':idlib', $idlib);
                                $registro->bindParam(':identificacion', $identificacion);
                                $registro->bindParam(':nombre', $nombre);
                                $registro->bindParam(':apellido', $apellido);
                                $registro->bindParam(':fecha_nacimiento', $fecha_nacimiento);
                                $registro->bindParam(':telefono', $telefono);
                                $registro->bindParam(':fecha_limite', $fecha_limite);
                                $registro->bindParam(':estado_prestamo', $estado_prestamo);
                                if($registro->execute()){
                                    //update
                                    $update = $pdo->prepare("UPDATE libros SET estado = :estado WHERE idlib = :idlib");
                                    $update->bindParam(':estado', $estado);
                                    $update->bindParam(':idlib', $idlib);
                                    if($update->execute()){
                                        echo json_encode(array("success" => "true", "message" => "Prestamo guardado con exito."));
                                    }else{
                                        echo json_encode(array("success" => "false", "error" => "Error al guardar nuevo prestamo."));
                                    }
                                    
                                }else{
                                    echo json_encode(array("success" => "false", "error" => "Error al guardar nuevo prestamo."));
                                }
                            }
                        }
                    }

                }else{
                    echo json_encode(array("success" => "false", "error" => "Error interno del servidor."));
                }  
            }else{
                echo json_encode(array("success" => "false", "error" => "IDLIB no existe en la base de datos."));
            }

        }else{
            echo json_encode(array("success" => "false", "error" => "Error interno del servidor."));
        }  
    
    break;
    default:
    echo json_encode(array("data" => ""));
}



?>