<?php
class Administrador {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    
    public function obtenerRegistros() {
        $this->db->query('SELECT a.*, u.nombre_usuario 
                         FROM administrador a 
                         LEFT JOIN usuarios u ON a.usuario_id = u.id
                         ORDER BY a.fecha_accion DESC');
        return $this->db->registros();
    }

    
    public function obtenerRegistroPorId($id) {
        $this->db->query('SELECT a.*, u.nombre_usuario 
                         FROM administrador a 
                         LEFT JOIN usuarios u ON a.usuario_id = u.id 
                         WHERE a.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    
    public function obtenerRegistrosPorUsuario($usuario_id) {
        $this->db->query('SELECT * FROM administrador WHERE usuario_id = :usuario_id ORDER BY fecha_accion DESC');
        $this->db->bind(':usuario_id', $usuario_id);
        return $this->db->registros();
    }

    
    public function registrarAccion($datos) {
        $this->db->query('INSERT INTO administrador (fecha_accion, rutas, descripcion_ruta, bandera_accion, 
                          mensaje_cambio, tipo_permiso, usuario_id) 
                          VALUES (NOW(), :rutas, :descripcion_ruta, :bandera_accion, 
                          :mensaje_cambio, :tipo_permiso, :usuario_id)');
        
        
        $this->db->bind(':rutas', $datos['rutas']);
        $this->db->bind(':descripcion_ruta', $datos['descripcion_ruta']);
        $this->db->bind(':bandera_accion', $datos['bandera_accion']);
        $this->db->bind(':mensaje_cambio', $datos['mensaje_cambio']);
        $this->db->bind(':tipo_permiso', $datos['tipo_permiso']);
        $this->db->bind(':usuario_id', $datos['usuario_id']);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function actualizarRegistro($datos) {
        $this->db->query('UPDATE administrador SET 
                          rutas = :rutas, 
                          descripcion_ruta = :descripcion_ruta,
                          bandera_accion = :bandera_accion,
                          mensaje_cambio = :mensaje_cambio,
                          tipo_permiso = :tipo_permiso
                          WHERE id = :id');
        
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':rutas', $datos['rutas']);
        $this->db->bind(':descripcion_ruta', $datos['descripcion_ruta']);
        $this->db->bind(':bandera_accion', $datos['bandera_accion']);
        $this->db->bind(':mensaje_cambio', $datos['mensaje_cambio']);
        $this->db->bind(':tipo_permiso', $datos['tipo_permiso']);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function eliminarRegistro($id) {
        $this->db->query('DELETE FROM administrador WHERE id = :id');
        $this->db->bind(':id', $id);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function obtenerRegistrosPorTipoPermiso($tipo_permiso) {
        $this->db->query('SELECT a.*, u.nombre_usuario 
                         FROM administrador a 
                         LEFT JOIN usuarios u ON a.usuario_id = u.id 
                         WHERE a.tipo_permiso = :tipo_permiso
                         ORDER BY a.fecha_accion DESC');
        $this->db->bind(':tipo_permiso', $tipo_permiso);
        return $this->db->registros();
    }

    
    public function obtenerRegistrosPorBandera($bandera_accion) {
        $this->db->query('SELECT a.*, u.nombre_usuario 
                         FROM administrador a 
                         LEFT JOIN usuarios u ON a.usuario_id = u.id 
                         WHERE a.bandera_accion = :bandera_accion
                         ORDER BY a.fecha_accion DESC');
        $this->db->bind(':bandera_accion', $bandera_accion);
        return $this->db->registros();
    }
} 