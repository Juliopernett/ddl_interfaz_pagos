-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-12-2024 a las 14:29:50
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ddl_interfaz_pagos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--

CREATE TABLE `metodos_pago` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `metodos_pago`
--

INSERT INTO `metodos_pago` (`id`, `descripcion`, `estado`) VALUES
(1, 'PSE', 1),
(2, 'TARJETA DE CREDITO/DEBITO', 1),
(3, 'TRANSFERENCIA', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `recibo_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `monto_pagado` decimal(10,2) NOT NULL,
  `fecha_pago` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('exitoso','fallido') DEFAULT 'exitoso',
  `referencia_transaccion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibos`
--

CREATE TABLE `recibos` (
  `id` int(11) NOT NULL,
  `tipo_tramite_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `id_metodo_pago` int(1) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','pagado') DEFAULT 'pendiente',
  `fecha_emision` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_vencimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `recibos`
--

INSERT INTO `recibos` (`id`, `tipo_tramite_id`, `usuario_id`, `id_metodo_pago`, `descripcion`, `monto`, `estado`, `fecha_emision`, `fecha_vencimiento`) VALUES
(26, 2, 26, 1, 'Certificado de Placa por parte del Instituto Distrital de Tránsito y Transporte de Barranquilla y Metrotransito en liquidación. Oficio que se expide ante el organismo de tránsito vigente donde se encuentra matriculada la respectiva Placa de vehículo o motocicleta.', '80000.00', 'pendiente', '2024-12-22 18:51:54', NULL),
(27, 2, 27, 1, 'Certificado de Placa por parte del Instituto Distrital de Tránsito y Transporte de Barranquilla y Metrotransito en liquidación. Oficio que se expide ante el organismo de tránsito vigente donde se encuentra matriculada la respectiva Placa de vehículo o motocicleta.', '80000.00', 'pendiente', '2024-12-22 18:52:15', NULL),
(28, 3, 28, 1, 'Levantamiento de medidas cautelares ante las entidades financieras de medidas que fueron ordenadas por la Extinta Metrotransito ante las 24 entidades financieras vigentes en el territorio nacional.', '120000.00', 'pendiente', '2024-12-22 18:57:23', NULL),
(29, 3, 29, 1, 'Levantamiento de medidas cautelares ante las entidades financieras de medidas que fueron ordenadas por la Extinta Metrotransito ante las 24 entidades financieras vigentes en el territorio nacional.', '120000.00', 'pendiente', '2024-12-22 19:01:18', NULL),
(30, 3, 30, 2, 'Levantamiento de medidas cautelares ante las entidades financieras de medidas que fueron ordenadas por la Extinta Metrotransito ante las 24 entidades financieras vigentes en el territorio nacional.', '120000.00', 'pendiente', '2024-12-22 19:02:01', NULL),
(31, 1, 31, 1, 'Certificado de Paz y salvo de comparendos que se encuentren registrados por parte de la Extinta Metrotransito.', '50000.00', 'pendiente', '2024-12-22 19:03:41', NULL),
(32, 1, 32, 1, 'Certificado de Paz y salvo de comparendos que se encuentren registrados por parte de la Extinta Metrotransito.', '50000.00', 'pendiente', '2024-12-22 19:10:03', NULL),
(33, 1, 33, 1, 'Certificado de Paz y salvo de comparendos que se encuentren registrados por parte de la Extinta Metrotransito.', '50000.00', 'pendiente', '2024-12-22 19:10:53', NULL),
(34, 1, 34, 1, 'Certificado de Paz y salvo de comparendos que se encuentren registrados por parte de la Extinta Metrotransito.', '50000.00', 'pendiente', '2024-12-22 19:11:24', NULL),
(35, 1, 35, 2, 'Certificado de Paz y salvo de comparendos que se encuentren registrados por parte de la Extinta Metrotransito.', '50000.00', 'pendiente', '2024-12-22 19:14:45', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_tramites`
--

CREATE TABLE `tipos_tramites` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `usuario_registro` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `valor` decimal(10,2) NOT NULL,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipos_tramites`
--

INSERT INTO `tipos_tramites` (`id`, `nombre`, `descripcion`, `estado`, `usuario_registro`, `fecha_registro`, `valor`, `fecha_actualizacion`) VALUES
(1, 'Certificado de Paz y Salvo', 'Certificado de Paz y salvo de comparendos que se encuentren registrados por parte de la Extinta Metrotransito.', 1, 'admin', '2024-12-21 16:40:17', '50000.00', '2024-12-21 16:40:17'),
(2, 'Certificado de Placa', 'Certificado de Placa por parte del Instituto Distrital de Tránsito y Transporte de Barranquilla y Metrotransito en liquidación. Oficio que se expide ante el organismo de tránsito vigente donde se encuentra matriculada la respectiva Placa de vehículo o motocicleta.', 1, 'admin', '2024-12-21 16:40:17', '80000.00', '2024-12-21 16:40:17'),
(3, 'Levantamiento de medidas cautelares (entidades financieras)', 'Levantamiento de medidas cautelares ante las entidades financieras de medidas que fueron ordenadas por la Extinta Metrotransito ante las 24 entidades financieras vigentes en el territorio nacional.', 1, 'admin', '2024-12-21 16:40:17', '120000.00', '2024-12-21 16:40:17'),
(4, 'Levantamiento de medidas cautelares (oficina de instrumentos públicos)', 'Levantamiento de medidas cautelares que fueron ordenadas ante la Oficina de Instrumentos públicos. Oficio que se dirige ante la oficina que corresponda en el territorio nacional y que sean embargos que hayan sido emitidos por la Dirección distrital de liquidaciones.', 1, 'admin', '2024-12-21 16:40:17', '100000.00', '2024-12-21 16:40:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `tipo_usuario` enum('natural','juridica') NOT NULL,
  `identificacion` varchar(50) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `tipo_usuario`, `identificacion`, `nombre`, `email`, `telefono`, `direccion`, `fecha_registro`) VALUES
(26, 'juridica', '1082974716', 'julio jose pernet retamozo', 'jjpernett2008@gmail.com', '3185218253', 'clle 7b 23 27', '2024-12-22 12:51:54'),
(27, 'juridica', '1082974716', 'julio jose pernet retamozo', 'jjpernett2008@gmail.com', '3185218253', 'clle 7b 23 27', '2024-12-22 12:52:15'),
(28, 'natural', '1082974716', 'julio jose pernet retamozo', 'jjpernett2008@gmail.com', '3185218253', 'clle 7b 23 27', '2024-12-22 12:57:23'),
(29, 'natural', '1082974716', 'julio jose pernet retamozo', 'jjpernett2008@gmail.com', '3185218253', 'clle 7b 23 27', '2024-12-22 13:01:18'),
(30, 'natural', '1082974716', 'julio jose pernet retamozo', 'jjpernett2008@gmail.com', '3185218253', 'clle 7b 23 27', '2024-12-22 13:02:01'),
(31, 'natural', '1082974716', 'julio jose pernet retamozo', 'jjpernett2008@gmail.com', '3185218253', 'clle 7b 23 27', '2024-12-22 13:03:41'),
(32, 'natural', '1082974716', 'julio jose pernet retamozo', 'jjpernett2008@gmail.com', '3185218253', 'clle 7b 23 27', '2024-12-22 13:10:03'),
(33, 'natural', '1082974716', 'julio jose pernet retamozo', 'jjpernett2008@gmail.com', '3185218253', 'clle 7b 23 27', '2024-12-22 13:10:53'),
(34, 'natural', '1082974716', 'julio jose pernet retamozo', 'jjpernett2008@gmail.com', '3185218253', 'clle 7b 23 27', '2024-12-22 13:11:24'),
(35, 'natural', '1082974716', 'julio jose pernet retamozo', 'jjpernett2008@gmail.com', '3185218253', 'clle 7b 23 27', '2024-12-22 13:14:45');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `referencia_transaccion` (`referencia_transaccion`),
  ADD KEY `recibo_id` (`recibo_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `recibos`
--
ALTER TABLE `recibos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_tramite_id` (`tipo_tramite_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `tipos_tramites`
--
ALTER TABLE `tipos_tramites`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recibos`
--
ALTER TABLE `recibos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `tipos_tramites`
--
ALTER TABLE `tipos_tramites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`recibo_id`) REFERENCES `recibos` (`id`),
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `recibos`
--
ALTER TABLE `recibos`
  ADD CONSTRAINT `recibos_ibfk_1` FOREIGN KEY (`tipo_tramite_id`) REFERENCES `tipos_tramites` (`id`),
  ADD CONSTRAINT `recibos_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
