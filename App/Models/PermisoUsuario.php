<?php
class PermisoUsuario {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    public function obtenerPermisosUsuarios() {
        $this->db->query('SELECT pu.*, u.nombre_usuario, p.nombre as nombre_permiso 
                          FROM permisos_usuario pu
                          LEFT JOIN usuarios u ON pu.usuario_id = u.id
                          LEFT JOIN permisos p ON pu.permiso_id = p.id
                          ORDER BY u.nombre_usuario ASC');
        return $this->db->registros();
    }

    public function obtenerPermisoUsuarioPorId($id) {
        $this->db->query('SELECT pu.*, u.nombre_usuario, p.nombre as nombre_permiso 
                          FROM permisos_usuario pu
                          LEFT JOIN usuarios u ON pu.usuario_id = u.id
                          LEFT JOIN permisos p ON pu.permiso_id = p.id
                          WHERE pu.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    public function obtenerPermisosPorUsuario($usuario_id) {
        $this->db->query('SELECT pu.*, p.nombre as nombre_permiso, p.tipo_permiso, p.codigo_nombre
                          FROM permisos_usuario pu
                          LEFT JOIN permisos p ON pu.permiso_id = p.id
                          WHERE pu.usuario_id = :usuario_id
                          ORDER BY p.nombre ASC');
        $this->db->bind(':usuario_id', $usuario_id);
        return $this->db->registros();
    }

    public function obtenerUsuariosPorPermiso($permiso_id) {
        $this->db->query('SELECT pu.*, u.nombre_usuario, u.nombre, u.apellido
                          FROM permisos_usuario pu
                          LEFT JOIN usuarios u ON pu.usuario_id = u.id
                          WHERE pu.permiso_id = :permiso_id
                          ORDER BY u.nombre_usuario ASC');
        $this->db->bind(':permiso_id', $permiso_id);
        return $this->db->registros();
    }

    public function verificarPermisoUsuario($usuario_id, $permiso_id) {
        $this->db->query('SELECT * FROM permisos_usuario 
                          WHERE usuario_id = :usuario_id AND permiso_id = :permiso_id');
        $this->db->bind(':usuario_id', $usuario_id);
        $this->db->bind(':permiso_id', $permiso_id);
        
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    public function agregarPermisoUsuario($datos) {
        // Verificar si ya existe la asignación
        if($this->verificarPermisoUsuario($datos['usuario_id'], $datos['permiso_id'])) {
            return false; // Ya existe, no se puede duplicar
        }

        $this->db->query('INSERT INTO permisos_usuario (usuario_id, permiso_id) 
                          VALUES (:usuario_id, :permiso_id)');
        
        $this->db->bind(':usuario_id', $datos['usuario_id']);
        $this->db->bind(':permiso_id', $datos['permiso_id']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarPermisoUsuario($id) {
        $this->db->query('DELETE FROM permisos_usuario WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarPermisosPorUsuario($usuario_id) {
        $this->db->query('DELETE FROM permisos_usuario WHERE usuario_id = :usuario_id');
        $this->db->bind(':usuario_id', $usuario_id);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarUsuariosPorPermiso($permiso_id) {
        $this->db->query('DELETE FROM permisos_usuario WHERE permiso_id = :permiso_id');
        $this->db->bind(':permiso_id', $permiso_id);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function asignarPermisosUsuario($usuario_id, $permisos_ids) {
        // Primero eliminamos todos los permisos actuales del usuario
        $this->eliminarPermisosPorUsuario($usuario_id);
        
        // Luego asignamos los nuevos permisos
        $errores = 0;
        foreach($permisos_ids as $permiso_id) {
            $datos = [
                'usuario_id' => $usuario_id,
                'permiso_id' => $permiso_id
            ];
            
            if(!$this->agregarPermisoUsuario($datos)) {
                $errores++;
            }
        }
        
        return $errores === 0;
    }
} 