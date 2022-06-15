<?php
require_once('../classes/Producto.php');

$objProducto = new Producto();

$lstProductos = $objProducto->listarProductos();

?>

<div class="col-12 mt-3">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-shopping-cart"></i> VENTAS</h3>
        </div>
        <div class="card-body">
            <form id="frmVenta" name="frmVenta" submit="return false">
                <input type="hidden" name="accion" id="accion" value="CREAR_VENTA">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nombre de cliente</label>
                            <input type="text" class="form-control validar" name="cliente" id="cliente" data-validar="Nombre de cliente">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Producto</label>
                            <select name="producto_id" id="producto_id" class="form-control validar" data-validar="Producto">
                                <option value="">Selecciona Producto</option>
                                <?php
                                foreach ($lstProductos as $key => $value) { ?>
                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['nombre'] . ' | cant: ' . $value['stock'] . ' | S/. ' . $value['precio'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cantidad</label>
                            <input type="number" class="form-control validar" name="cantidad" id="cantidad" data-validar="Cantidad">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <button type="button" id="btnGuardar" class="btn btn-primary" onclick="Guardar()">Realizar venta</button>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <div>
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <th>Cliente</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                    </thead>
                                    <tbody id="div_ventas">
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
        ListarVentas();
    });

    function ListarVentas() {
        $.ajax({
            method: "POST",
            url: "app/controller/controller.php",
            data: {
                "accion": "LISTAR_VENTAS",
            }
        }).done(function(resultado) {
            json = JSON.parse(resultado);
            ventas = json.ventas;
            listado = '';
            for (i = 0; i < ventas.length; i++) {
                listado = listado + '<tr><td>' + ventas[i].cliente +
                    '</td><td>' + ventas[i].producto +
                    '</td><td>' + ventas[i].cantidad +
                    '</td></tr>';
            }
            $('#div_ventas').html(listado);
        })
    }

    function ComboProductos() {
        $.ajax({
            method: "POST",
            url: "app/controller/controller.php",
            data: {
                "accion": "LISTAR_PRODUCTOS",
            }
        }).done(function(resultado) {
            json = JSON.parse(resultado);
            productos = json.productos;
            listado = '<option value="null">Selecciona Producto</option>';
            for (i = 0; i < productos.length; i++) {
                listado = listado + '<option value="' + productos[i].id + '">' + productos[i].nombre + ' | cant: ' + productos[i].stock + ' | S/. ' + productos[i].precio + '</option>';
                $('#producto_id').html(listado);
            }
        });
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
            var datax = $('#frmVenta').serializeArray();
            $.ajax({
                method: "POST",
                url: "app/controller/controller.php",
                data: datax
            }).done(function(resultado) {
                alert(resultado);
                $("#frmVenta")[0].reset();
                ListarVentas();
                ComboProductos();
            })
        }
    }
</script>