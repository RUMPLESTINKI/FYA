-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 27-04-2021 a las 05:02:48
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fya`
--
CREATE DATABASE IF NOT EXISTS `fya` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `fya`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

DROP TABLE IF EXISTS `administrador`;
CREATE TABLE IF NOT EXISTS `administrador` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_admin` varchar(40) DEFAULT NULL,
  `password_admin` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id_admin`, `usuario_admin`, `password_admin`) VALUES
(1, 'Admin_123', 'admin_321');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
CREATE TABLE IF NOT EXISTS `alumnos` (
  `id_alumn` int(11) NOT NULL AUTO_INCREMENT,
  `no_control` varchar(8) NOT NULL,
  `Nombre` varchar(60) NOT NULL,
  `carrera` varchar(65) DEFAULT NULL,
  `promedio_ingles` int(3) DEFAULT NULL,
  `semestre` int(2) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_alumn`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id_alumn`, `no_control`, `Nombre`, `carrera`, `promedio_ingles`, `semestre`, `password`, `created_at`, `updated_at`) VALUES
(24, '17698514', 'Eduardo Hernandez Gonzalez', 'Ing. en Sistemas Computacionales', 88, 9, 'edu98', '2021-04-23 01:50:54', '2021-04-23 02:46:23'),
(25, '17690127', 'Enrique Martinez Hernadez', 'Ing. Industrial', NULL, 9, 'fvsdf435', '2021-04-23 01:51:37', '2021-04-23 01:51:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

DROP TABLE IF EXISTS `grupos`;
CREATE TABLE IF NOT EXISTS `grupos` (
  `id_grupo` int(4) NOT NULL AUTO_INCREMENT,
  `nivel` int(2) DEFAULT NULL,
  `nombre` varchar(70) DEFAULT NULL,
  `capacidad` int(2) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `descripcion` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id_grupo`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id_grupo`, `nivel`, `nombre`, `capacidad`, `status`, `descripcion`) VALUES
(1, 1, 'Nivel 1 de 7:00 a 9:00 de lunes a viernes', 30, 'cerrado', 'Curso de unidad 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_alumno`
--

DROP TABLE IF EXISTS `grupo_alumno`;
CREATE TABLE IF NOT EXISTS `grupo_alumno` (
  `id_ga` int(8) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(4) DEFAULT NULL,
  `alumno` varchar(8) DEFAULT NULL,
  `nivel` int(2) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `fecha_ultimo_movimiento` date DEFAULT NULL,
  `calificacion` int(3) DEFAULT NULL,
  `periodo` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_ga`),
  KEY `id_grupo` (`id_grupo`),
  KEY `nivel` (`nivel`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `grupo_alumno`
--

INSERT INTO `grupo_alumno` (`id_ga`, `id_grupo`, `alumno`, `nivel`, `status`, `fecha_ultimo_movimiento`, `calificacion`, `periodo`) VALUES
(1, 1, '17690285', 1, 'cerrado', '2021-04-10', 70, 'AGOSTO-DICIEMBRE 2020');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `list_espera`
--

DROP TABLE IF EXISTS `list_espera`;
CREATE TABLE IF NOT EXISTS `list_espera` (
  `id_list` int(9) NOT NULL AUTO_INCREMENT,
  `no_control` varchar(8) NOT NULL,
  `Nombre` varchar(60) NOT NULL,
  `carrera` varchar(65) DEFAULT NULL,
  `modulo` int(9) DEFAULT NULL,
  `semestre` int(2) DEFAULT NULL,
  `argumento` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_list`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `list_espera`
--

INSERT INTO `list_espera` (`id_list`, `no_control`, `Nombre`, `carrera`, `modulo`, `semestre`, `argumento`, `created_at`, `updated_at`) VALUES
(7, '17690124', 'Lopez samuel', 'Ing. Industrial', 2, 2, 'No puedo estar en la maÃ±ana porque se me empalma', '2021-04-20 03:05:52', '2021-04-20 03:05:52'),
(10, '17690127', 'Enrique Martinez Hernadez', 'Ing. Industrial', 2, 1, 'No puedo estar en la maÃ±ana porque se me empalma con otra materia.', '2021-04-23 03:24:26', '2021-04-23 03:24:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel`
--

DROP TABLE IF EXISTS `nivel`;
CREATE TABLE IF NOT EXISTS `nivel` (
  `id_nivel` int(2) NOT NULL AUTO_INCREMENT,
  `capacidad` int(3) DEFAULT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_nivel`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `nivel`
--

INSERT INTO `nivel` (`id_nivel`, `capacidad`, `nombre`) VALUES
(1, 90, 'Nivel 1'),
(2, 90, 'Nivel 2'),
(3, 90, 'Nivel 3'),
(4, 90, 'Nivel 4'),
(5, 90, 'Nivel 5'),
(6, 90, 'Nivel 6'),
(7, 90, 'Nivel 7'),
(8, 90, 'Nivel 8'),
(9, 90, 'Nivel 9'),
(10, 90, 'Nivel 10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel_alumno`
--

DROP TABLE IF EXISTS `nivel_alumno`;
CREATE TABLE IF NOT EXISTS `nivel_alumno` (
  `id_rel` int(8) NOT NULL AUTO_INCREMENT,
  `nivel` int(2) DEFAULT NULL,
  `alumno` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`id_rel`),
  KEY `nivel` (`nivel`),
  KEY `alumno` (`alumno`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `nivel_alumno`
--

INSERT INTO `nivel_alumno` (`id_rel`, `nivel`, `alumno`) VALUES
(1, 1, '17690285');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

DROP TABLE IF EXISTS `profesores`;
CREATE TABLE IF NOT EXISTS `profesores` (
  `id_prof` int(4) NOT NULL AUTO_INCREMENT,
  `CURP` varchar(18) NOT NULL,
  `Nombre_profesor` varchar(60) NOT NULL,
  `password` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_prof`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`CURP`, `Nombre_profesor`) VALUES
('123456789012345678', 'Prueba prof'),
('098765432112345678', 'Profesor prueba 2'),
('098765432187654321', 'Profesor prueba 3'),
('QWERTYUIOP12345678', 'Profesor prueba 4'),
('MAHE990827HSPRRN02', 'Enrique Martinez Hernandez'),
('MAHE990827HSPRRN01', 'Eduardo Hernandez'),
('MAHE990827HSPRRN00', 'Enrique'),
('MAHE990827HSPRRN03', 'Enrique');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
