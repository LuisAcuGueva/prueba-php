<div class="col-12 mt-3">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-box"></i> PRODUCTOS</h3>
        </div>
        <div class="card-body">
            <form id="frmProducto" name="frmProducto" submit="return false">
                <input type="hidden" name="accion" id="accion" value="CREAR_PRODUCTO">
                <input type="hidden" name="id" id="id">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nombre de producto</label>
                            <input type="text" class="form-control validar" name="nombre" id="nombre" data-validar="Nombre de producto">
                            <label>Referencia</label>
                            <input type="text" class="form-control validar" name="referencia" id="referencia" data-validar="Referencia">
                            <label>Fecha de creación</label>
                            <input type="date" class="form-control validar" name="fecha_creacion" id="fecha_creacion" data-validar="Fecha de creación">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Precio</label>
                            <input type="number" class="form-control validar" name="precio" id="precio" data-validar="Precio">
                            <label>Peso</label>
                            <input type="number" class="form-control validar" name="peso" id="peso" data-validar="Peso">
                        </div>
                        <div class="mt-4">
                            <button type="button" id="btnGuardar" class="btn btn-primary" onclick="Guardar()">Agregar</button>
                            <button type="button" class="btn btn-danger" onclick="Cancelar()">Cancelar</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Categoría</label>
                            <input type="text" class="form-control validar" name="categoria" id="categoria" data-validar="Categoría">
                            <label>Stock</label>
                            <input type="number" class="form-control validar" name="stock" id="stock" data-validar="Stock">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <div>
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <th>Nombre</th>
                                        <th>Referencia</th>
                                        <th>Precio</th>
                                        <th>Peso</th>
                                        <th>Categoría</th>
                                        <th>Stock</th>
                                        <th>Fecha de creación</th>
                                        <th>Editar</th>
                                        <th>Eliminar</th>
                                    </thead>
                                    <tbody id="div_productos">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        ListarProductos();
    });

    function ListarProductos() {
        $.ajax({
            method: "POST",
            url: "app/controller/controller.php",
            data: {
                "accion": "LISTAR_PRODUCTOS",
            }
        }).done(function(resultado) {
            json = JSON.parse(resultado);
            productos = json.productos;
            listado = '';
            for (i = 0; i < productos.length; i++) {
                listado = listado + '<tr><td>' + productos[i].nombre +
                    '</td><td>' + productos[i].referencia +
                    '</td><td>' + productos[i].precio +
                    '</td><td>' + productos[i].peso +
                    '</td><td>' + productos[i].categoria +
                    '</td><td>' + productos[i].stock +
                    '</td><td>' + productos[i].fecha_creacion +
                    '</td><td><button type="button" class="btn btn-success btn-sm" onclick="ObtenerProducto(' + productos[i].id + ')"> <i class="fas fa-pen"> </i> </button></td>' +
                    '</td><td><button type="button" class="btn btn-danger btn-sm" onclick="EliminarProducto(' + productos[i].id + ')"> <i class="fas fa-trash"> </i> </button></td>' +
                    '</tr>';
            }
            $('#div_productos').html(listado);
        })
    }

    function ObtenerProducto(id) {
        $.ajax({
            method: "POST",
            url: "app/controller/controller.php",
            data: {
                "accion": "OBTENER_PRODUCTO",
                "id": id
            }
        }).done(function(resultado) {
            let producto = (JSON.parse(resultado))[0];
            $("#id").val(producto.id);
            $("#categoria").val(producto.categoria);
            $("#fecha_creacion").val(producto.fecha_creacion);
            $("#nombre").val(producto.nombre);
            $("#peso").val(producto.peso);
            $("#precio").val(producto.precio);
            $("#referencia").val(producto.referencia);
            $("#stock").val(producto.stock);
            $("#accion").val('EDITAR_PRODUCTO');
            $("#btnGuardar").html("Editar");
        })
    }

    function EliminarProducto(id) {
        if (confirm("¿Estás seguro de eliminar el producto?")) {
            $.ajax({
                method: "POST",
                url: "app/controller/controller.php",
                data: {
                    "accion": "ELIMINAR_PRODUCTO",
                    "id": id
                }
            }).done(function(resultado) {
                alert(resultado);
                ListarProductos();
            });
        } else {
            return false;
        }
    }

    function Cancelar() {
        $("#id").val('');
        $("#btnGuardar").html("Guardar");
        $("#accion").val('CREAR_PRODUCTO');
        $("#frmProducto")[0].reset();
    }

    function Guardar() {
        let alert_txt = "";
        $('.validar').each(function() {
            if ($(this).val() == '') {
                alert_txt += 'El campo ' + $(this).data('validar') + ' es obligatorio \n';
            }
        });
        if (alert_txt != '') {
            alert(alert_txt)
            return false;
        } else {
            var datax = $('#frmProducto').serializeArray();
            $.ajax({
                method: "POST",
                url: "app/controller/controller.php",
                data: datax
            }).done(function(resultado) {
                alert(resultado);
                ListarProductos();
                Cancelar();
            })
        }
    }
</script>