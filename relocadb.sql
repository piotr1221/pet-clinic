-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-03-2022 a las 16:51:34
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `relocadb`
--
DROP DATABASE IF EXISTS `relocadb`;
CREATE DATABASE `relocadb`;
USE `relocadb`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `name`, `dni`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'xocrona', '11111111', '$2y$10$7B9lMqdtb3TubZrVHQeBluSKDn79BzUGhEANTefBq34/AZvmkbvYy', '2022-03-26 01:15:52', NULL, NULL),
(4, 'Xocrona', '11111112', '$2y$10$WbvEHPaZBegJdmM89ZwWpOa3CqLD/Sd2ho9Afo.GNSmg/1aefSYLe', '2022-03-26 01:17:06', NULL, NULL),
(5, 'Xocrona', '11111113', '$2y$10$I/kjnYBXQSflDx20JGt.e.etvNZueS/ctMoqLL9MrczMl6hSEgdLy', '2022-03-26 01:17:29', NULL, NULL),
(6, 'xocrona', '11111114', '$2y$10$kZj3FJgJsVb9n1ihpFD/teyewykQ1uWUKqpcwkydQzHkGNg428DDu', '2022-03-26 01:18:12', NULL, NULL),
(7, 'xocrona', '11111115', '$2y$10$HWcvcP/AdCyzzxnIaaeOburGKNDA9R4siUNaLeZ6WQY9ZdvrjYjwW', '2022-03-26 01:19:01', NULL, NULL),
(8, 'ra', '1', '$2y$10$o5wRyxck26lPR.K/1aaAQuMa30LEtUPrIIi3pmva6Ezb7L.rcFe4O', '2022-03-26 23:42:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `id` int(11) NOT NULL,
  `dni_perro` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `fecha_consulta` datetime NOT NULL DEFAULT current_timestamp(),
  `costo` double NOT NULL,
  `sintoma` longtext NOT NULL,
  `diagnostico` longtext NOT NULL,
  `medicacion` longtext DEFAULT NULL,
  `examen_sangre` longtext DEFAULT NULL,
  `is_payed` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`id`, `dni_perro`, `id_user`, `fecha_consulta`, `costo`, `sintoma`, `diagnostico`, `medicacion`, `examen_sangre`, `is_payed`) VALUES
(5, 20, 2, '2022-03-25 22:43:55', 100, 'S', 'D', 'M', 'E', 1),
(6, 20, 2, '2022-03-25 23:53:53', 150, 'S2                    ', 'D2                    ', 'M2                    ', 'E2                    ', 0),
(7, 21, 2, '2022-03-26 23:40:48', 23, 'S', 'D', 'M', 'E', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_archivos`
--

CREATE TABLE `consulta_archivos` (
  `id` int(11) NOT NULL,
  `id_consulta` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `consulta_archivos`
--

INSERT INTO `consulta_archivos` (`id`, `id_consulta`, `fecha_creacion`, `url`) VALUES
(4, 5, '2022-03-25 22:43:57', 'gs://reloca_taller_web/20/consultas/5/623e8bfbb11fa6.20148373.jpg'),
(5, 6, '2022-03-25 23:53:55', 'gs://reloca_taller_web/20/consultas/6/623e9c616716e1.22341044.jpg'),
(6, 6, '2022-03-25 23:53:55', 'gs://reloca_taller_web/20/consultas/6/623e9c62666ab7.57203892.jpg'),
(7, 7, '2022-03-26 23:40:49', 'gs://reloca_taller_web/21/consultas/7/623fead10591d6.80879486.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perro`
--

CREATE TABLE `perro` (
  `DNI` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Raza` varchar(255) NOT NULL,
  `Genero` int(11) NOT NULL,
  `FechaNacimiento` date NOT NULL,
  `Foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `perro`
--

INSERT INTO `perro` (`DNI`, `id_cliente`, `Nombre`, `Raza`, `Genero`, `FechaNacimiento`, `Foto`) VALUES
(0, 0, 'a', '', 0, '0000-00-00', ''),
(1, 0, 'Asd', 'Pitbull', 1, '2022-03-10', 'gs://reloca_taller_web/62337e77af0c58.58583306.jpg'),
(2, 0, 'Ra', 'Bulldog', 0, '2022-03-10', 'gs://reloca_taller_web/62337ee9e12f67.12548456.jpg'),
(3, 0, 'Ra', 'Pitbull', 1, '2022-03-16', 'gs://reloca_taller_web/623387895a85d5.53809763.jpg'),
(4, 0, 'Ra', 'Shichu', 1, '2022-03-15', 'gs://reloca_taller_web/6233884b2b9e99.82074586.jpg'),
(10, 0, 'Firulais', 'Pitbull', 1, '2022-03-16', 'gs://reloca_taller_web/6233cee52b0ab6.24102376.jpg'),
(20, 3, 'Xocrona', 'N/A', 1, '2022-03-25', 'gs://reloca_taller_web/20/623e3c4c169bb7.20461807.jpg'),
(21, 0, 'XD', 'Pequines', 0, '2022-03-26', 'gs://reloca_taller_web/21/623fea82afcf61.21036231.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `precio` double NOT NULL,
  `url` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `url`, `stock`) VALUES
(1, 'Plato Saturno', 'Plato con forma de Saturno para que tu perro juegue mientras obtiene sus croquetas', 16.5, 'gs://reloca_taller_web/productos/624126e1c363f4.62726350.jpg', 100),
(2, 'Plato Dispensador', 'Plato que suelta croquetas cuando tu perro juega con el', 18.5, 'gs://reloca_taller_web/productos/6241273b929cf9.97608618.jpg', 100),
(3, 'Juguete para masticar', 'Fijalo en el piso para que tu perro pueda jugar tirando de el', 13, 'gs://reloca_taller_web/productos/6241277d1583e5.18170939.jpg', 100),
(4, 'Jueguete para masticar con doble soporte', 'Fijalo en el piso para que tu perro tire de el. Cuenta con doble soporte para perros mas grandes.', 22, 'gs://reloca_taller_web/productos/624127b73e5ec1.86682329.jpg', 100),
(5, 'Bola para croquetas', 'Bola para que juegue tu perro mientras suelta croquetas', 15, 'gs://reloca_taller_web/productos/624127e6ee5b82.21020270.jpg', 98),
(8, 'Donas de peluche', 'Donas suaves de peluche para tu cachorro', 12, 'gs://reloca_taller_web/productos/6241c0bc50d885.16553393.jpg', 94);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `password`, `name`, `created_at`, `updated_at`, `deleted_at`, `is_deleted`, `is_admin`) VALUES
(1, 'ra@ra.com', '$2y$10$ZQpOpnFBsWmqfOggBTUUzOQCtVZJyeg2jzfrU21HLnRrMHFeEr3/.', 'ra', '2022-03-19 23:25:23', '2022-03-20 00:16:24', NULL, 0, 1),
(2, 'xocrona@gmail.com', '$2y$10$0otki29bOvYyT.G2iLwdS.ALxzdLAkFQwD5OH5yPaYkSPOR7ELqHm', 'xocrona', '2022-03-19 23:31:32', '2022-03-27 02:23:19', NULL, 0, 0),
(5, 'xd@xd.com', '$2y$10$GiU5idIkmr8pJb3TkyLNAeS/GsOAldqS7rYGWRouN7Xi6V0PBj1Ra', 'Asd', '2022-03-21 00:29:58', '2022-03-26 19:53:26', NULL, 1, 0),
(6, 'edwin@gmail.com', '$2y$10$NKWfssqz12jUwbSnWMe0OupVTpRSG2tQefzTr7EK7XPqa.UFXQZEi', 'edwin', '2022-03-21 18:33:28', NULL, NULL, 0, 0),
(10, 'admin@admin.com', '$2y$10$fKgDqgaVj/38rIfzbmjJXewUvGitdkXpdUTbxCZ/WunBzg0yU5edS', 'admin', '2022-03-25 13:02:32', '2022-03-25 19:01:52', '2022-03-25 19:01:52', 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni` (`dni`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dni_perro_fk` (`dni_perro`),
  ADD KEY `id_user_fk` (`id_user`);

--
-- Indices de la tabla `consulta_archivos`
--
ALTER TABLE `consulta_archivos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `perro`
--
ALTER TABLE `perro`
  ADD UNIQUE KEY `dni_unique` (`DNI`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `consulta_archivos`
--
ALTER TABLE `consulta_archivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `dni_perro_fk` FOREIGN KEY (`dni_perro`) REFERENCES `perro` (`DNI`),
  ADD CONSTRAINT `id_user_fk` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
