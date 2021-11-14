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
        success: function(response) {
            let data = JSON.parse(response);

            data.forEach(element => {
                let precio = element.precio;
                precio = new Intl.NumberFormat("de-DE", { maximumFractionDigits: 0 }).format(Number(precio));

                let stock = (element.stock == 0) ? 'Sin stock' : element.stock;
                let tr = document.createElement('tr');

                tr.innerHTML = `
                <th class="text-primary">${element.nombre}</th>
                <th class="text-primary">${element.referencia}</th>
                <th class="text-primary">$ ${precio}</th>
                <th class="text-primary">${element.peso}</th>
                <th class="text-primary">${element.categoria}</th>
                <th class="text-primary">${stock}</th>
                <th class="text-primary">${element.fcreacion}</th>
                <th class="text-primary">${element.factualizacion}</th>
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
                    title: 'Datos del Producto actualizados',
                    showConfirmButton: false,
                    timer: 1500
                })
                $('#ModalEditar').modal('hide');
                $('#formularioEditar')[0].reset();
                mostrarProductos();
            }

            if (response == "error") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Algo salió mal!',
                    footer: 'no se pudo realizar la operacion'
                })
            }
        }
    });
}

// traer producto
function traerProducto(id) {
    // traigo los datos del producto
    $.ajax({
        async: true,
        url: "ajax/productos.ajax.php",
        type: "POST",
        data: {
            accion: "traer",
            id: id
        },
        success: function(response) {
            let data = JSON.parse(response);
            console.log(data[0]);

            $('#ModalVer').modal('show');
            let precio = data[0]['precio'];
            precio = new Intl.NumberFormat("de-DE", { maximumFractionDigits: 0 }).format(Number(precio));

            $('#verNombre').val(data[0]['nombre']);
            $('#verRef').val(data[0]['referencia']);
            $('#verPrecio').val('$' + precio);
            $('#verPeso').val(data[0]['peso'] + ' Kg');
            $('#verCat').val(data[0]['categoria']);
            $('#verStock').val(data[0]['stock']);
            $('#fechaCreacion').val(data[0]['fcreacion']);
            $('#fechaUp').val(data[0]['factualizacion']);


        }
    });
}

// editar producto
function editarProducto(id) {
    console.log(id);
}

// eliminar producto
function eliminarProducto(id) {
    Swal.fire({
        title: "Estas segur@?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "¡Sí, bórralo!",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            // eliminando 
            $.ajax({
                async: true,
                url: "ajax/productos.ajax.php",
                type: "POST",
                data: {
                    accion: "eliminar",
                    id: id
                },
                success: function(response) {
                    console.log("delete:" + response);
                    if (response == 'ok') {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'El producto ha sido eliminado',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        mostrarProductos();
                    }
                    if (response == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '¡Algo salió mal!',
                            footer: 'no se pudo realizar la operacion'
                        });
                    }
                }
            });
        }
    });
}