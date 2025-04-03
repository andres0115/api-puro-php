<?php
class TipoSitio {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    public function obtenerTiposSitio() {
        $this->db->query('SELECT * FROM tipos_sitio ORDER BY nombre_tipo_sitio ASC');
        return $this->db->registros();
    }

    public function obtenerTipoSitioPorId($id) {
        $this->db->query('SELECT * FROM tipos_sitio WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    public function agregarTipoSitio($datos) {
        $this->db->query('INSERT INTO tipos_sitio (nombre_tipo_sitio, fecha_creacion) 
                          VALUES (:nombre_tipo_sitio, NOW())');
        
        $this->db->bind(':nombre_tipo_sitio', $datos['nombre_tipo_sitio']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarTipoSitio($datos) {
        $this->db->query('UPDATE tipos_sitio SET 
                          nombre_tipo_sitio = :nombre_tipo_sitio, 
                          fecha_modificacion = NOW() 
                          WHERE id = :id');
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':nombre_tipo_sitio', $datos['nombre_tipo_sitio']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarTipoSitio($id) {
        // Verificar si el tipo de sitio está siendo utilizado en la tabla sitios
        $this->db->query('SELECT COUNT(*) as total FROM sitios WHERE tipo_sitio = :id');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registro();
        
        if(isset($resultado->total) && $resultado->total > 0) {
            return false; // No se puede eliminar un tipo que está siendo utilizado
        }
        
        $this->db->query('DELETE FROM tipos_sitio WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function buscarTiposSitioPorNombre($nombre) {
        $this->db->query('SELECT * FROM tipos_sitio WHERE nombre_tipo_sitio LIKE :nombre ORDER BY nombre_tipo_sitio ASC');
        $this->db->bind(':nombre', '%' . $nombre . '%');
        return $this->db->registros();
    }
} 