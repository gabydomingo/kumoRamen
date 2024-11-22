-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-11-2024 a las 07:07:15
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
-- Base de datos: `kumo_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `celular` int(30) NOT NULL,
  `mail` varchar(60) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasenia` varchar(50) NOT NULL,
  `tipo_usuario` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `apellido`, `celular`, `mail`, `usuario`, `contrasenia`, `tipo_usuario`) VALUES
(16, 'gaby', 'domingo', 2147483647, 'gaby@admin', 'gdomingo', '123', 1),
(17, 'tobias', 'alfonso', 2147483647, 'toto@mail', 'talfonso', '123', 0),
(18, 'lautaro', 'papaianni', 2147483647, 'lautaro@mail', 'lpapaiani', '123', 0),
(19, 'tobias', 'Domingo', 2147483647, 'tobias@gmail.com', 'El_perri', '1234', 0),
(20, 'agustin', 'lamendola', 564323, 'agus@mail', 'glamendola', '123', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resenias`
--

CREATE TABLE `resenias` (
  `id_resenia` int(60) NOT NULL,
  `calificacion` int(60) NOT NULL,
  `comentario` text NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `id_cliente` int(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resenias`
--

INSERT INTO `resenias` (`id_resenia`, `calificacion`, `comentario`, `imagen`, `id_cliente`) VALUES
(57, 1, 'el plato vino frio', 'img/img_resenia/VQ9B_DzHS_1200x0__1_1732250640.jpg', 18),
(58, 4, 'genial servicio', 'img/img_resenia/receta-ramen-casero_1732251651.jpg', 17),
(60, 5, 'prueba', 'img/img_resenia/Sin título_1732252209.png', 17),
(61, 3, 'sdsdsd ', 'img/img_resenia/receta-ramen-casero_1732254835.jpg', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `platos` varchar(60) NOT NULL,
  `cantidad_personas` int(60) NOT NULL,
  `telefono` varchar(60) NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(10) NOT NULL,
  `instrucciones` text NOT NULL,
  `id_cliente` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `platos`, `cantidad_personas`, `telefono`, `fecha`, `hora`, `instrucciones`, `id_cliente`) VALUES
(17, 'shoyu: 2, vegano: 6', 7, '911', '2024-11-23', '00:09', '', 17),
(18, 'shoyu: 1', 2, '123234234', '2024-11-30', '00:47', 'sudjdhjhs', 17),
(20, 'shoyu: 2, tantan: 4', 6, '564312', '2024-12-12', '08:15', 'klklkl', 17),
(21, 'shoyu: 5, miso: 1', 6, '1234567', '2024-12-16', '03:13', 'lorem', 20);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `resenias`
--
ALTER TABLE `resenias`
  ADD PRIMARY KEY (`id_resenia`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `idClientes` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `resenias`
--
ALTER TABLE `resenias`
  MODIFY `id_resenia` int(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `resenias`
--
ALTER TABLE `resenias`
  ADD CONSTRAINT `resenias_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
