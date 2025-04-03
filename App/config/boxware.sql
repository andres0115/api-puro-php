-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-04-2025 a las 06:47:26
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `boxware`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `fecha_accion` datetime(6) DEFAULT NULL,
  `rutas` longtext DEFAULT NULL,
  `descripcion_ruta` varchar(200) DEFAULT NULL,
  `bandera_accion` smallint(5) UNSIGNED DEFAULT NULL,
  `mensaje_cambio` longtext DEFAULT NULL,
  `tipo_permiso` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `id` int(11) NOT NULL,
  `nombre_area` varchar(100) DEFAULT NULL,
  `fecha_creacion` datetime(6) DEFAULT NULL,
  `fecha_modificacion` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id`, `nombre_area`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 'pruebaaaa', '2025-03-19 22:12:31.000000', '2025-03-29 22:12:31.000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas_sedes`
--

CREATE TABLE `areas_sedes` (
  `id` int(11) NOT NULL,
  `fecha_creacion` datetime(6) DEFAULT NULL,
  `fecha_modificacion` datetime(6) DEFAULT NULL,
  `area` int(11) DEFAULT NULL,
  `persona_administrativa` int(11) DEFAULT NULL,
  `sede` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_elementos`
--

CREATE TABLE `categorias_elementos` (
  `id` int(11) NOT NULL,
  `codigo_unpsc_material` varchar(255) DEFAULT NULL,
  `nombre_categoria` varchar(255) DEFAULT NULL,
  `fecha_creacion` datetime(6) DEFAULT NULL,
  `fecha_modificacion` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centros`
--

CREATE TABLE `centros` (
  `id` int(11) NOT NULL,
  `nombre_centro` varchar(100) DEFAULT NULL,
  `fecha_creacion` datetime(6) DEFAULT NULL,
  `fecha_modificacion` datetime(6) DEFAULT NULL,
  `municipio_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas`
--

CREATE TABLE `fichas` (
  `id` int(11) NOT NULL,
  `fecha_creacion` datetime(6) DEFAULT NULL,
  `fecha_modificacion` datetime(6) DEFAULT NULL,
  `usuario_ficha` int(11) DEFAULT NULL,
  `programa` int(11) DEFAULT NULL,
  `id_ficha` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `id` int(11) NOT NULL,
  `fecha_vencimiento` datetime(6) DEFAULT NULL,
  `codigo_sena_material` varchar(255) DEFAULT NULL,
  `nombre_material` varchar(255) DEFAULT NULL,
  `descripcion_material` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `unidad_medida` varchar(255) DEFAULT NULL,
  `producto_perecedero` tinyint(1) DEFAULT NULL,
  `fecha_creacion` datetime(6) DEFAULT NULL,
  `fecha_modificacion` datetime(6) DEFAULT NULL,
  `categoria` int(11) DEFAULT NULL,
  `tipo_material` int(11) DEFAULT NULL,
  `sitio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` int(11) NOT NULL,
  `fecha_creacion` datetime(6) DEFAULT NULL,
  `fecha_modificacion` datetime(6) DEFAULT NULL,
  `usuario_movimiento` int(11) DEFAULT NULL,
  `tipo_movimiento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id` int(11) NOT NULL,
  `nombre_municipio` varchar(255) DEFAULT NULL,
  `fecha_creacion` datetime(6) DEFAULT NULL,
  `fecha_modificacion` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `tipo_permiso` int(11) DEFAULT NULL,
  `codigo_nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_usuario`
--

CREATE TABLE `permisos_usuario` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `permiso_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

CREATE TABLE `programas` (
  `id` int(11) NOT NULL,
  `nombre_programa` varchar(100) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL,
  `area` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre_rol` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_creacion` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre_rol`, `descripcion`, `estado`, `fecha_creacion`) VALUES
(1, 'Admin', 'Manejar todas las solicitudes', 1, '2025-03-27 15:44:18.000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sedes`
--

CREATE TABLE `sedes` (
  `id` int(11) NOT NULL,
  `nombre_sede` varchar(100) DEFAULT NULL,
  `direccion_sede` varchar(100) DEFAULT NULL,
  `fecha_creacion` datetime(6) DEFAULT NULL,
  `fecha_modificacion` datetime(6) DEFAULT NULL,
  `centro_sede_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sitios`
--

CREATE TABLE `sitios` (
  `id` int(11) NOT NULL,
  `nombre_sitio` varchar(100) DEFAULT NULL,
  `ubicacion` varchar(100) DEFAULT NULL,
  `ficha_tecnica` varchar(100) DEFAULT NULL,
  `fecha_creacion` datetime(6) DEFAULT NULL,
  `fecha_modificacion` datetime(6) DEFAULT NULL,
  `persona_encargada` int(11) DEFAULT NULL,
  `tipo_sitio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_movimiento`
--

CREATE TABLE `tipos_movimiento` (
  `id` int(11) NOT NULL,
  `tipo_movimiento` varchar(255) DEFAULT NULL,
  `fecha_creacion` datetime(6) DEFAULT NULL,
  `fecha_modificacion` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_permisos`
--

CREATE TABLE `tipos_permisos` (
  `id` int(11) NOT NULL,
  `permisos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_sitio`
--

CREATE TABLE `tipos_sitio` (
  `id` int(11) NOT NULL,
  `nombre_tipo_sitio` varchar(100) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_materiales`
--

CREATE TABLE `tipo_materiales` (
  `id` int(11) NOT NULL,
  `tipo_elemento` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_creacion` datetime(6) DEFAULT NULL,
  `fecha_modificacion` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_materiales`
--

INSERT INTO `tipo_materiales` (`id`, `tipo_elemento`, `estado`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 'Herramientas Eléctricas', 1, '2025-04-01 20:16:49.000000', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `contrasena` varchar(128) DEFAULT NULL,
  `inicio_sesion` datetime(6) DEFAULT NULL,
  `nombre_usuario` varchar(150) DEFAULT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `apellido` varchar(150) DEFAULT NULL,
  `esta_activo` tinyint(1) DEFAULT NULL,
  `fecha_registro` datetime(6) DEFAULT NULL,
  `cedula_persona` varchar(255) DEFAULT NULL,
  `edad_persona` varchar(100) DEFAULT NULL,
  `telefono_persona` varchar(255) DEFAULT NULL,
  `email` varchar(254) DEFAULT NULL,
  `rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `contrasena`, `inicio_sesion`, `nombre_usuario`, `nombre`, `apellido`, `esta_activo`, `fecha_registro`, `cedula_persona`, `edad_persona`, `telefono_persona`, `email`, `rol`) VALUES
(2, '12345', '2025-03-27 15:45:05.000000', 'usuario1_actualizado', 'Juan Actualizado', 'Pérez Actualizado', 1, '2025-03-27 15:45:05.000000', '87654321', '31', '9999999999', 'juan_nuevo@ejemplo.com', 1),
(3, 'triana123', '2025-03-28 22:25:16.000000', 'TrianaAndres', 'Andres', 'Triana', 1, '2025-03-27 22:25:16.000000', '12345678', '19', '54321223', 'triana@gmail.com', 1),
(5, '123456', '2025-03-27 10:00:00.000000', 'juanes123', 'Juan', 'Perez', 1, '2025-03-27 00:00:00.000000', '123456789', '25', '3123456789', 'juan@example.com', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_permiso` (`tipo_permiso`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `areas_sedes`
--
ALTER TABLE `areas_sedes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `area` (`area`),
  ADD KEY `persona_administrativa` (`persona_administrativa`),
  ADD KEY `sede` (`sede`);

--
-- Indices de la tabla `categorias_elementos`
--
ALTER TABLE `categorias_elementos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `centros`
--
ALTER TABLE `centros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `municipio_id` (`municipio_id`);

--
-- Indices de la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_ficha` (`usuario_ficha`),
  ADD KEY `programa` (`programa`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria` (`categoria`),
  ADD KEY `tipo_material` (`tipo_material`),
  ADD KEY `sitio` (`sitio`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_movimiento` (`usuario_movimiento`),
  ADD KEY `tipo_movimiento` (`tipo_movimiento`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_permiso` (`tipo_permiso`);

--
-- Indices de la tabla `permisos_usuario`
--
ALTER TABLE `permisos_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `permiso_id` (`permiso_id`);

--
-- Indices de la tabla `programas`
--
ALTER TABLE `programas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `area` (`area`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sedes`
--
ALTER TABLE `sedes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `centro_sede_id` (`centro_sede_id`);

--
-- Indices de la tabla `sitios`
--
ALTER TABLE `sitios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `persona_encargada` (`persona_encargada`),
  ADD KEY `tipo_sitio` (`tipo_sitio`);

--
-- Indices de la tabla `tipos_movimiento`
--
ALTER TABLE `tipos_movimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_permisos`
--
ALTER TABLE `tipos_permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_sitio`
--
ALTER TABLE `tipos_sitio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_materiales`
--
ALTER TABLE `tipo_materiales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `areas_sedes`
--
ALTER TABLE `areas_sedes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias_elementos`
--
ALTER TABLE `categorias_elementos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `centros`
--
ALTER TABLE `centros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos_usuario`
--
ALTER TABLE `permisos_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `programas`
--
ALTER TABLE `programas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `sedes`
--
ALTER TABLE `sedes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sitios`
--
ALTER TABLE `sitios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos_movimiento`
--
ALTER TABLE `tipos_movimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos_permisos`
--
ALTER TABLE `tipos_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos_sitio`
--
ALTER TABLE `tipos_sitio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_materiales`
--
ALTER TABLE `tipo_materiales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`tipo_permiso`) REFERENCES `tipos_permisos` (`id`),
  ADD CONSTRAINT `administrador_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `administrador_ibfk_3` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `areas_sedes`
--
ALTER TABLE `areas_sedes`
  ADD CONSTRAINT `areas_sedes_ibfk_1` FOREIGN KEY (`area`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `areas_sedes_ibfk_2` FOREIGN KEY (`persona_administrativa`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `areas_sedes_ibfk_3` FOREIGN KEY (`sede`) REFERENCES `sedes` (`id`);

--
-- Filtros para la tabla `centros`
--
ALTER TABLE `centros`
  ADD CONSTRAINT `centros_ibfk_1` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`);

--
-- Filtros para la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD CONSTRAINT `fichas_ibfk_1` FOREIGN KEY (`usuario_ficha`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `fichas_ibfk_2` FOREIGN KEY (`programa`) REFERENCES `programas` (`id`);

--
-- Filtros para la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD CONSTRAINT `materiales_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categorias_elementos` (`id`),
  ADD CONSTRAINT `materiales_ibfk_2` FOREIGN KEY (`tipo_material`) REFERENCES `tipo_materiales` (`id`),
  ADD CONSTRAINT `materiales_ibfk_3` FOREIGN KEY (`sitio`) REFERENCES `sitios` (`id`);

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`usuario_movimiento`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `movimientos_ibfk_2` FOREIGN KEY (`tipo_movimiento`) REFERENCES `tipos_movimiento` (`id`);

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`tipo_permiso`) REFERENCES `tipos_permisos` (`id`);

--
-- Filtros para la tabla `permisos_usuario`
--
ALTER TABLE `permisos_usuario`
  ADD CONSTRAINT `permisos_usuario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `permisos_usuario_ibfk_2` FOREIGN KEY (`permiso_id`) REFERENCES `permisos` (`id`);

--
-- Filtros para la tabla `programas`
--
ALTER TABLE `programas`
  ADD CONSTRAINT `programas_ibfk_1` FOREIGN KEY (`area`) REFERENCES `areas` (`id`);

--
-- Filtros para la tabla `sedes`
--
ALTER TABLE `sedes`
  ADD CONSTRAINT `sedes_ibfk_1` FOREIGN KEY (`centro_sede_id`) REFERENCES `centros` (`id`);

--
-- Filtros para la tabla `sitios`
--
ALTER TABLE `sitios`
  ADD CONSTRAINT `sitios_ibfk_1` FOREIGN KEY (`persona_encargada`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `sitios_ibfk_2` FOREIGN KEY (`tipo_sitio`) REFERENCES `tipos_sitio` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
