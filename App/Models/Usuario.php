<?php
class Usuario {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    
    public function obtenerUsuarios() {
        $this->db->query('SELECT u.*, r.nombre_rol 
                         FROM usuarios u 
                         LEFT JOIN roles r ON u.rol = r.id');
        return $this->db->registros();
    }

    
    public function obtenerUsuarioPorId($id) {
        $this->db->query('SELECT u.*, r.nombre_rol 
                         FROM usuarios u 
                         LEFT JOIN roles r ON u.rol = r.id 
                         WHERE u.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    
    public function agregarUsuario($datos) {
        $this->db->query('INSERT INTO usuarios (nombre_usuario, contrasena, nombre, apellido, 
                          cedula_persona, edad_persona, telefono_persona, email, rol) 
                          VALUES (:nombre_usuario, :contrasena, :nombre, :apellido, 
                          :cedula_persona, :edad_persona, :telefono_persona, :email, :rol)');
        
        
        $this->db->bind(':nombre_usuario', $datos['nombre_usuario']);
        $this->db->bind(':contrasena', password_hash($datos['contrasena'], PASSWORD_DEFAULT));
        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':apellido', $datos['apellido']);
        $this->db->bind(':cedula_persona', $datos['cedula_persona']);
        $this->db->bind(':edad_persona', $datos['edad_persona']);
        $this->db->bind(':telefono_persona', $datos['telefono_persona']);
        $this->db->bind(':email', $datos['email']);
        $this->db->bind(':rol', $datos['rol']);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function actualizarUsuario($datos) {
        $this->db->query('UPDATE usuarios SET 
                          nombre_usuario = :nombre_usuario, 
                          nombre = :nombre, 
                          apellido = :apellido,
                          cedula_persona = :cedula_persona, 
                          edad_persona = :edad_persona, 
                          telefono_persona = :telefono_persona, 
                          email = :email, 
                          rol = :rol 
                          WHERE id = :id');
        
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':nombre_usuario', $datos['nombre_usuario']);
        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':apellido', $datos['apellido']);
        $this->db->bind(':cedula_persona', $datos['cedula_persona']);
        $this->db->bind(':edad_persona', $datos['edad_persona']);
        $this->db->bind(':telefono_persona', $datos['telefono_persona']);
        $this->db->bind(':email', $datos['email']);
        $this->db->bind(':rol', $datos['rol']);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function actualizarContrasena($id, $contrasena) {
        $this->db->query('UPDATE usuarios SET contrasena = :contrasena WHERE id = :id');
        
        $this->db->bind(':id', $id);
        $this->db->bind(':contrasena', password_hash($contrasena, PASSWORD_DEFAULT));
        
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function eliminarUsuario($id) {
        $this->db->query('DELETE FROM usuarios WHERE id = :id');
        
        
        $this->db->bind(':id', $id);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function login($nombre_usuario, $contrasena) {
        $this->db->query('SELECT * FROM usuarios WHERE nombre_usuario = :nombre_usuario');
        $this->db->bind(':nombre_usuario', $nombre_usuario);

        $fila = $this->db->registro();

        
        if($fila) {
            $hashed_password = $fila->contrasena;
            if(password_verify($contrasena, $hashed_password)) {
                return $fila;
            }
        }
        
        return false;
    }

    
    public function obtenerUsuariosPorRol($rol_id) {
        $this->db->query('SELECT * FROM usuarios WHERE rol = :rol_id');
        $this->db->bind(':rol_id', $rol_id);
        return $this->db->registros();
    }
} 