<?php

require_once "conexion.php";

class ModeloProductos
{

    /*=============================================
	MOSTRAR EMPLEADOS
	=============================================*/

	static public function mdlMostrarProductos($tabla, $tablaCat)
	{
		$db = new Conexion();
		$stmt = $db->pdo->prepare("SELECT p.*, c.nombre as categoria FROM $tabla as p INNER JOIN $tablaCat as c ON p.categoria_id = c.id 
                                    WHERE p.estado = 1    ORDER BY p.id ASC");

		$stmt->execute();

		return $stmt->fetchAll();

		$stmt = null;
	}

    /*=============================================
	GUARDAR PRODUCTO
	=============================================*/

	static public function mdlGuardarProducto($tabla, $datos)
	{
        //configurar zona horaria
        date_default_timezone_set('America/Bogota');
        $fechaCreacion = date('Y-m-d');
        $fechaUP = date('Y-m-d H:i:s');

        try
            {
                $db = new Conexion();
                $stmt = $db->pdo->prepare("INSERT INTO $tabla(nombre,referencia,precio,peso,categoria_id, stock,fcreacion,factualizacion,estado) VALUES (:nombre, :referencia, :precio, :peso, :categoria_id, :stock, :fcreacion, :factualizacion, :estado)");

                $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
                $stmt->bindParam(":referencia", $datos["referencia"], PDO::PARAM_STR);
                $stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_INT);
                $stmt->bindParam(":peso", $datos["peso"], PDO::PARAM_INT);
                $stmt->bindParam(":categoria_id", $datos["id_categoria"], PDO::PARAM_INT);
                $stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_INT);
                $stmt->bindParam(":fcreacion", $fechaCreacion, PDO::PARAM_STR);
                $stmt->bindParam(":factualizacion", $fechaUP, PDO::PARAM_STR);
                $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);

                $nReg = $stmt->execute();

                if ($nReg > 0) {
                    return "ok";			
                }  

                $stmt = null;
        }
        catch(PDOException $pdoE){
                return "error";
        }
	}

    /*=============================================
	ELIMINAR PRODUCTOS
	=============================================*/

	static public function mdlEliminarProductos($tabla, $id)
	{
		$db = new Conexion();
		$stmt = $db->pdo->prepare("UPDATE $tabla SET estado = 0 WHERE id = :id");

		$stmt->bindParam(":id", $id, PDO::PARAM_INT);

		$nReg = $stmt->execute();

		if ($nReg > 0) {

			return 'ok';
		} else {

			return 'error';
		}
	}

    /*=============================================
	TRAER DATOS DE PRODUCTO
	=============================================*/
    static public function mdlTraerProducto($tabla,$id,$tablaCat)
    {
        $db = new Conexion();
		$stmt = $db->pdo->prepare("SELECT p.*, c.nombre as categoria, c.id as idcat FROM $tabla as p INNER JOIN $tablaCat as c ON p.categoria_id = c.id 
                                    WHERE p.id = :id");

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt = null;
    }

    /*=============================================
	EDITAR PRODUCTO
	=============================================*/

	static public function mdlEditarProducto($tabla, $id, $datos)
	{
        try
            {
                $db = new Conexion();
                $stmt = $db->pdo->prepare("UPDATE $tabla SET nombre = :nombre, referencia = :referencia, precio = :precio, peso =:peso, categoria_id = :categoria_id, stock = :stock  WHERE id = :id");

                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
                $stmt->bindParam(":referencia", $datos["referencia"], PDO::PARAM_STR);
                $stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_INT);
                $stmt->bindParam(":peso", $datos["peso"], PDO::PARAM_INT);
                $stmt->bindParam(":categoria_id", $datos["id_categoria"], PDO::PARAM_INT);
                $stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_INT);


                $nReg = $stmt->execute();

                if ($nReg > 0) {
                    return 'actualizado';
                }
            }
        catch(Exception $e){
            error_log('Error: '.$e->getMessage());
            return 'error';
        }
	}

    /*=============================================
	VENTA DE PRODUCTO
	=============================================*/

    static public function mdlVentaProducto($tabla, $id)
    {
        try{
            //consultar si ID existe en BD
            $db = new Conexion();
            $stmt = $db->pdo->prepare("SELECT stock FROM $tabla WHERE id = :id AND estado = 1");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
		    $stmt->execute();
            $data = $stmt->fetchAll();
            if(!$data){
                return array(
                    'code' => 'info',
                    'msn' => 'El numero de ID ingresado no existe en la base de datos.'
                );
            }else{
                $stock = (int)$data[0]["stock"];
                if($stock == 0){
                    return array(
                        'code' => 'info',
                        'msn' => 'No se puede registrar la venta, el stock actual del producto es cero (0)'
                    );
                }
                $nuevoStock = $stock - 1;
                date_default_timezone_set('America/Bogota');
                $fechaUP = date('Y-m-d H:i:s');
                $update = $db->pdo->prepare("UPDATE $tabla SET stock = :stock, factualizacion = :factualizacion  WHERE id = :id");
                $update->bindParam(":id", $id, PDO::PARAM_INT);
                $update->bindParam(":stock", $nuevoStock, PDO::PARAM_INT);
                $update->bindParam(":factualizacion", $fechaUP, PDO::PARAM_STR);
                //actualizar con nuevo stock
                $nReg = $update->execute();

                if ($nReg > 0) {
                    return array(
                        'code' => 'success',
                        'msn' => 'Venta registrada con exito, Stock actual del producto: '.$nuevoStock
                    );

                } else {
                    return array(
                        'code' => 'error',
                        'msn' => 'No se pudo procesar su solicitud'
                    );
                }
            }
            
        }
        catch(Exception $e){
            error_log('Error: '.$e->getMessage());
            return array(
                'code' => 'error',
                'msn' => 'No se pudo procesar su solicitud'
            );
        }
        
    }

}