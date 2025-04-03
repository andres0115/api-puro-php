<?php
class Permiso {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    public function obtenerPermisos() {
        $this->db->query('SELECT * FROM permisos ORDER BY nombre ASC');
        return $this->db->registros();
    }

    public function obtenerPermisoPorId($id) {
        $this->db->query('SELECT * FROM permisos WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    public function agregarPermiso($datos) {
        $this->db->query('INSERT INTO permisos (nombre, tipo_permiso, codigo_nombre) 
                          VALUES (:nombre, :tipo_permiso, :codigo_nombre)');
        
        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':tipo_permiso', $datos['tipo_permiso']);
        $this->db->bind(':codigo_nombre', $datos['codigo_nombre']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarPermiso($datos) {
        $this->db->query('UPDATE permisos SET 
                          nombre = :nombre, 
                          tipo_permiso = :tipo_permiso, 
                          codigo_nombre = :codigo_nombre 
                          WHERE id = :id');
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':tipo_permiso', $datos['tipo_permiso']);
        $this->db->bind(':codigo_nombre', $datos['codigo_nombre']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarPermiso($id) {
        // Verificar si el permiso está siendo utilizado (ejemplo)
        $this->db->query('SELECT COUNT(*) as total FROM roles_permisos WHERE permiso_id = :id');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registro();
        
        if(isset($resultado->total) && $resultado->total > 0) {
            return false; // No se puede eliminar un permiso en uso
        }
        
        $this->db->query('DELETE FROM permisos WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function buscarPermisosPorNombre($nombre) {
        $this->db->query('SELECT * FROM permisos WHERE nombre LIKE :nombre ORDER BY nombre ASC');
        $this->db->bind(':nombre', '%' . $nombre . '%');
        return $this->db->registros();
    }

    public function obtenerPermisosPorTipo($tipo_permiso) {
        $this->db->query('SELECT * FROM permisos WHERE tipo_permiso = :tipo_permiso ORDER BY nombre ASC');
        $this->db->bind(':tipo_permiso', $tipo_permiso);
        return $this->db->registros();
    }

    public function obtenerPermisoPorCodigo($codigo_nombre) {
        $this->db->query('SELECT * FROM permisos WHERE codigo_nombre = :codigo_nombre');
        $this->db->bind(':codigo_nombre', $codigo_nombre);
        return $this->db->registro();
    }
} 