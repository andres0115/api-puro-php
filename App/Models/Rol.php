<?php
class Rol {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    
    public function obtenerRoles() {
        $this->db->query('SELECT * FROM roles');
        return $this->db->registros();
    }

    
    public function obtenerRolPorId($id) {
        $this->db->query('SELECT * FROM roles WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    
    public function agregarRol($datos) {
        $this->db->query('INSERT INTO roles (nombre_rol, descripcion, estado) 
                          VALUES (:nombre_rol, :descripcion, :estado)');
        
        
        $this->db->bind(':nombre_rol', $datos['nombre_rol']);
        $this->db->bind(':descripcion', $datos['descripcion']);
        $this->db->bind(':estado', isset($datos['estado']) ? $datos['estado'] : 1);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function actualizarRol($datos) {
        $this->db->query('UPDATE roles SET 
                          nombre_rol = :nombre_rol, 
                          descripcion = :descripcion,
                          estado = :estado
                          WHERE id = :id');
        
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':nombre_rol', $datos['nombre_rol']);
        $this->db->bind(':descripcion', $datos['descripcion']);
        $this->db->bind(':estado', $datos['estado']);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function eliminarRol($id) {
        
        $this->db->query('SELECT COUNT(*) as total FROM usuarios WHERE rol = :id');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registro();
        
        if($resultado->total > 0) {
            return false; 
        }
        
        $this->db->query('DELETE FROM roles WHERE id = :id');
        $this->db->bind(':id', $id);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function obtenerRolesActivos() {
        $this->db->query('SELECT * FROM roles WHERE estado = 1');
        return $this->db->registros();
    }
} 