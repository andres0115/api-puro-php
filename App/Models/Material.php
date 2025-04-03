<?php
class Material {
    private $db;

    public function __construct() {
        $this->db = new BaseConexion;
    }

    public function obtenerMateriales() {
        $this->db->query('SELECT * FROM materiales ORDER BY nombre_material ASC');
        return $this->db->registros();
    }

    public function obtenerMaterialPorId($id) {
        $this->db->query('SELECT * FROM materiales WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    public function agregarMaterial($datos) {
        $this->db->query('INSERT INTO materiales (
                          fecha_vencimiento, codigo_serial_material, nombre_material, 
                          descripcion_material, stock, unidad_medida, producto_perecedero, 
                          fecha_creacion, categoria, tipo_material, sitio) 
                          VALUES (
                          :fecha_vencimiento, :codigo_serial_material, :nombre_material, 
                          :descripcion_material, :stock, :unidad_medida, :producto_perecedero, 
                          NOW(), :categoria, :tipo_material, :sitio)');
        
        $this->db->bind(':fecha_vencimiento', $datos['fecha_vencimiento'] ?? null);
        $this->db->bind(':codigo_serial_material', $datos['codigo_serial_material']);
        $this->db->bind(':nombre_material', $datos['nombre_material']);
        $this->db->bind(':descripcion_material', $datos['descripcion_material'] ?? '');
        $this->db->bind(':stock', $datos['stock']);
        $this->db->bind(':unidad_medida', $datos['unidad_medida']);
        $this->db->bind(':producto_perecedero', $datos['producto_perecedero'] ?? 0);
        $this->db->bind(':categoria', $datos['categoria']);
        $this->db->bind(':tipo_material', $datos['tipo_material']);
        $this->db->bind(':sitio', $datos['sitio'] ?? null);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarMaterial($datos) {
        $this->db->query('UPDATE materiales SET 
                          fecha_vencimiento = :fecha_vencimiento, 
                          codigo_serial_material = :codigo_serial_material, 
                          nombre_material = :nombre_material, 
                          descripcion_material = :descripcion_material, 
                          stock = :stock, 
                          unidad_medida = :unidad_medida, 
                          producto_perecedero = :producto_perecedero, 
                          fecha_modificacion = NOW(), 
                          categoria = :categoria, 
                          tipo_material = :tipo_material, 
                          sitio = :sitio 
                          WHERE id = :id');
        
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':fecha_vencimiento', $datos['fecha_vencimiento'] ?? null);
        $this->db->bind(':codigo_serial_material', $datos['codigo_serial_material']);
        $this->db->bind(':nombre_material', $datos['nombre_material']);
        $this->db->bind(':descripcion_material', $datos['descripcion_material'] ?? '');
        $this->db->bind(':stock', $datos['stock']);
        $this->db->bind(':unidad_medida', $datos['unidad_medida']);
        $this->db->bind(':producto_perecedero', $datos['producto_perecedero'] ?? 0);
        $this->db->bind(':categoria', $datos['categoria']);
        $this->db->bind(':tipo_material', $datos['tipo_material']);
        $this->db->bind(':sitio', $datos['sitio'] ?? null);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarMaterial($id) {
        $this->db->query('DELETE FROM materiales WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function buscarMaterialesPorNombre($nombre) {
        $this->db->query('SELECT * FROM materiales WHERE nombre_material LIKE :nombre ORDER BY nombre_material ASC');
        $this->db->bind(':nombre', '%' . $nombre . '%');
        return $this->db->registros();
    }

    public function buscarMaterialesPorCodigo($codigo) {
        $this->db->query('SELECT * FROM materiales WHERE codigo_serial_material LIKE :codigo');
        $this->db->bind(':codigo', '%' . $codigo . '%');
        return $this->db->registros();
    }

    public function obtenerMaterialesPorCategoria($categoria_id) {
        $this->db->query('SELECT * FROM materiales WHERE categoria = :categoria_id ORDER BY nombre_material ASC');
        $this->db->bind(':categoria_id', $categoria_id);
        return $this->db->registros();
    }

    public function obtenerMaterialesPorTipo($tipo_material) {
        $this->db->query('SELECT * FROM materiales WHERE tipo_material = :tipo_material ORDER BY nombre_material ASC');
        $this->db->bind(':tipo_material', $tipo_material);
        return $this->db->registros();
    }

    public function obtenerMaterialesPorSitio($sitio_id) {
        $this->db->query('SELECT * FROM materiales WHERE sitio = :sitio_id ORDER BY nombre_material ASC');
        $this->db->bind(':sitio_id', $sitio_id);
        return $this->db->registros();
    }

    public function obtenerMaterialesPorVencer($dias = 30) {
        $this->db->query('SELECT * FROM materiales 
                         WHERE fecha_vencimiento IS NOT NULL 
                         AND fecha_vencimiento <= DATE_ADD(CURDATE(), INTERVAL :dias DAY)
                         AND fecha_vencimiento >= CURDATE()
                         ORDER BY fecha_vencimiento ASC');
        $this->db->bind(':dias', $dias);
        return $this->db->registros();
    }

    public function actualizarStock($id, $cantidad) {
        $this->db->query('UPDATE materiales SET stock = stock + :cantidad WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':cantidad', $cantidad);
        return $this->db->execute();
    }
} 