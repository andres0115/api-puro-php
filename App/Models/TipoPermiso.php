<?php
class TipoPermiso {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    public function obtenerTiposPermisos() {
        $this->db->query('SELECT * FROM tipos_permisos ORDER BY permisos ASC');
        return $this->db->registros();
    }

    public function obtenerTipoPermisoPorId($id) {
        $this->db->query('SELECT * FROM tipos_permisos WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    public function agregarTipoPermiso($datos) {
        $this->db->query('INSERT INTO tipos_permisos (permisos) VALUES (:permisos)');
        
        $this->db->bind(':permisos', $datos['permisos']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarTipoPermiso($datos) {
        $this->db->query('UPDATE tipos_permisos SET permisos = :permisos WHERE id = :id');
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':permisos', $datos['permisos']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarTipoPermiso($id) {
        // Verificar si el tipo de permiso está siendo utilizado en la tabla permisos
        $this->db->query('SELECT COUNT(*) as total FROM permisos WHERE tipo_permiso = :id');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registro();
        
        if(isset($resultado->total) && $resultado->total > 0) {
            return false; // No se puede eliminar un tipo que está siendo utilizado
        }
        
        $this->db->query('DELETE FROM tipos_permisos WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function buscarTiposPermisosPorNombre($nombre) {
        $this->db->query('SELECT * FROM tipos_permisos WHERE permisos LIKE :nombre ORDER BY permisos ASC');
        $this->db->bind(':nombre', '%' . $nombre . '%');
        return $this->db->registros();
    }
} 