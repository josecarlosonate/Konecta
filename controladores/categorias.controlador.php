<?php

class ControladorCategorias{

    /*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function ctrMostrarCategorias(){

		$tabla = "categorias";

		return ModeloCategorias::mdlMostrarCategorias($tabla);

		 

	}
}

?>