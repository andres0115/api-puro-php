<?php
class Movimiento {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    public function obtenerMovimientos() {
        $this->db->query('SELECT m.*, u.nombre_usuario 
                         FROM movimientos m 
                         LEFT JOIN usuarios u ON m.usuario_movimiento = u.id
                         ORDER BY m.fecha_creacion DESC');
        return $this->db->registros();
    }

    public function obtenerMovimientoPorId($id) {
        $this->db->query('SELECT m.*, u.nombre_usuario 
                         FROM movimientos m 
                         LEFT JOIN usuarios u ON m.usuario_movimiento = u.id 
                         WHERE m.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    public function agregarMovimiento($datos) {
        $this->db->query('INSERT INTO movimientos (usuario_movimiento, tipo_movimiento, fecha_creacion) 
                          VALUES (:usuario_movimiento, :tipo_movimiento, NOW())');
        
        $this->db->bind(':usuario_movimiento', $datos['usuario_movimiento']);
        $this->db->bind(':tipo_movimiento', $datos['tipo_movimiento']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarMovimiento($datos) {
        $this->db->query('UPDATE movimientos SET 
                          usuario_movimiento = :usuario_movimiento,
                          tipo_movimiento = :tipo_movimiento,
                          fecha_modificacion = NOW()
                          WHERE id = :id');
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':usuario_movimiento', $datos['usuario_movimiento']);
        $this->db->bind(':tipo_movimiento', $datos['tipo_movimiento']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarMovimiento($id) {
        $this->db->query('DELETE FROM movimientos WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerMovimientosPorUsuario($usuario_id) {
        $this->db->query('SELECT m.*, u.nombre_usuario 
                         FROM movimientos m 
                         LEFT JOIN usuarios u ON m.usuario_movimiento = u.id 
                         WHERE m.usuario_movimiento = :usuario_id
                         ORDER BY m.fecha_creacion DESC');
        $this->db->bind(':usuario_id', $usuario_id);
        return $this->db->registros();
    }

    public function obtenerMovimientosPorTipo($tipo_movimiento) {
        $this->db->query('SELECT m.*, u.nombre_usuario 
                         FROM movimientos m 
                         LEFT JOIN usuarios u ON m.usuario_movimiento = u.id 
                         WHERE m.tipo_movimiento = :tipo_movimiento
                         ORDER BY m.fecha_creacion DESC');
        $this->db->bind(':tipo_movimiento', $tipo_movimiento);
        return $this->db->registros();
    }

    public function obtenerMovimientosPorFecha($fecha_inicio, $fecha_fin) {
        $this->db->query('SELECT m.*, u.nombre_usuario 
                         FROM movimientos m 
                         LEFT JOIN usuarios u ON m.usuario_movimiento = u.id 
                         WHERE m.fecha_creacion BETWEEN :fecha_inicio AND :fecha_fin
                         ORDER BY m.fecha_creacion DESC');
        $this->db->bind(':fecha_inicio', $fecha_inicio);
        $this->db->bind(':fecha_fin', $fecha_fin);
        return $this->db->registros();
    }
} 