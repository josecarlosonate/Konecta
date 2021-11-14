<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

class AjaxProductos{

    /*=============================================
	AGREGAR PRODUCTO
	=============================================*/

	public $datosProducto;	
    public $datosProductoEdit;

	public function ajaxGuardarProductos(){

		$datos = $this->datosProducto;

		$respuesta = ControladorProductos::ctrGuardarProducto($datos);

		echo ($respuesta);

	}

    /*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/
    
	public function ajaxConsultarProductos(){

		$respuesta = ControladorProductos::ctrMostrarproductos();

		echo json_encode($respuesta);
	}

}

if(isset($_POST["accion"])){

    // consultar productos 
	if($_POST["accion"] == 'consultar'){
		$productos = new AjaxProductos();
		$productos->ajaxConsultarProductos();
	}

    // nuevo producto
	if($_POST["accion"] == 'nuevo'){
        $producto = new AjaxProductos();
		$productoData = json_decode($_POST['producto'],true);

        // validar con expresion regular nombre 
        if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $productoData['nombre']) ){
            $producto->datosProducto = $productoData;

			$producto->ajaxGuardarProductos();
        }else{
            echo "error";
        }
    }
}