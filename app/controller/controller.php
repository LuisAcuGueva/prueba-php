<?php

require_once('../classes/Producto.php');
require_once('../classes/Venta.php');

$accion = $_POST['accion'];
operaciones($accion);

function operaciones($accion)
{
    $objProducto = new Producto();
    $objVenta = new Venta();

    switch ($accion) {
        case 'LISTAR_PRODUCTOS':
            try {
                $productos = $objProducto->listarProductos();
                $productos = array(
                    'productos' =>  $productos
                );
                echo json_encode($productos);
            } catch (\Throwable $th) {
                echo "error";
            }
            break;
        case 'OBTENER_PRODUCTO':
            try {
                $producto = $objProducto->obtenerProducto($_POST["id"]);
                echo json_encode($producto);
            } catch (\Throwable $th) {
                echo "error";
            }
            break;
        case 'CREAR_PRODUCTO':
            try {
                $producto = array(
                    'nombre' => $_POST['nombre'],
                    'referencia' => $_POST['referencia'],
                    'precio' => $_POST['precio'],
                    'peso' => $_POST['peso'],
                    'categoria' => $_POST['categoria'],
                    'stock' => $_POST['stock'],
                    'fecha_creacion' => $_POST['fecha_creacion'],
                );
                $objProducto->insertarProducto($producto);
                echo "Producto insertado con éxito";
            } catch (\Throwable $th) {
                echo "error";
            }
            break;
        case 'EDITAR_PRODUCTO':
            try {
                $producto = array(
                    'id' => $_POST['id'],
                    'nombre' => $_POST['nombre'],
                    'referencia' => $_POST['referencia'],
                    'precio' => $_POST['precio'],
                    'peso' => $_POST['peso'],
                    'categoria' => $_POST['categoria'],
                    'stock' => $_POST['stock'],
                    'fecha_creacion' => $_POST['fecha_creacion'],
                );
                $objProducto->editarProducto($producto);
                echo "Producto editado con éxito";
            } catch (\Throwable $th) {
                echo "error";
            }
            break;
        case 'ELIMINAR_PRODUCTO':
            try {
                $objProducto->eliminarProducto($_POST["id"]);
                echo "Producto eliminado con éxito";
            } catch (\Throwable $th) {
                echo "error";
            }
            break;
        case 'LISTAR_VENTAS':
            try {
                $ventas = $objVenta->listarVentas();
                $ventas = array(
                    'ventas' =>  $ventas
                );
                echo json_encode($ventas);
            } catch (\Throwable $th) {
                echo "error";
            }
            break;
        case 'CREAR_VENTA':
            try {
                $venta = array(
                    'cliente' => $_POST['cliente'],
                    'producto_id' => $_POST['producto_id'],
                    'cantidad' => $_POST['cantidad'],
                );
                $venta = $objVenta->insertarVenta($venta);
                echo $venta;
            } catch (\Throwable $th) {
                echo "error";
            }
            break;
        default:
            # code...
            break;
    }
}
