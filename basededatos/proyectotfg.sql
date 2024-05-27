-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2024 a las 23:20:06
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
-- Base de datos: `proyectotfg`
--
CREATE DATABASE IF NOT EXISTS `proyectotfg` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `proyectotfg`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `contrasena` varchar(20) NOT NULL,
  `correo` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`dni`, `nombre`, `contrasena`, `correo`) VALUES
('00000000Z', 'SuperAdmin', '1234qwer', 'admin@1.com'),
('31017084C', 'Antonio Francisco Espejo Santofimia', '1234qwer', 'seiya666666@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adminfed`
--

CREATE TABLE `adminfed` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `contrasena` varchar(20) NOT NULL,
  `correo` varchar(40) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `adminfed`
--

INSERT INTO `adminfed` (`dni`, `nombre`, `contrasena`, `correo`, `estado`) VALUES
('11111111A', 'Administrador Andalucia', '1234qwer', 'adminAndalucia@gmail.com', 1),
('64051746N', 'Rafael Castillo', '1234qwer', 'adminRafa@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arbitro`
--

CREATE TABLE `arbitro` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `contrasena` varchar(20) NOT NULL,
  `correo` varchar(40) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `arbitro`
--

INSERT INTO `arbitro` (`dni`, `nombre`, `contrasena`, `correo`, `estado`) VALUES
('23685159N', 'Paco Garcia', '1234qwer', 'paco@gmail.com', 1),
('54622780B', 'Maria Ortiz', '1234qwer', 'maria@gmail.com', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idCategoria` int(11) NOT NULL,
  `idtorneo` int(11) NOT NULL,
  `sexo` varchar(1) NOT NULL,
  `peso` int(3) NOT NULL,
  `edad` varchar(15) NOT NULL,
  `modalidad` varchar(30) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `idtorneo`, `sexo`, `peso`, `edad`, `modalidad`, `estado`) VALUES
(1790, 49, 'm', 64, 'senior', 'lowkick', 1),
(1791, 49, 'm', 69, 'senior', 'lowkick', 1),
(1792, 49, 'm', 74, 'senior', 'lowkick', 1),
(1793, 49, 'm', 79, 'senior', 'lowkick', 1),
(1794, 49, 'm', 84, 'senior', 'lowkick', 1),
(1795, 49, 'm', 90, 'senior', 'lowkick', 1),
(1796, 50, 'm', 64, 'senior', 'lowkick', 1),
(1797, 50, 'm', 69, 'senior', 'lowkick', 1),
(1798, 50, 'm', 74, 'senior', 'lowkick', 1),
(1799, 50, 'm', 79, 'senior', 'lowkick', 1),
(1800, 50, 'm', 84, 'senior', 'lowkick', 1),
(1801, 50, 'm', 90, 'senior', 'lowkick', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `club`
--

CREATE TABLE `club` (
  `idclub` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `localidad` varchar(50) NOT NULL,
  `img` varchar(200) DEFAULT NULL,
  `latitud` double DEFAULT NULL,
  `longitud` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `club`
--

INSERT INTO `club` (`idclub`, `nombre`, `localidad`, `img`, `latitud`, `longitud`) VALUES
(1, 'Keikami1.0', 'Cordoba', '1_KeikamiLogo.png', 37.888072, -4.764885),
(2, 'Ponce Team', 'Cordoba', '', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coach`
--

CREATE TABLE `coach` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `contrasena` varchar(30) NOT NULL,
  `correo` varchar(40) NOT NULL,
  `club` int(11) NOT NULL,
  `licencia` int(11) NOT NULL,
  `estado` int(1) NOT NULL,
  `img` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `coach`
--

INSERT INTO `coach` (`dni`, `nombre`, `contrasena`, `correo`, `club`, `licencia`, `estado`, `img`) VALUES
('12345612M', 'Manuel Perez', '1234qwer', 'manuu@gmail.com', 1, 1676524, 0, ''),
('50243168J', 'Antonio Ponce', '1234qwer', 'ponce@gmail.com', 2, 1676524, 1, ''),
('70291704R', 'Emilio Lucena Flores', '1234qwer', 'emilio@gmail.com', 1, 2344554, 1, '88888888E_2019.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `competidores`
--

CREATE TABLE `competidores` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `contrasena` varchar(20) NOT NULL,
  `correo` varchar(40) NOT NULL,
  `fech_nac` date NOT NULL,
  `Catedad` varchar(30) NOT NULL,
  `licencia` int(11) NOT NULL,
  `club` int(11) NOT NULL,
  `peso` int(3) NOT NULL,
  `sexo` varchar(1) NOT NULL,
  `estado` int(1) NOT NULL,
  `img` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `competidores`
--

INSERT INTO `competidores` (`dni`, `nombre`, `contrasena`, `correo`, `fech_nac`, `Catedad`, `licencia`, `club`, `peso`, `sexo`, `estado`, `img`) VALUES
('00865253H', 'Cristian Lucena', '1234qwer', 'cristian@gmail.com', '1998-10-01', 'senior', 666666, 1, 64, 'm', 3, ''),
('12865456F', 'Francisco Cuesta', '1234qwer', 'juan@gmail.com', '1998-10-01', 'senior', 666666, 2, 74, 'm', 3, ''),
('31017084C', 'Antonio Espejo Santofimia', '1234qwer', 'seiya666666@gmail.com', '1998-10-04', 'senior', 123456789, 1, 74, 'm', 3, '31017084C_IMG-20240205-WA0040.jpg'),
('33865456T', 'Teodoro Ruiz', '1234qwer', 'teo@gmail.com', '1998-10-01', 'senior', 666666, 2, 74, 'm', 3, ''),
('46270399B', 'Tamara Muñoz Ortega', '1234qwer', 'tamara@gmail.com', '1998-02-12', 'senior', 42523452, 1, 59, 'f', 3, ''),
('54678943W', 'Pedro Moreno', '1234qwer', 'prueba@gmail.com', '1998-10-04', 'senior', 666666, 1, 74, 'm', 3, ''),
('55555555M', 'Maria de los Angeles Santofimia Dávila', '1234qwer', 'mariangeles@gmail.com', '1988-06-06', 'senior', 1676524, 1, 59, 'f', 3, ''),
('76865456Q', 'Juan Castro', '1234qwer', 'juan@gmail.com', '1998-10-01', 'senior', 666666, 1, 74, 'm', 3, ''),
('78657888Q', 'Alvaro Jimenez', '1234qwer', 'prueba@gmail.com', '1998-10-04', 'senior', 666666, 2, 74, 'm', 3, ''),
('83205587M', 'María del Mar Martinez', '1234qwer', 'ejemplo@gmail.com', '1999-07-08', 'senior', 1676524, 1, 59, 'f', 3, ''),
('99865256A', 'Adrian Matín', '1234qwer', 'adri@gmail.com', '1998-10-01', 'senior', 666666, 1, 64, 'm', 3, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enfrentamiento`
--

CREATE TABLE `enfrentamiento` (
  `idEnfrentamiento` int(11) NOT NULL,
  `dni1` varchar(9) DEFAULT NULL,
  `dni2` varchar(9) DEFAULT NULL,
  `puntos1` int(3) DEFAULT NULL,
  `puntos2` int(3) DEFAULT NULL,
  `ronda` int(3) NOT NULL,
  `idTorneo` int(11) NOT NULL,
  `peso` int(3) NOT NULL,
  `sexo` varchar(1) NOT NULL,
  `edad` varchar(30) NOT NULL,
  `modalidad` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `enfrentamiento`
--

INSERT INTO `enfrentamiento` (`idEnfrentamiento`, `dni1`, `dni2`, `puntos1`, `puntos2`, `ronda`, `idTorneo`, `peso`, `sexo`, `edad`, `modalidad`) VALUES
(2131, '99865256A', '00865253H', NULL, NULL, 1, 50, 64, 'm', 'senior', 'lowkick'),
(2132, '12865456F', '76865456Q', 34, 23, 3, 50, 74, 'm', 'senior', 'lowkick'),
(2133, '33865456T', '54678943W', 22, 11, 3, 50, 74, 'm', 'senior', 'lowkick'),
(2134, '31017084C', '78657888Q', 23, 15, 2, 50, 74, 'm', 'senior', 'lowkick'),
(2135, '12865456F', '33865456T', 12, 43, 2, 50, 74, 'm', 'senior', 'lowkick'),
(2136, '33865456T', '31017084C', 22, 24, 1, 50, 74, 'm', 'senior', 'lowkick');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion`
--

CREATE TABLE `gestion` (
  `idGestion` int(50) NOT NULL,
  `idTorneo` int(50) NOT NULL,
  `dniArbitro` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `gestion`
--

INSERT INTO `gestion` (`idGestion`, `idTorneo`, `dniArbitro`) VALUES
(23, 49, '23685159N'),
(25, 50, '23685159N');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registrado`
--

CREATE TABLE `registrado` (
  `idRegistro` int(11) NOT NULL,
  `dnicompetidor` varchar(9) NOT NULL,
  `idtorneo` int(4) NOT NULL,
  `sexo` varchar(1) NOT NULL,
  `peso` int(3) NOT NULL,
  `edad` varchar(30) NOT NULL,
  `modalidad` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `registrado`
--

INSERT INTO `registrado` (`idRegistro`, `dnicompetidor`, `idtorneo`, `sexo`, `peso`, `edad`, `modalidad`) VALUES
(77, '31017084C', 50, 'm', 74, 'senior', 'lowkick'),
(78, '33865456T', 50, 'm', 74, 'senior', 'lowkick'),
(79, '54678943W', 50, 'm', 74, 'senior', 'lowkick'),
(80, '78657888Q', 50, 'm', 74, 'senior', 'lowkick'),
(81, '12865456F', 50, 'm', 74, 'senior', 'lowkick'),
(82, '76865456Q', 50, 'm', 74, 'senior', 'lowkick'),
(83, '00865253H', 50, 'm', 64, 'senior', 'lowkick'),
(84, '99865256A', 50, 'm', 64, 'senior', 'lowkick');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneo`
--

CREATE TABLE `torneo` (
  `idtorneo` int(11) NOT NULL,
  `fechainscripcion` date DEFAULT NULL,
  `fechatorneo` date NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `estado` int(1) NOT NULL,
  `finalizado` int(1) NOT NULL,
  `plazas` int(3) DEFAULT 8
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `torneo`
--

INSERT INTO `torneo` (`idtorneo`, `fechainscripcion`, `fechatorneo`, `descripcion`, `estado`, `finalizado`, `plazas`) VALUES
(49, '2023-05-01', '2023-05-10', 'Copa Andalucía 2023', 0, 1, 8),
(50, '2024-05-05', '2024-05-18', 'Campeonato Andalucía 2024', 0, 1, 8);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adminfed`
--
ALTER TABLE `adminfed`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `arbitro`
--
ALTER TABLE `arbitro`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `club`
--
ALTER TABLE `club`
  ADD PRIMARY KEY (`idclub`);

--
-- Indices de la tabla `coach`
--
ALTER TABLE `coach`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `competidores`
--
ALTER TABLE `competidores`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `enfrentamiento`
--
ALTER TABLE `enfrentamiento`
  ADD PRIMARY KEY (`idEnfrentamiento`);

--
-- Indices de la tabla `gestion`
--
ALTER TABLE `gestion`
  ADD PRIMARY KEY (`idGestion`);

--
-- Indices de la tabla `registrado`
--
ALTER TABLE `registrado`
  ADD PRIMARY KEY (`idRegistro`);

--
-- Indices de la tabla `torneo`
--
ALTER TABLE `torneo`
  ADD PRIMARY KEY (`idtorneo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1808;

--
-- AUTO_INCREMENT de la tabla `club`
--
ALTER TABLE `club`
  MODIFY `idclub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `enfrentamiento`
--
ALTER TABLE `enfrentamiento`
  MODIFY `idEnfrentamiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2137;

--
-- AUTO_INCREMENT de la tabla `gestion`
--
ALTER TABLE `gestion`
  MODIFY `idGestion` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `registrado`
--
ALTER TABLE `registrado`
  MODIFY `idRegistro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de la tabla `torneo`
--
ALTER TABLE `torneo`
  MODIFY `idtorneo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
