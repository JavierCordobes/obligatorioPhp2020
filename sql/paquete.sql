-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-07-2020 a las 00:16:06
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquete`
--

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
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `paquete`
--
ALTER TABLE `paquete`
  ADD CONSTRAINT `fk` FOREIGN KEY (`ciTransportista`) REFERENCES `transportista` (`cedula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
