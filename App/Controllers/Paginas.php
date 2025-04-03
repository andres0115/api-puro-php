<?php
class Paginas extends Controlador {
    
    public function __construct() {
        
    }

    
    public function index() {
        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        
        $api_info = [
            'nombre' => 'API Boxware',
            'version' => '1.0.0',
            'endpoints' => [
                'usuarios' => [
                    'listar' => RUTA_URL . 'usuarios',
                    'ver' => RUTA_URL . 'usuarios/ver/{id}',
                    'crear' => RUTA_URL . 'usuarios/crear',
                    'actualizar' => RUTA_URL . 'usuarios/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'usuarios/eliminar/{id}',
                    'login' => RUTA_URL . 'usuarios/login'
                ],
                'roles' => [
                    'listar' => RUTA_URL . 'roles',
                    'activos' => RUTA_URL . 'roles/activos',
                    'ver' => RUTA_URL . 'roles/ver/{id}',
                    'crear' => RUTA_URL . 'roles/crear',
                    'actualizar' => RUTA_URL . 'roles/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'roles/eliminar/{id}',
                    'usuarios_por_rol' => RUTA_URL . 'roles/usuarios/{id}'
                ],
                'permisos' => [
                    'listar' => RUTA_URL . 'permisos',
                    'ver' => RUTA_URL . 'permisos/ver/{id}',
                    'crear' => RUTA_URL . 'permisos/crear',
                    'actualizar' => RUTA_URL . 'permisos/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'permisos/eliminar/{id}',
                    'buscar' => RUTA_URL . 'permisos/buscar/{nombre}',
                    'por_tipo' => RUTA_URL . 'permisos/porTipo/{tipo_permiso}',
                    'por_codigo' => RUTA_URL . 'permisos/porCodigo/{codigo_nombre}'
                ],
                'permisos_usuario' => [
                    'listar' => RUTA_URL . 'permisos_usuarios',
                    'ver' => RUTA_URL . 'permisos_usuarios/ver/{id}',
                    'por_usuario' => RUTA_URL . 'permisos_usuarios/porUsuario/{usuario_id}',
                    'por_permiso' => RUTA_URL . 'permisos_usuarios/porPermiso/{permiso_id}',
                    'asignar' => RUTA_URL . 'permisos_usuarios/asignar',
                    'asignar_multiples' => RUTA_URL . 'permisos_usuarios/asignarMultiples',
                    'eliminar' => RUTA_URL . 'permisos_usuarios/eliminar/{id}',
                    'verificar' => RUTA_URL . 'permisos_usuarios/verificar'
                ],
                'administrador' => [
                    'listar' => RUTA_URL . 'administradores',
                    'ver' => RUTA_URL . 'administradores/ver/{id}',
                    'registrar' => RUTA_URL . 'administradores/registrar',
                    'actualizar' => RUTA_URL . 'administradores/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'administradores/eliminar/{id}',
                    'por_usuario' => RUTA_URL . 'administradores/porUsuario/{usuario_id}',
                    'por_tipo_permiso' => RUTA_URL . 'administradores/porTipoPermiso/{tipo_permiso}',
                    'por_bandera' => RUTA_URL . 'administradores/porBandera/{bandera_accion}'
                ],
                'areas' => [
                    'listar' => RUTA_URL . 'areas',
                    'ver' => RUTA_URL . 'areas/ver/{id}',
                    'crear' => RUTA_URL . 'areas/crear',
                    'actualizar' => RUTA_URL . 'areas/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'areas/eliminar/{id}',
                    'buscar' => RUTA_URL . 'areas/buscar/{nombre}'
                ],
                'programas' => [
                    'listar' => RUTA_URL . 'programas',
                    'ver' => RUTA_URL . 'programas/ver/{id}',
                    'crear' => RUTA_URL . 'programas/crear',
                    'actualizar' => RUTA_URL . 'programas/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'programas/eliminar/{id}',
                    'buscar' => RUTA_URL . 'programas/buscar/{nombre}',
                    'por_area' => RUTA_URL . 'programas/porArea/{area_id}'
                ],
                'sedes' => [
                    'listar' => RUTA_URL . 'sedes',
                    'ver' => RUTA_URL . 'sedes/ver/{id}',
                    'crear' => RUTA_URL . 'sedes/crear',
                    'actualizar' => RUTA_URL . 'sedes/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'sedes/eliminar/{id}',
                    'buscar_por_nombre' => RUTA_URL . 'sedes/buscarPorNombre/{nombre}',
                    'buscar_por_direccion' => RUTA_URL . 'sedes/buscarPorDireccion/{direccion}',
                    'por_centro' => RUTA_URL . 'sedes/porCentro/{centro_id}'
                ],
                'sitios' => [
                    'listar' => RUTA_URL . 'sitios',
                    'ver' => RUTA_URL . 'sitios/ver/{id}',
                    'crear' => RUTA_URL . 'sitios/crear',
                    'actualizar' => RUTA_URL . 'sitios/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'sitios/eliminar/{id}',
                    'buscar_por_nombre' => RUTA_URL . 'sitios/buscarPorNombre/{nombre}',
                    'buscar_por_ubicacion' => RUTA_URL . 'sitios/buscarPorUbicacion/{ubicacion}',
                    'por_encargado' => RUTA_URL . 'sitios/porEncargado/{encargado_id}',
                    'por_tipo' => RUTA_URL . 'sitios/porTipo/{tipo_sitio}'
                ],
                'areas_sedes' => [
                    'listar' => RUTA_URL . 'areassedes',
                    'ver' => RUTA_URL . 'areassedes/ver/{id}',
                    'crear' => RUTA_URL . 'areassedes/crear',
                    'actualizar' => RUTA_URL . 'areassedes/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'areassedes/eliminar/{id}',
                    'por_area' => RUTA_URL . 'areassedes/porArea/{area_id}',
                    'por_sede' => RUTA_URL . 'areassedes/porSede/{sede_id}', 
                    'por_persona' => RUTA_URL . 'areassedes/porPersona/{persona_id}'
                ],
                'materiales' => [
                    'listar' => RUTA_URL . 'materiales',
                    'ver' => RUTA_URL . 'materiales/ver/{id}',
                    'crear' => RUTA_URL . 'materiales/crear',
                    'actualizar' => RUTA_URL . 'materiales/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'materiales/eliminar/{id}',
                    'buscar_por_nombre' => RUTA_URL . 'materiales/buscarPorNombre/{nombre}',
                    'buscar_por_codigo' => RUTA_URL . 'materiales/buscarPorCodigo/{codigo}',
                    'por_categoria' => RUTA_URL . 'materiales/porCategoria/{categoria_id}',
                    'por_tipo' => RUTA_URL . 'materiales/porTipo/{tipo_material}',
                    'por_sitio' => RUTA_URL . 'materiales/porSitio/{sitio_id}',
                    'por_vencer' => RUTA_URL . 'materiales/porVencer/{dias}',
                    'actualizar_stock' => RUTA_URL . 'materiales/actualizarStock/{id}'
                ],
                'movimientos' => [
                    'listar' => RUTA_URL . 'movimientos',
                    'ver' => RUTA_URL . 'movimientos/ver/{id}',
                    'crear' => RUTA_URL . 'movimientos/crear',
                    'actualizar' => RUTA_URL . 'movimientos/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'movimientos/eliminar/{id}',
                    'por_usuario' => RUTA_URL . 'movimientos/porUsuario/{usuario_id}',
                    'por_tipo' => RUTA_URL . 'movimientos/porTipo/{tipo_movimiento}',
                    'por_fecha' => RUTA_URL . 'movimientos/porFecha'
                ],
                'municipios' => [
                    'listar' => RUTA_URL . 'municipios',
                    'ver' => RUTA_URL . 'municipios/ver/{id}',
                    'crear' => RUTA_URL . 'municipios/crear',
                    'actualizar' => RUTA_URL . 'municipios/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'municipios/eliminar/{id}',
                    'buscar' => RUTA_URL . 'municipios/buscar/{nombre}'
                ],
                'categorias_elementos' => [
                    'listar' => RUTA_URL . 'categoriaselementos',
                    'ver' => RUTA_URL . 'categoriaselementos/ver/{id}',
                    'crear' => RUTA_URL . 'categoriaselementos/crear',
                    'actualizar' => RUTA_URL . 'categoriaselementos/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'categoriaselementos/eliminar/{id}',
                    'buscar' => RUTA_URL . 'categoriaselementos/buscar/{nombre}'
                ],
                'centros' => [
                    'listar' => RUTA_URL . 'centros',
                    'ver' => RUTA_URL . 'centros/ver/{id}',
                    'crear' => RUTA_URL . 'centros/crear',
                    'actualizar' => RUTA_URL . 'centros/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'centros/eliminar/{id}',
                    'buscar' => RUTA_URL . 'centros/buscar/{nombre}',
                    'por_municipio' => RUTA_URL . 'centros/porMunicipio/{municipio_id}'
                ],
                'fichas' => [
                    'listar' => RUTA_URL . 'fichas',
                    'ver' => RUTA_URL . 'fichas/ver/{id}',
                    'por_numero' => RUTA_URL . 'fichas/porNumero/{id_ficha}',
                    'crear' => RUTA_URL . 'fichas/crear',
                    'actualizar' => RUTA_URL . 'fichas/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'fichas/eliminar/{id}',
                    'buscar' => RUTA_URL . 'fichas/buscar/{numero}',
                    'por_programa' => RUTA_URL . 'fichas/porPrograma/{programa_id}',
                    'por_usuario' => RUTA_URL . 'fichas/porUsuario/{usuario_id}'
                ],
                'tipos_movimiento' => [
                    'listar' => RUTA_URL . 'tipos_movimiento',
                    'ver' => RUTA_URL . 'tipos_movimiento/ver/{id}',
                    'crear' => RUTA_URL . 'tipos_movimiento/crear',
                    'actualizar' => RUTA_URL . 'tipos_movimiento/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'tipos_movimiento/eliminar/{id}',
                    'buscar' => RUTA_URL . 'tipos_movimiento/buscar/{nombre}'
                ],
                'tipos_permisos' => [
                    'listar' => RUTA_URL . 'tipos_permisos',
                    'ver' => RUTA_URL . 'tipos_permisos/ver/{id}',
                    'crear' => RUTA_URL . 'tipos_permisos/crear',
                    'actualizar' => RUTA_URL . 'tipos_permisos/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'tipos_permisos/eliminar/{id}',
                    'buscar' => RUTA_URL . 'tipos_permisos/buscar/{nombre}'
                ],
                'tipos_sitio' => [
                    'listar' => RUTA_URL . 'tipos_sitio',
                    'ver' => RUTA_URL . 'tipos_sitio/ver/{id}',
                    'crear' => RUTA_URL . 'tipos_sitio/crear',
                    'actualizar' => RUTA_URL . 'tipos_sitio/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'tipos_sitio/eliminar/{id}',
                    'buscar' => RUTA_URL . 'tipos_sitio/buscar/{nombre}'
                ],
                'tipos_material' => [
                    'listar' => RUTA_URL . 'tipos_material',
                    'activos' => RUTA_URL . 'tipos_material/activos',
                    'ver' => RUTA_URL . 'tipos_material/ver/{id}',
                    'crear' => RUTA_URL . 'tipos_material/crear',
                    'actualizar' => RUTA_URL . 'tipos_material/actualizar/{id}',
                    'eliminar' => RUTA_URL . 'tipos_material/eliminar/{id}',
                    'buscar' => RUTA_URL . 'tipos_material/buscar/{nombre}'
                ]
            ]
        ];
        
        echo json_encode($api_info);
    }
    
}