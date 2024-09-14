-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-01-2024 a las 06:45:11
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_zapatos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `eliminado` int(11) NOT NULL,
  `precio` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id`, `id_usuario`, `id_producto`, `cantidad`, `eliminado`, `precio`) VALUES
(1, 9, 4, 1, 1, 650),
(2, 9, 2, 1, 1, 732),
(3, 7, 5, 3, 0, 7497),
(4, 7, 4, 1, 0, 650),
(5, 8, 1, 1, 1, 1038.7),
(6, 8, 4, 5, 0, 3250),
(7, 9, 1, 2, 0, 2077.4),
(8, 8, 1, 2, 0, 2077.4),
(9, 9, 5, 1, 0, 2499),
(10, 10, 4, 1, 1, 650),
(11, 10, 1, 1, 1, 1038.7),
(12, 10, 2, 3, 1, 2196);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `id` int(11) NOT NULL,
  `comentario` varchar(700) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `id_producto` int(10) UNSIGNED NOT NULL,
  `eliminado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`id`, `comentario`, `fecha`, `id_usuario`, `id_producto`, `eliminado`) VALUES
(1, 'Eso tilin', '2023-12-12 05:44:34', 8, 1, 0),
(2, 'Hola soy un comentario de prueba para ver si funciona', '2023-12-12 23:41:55', 9, 4, 0),
(3, 'Soy otro comentario de prueba editado.', '2023-12-12 23:43:39', 9, 4, 0),
(4, 'Muy chulas se las comprare a mi novia <3', '2023-12-13 00:51:36', 8, 2, 0),
(5, 'Probando tambien y editando', '2023-12-13 02:16:16', 8, 4, 0),
(6, 'Actualizando comentario.', '2023-12-13 02:22:42', 7, 4, 0),
(7, 'Un nuevo comentario y editado', '2023-12-14 13:26:26', 8, 4, 1),
(8, 'probando fecha', '2024-01-05 23:43:32', 7, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `precio` double NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `existencia` int(11) NOT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `descuento` double DEFAULT 0,
  `eliminado` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `precio`, `descripcion`, `existencia`, `imagen`, `descuento`, `eliminado`) VALUES
(1, 'Tenis pumas', 1222, 'Zapatos pumas de color verde que cuentan con la ultima tecnología para correr como usain bolt o quizas hasta aun más rapido', 17, 'imagen-1.png', 15, 0),
(2, 'Zapatillas', 1220, 'Zapatillas rojas de muy buena calidad, son las que uso lady gaga en el concurso de belleza del 2010, muy comodas de usar y muy esteticas', 4, 'imagen-4.png', 40, 0),
(3, 'Zapatos nike', 4000, 'Son unos zapatos nike azules de muy buena calidad con tela de seda e importados de italia, ademas cuentan con una tecnología de espuma en la parte inferior (suela) para que se sienta aun más comodo al hacer cualquier actividad con ellos.', 5, 'imagen-3.png', 0, 0),
(4, 'Zapatos Nike', 1300, 'Son unos zapatos azules.', 3, 'imagen-3.png', 50, 0),
(5, 'Jordans', 2499, 'Son unos jordans rojos muy bonitos, con suela de adamantium que ayuda a poder brincar mas alto que cualquier basquetbolista profesional y estan autografiados por michael jackson', 0, 'imagen-7.png', 0, 0),
(6, 'Converse', 3100, 'Converse negros de muy buena calidad con toques de blanco para que se vean aun mas elegantes', 17, 'imagen-2.png', 0, 0),
(7, 'Zapatillas negras', 3500, 'Las elegantes zapatillas negras, bautizadas como \"Shadow Stealth\", son una fusión perfecta entre estilo y comodidad. Su diseño moderno y minimalista presenta una silueta aerodinámica que se adapta a cualquier ocasión. El tono negro intenso, imperturbable y atemporal, resalta la sofisticación de cada paso', 1, 'imagen-5.png', 0, 0),
(8, 'Zapatos Cafeses', 800, '\r\nLos cautivadores zapatos cafés, conocidos como \"Earth Essence\", encarnan la esencia de la elegancia informal. Su diseño único refleja la fusión entre la comodidad sin esfuerzo y la distinción sutil. El tono café, rico y cálido como la tierra, agrega un toque de naturalidad y calidez a cada paso', 7, 'imagen-6.png', 0, 0),
(9, 'Vans Negros', 4000, 'La parte superior de \"Urban Vibe\" está confeccionada con lona duradera y presenta el distintivo patrón de cuadros característico de Vans. La suela vulcanizada no solo brinda una estética distintiva sino también una tracción superior', 50, 'imagen-15.png', 10, 0),
(10, 'Zapatillas Beige', 2999, 'La parte superior de \"Neutral Chic\" está confeccionada con una mezcla de cuero sintético y tejido transpirable, ofreciendo durabilidad y frescura, La suela, diseñada para proporcionar un soporte excepcional, garantiza una experiencia de caminar cómoda y estable', 15, 'imagen-9.png', 25, 0),
(11, 'Addidas blancos', 3800, 'Adidas blancos \"Pure Classic\", símbolo de elegancia minimalista. Su diseño atemporal y comodidad excepcional hacen de estos sneakers la opción perfecta para estilo sin esfuerzo', 5, 'imagen-16.png', 8, 0),
(12, 'Addidas rojos', 1200, 'Adidas rojos y negros \"Dynamic Edge\", fusionando estilo audaz y comodidad. Un diseño llamativo y detalles negros contrastantes crean un look deportivo moderno.', 5, 'imagen-11.png', 43, 0),
(13, 'Zapatitos rojos', 599, 'Zapatitos rojos \"Dynamic Edge\", fusionando estilo audaz y comodidad. Un diseño llamativo y detalles negros contrastantes crean un look deportivo moderno y comodo.', 8, 'imagen-14.png', 5, 0),
(14, 'Zapato negro', 3300, 'Zapatos negros \"Elegance Noir\", esencia de sofisticación. Diseño atemporal para vestir con elegancia. Comodidad y estilo fusionados en cada paso.', 8, 'imagen-8.png', 20, 0),
(15, 'Converse Hipster', 2855, 'Converse \"Street Vibe\", la esencia del estilo casual. Diseño clásico en blanco y negro. Comodidad y versatilidad para una expresión auténtica en cada paso.', 16, 'imagen-12.png', 7, 0),
(16, 'Nikes rojos', 2999, 'Nike\"Street Focus\", la esencia del estilo casual. Diseño clásico en blanco y negro. Comodidad y versatilidad para una expresión auténtica en cada paso.', 16, 'imagen-13.png', 25, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `rol`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contrasenia` varchar(50) NOT NULL,
  `id_rol` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `correo`, `contrasenia`, `id_rol`) VALUES
(1, 'admin', 'admin@gmail.com', '74afd6b64658be03d2fa7e68383bf10803b28b12', 1),
(3, 'prueba', 'prueba2@gmail.com', '711383a59fda05336fd2ccf70c8059d1523eb41a', 2),
(4, 'admin2', 'admin2@gmail.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1),
(5, 'roberto', 'roberto@gmail.com', '012c19e100efd41a0d4d6353f289b99472719ff1', 2),
(7, 'Admin', 'admin@mail.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1),
(8, 'Daniel', 'daniel@mail.com', '53e1edf23f8fa287b94bdf174209287d94f5eac5', 2),
(9, 'test', 'tes@mail.com', 'b444ac06613fc8d63795be9ad0beaf55011936ac', 2),
(10, 'test do', 'test2@mail.com', '109f4b3c50d7b0df729d299bc6f8e9ef9066971f', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id` int(10) UNSIGNED NOT NULL,
  `cantidad_producto` int(11) NOT NULL,
  `total` double NOT NULL,
  `fecha` timestamp NULL DEFAULT current_timestamp(),
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `id_producto` int(10) UNSIGNED NOT NULL,
  `subtotal` double NOT NULL,
  `precio_real` double NOT NULL,
  `municipio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id`, `cantidad_producto`, `total`, `fecha`, `id_usuario`, `id_producto`, `subtotal`, `precio_real`, `municipio`) VALUES
(1, 3, 3660, '2023-01-18 18:46:15', 3, 2, 0, 0, ''),
(2, 7, 8540, '2023-01-20 15:33:19', 5, 2, 0, 0, ''),
(3, 32, 39040, '2023-01-20 15:36:23', 1, 2, 0, 0, ''),
(4, 1, 650, '2023-12-12 20:02:29', 8, 4, 0, 0, ''),
(5, 19, 12350, '2023-12-12 20:03:32', 9, 4, 0, 0, ''),
(6, 1, 650, '2023-12-12 20:07:27', 9, 4, 0, 0, ''),
(7, 3, 2196, '2023-12-14 03:23:09', 8, 2, 0, 0, ''),
(8, 3, 2196, '2023-12-14 03:33:10', 9, 2, 0, 0, ''),
(9, 3, 2150, '2024-01-06 22:26:46', 9, 4, 1950, 1300, 'concordia'),
(10, 1, 2699, '2024-01-07 02:26:37', 8, 5, 2499, 2499, 'concordia'),
(11, 3, 2396, '2024-01-07 03:22:35', 10, 2, 2196, 1220, 'mazatlan'),
(12, 1, 2855.15, '2024-01-07 03:54:47', 10, 15, 2655.15, 2855, 'concordia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_carrito`
--

CREATE TABLE `venta_carrito` (
  `id` int(11) NOT NULL,
  `total` double NOT NULL,
  `id_carrito` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `municipio` varchar(100) NOT NULL,
  `precio_unitario` double NOT NULL,
  `subtotal` double NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `venta_carrito`
--

INSERT INTO `venta_carrito` (`id`, `total`, `id_carrito`, `fecha`, `id_usuario`, `id_producto`, `municipio`, `precio_unitario`, `subtotal`, `cantidad`) VALUES
(7, 7401.4, 7, '2024-01-07 01:28:13', 9, 1, 'mazatlan', 0, 0, 0),
(8, 7401.4, 2, '2024-01-07 01:28:13', 9, 2, 'mazatlan', 0, 0, 0),
(9, 7401.4, 1, '2024-01-07 01:28:13', 9, 4, 'mazatlan', 0, 0, 0),
(10, 12146, 4, '2024-01-07 01:31:52', 7, 4, 'concordia', 0, 0, 0),
(11, 12146, 3, '2024-01-07 01:31:52', 7, 5, 'concordia', 0, 0, 0),
(12, 7826.7, 12, '2024-01-07 03:14:07', 10, 2, 'concordia', 0, 0, 3),
(13, 7826.7, 11, '2024-01-07 03:14:07', 10, 1, 'concordia', 0, 0, 1),
(14, 7826.7, 10, '2024-01-07 03:14:07', 10, 4, 'concordia', 0, 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `venta_carrito`
--
ALTER TABLE `venta_carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_carrito` (`id_carrito`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_producto` (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `venta_carrito`
--
ALTER TABLE `venta_carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
