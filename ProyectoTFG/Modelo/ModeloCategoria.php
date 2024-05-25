<?php
include_once 'ModeloBD.php';
include_once '../Clases/Categoria.php';
include_once '../Clases/Torneo.php';
class ModeloCategoria {
    private $modeloBD;

    public function __construct() {
        $this->modeloBD = new ModeloBD();
    }
    //Obtener categoría por id
    public function obtenerCategoriaPorId($idCategoria) {
        $sql = "SELECT * FROM categorias WHERE idCategoria = '$idCategoria'";
        $this->modeloBD->open_connection();
        if ($this->modeloBD->get_results_from_query($sql)) {
            $rows = $this->modeloBD->get_rows();
            if (count($rows) === 1) {
                $datos = $rows[0];
                $categoria = new Categoria(
                    $datos['idCategoria'],
                    $datos['idtorneo'],
                    $datos['sexo'],
                    $datos['peso'],
                    $datos['edad'],
                    $datos['modalidad'],
                    $datos['estado']
                );
                return $categoria;
            }
        }
        return null;
    }
    
    //Obtener categoría por por los detalles de la categoría
    public function obtenerCategoriaPorDetalles($idTorneo, $sexo, $peso, $edad, $modalidad) {
    $sql = "SELECT * FROM categorias WHERE idtorneo = '$idTorneo' AND sexo = '$sexo' AND peso = '$peso' AND edad = '$edad' AND modalidad = '$modalidad'";
    $this->modeloBD->open_connection();
    if ($this->modeloBD->get_results_from_query($sql)) {
        $rows = $this->modeloBD->get_rows();
        if (count($rows) > 0) {
            $datos = $rows[0];
            $categoria = new Categoria($datos['idCategoria'], $datos['idtorneo'], $datos['sexo'], $datos['peso'], $datos['edad'], $datos['modalidad'], $datos['estado']);
            return $categoria;
        }
    }
    return null;
}
    
    //Obtener categorias por torneo
    public function obtenerCategoriasPorTorneo($idTorneo) {
        $sql = "SELECT * FROM categorias WHERE idtorneo = '$idTorneo'";
        $this->modeloBD->open_connection();
        $listaCategorias = array();  
        if ($this->modeloBD->get_results_from_query($sql)) {
            $rows = $this->modeloBD->get_rows();
            foreach ($rows as $row) {
                $listaCategorias[] = new Categoria(
                    $row['idCategoria'],
                    $row['idtorneo'],
                    $row['sexo'],
                    $row['peso'],
                    $row['edad'],
                    $row['modalidad'],
                    $row['estado']
                );
            }
        }

        return $listaCategorias;
    }
    //Obtener todasd las categorías
    public function obtenerCategorias() {
        $sql = "SELECT * FROM categorias";
        $this->modeloBD->open_connection();
        $listaCategorias = array();
        if ($this->modeloBD->get_results_from_query($sql)) {
            $rows = $this->modeloBD->get_rows();
            foreach ($rows as $row) {
                $listaCategorias[] = new Categoria(
                    $row['idCategoria'],
                    $row['idtorneo'],
                    $row['sexo'],
                    $row['peso'],
                    $row['edad'],
                    $row['modalidad'],
                    $row['estado']
                );
            }
        }
        return $listaCategorias;
    }

    //Obtener categorías que tengan enfrentamientos de un torneo
    public function obtenerCategoriasPorTorneoConEnfrentamientos($idTorneo) {
        $sql = "SELECT DISTINCT c.* FROM categorias c INNER JOIN enfrentamiento r ON c.idtorneo = r.idtorneo AND c.sexo = r.sexo AND c.peso = r.peso AND c.edad = r.edad AND c.modalidad = r.modalidad WHERE c.idtorneo = '$idTorneo'";
        $this->modeloBD->open_connection();
        $listaCategorias = array();  
        if ($this->modeloBD->get_results_from_query($sql)) {
            $rows = $this->modeloBD->get_rows();
            foreach ($rows as $row) {
                $listaCategorias[] = new Categoria(
                    $row['idCategoria'],
                    $row['idtorneo'],
                    $row['sexo'],
                    $row['peso'],
                    $row['edad'],
                    $row['modalidad'],
                    $row['estado']
                );
            }
        }
        return $listaCategorias;
    }

    
    //Insertar categorías
    public function insertarCategoria(Categoria $categoria) {
        $sql = "INSERT INTO categorias (idtorneo, sexo, peso, edad, modalidad, estado) VALUES (" .
               "'" . $categoria->idtorneo . "', " .
               "'" . $categoria->sexo . "', " .
               $categoria->peso . ", " .
               "'" . $categoria->edad . "', " .
               "'" . $categoria->modalidad . "', " .
               $categoria->estado . ")";

        try {
            $this->modeloBD->execute_single_query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    //Modificar categoría
    public function modificarCategoria(Categoria $categoria) {
        $sql = "UPDATE categorias SET " .
               "idtorneo = '" . $categoria->idtorneo . "', " .
               "sexo = '" . $categoria->sexo . "', " .
               "peso = " . $categoria->peso . ", " .
               "edad = '" . $categoria->edad . "', " .
               "modalidad = '" . $categoria->modalidad . "', " .
               "estado = " . $categoria->estado .
               " WHERE idCategoria = '" . $categoria->idCategoria . "'";

        try {
            $this->modeloBD->execute_single_query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    //Eliminar categoría
    public function eliminarCategoria(Categoria $categoria) {
        $idCategoria=$categoria->getIdCategoria();
        $sql = "DELETE FROM categorias WHERE idCategoria = '$idCategoria'";
        try {
            $this->modeloBD->execute_single_query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    //Eliminar todas las categorías de un torneo 
    public function eliminarCategoriasPorTorneo(Torneo $torneo) {
        $idTorneo=$torneo->getIdtorneo();
        $sql = "DELETE FROM categorias WHERE idtorneo = '$idTorneo'";
        try {
            $this->modeloBD->execute_single_query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
