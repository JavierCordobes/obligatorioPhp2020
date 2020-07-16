-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-07-2020 a las 01:53:05
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `obligatorio`
--
CREATE DATABASE IF NOT EXISTS `obligatorio` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `obligatorio`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encargado`
--

DROP TABLE IF EXISTS `encargado`;
CREATE TABLE IF NOT EXISTS `encargado` (
  `cedula` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `nombres` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `pin` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `foto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `encargado`
--

INSERT INTO `encargado` (`cedula`, `nombres`, `apellidos`, `email`, `pin`, `foto`, `eliminado`) VALUES
('12', 'Juan', 'Fernandez', 'email12@ejemplo.com', '3c59dc048e8850243be8079a5c74d079', 'Fotos/Encargado/12.jpg', 0),
('34', 'Pedro', 'Sanchez', 'email34@ejemplo.com', '17e62166fc8586dfa4d1bc0e1742c08b', 'Fotos/Encargado/34.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquete`
--

DROP TABLE IF EXISTS `paquete`;
CREATE TABLE IF NOT EXISTS `paquete` (
  `codigo` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `dirRemitente` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `dirEnvio` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `fragil` tinyint(1) NOT NULL,
  `perecedero` tinyint(1) NOT NULL,
  `fechaEstimada` date DEFAULT NULL,
  `fechaEntrega` date DEFAULT NULL,
  `estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'No asignado',
  `fechaAsignacion` date DEFAULT NULL,
  `ciTransportista` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codigo`),
  KEY `fk` (`ciTransportista`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `paquete`
--

INSERT INTO `paquete` (`codigo`, `dirRemitente`, `dirEnvio`, `fragil`, `perecedero`, `fechaEstimada`, `fechaEntrega`, `estado`, `fechaAsignacion`, `ciTransportista`, `eliminado`) VALUES
('a1', 'Ejemplo Remitente a1', 'Ejemplo Envio a1', 1, 1, '2020-07-09', '2020-07-08', 'Entregado', '2020-07-16', '67', 0),
('a2', 'Ejemplo Remitente a2', 'Ejemplo Envio a2', 0, 0, NULL, NULL, 'No asignado', NULL, NULL, 0),
('a3', 'Ejemplo Remitente a3', 'Ejemplo Envio a3', 1, 0, '2020-07-13', '2020-07-13', 'Entregado', '2020-07-16', '67', 0),
('a4', 'Ejemplo Remitente a4', 'Ejemplo Envio a4', 0, 1, NULL, NULL, 'No asignado', NULL, NULL, 0),
('b1', 'Ejemplo Remitente b1', 'Ejemplo Envio b1', 1, 1, NULL, NULL, 'No asignado', NULL, NULL, 0),
('b2', 'Ejemplo Remitente b2', 'Ejemplo Envio b2', 0, 0, '2020-07-03', '2020-07-04', 'Entregado', '2020-07-16', '89', 0),
('b3', 'Ejemplo Remitente b3', 'Ejemplo Envio b3', 1, 0, '2020-07-17', NULL, 'Asignado', '2020-07-16', '89', 0),
('b4', 'Ejemplo Remitente b4', 'Ejemplo Envio b4', 0, 1, NULL, NULL, 'No asignado', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transportista`
--

DROP TABLE IF EXISTS `transportista`;
CREATE TABLE IF NOT EXISTS `transportista` (
  `cedula` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `nombres` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `foto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `pin` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `transportista`
--

INSERT INTO `transportista` (`cedula`, `nombres`, `apellidos`, `direccion`, `telefono`, `foto`, `pin`, `eliminado`) VALUES
('67', 'Jose', 'Martinez', 'Ejemplo67', '67-67-67', 'Fotos/Transportista/67.jpg', 'fbd7939d674997cdb4692d34de8633c4', 0),
('89', 'Pablo', 'Gomez', 'Ejemplo89', '89-89-89', 'Fotos/Transportista/89.jpg', 'ed3d2c21991e3bef5e069713af9fa6ca', 0);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `paquete`
--
ALTER TABLE `paquete`
  ADD CONSTRAINT `fk_p.t` FOREIGN KEY (`ciTransportista`) REFERENCES `transportista` (`cedula`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
