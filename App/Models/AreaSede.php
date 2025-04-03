<?php
class AreaSede {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    public function obtenerAreasSedes() {
        $this->db->query('SELECT a_s.*, a.nombre_area, u.nombre as nombre_persona, u.apellido as apellido_persona, s.nombre as nombre_sede
                          FROM areas_sedes a_s
                          LEFT JOIN areas a ON a_s.area = a.id
                          LEFT JOIN usuarios u ON a_s.persona_administrativa = u.id
                          LEFT JOIN sedes s ON a_s.sede = s.id
                          ORDER BY a.nombre_area ASC');
        return $this->db->registros();
    }

    public function obtenerAreaSedePorId($id) {
        $this->db->query('SELECT a_s.*, a.nombre_area, u.nombre as nombre_persona, u.apellido as apellido_persona, s.nombre as nombre_sede
                          FROM areas_sedes a_s
                          LEFT JOIN areas a ON a_s.area = a.id
                          LEFT JOIN usuarios u ON a_s.persona_administrativa = u.id
                          LEFT JOIN sedes s ON a_s.sede = s.id
                          WHERE a_s.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    public function agregarAreaSede($datos) {
        $this->db->query('INSERT INTO areas_sedes (area, persona_administrativa, sede, fecha_creacion) 
                          VALUES (:area, :persona_administrativa, :sede, NOW())');
        
        $this->db->bind(':area', $datos['area']);
        $this->db->bind(':persona_administrativa', $datos['persona_administrativa']);
        $this->db->bind(':sede', $datos['sede']);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarAreaSede($datos) {
        $this->db->query('UPDATE areas_sedes SET 
                          area = :area, 
                          persona_administrativa = :persona_administrativa, 
                          sede = :sede,
                          fecha_modificacion = NOW() 
                          WHERE id = :id');
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':area', $datos['area']);
        $this->db->bind(':persona_administrativa', $datos['persona_administrativa']);
        $this->db->bind(':sede', $datos['sede']);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarAreaSede($id) {
        $this->db->query('DELETE FROM areas_sedes WHERE id = :id');
        $this->db->bind(':id', $id);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerAreaSedesPorArea($area_id) {
        $this->db->query('SELECT a_s.*, a.nombre_area, u.nombre as nombre_persona, u.apellido as apellido_persona, s.nombre as nombre_sede
                          FROM areas_sedes a_s
                          LEFT JOIN areas a ON a_s.area = a.id
                          LEFT JOIN usuarios u ON a_s.persona_administrativa = u.id
                          LEFT JOIN sedes s ON a_s.sede = s.id
                          WHERE a_s.area = :area_id
                          ORDER BY s.nombre ASC');
        $this->db->bind(':area_id', $area_id);
        return $this->db->registros();
    }

    public function obtenerAreaSedesPorSede($sede_id) {
        $this->db->query('SELECT a_s.*, a.nombre_area, u.nombre as nombre_persona, u.apellido as apellido_persona, s.nombre as nombre_sede
                          FROM areas_sedes a_s
                          LEFT JOIN areas a ON a_s.area = a.id
                          LEFT JOIN usuarios u ON a_s.persona_administrativa = u.id
                          LEFT JOIN sedes s ON a_s.sede = s.id
                          WHERE a_s.sede = :sede_id
                          ORDER BY a.nombre_area ASC');
        $this->db->bind(':sede_id', $sede_id);
        return $this->db->registros();
    }

    public function obtenerAreaSedesPorPersona($persona_id) {
        $this->db->query('SELECT a_s.*, a.nombre_area, u.nombre as nombre_persona, u.apellido as apellido_persona, s.nombre as nombre_sede
                          FROM areas_sedes a_s
                          LEFT JOIN areas a ON a_s.area = a.id
                          LEFT JOIN usuarios u ON a_s.persona_administrativa = u.id
                          LEFT JOIN sedes s ON a_s.sede = s.id
                          WHERE a_s.persona_administrativa = :persona_id
                          ORDER BY a.nombre_area, s.nombre ASC');
        $this->db->bind(':persona_id', $persona_id);
        return $this->db->registros();
    }
} 