<?php
require_once('conexion.php');

class Producto
{
    public $id;
    public $nombre;
    public $referencia;
    public $precio;
    public $peso;
    public $categoria;
    public $stock;
    public $fecha_creacion;

    public function listarProductos()
    {
        $query = "SELECT * FROM producto";
        global $cnx;
        $res = $cnx->query($query);
        $res = $res->fetchAll(PDO::FETCH_NAMED);
        return $res;
    }

    public function obtenerProducto($id)
    {
        $query = "SELECT * FROM producto WHERE id = '$id'";
        global $cnx;
        $res = $cnx->query($query);
        $res = $res->fetchAll(PDO::FETCH_NAMED);
        return $res;
    }

    public function insertarProducto($producto)
    {
        $query = "INSERT INTO producto(nombre, referencia, precio, peso, categoria, stock, fecha_creacion)
                    VALUES(:nombre, :referencia, :precio, :peso, :categoria, :stock, :fecha_creacion)";
        $parametros = array(
            ':nombre' => $producto['nombre'],
            ':referencia' => $producto['referencia'],
            ':precio' => $producto['precio'],
            ':peso' => $producto['peso'],
            ':categoria' => $producto['categoria'],
            ':stock' => $producto['stock'],
            ':fecha_creacion' => $producto['fecha_creacion'],
        );
        global $cnx;
        $pre = $cnx->prepare($query);
        $pre->execute($parametros);
        $pre = $pre->fetchAll(PDO::FETCH_NAMED);
    }

    public function editarProducto($producto)
    {
        try {
            $query = "UPDATE producto SET 
                nombre = :nombre,
                referencia = :referencia, 
                precio = :precio, 
                peso = :peso, 
                categoria = :categoria, 
                stock = :stock,
                fecha_creacion = :fecha_creacion
                WHERE id = :id";
            $parametros = array(
                ':id' => $producto['id'],
                ':nombre' => $producto['nombre'],
                ':referencia' => $producto['referencia'],
                ':precio' => $producto['precio'],
                ':peso' => $producto['peso'],
                ':categoria' => $producto['categoria'],
                ':stock' => $producto['stock'],
                ':fecha_creacion' => $producto['fecha_creacion'],
            );
            global $cnx;
            $pre = $cnx->prepare($query);
            $pre->execute($parametros);
            $pre = $pre->fetchAll(PDO::FETCH_NAMED);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function eliminarProducto($id)
    {
        $query = "DELETE FROM producto WHERE id = :id";
        $parametros = array(
            ':id' => $id
        );
        global $cnx;
        $pre = $cnx->prepare($query);
        $pre->execute($parametros);
        $pre = $pre->fetchAll(PDO::FETCH_NAMED);
    }
}
