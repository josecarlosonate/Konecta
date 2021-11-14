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

    /*=============================================
	ELIMINAR PRODUCTO
	=============================================*/

	static public function ctrEliminarProductos($id){
		$tabla = "productos";

		return ModeloProductos::mdlEliminarProductos($tabla,$id);
        
		
	}

    /*=============================================
	TRAER DATOS DE PRODUCTO
	=============================================*/

	static public function ctrTraerProducto($id){
		$tabla = "productos";
		$tablaCateg = "categorias";

		return ModeloProductos::mdlTraerProducto($tabla,$id,$tablaCateg);

		
	}

    /*=============================================
	EDITAR PRODUCTO
	=============================================*/

	static public function ctrEditarProducto($id,$datos){
		$tabla = "productos";		

		return ModeloProductos::mdlEditarProducto($tabla,$id,$datos);

		
	}

}

?>