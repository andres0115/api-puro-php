<?php
class CategoriaElemento {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    
    public function obtenerCategoriasElementos() {
        $this->db->query('SELECT * FROM categorias_elementos ORDER BY nombre_categoria ASC');
        return $this->db->registros();
    }

    
    public function obtenerCategoriaElementoPorId($id) {
        $this->db->query('SELECT * FROM categorias_elementos WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    
    public function agregarCategoriaElemento($datos) {
        $this->db->query('INSERT INTO categorias_elementos (nombre_categoria, descripcion, fecha_creacion) 
                          VALUES (:nombre_categoria, :descripcion, NOW())');
        
        
        $this->db->bind(':nombre_categoria', $datos['nombre_categoria']);
        $this->db->bind(':descripcion', $datos['descripcion'] ?? '');

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function actualizarCategoriaElemento($datos) {
        $this->db->query('UPDATE categorias_elementos SET 
                          nombre_categoria = :nombre_categoria, 
                          descripcion = :descripcion,
                          fecha_modificacion = NOW() 
                          WHERE id = :id');
        
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':nombre_categoria', $datos['nombre_categoria']);
        $this->db->bind(':descripcion', $datos['descripcion'] ?? '');

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function eliminarCategoriaElemento($id) {
        
        
        $this->db->query('SELECT COUNT(*) as total FROM elementos WHERE categoria_id = :id');
        $this->db->bind(':id', $id);
        $resultado = $this->db->registro();
        
        if(isset($resultado->total) && $resultado->total > 0) {
            return false; 
        }
        
        $this->db->query('DELETE FROM categorias_elementos WHERE id = :id');
        $this->db->bind(':id', $id);

        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function buscarCategoriasElementosPorNombre($nombre) {
        $this->db->query('SELECT * FROM categorias_elementos WHERE nombre_categoria LIKE :nombre ORDER BY nombre_categoria ASC');
        $this->db->bind(':nombre', '%' . $nombre . '%');
        return $this->db->registros();
    }
}
