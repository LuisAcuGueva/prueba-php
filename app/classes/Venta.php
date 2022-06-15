<?php
require_once('conexion.php');

class Venta
{
    public $id;
    public $cliente;
    public $producto_id;
    public $cantidad;

    public function listarVentas()
    {
        $query = "SELECT venta.cliente, producto.nombre as producto, venta.cantidad 
                    FROM venta
                    INNER JOIN producto ON producto.id = venta.producto_id";
        global $cnx;
        $res = $cnx->query($query);
        $res = $res->fetchAll(PDO::FETCH_NAMED);
        return $res;
    }

    public function insertarVenta($venta)
    {
        $objProducto = new Producto();
        $producto = $objProducto->obtenerProducto($venta['producto_id']);
        $producto = $producto[0];
        if ($producto['stock'] >= $venta['cantidad']) {
            $query_venta = "INSERT INTO venta(cliente, producto_id, cantidad)
                    VALUES(:cliente, :producto_id, :cantidad)";
            $parametros_venta = array(
                ':cliente' => $venta['cliente'],
                ':producto_id' => $venta['producto_id'],
                ':cantidad' => $venta['cantidad'],
            );
            global $cnx;
            $pre_venta = $cnx->prepare($query_venta);
            $pre_venta->execute($parametros_venta);
            $pre_venta = $pre_venta->fetchAll(PDO::FETCH_NAMED);

            $new_stock = $producto['stock'] - $venta['cantidad'];
            $query_prod = "UPDATE producto SET stock = :stock WHERE id = :id";
            $parametros_prod = array(
                ':stock' => $new_stock,
                ':id' => $venta['producto_id']
            );
            $pre_prod = $cnx->prepare($query_prod);
            $pre_prod->execute($parametros_prod);
            $pre_prod = $pre_prod->fetchAll(PDO::FETCH_NAMED);
            return "Venta realizada con éxito";
        } else if ($producto['stock'] == 0) {
            return "El producto cuenta con stock 0, no se puedo realizar la venta";
        } else {
            return "Insuficiente stock para realizar la venta";
        }
    }
}
