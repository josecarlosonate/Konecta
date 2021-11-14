// $("i.fa.fa-trash").click(function () {

// });
// mensajes español
$(document).ready(function() {
    jQuery.extend(jQuery.validator.messages, {
        required: "Este campo es obligatorio.",
        number: "Por favor, escribe un número entero válido.",
        maxlength: jQuery.validator.format(
            "Por favor, no escribas más de {0} caracteres."
        ),
        minlength: jQuery.validator.format(
            "Por favor, no escribas menos de {0} caracteres."
        ),
    });
});
// validar formulario
$("#formularioRegistro").validate({
    rules: {
        nombre: {
            required: true,
            minlength: 4,
        },
        ref: {
            required: true
        },
        precio: {
            required: true,
            number: true,
            minlength: 3
        },
        peso: {
            required: true,
            number: true
        },
        sltCat: {
            required: true
        },
        stock: {
            required: true,
            number: true
        }
    }
});

// guardar datos del producto
$("#btnGuardar").click(function() {
    if ($("#formularioRegistro").valid() == false) {
        return;
    }

    let nombre = $("#nombre").val();
    let referencia = $("#ref").val();
    let precio = $("#precio").val();
    let peso = $("#peso").val();
    let sltCat = $("#sltCat").val();
    let stock = $("#stock").val();


    // objeto de datos
    let objDatos = {
        nombre: nombre,
        referencia: referencia,
        precio: precio,
        peso: peso,
        id_categoria: Number(sltCat),
        stock: stock,
        estado: 1
    };

    let accion = "nuevo";

    enviarAjax(JSON.stringify(objDatos), accion);
});

function enviarAjax(datos, accion) {
    $.ajax({
        async: true,
        url: "ajax/productos.ajax.php",
        type: "POST",
        data: {
            accion: accion,
            producto: datos,
        },
        beforeSend: function() {
            $("#btnGuardar").val("Espere...");
            $("#btnGuardar").prop("disabled", true);
        },
        success: function(response) {

            console.log(response);
            if (response == "ok") {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'El producto ha sido guardado',
                    showConfirmButton: false,
                    timer: 1500
                })
                $('#Modal').modal('hide');
                $('#formularioRegistro')[0].reset();
                mostrarProductos();
            }
            if (response == "actualizado") {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Datos del empleado actualizados',
                    showConfirmButton: false,
                    timer: 1500
                })
                $('#ModalEditar').modal('hide');
                $('#formularioEditar')[0].reset();
                mostrarEmpleados();
            }

            if (response == "error") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Algo salió mal!',
                    footer: 'no se pudo realizar la operacion'
                })
            }
        },
        complete: function() {
            //vuelvo a habilitar boton
            $("#btnGuardar").prop("disabled", false);
            $("#btnGuardar").val("Guardar");

        }
    });
}

// traer listado de productos
function mostrarProductos() {
    $('#listadoProductos').empty();
    $.ajax({
        async: true,
        url: "ajax/productos.ajax.php",
        type: "POST",
        data: {
            accion: "consultar",
        },
        beforeSend: function() {
            $('#listadoProductos').html('Cargando registros...');
        },
        success: function(response) {
            $('#listadoProductos').empty();
            let data = JSON.parse(response);

            data.forEach(element => {
                let precio = element.precio;
                precio = new Intl.NumberFormat("de-DE", { maximumFractionDigits: 0 }).format(Number(precio));

                let stock = (element.stock == 0) ? 'Sin stock' : element.stock;
                let tr = document.createElement('tr');
                var date = new Date(Number(element.fcreacion * 1000));
                var dateUp = new Date(Number(element.factualizacion * 1000));

                tr.innerHTML = `
                <th class="text-primary">${element.nombre}</th>
                <th class="text-primary">${element.referencia}</th>
                <th class="text-primary">$ ${precio}</th>
                <th class="text-primary">${element.peso}</th>
                <th class="text-primary">${element.categoria}</th>
                <th class="text-primary">${stock}</th>
                <th class="text-primary">${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()}</th>
                <th class="text-primary">${dateUp.getFullYear()}-${dateUp.getMonth()+1}-${dateUp.getDate()} ${dateUp.getHours()}:${date.getMinutes()}</th>
                <th class="text-primary">
                    <button class="iconoVer btnAccion" title="ver" onclick="traerProducto(${element.id})"><i class="fa fa-eye"></i></button>
                    <button class="iconoEditar btnAccion" title="editar" onclick="editarProducto(${element.id})"><i class="fa fa-edit"></i></button>
                    <button class="iconoBorrar btnAccion" title="eliminar" onclick="eliminarProducto(${element.id})"><i class="fa fa-trash"></i></button>
                </th>
                `;
                $('#listadoProductos').append(tr);
            });

        }
    });
}
mostrarProductos();

// traer producto
function traerProducto(id) {
    console.log(id);
}

// editar producto
function editarProducto(id) {
    console.log(id);
}

// eliminar producto
function eliminarProducto(id) {
    console.log(id);
}