<?php

require_once "controladores/inicio.controlador.php";

require_once "controladores/productos.controlador.php";
require_once "controladores/categorias.controlador.php";

require_once "modelos/productos.modelo.php";
require_once "modelos/categorias.modelo.php";


$inicio = new ControladorInicio();

$inicio->inicio();

?>