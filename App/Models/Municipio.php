<?php
class Municipio {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    public function obtenerMunicipios() {
        $this->db->query('SELECT * FROM municipios ORDER BY nombre_municipio ASC');
        return $this->db->registros();
    }

    public function obtenerMunicipioPorId($id) {
        $this->db->query('SELECT * FROM municipios WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    public function agregarMunicipio($datos) {
        $this->db->query('INSERT INTO municipios (nombre_municipio, fecha_creacion) 
                          VALUES (:nombre_municipio, NOW())');
        
        $this->db->bind(':nombre_municipio', $datos['nombre_municipio']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarMunicipio($datos) {
        $this->db->query('UPDATE municipios SET 
                          nombre_municipio = :nombre_municipio, 
                          fecha_modificacion = NOW() 
                          WHERE id = :id');
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':nombre_municipio', $datos['nombre_municipio']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarMunicipio($id) {
        $this->db->query('SELECT COUNT(*) as total FROM centros WHERE municipio_id = :id');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registro();
        
        if(isset($resultado->total) && $resultado->total > 0) {
            return false;
        }
        
        $this->db->query('DELETE FROM municipios WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function buscarMunicipiosPorNombre($nombre) {
        $this->db->query('SELECT * FROM municipios WHERE nombre_municipio LIKE :nombre ORDER BY nombre_municipio ASC');
        $this->db->bind(':nombre', '%' . $nombre . '%');
        return $this->db->registros();
    }
} 