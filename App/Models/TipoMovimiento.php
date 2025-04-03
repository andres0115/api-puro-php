<?php
class TipoMovimiento {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    public function obtenerTiposMovimiento() {
        $this->db->query('SELECT * FROM tipos_movimiento ORDER BY tipo_movimiento ASC');
        return $this->db->registros();
    }

    public function obtenerTipoMovimientoPorId($id) {
        $this->db->query('SELECT * FROM tipos_movimiento WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    public function agregarTipoMovimiento($datos) {
        $this->db->query('INSERT INTO tipos_movimiento (tipo_movimiento, fecha_creacion) 
                          VALUES (:tipo_movimiento, NOW())');
        
        $this->db->bind(':tipo_movimiento', $datos['tipo_movimiento']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarTipoMovimiento($datos) {
        $this->db->query('UPDATE tipos_movimiento SET 
                          tipo_movimiento = :tipo_movimiento, 
                          fecha_modificacion = NOW() 
                          WHERE id = :id');
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':tipo_movimiento', $datos['tipo_movimiento']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarTipoMovimiento($id) {
        // Verificar si el tipo de movimiento está siendo utilizado en la tabla movimientos
        $this->db->query('SELECT COUNT(*) as total FROM movimientos WHERE tipo_movimiento = :id');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registro();
        
        if(isset($resultado->total) && $resultado->total > 0) {
            return false; // No se puede eliminar un tipo que está siendo utilizado
        }
        
        $this->db->query('DELETE FROM tipos_movimiento WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function buscarTiposMovimientoPorNombre($nombre) {
        $this->db->query('SELECT * FROM tipos_movimiento WHERE tipo_movimiento LIKE :nombre ORDER BY tipo_movimiento ASC');
        $this->db->bind(':nombre', '%' . $nombre . '%');
        return $this->db->registros();
    }
} 