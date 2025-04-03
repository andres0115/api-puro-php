<?php
class TipoMaterial {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    public function obtenerTiposMaterial() {
        $this->db->query('SELECT * FROM tipo_materiales ORDER BY nombre_tipo_material ASC');
        return $this->db->registros();
    }

    public function obtenerTipoMaterialPorId($id) {
        $this->db->query('SELECT * FROM tipo_materiales WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    public function agregarTipoMaterial($datos) {
        $this->db->query('INSERT INTO tipo_materiales (nombre_tipo_material, fecha_creacion) 
                          VALUES (:nombre_tipo_material, NOW())');
        
        $this->db->bind(':nombre_tipo_material', $datos['nombre_tipo_material']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarTipoMaterial($datos) {
        $this->db->query('UPDATE tipo_materiales SET 
                          nombre_tipo_material = :nombre_tipo_material, 
                          fecha_modificacion = NOW() 
                          WHERE id = :id');
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':nombre_tipo_material', $datos['nombre_tipo_material']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarTipoMaterial($id) {
        // Verificar si el tipo de material está siendo utilizado en la tabla materiales
        $this->db->query('SELECT COUNT(*) as total FROM materiales WHERE tipo_material = :id');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registro();
        
        if(isset($resultado->total) && $resultado->total > 0) {
            return false; // No se puede eliminar un tipo que está siendo utilizado
        }
        
        $this->db->query('DELETE FROM tipo_materiales WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function buscarTiposMaterialPorNombre($nombre) {
        $this->db->query('SELECT * FROM tipo_materiales WHERE nombre_tipo_material LIKE :nombre ORDER BY nombre_tipo_material ASC');
        $this->db->bind(':nombre', '%' . $nombre . '%');
        return $this->db->registros();
    }
} 