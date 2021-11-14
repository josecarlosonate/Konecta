<?php

require_once "conexion.php";

class ModeloCategorias{
    /*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

    static public function mdlMostrarCategorias($tabla){
        $db = new Conexion();
        $stmt = $db->pdo->prepare("SELECT * FROM $tabla ");

        $stmt -> execute();

		return $stmt -> fetchAll();

		$stmt = null;
    }
}

?>