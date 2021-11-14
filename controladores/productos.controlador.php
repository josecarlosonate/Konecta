<?php

class ControladorProductos{

    /*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/

	static public function ctrMostrarproductos(){

		$tabla = "productos";
		$tablaCateg = "categorias";

		return ModeloProductos::mdlMostrarProductos($tabla,$tablaCateg);

	}

    /*=============================================
	GUARDAR PRODUCTO
	=============================================*/

	static public function ctrGuardarProducto($datos){

		$tabla = "productos";
        
		return ModeloProductos::mdlGuardarProducto($tabla,$datos);
		

	}

}

?>