<?php
class Ficha {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    
    public function obtenerFichas() {
        $this->db->query('SELECT f.*, u.nombre as nombre_usuario, p.nombre_programa 
                         FROM fichas f
                         LEFT JOIN usuarios u ON f.usuario_ficha = u.id
                         LEFT JOIN programas p ON f.programa = p.id
                         ORDER BY f.id_ficha ASC');
        return $this->db->registros();
    }

    
    public function obtenerFichaPorId($id) {
        $this->db->query('SELECT f.*, u.nombre as nombre_usuario, p.nombre_programa 
                         FROM fichas f
                         LEFT JOIN usuarios u ON f.usuario_ficha = u.id
                         LEFT JOIN programas p ON f.programa = p.id
                         WHERE f.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    
    public function obtenerFichaPorNumero($id_ficha) {
        $this->db->query('SELECT f.*, u.nombre as nombre_usuario, p.nombre_programa 
                         FROM fichas f
                         LEFT JOIN usuarios u ON f.usuario_ficha = u.id
                         LEFT JOIN programas p ON f.programa = p.id
                         WHERE f.id_ficha = :id_ficha');
        $this->db->bind(':id_ficha', $id_ficha);
        return $this->db->registro();
    }

    
    public function agregarFicha($datos) {
        $this->db->query('INSERT INTO fichas (id_ficha, usuario_ficha, programa, fecha_creacion) 
                          VALUES (:id_ficha, :usuario_ficha, :programa, NOW())');
        
        
        $this->db->bind(':id_ficha', $datos['id_ficha']);
        $this->db->bind(':usuario_ficha', $datos['usuario_ficha']);
        $this->db->bind(':programa', $datos['programa']);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function actualizarFicha($datos) {
        $this->db->query('UPDATE fichas SET 
                          id_ficha = :id_ficha, 
                          usuario_ficha = :usuario_ficha,
                          programa = :programa,
                          fecha_modificacion = NOW() 
                          WHERE id = :id');
        
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':id_ficha', $datos['id_ficha']);
        $this->db->bind(':usuario_ficha', $datos['usuario_ficha']);
        $this->db->bind(':programa', $datos['programa']);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function eliminarFicha($id) {
        
        
        $this->db->query('SELECT COUNT(*) as total FROM aprendices WHERE ficha_id = :id');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registro();
        
        if(isset($resultado->total) && $resultado->total > 0) {
            return false; 
        }
        
        $this->db->query('DELETE FROM fichas WHERE id = :id');
        $this->db->bind(':id', $id);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function buscarFichasPorNumero($numero) {
        $this->db->query('SELECT f.*, u.nombre as nombre_usuario, p.nombre_programa 
                         FROM fichas f
                         LEFT JOIN usuarios u ON f.usuario_ficha = u.id
                         LEFT JOIN programas p ON f.programa = p.id
                         WHERE f.id_ficha LIKE :numero 
                         ORDER BY f.id_ficha ASC');
        $this->db->bind(':numero', '%' . $numero . '%');
        return $this->db->registros();
    }
    
    
    public function obtenerFichasPorPrograma($programa_id) {
        $this->db->query('SELECT f.*, u.nombre as nombre_usuario, p.nombre_programa 
                         FROM fichas f
                         LEFT JOIN usuarios u ON f.usuario_ficha = u.id
                         LEFT JOIN programas p ON f.programa = p.id
                         WHERE f.programa = :programa_id
                         ORDER BY f.id_ficha ASC');
        $this->db->bind(':programa_id', $programa_id);
        return $this->db->registros();
    }
    
    
    public function obtenerFichasPorUsuario($usuario_id) {
        $this->db->query('SELECT f.*, u.nombre as nombre_usuario, p.nombre_programa 
                         FROM fichas f
                         LEFT JOIN usuarios u ON f.usuario_ficha = u.id
                         LEFT JOIN programas p ON f.programa = p.id
                         WHERE f.usuario_ficha = :usuario_id
                         ORDER BY f.id_ficha ASC');
        $this->db->bind(':usuario_id', $usuario_id);
        return $this->db->registros();
    }
}
