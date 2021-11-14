<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="title" content="prueba konecta">

    <meta name="description" content="realizacion de prueba php konecta">

    <meta name="keyword" content="prueba konecta, php">

    <title>Konecta</title>

    <!--=====================================
	HOJA DE CSS 
	======================================-->

    <link rel="stylesheet" href="vistas/css/plugins/bootstrap4.min.css">
    <link rel="stylesheet" href="vistas/css/estilo.css">


</head>

<body>
    <div class="container">
        <div class="centrar">
            <img src="vistas/img/bienvenido.svg" class="img-fluid" alt="bienvenida">
            <div>
                <h2 class="text-center">Bienvenid@</h2>

            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Listado de productos
                <a class="btn btn-outline-success float-right" data-toggle="modal" data-target="#Modal"><i class="fa fa-plus"></i> Nuevo Producto</a>
            </div>
            <div class="card-body">
                <?php
                $productos = ControladorProductos::ctrMostrarproductos();
                if (!$productos) {
                ?>
                    <p class="text-info">Aun no hay productos registrados</p>
                <?php
                } else {
                ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">&nbsp;Nombre</th>
                                    <th scope="col"> &nbsp;Referencia</th>
                                    <th scope="col">&nbsp;Precio</th>
                                    <th scope="col">&nbsp;Peso (Kg)</th>
                                    <th scope="col">&nbsp;Categoría</th>
                                    <th scope="col">&nbsp;Stock</th>
                                    <th scope="col">&nbsp;Fecha de creación</th>
                                    <th scope="col">&nbsp;Ultima venta</th>
                                    <th scope="col">&nbsp;Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="listadoProductos">
                            </tbody>
                        </table>
                    </div>
                <?php
                }

                ?>
            </div>
        </div>
    </div>
    <br><br>
    <!-- Modal Producto -->
    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear nuevo producto</h5>
                    <button type="button" id="btnCerrarM" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="formularioRegistro">
                    <div class="modal-body">
                        <h6 class="text-danger">los campos marcados con * son obligatorios</h6>
                        <!-- nombre  -->
                        <div class="mb-2">                            
                            <label for="nombre">Nombre <b class="text-danger"> *</b></label>
                            <input type="text" id="nombre" name="nombre" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <!-- referencia  -->
                        <div class="mb-2">
                            <label for="ref">Referencia <b class="text-danger"> *</b></label>
                            <input type="text" id="ref" class="form-control" name="ref" aria-describedby="basic-addon1">
                        </div>
                        <!-- precio  -->
                        <div class="mb-2">
                            <label for="precio">Precio <b class="text-danger"> *</b></label>
                            <input type="number" min="0" id="precio" class="form-control" name="precio" aria-describedby="basic-addon1">
                        </div>

                        <!-- peso  -->
                        <div class="mb-2">
                            <label for="Peso">Peso en Kilogramos <b class="text-danger"> *</b></label>
                            <input type="number" min="0" id="peso" class="form-control" name="peso" aria-describedby="basic-addon1">
                        </div>

                        <!-- listado de categorias -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Seleccione una categoria <b class="text-danger"> *</b></span>
                            </div>
                            <select class="form-control" id="sltCat" name="sltCat">
                                <?php
                                $categorias = ControladorCategorias::ctrMostrarCategorias();
                                if (!$categorias) {
                                ?>
                                    <option class="text-info" value="">no existen categorias</option>
                                    <?php
                                } else {
                                    foreach ($categorias as $key => $value) {
                                    ?>
                                        <option value="<?php echo $value["id"] ?>"><?php echo $value["nombre"] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        
                        <!-- stock  -->
                        <div class="mb-2">
                            <label for="stock">Stock <b class="text-danger"> *</b></label>
                            <input type="number" min="0" id="stock" class="form-control" name="stock" aria-describedby="basic-addon1">
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <input type="button" id="btnGuardar" value="Guardar" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

        
    <!--=====================================
	PLUGINS DE JAVASCRIPT
	======================================-->

    <script src="https://kit.fontawesome.com/2c9eef3e53.js" crossorigin="anonymous"></script>

    <script src="vistas/js/plugins/jquery-3.5.1.slim.min.js"></script>

    <script src="vistas/js/plugins/bootstrap4.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="vistas/js/plugins/jquery.validate.min.js"></script>

    <!--=====================================
    MI JAVASCRIPT
    ======================================-->

    <script src="vistas/js/main.js"></script>

</body>

</html>