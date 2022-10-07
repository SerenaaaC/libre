-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-09-2022 a las 11:37:56
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gatones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gatos`
--

CREATE TABLE `gatos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `dueno` varchar(100) NOT NULL,
  `comida` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `gatos`
--

INSERT INTO `gatos` (`id`, `nombre`, `dueno`, `comida`) VALUES
(1, 'Rey', 'Ana', 'pescado'),
(2, 'Rayas', 'Juanillo', 'buey'),
(3, 'Pardo', 'Juanillo', 'pollo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maullidos`
--

CREATE TABLE `maullidos` (
  `id` int(11) NOT NULL,
  `maullido` varchar(100) NOT NULL,
  `sonido` varchar(100) NOT NULL,
  `gato_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL -- este campo ya no existe
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `maullidos`
--

INSERT INTO `maullidos` (`id`, `maullido`, `sonido`, `gato_id`, `post_id`) VALUES
(1, 'gruño', 'grrrrr', 1, 1),
(2, 'felicidad', 'mrrrrrr', 2, 2),
(3, 'cazar', 'oooowwwww', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `status` enum('pronunciado','silenciado') NOT NULL DEFAULT 'pronunciado',
  `content` varchar(100) NOT NULL,
  `gato_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`id`, `title`, `status`, `content`, `gato_id`) VALUES
(1, 'Estoy enfadado', 'pronunciado', 'grrrrr', 2),
(2, 'Qué placer es POLLO!', 'silenciado', 'mrrrrrr', 1),
(3, 'Huy eso no me lo esperaba!', 'pronunciado', 'oooowwwww', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `gatos`
--
ALTER TABLE `gatos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gato_id` (`id`);

--
-- Indices de la tabla `maullidos`
--
ALTER TABLE `maullidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gato_id_foreign` (`gato_id`) USING BTREE,
  ADD KEY `post_id_foreign` (`post_id`) USING BTREE;

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gato_id_foreign` (`gato_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `gatos`
--
ALTER TABLE `gatos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `maullidos`
--
ALTER TABLE `maullidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `gato_id_foreign` FOREIGN KEY (`gato_id`) REFERENCES `gatos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
