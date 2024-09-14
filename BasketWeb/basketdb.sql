-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-01-2024 a las 06:59:42
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `basketdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultado`
--

CREATE TABLE `resultado` (
  `idCalendario` int(11) NOT NULL,
  `EquipoGanador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbladministrador`
--

CREATE TABLE `tbladministrador` (
  `idOrganizador` int(11) NOT NULL,
  `vNombreCompleto` varchar(50) NOT NULL,
  `vUsuario` varchar(10) NOT NULL,
  `vContrasena` varchar(100) NOT NULL,
  `idRol` tinyint(1) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbladministrador`
--

INSERT INTO `tbladministrador` (`idOrganizador`, `vNombreCompleto`, `vUsuario`, `vContrasena`, `idRol`) VALUES
(1, 'UserAdministrador', 'BkAdmin', '$2y$10$6enVLvxfYb29nHQ8hskubOfZbaSGCqDmHezjAKN/EOWANVrk2EGt6', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblcalendario`
--

CREATE TABLE `tblcalendario` (
  `idCalendario` int(11) NOT NULL,
  `vEqLocal` varchar(20) NOT NULL,
  `vEqVisitante` varchar(20) NOT NULL,
  `vFecha` date NOT NULL,
  `vHora` time NOT NULL,
  `vSede` varchar(25) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `vTipoJuego` varchar(50) NOT NULL,
  `idTorneo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tblcalendario`
--

INSERT INTO `tblcalendario` (`idCalendario`, `vEqLocal`, `vEqVisitante`, `vFecha`, `vHora`, `vSede`, `idCategoria`, `vTipoJuego`, `idTorneo`) VALUES
(1, '1', '4', '2024-01-10', '19:00:00', 'Parque Martiniano', 4, 'Exhibicion', 1),
(2, '2', '3', '2024-01-12', '19:00:00', 'Polideportivo UAS', 1, 'Regular', 1),
(3, '4', '1', '2024-02-14', '13:00:00', 'Polideportivo UAS', 1, 'Exhibicion', 1),
(4, '3', '2', '2024-01-12', '20:00:00', 'Parque Martiniano', 1, 'Exhibicion', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblcategorias`
--

CREATE TABLE `tblcategorias` (
  `idCategoria` int(11) NOT NULL,
  `vCategoria` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tblcategorias`
--

INSERT INTO `tblcategorias` (`idCategoria`, `vCategoria`) VALUES
(1, '1ra Fuerza'),
(2, '2da Fuerza'),
(3, 'Libre'),
(4, 'Veteranos'),
(5, 'Empresarial'),
(6, 'Infantil'),
(7, 'Juvenil'),
(8, 'MiniBasket'),
(9, 'Femenil');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbldefault`
--

CREATE TABLE `tbldefault` (
  `idDefault` int(11) NOT NULL,
  `vPuntosDefault` tinyint(1) NOT NULL DEFAULT 1,
  `idEquipo` int(11) NOT NULL,
  `idCalendario` int(11) NOT NULL,
  `idTorneo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbldefault`
--

INSERT INTO `tbldefault` (`idDefault`, `vPuntosDefault`, `idEquipo`, `idCalendario`, `idTorneo`) VALUES
(1, 20, 3, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblequipos`
--

CREATE TABLE `tblequipos` (
  `idEquipo` int(11) NOT NULL,
  `vNombreEquipo` varchar(50) NOT NULL,
  `vImgEquipo` varchar(100) NOT NULL,
  `vNombreCapitan` varchar(50) NOT NULL,
  `vCorreoCapitan` varchar(50) NOT NULL,
  `vCelularCapitan` varchar(10) NOT NULL,
  `idGrupo` int(11) NOT NULL,
  `idTorneo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tblequipos`
--

INSERT INTO `tblequipos` (`idEquipo`, `vNombreEquipo`, `vImgEquipo`, `vNombreCapitan`, `vCorreoCapitan`, `vCelularCapitan`, `idGrupo`, `idTorneo`) VALUES
(1, 'Wizards', 'Eq0.jpg', 'Jorge Campos', 'JorgeCampos@gmail.com', '6698789898', 1, 1),
(2, 'Warriors', 'Eq01.jpg', 'Luis Estrada Ramos', 'LuisEstrad@gmail.com', '6694786556', 1, 1),
(3, 'Sacramento', 'Eq02.jpg', 'Isidoro Sanchez', 'Isidoro@gmail.com', '6698778877', 2, 1),
(4, 'Knicks', 'Eq03.jpg', 'Alfonso Aguilar', 'Alfonso@gmail.com', '6693578952', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblgrupos`
--

CREATE TABLE `tblgrupos` (
  `idGrupo` int(11) NOT NULL,
  `vNombreGrupo` varchar(25) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `idTorneo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tblgrupos`
--

INSERT INTO `tblgrupos` (`idGrupo`, `vNombreGrupo`, `idCategoria`, `idTorneo`) VALUES
(1, 'Grupo A', 1, 1),
(2, 'Grupo B', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblhistoricojugador`
--

CREATE TABLE `tblhistoricojugador` (
  `idHistoriCoJugador` int(11) NOT NULL,
  `vPuntosTotal` int(11) NOT NULL,
  `vTirosde3` int(11) NOT NULL,
  `vFaltas` int(11) NOT NULL,
  `idEquipo` int(11) NOT NULL,
  `idJugador` int(11) NOT NULL,
  `idCalendario` int(11) NOT NULL,
  `idTorneo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tblhistoricojugador`
--

INSERT INTO `tblhistoricojugador` (`idHistoriCoJugador`, `vPuntosTotal`, `vTirosde3`, `vFaltas`, `idEquipo`, `idJugador`, `idCalendario`, `idTorneo`) VALUES
(1, 25, 0, 0, 1, 4, 1, 1),
(2, 5, 2, 2, 1, 5, 1, 1),
(3, 15, 1, 3, 4, 6, 1, 1),
(4, 5, 2, 2, 4, 7, 1, 1),
(5, 30, 0, 1, 4, 6, 3, 1),
(6, 25, 0, 0, 4, 7, 3, 1),
(7, 15, 0, 2, 1, 4, 3, 1),
(8, 20, 0, 0, 1, 5, 3, 1),
(9, 5, 1, 0, 3, 8, 4, 1),
(10, 20, 0, 2, 3, 9, 4, 1),
(11, 40, 0, 2, 2, 1, 4, 1),
(12, 15, 1, 0, 2, 2, 4, 1),
(13, 10, 0, 1, 2, 3, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbljugadores`
--

CREATE TABLE `tbljugadores` (
  `idJugador` int(11) NOT NULL,
  `vNombreJugador` varchar(50) NOT NULL,
  `vApellidoJugador` varchar(50) NOT NULL,
  `vFechaNacimiento` date NOT NULL,
  `vCorreoJugador` varchar(50) NOT NULL,
  `vCelularJugador` varchar(15) NOT NULL,
  `vTipoSangre` varchar(15) NOT NULL,
  `vContactoEmergencia` varchar(15) NOT NULL,
  `vImgJugador` varchar(50) NOT NULL,
  `idGrupo` int(11) NOT NULL,
  `idTorneo` int(11) NOT NULL,
  `idEquipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbljugadores`
--

INSERT INTO `tbljugadores` (`idJugador`, `vNombreJugador`, `vApellidoJugador`, `vFechaNacimiento`, `vCorreoJugador`, `vCelularJugador`, `vTipoSangre`, `vContactoEmergencia`, `vImgJugador`, `idGrupo`, `idTorneo`, `idEquipo`) VALUES
(1, 'Jose Arturo', 'Gutierrez', '1999-02-01', 'Jose@gmail.com', '6699151235', 'A-', '6691456988', 'image (142).png', 1, 1, 2),
(2, 'Juan', 'Perez Garcia', '2001-02-02', 'PerezGarcia@gmail.com', '6696365456', 'A+', '6699665565', 'image (153).png', 1, 1, 2),
(3, 'Alfredo', 'Beltran', '2000-02-25', 'alfredo@gmail.com', '6691512078', 'A+', '6691456988', 'image (133).png', 1, 1, 2),
(4, 'Alfredo ', 'Morales Aramburo', '2001-08-16', 'AlfredoMa@gmail.com', '6698568662', 'O+', '6695866565', 'image (151).png', 1, 1, 1),
(5, 'Adrian', 'Millan Games', '2001-06-13', 'Adrian@gmail.com', '6956568874', 'A-', '6698926565', 'image (153).png', 1, 1, 1),
(6, 'Pedro Armando', 'Flores', '1999-01-14', 'Pedro@gmail.com', '6695635663', 'AB+', '6698987445', 'image (159).png', 2, 1, 4),
(7, 'Javier', 'Osuna', '2009-09-05', 'Armando@gmail.com', '6999266565', 'A-', '6698989892', 'image (150).png', 2, 1, 4),
(8, 'Marcos', 'Lopez Perez', '2009-01-31', 'Marcos@gmail.com', '6696356561', 'A-', '6698635656', 'image (138).png', 2, 1, 3),
(9, 'Emmnual', 'Carrazco', '2001-02-01', 'Emmanuel@gmail.com', '6698966656', 'A-', '6693655674', 'image (145).png', 2, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblpatrocinadores`
--

CREATE TABLE `tblpatrocinadores` (
  `idPatrocinador` int(11) NOT NULL,
  `vNombrePatrocinador` varchar(50) NOT NULL,
  `vImgPatrocinador` varchar(50) NOT NULL,
  `idTorneo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tblpatrocinadores`
--

INSERT INTO `tblpatrocinadores` (`idPatrocinador`, `vNombrePatrocinador`, `vImgPatrocinador`, `idTorneo`) VALUES
(1, 'Nike', 'Pa0.jpg', 1),
(2, 'Vans', 'Pa01.jpg', 1),
(3, 'Adidas', 'Pa03.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblrol`
--

CREATE TABLE `tblrol` (
  `idRol` int(11) NOT NULL,
  `vTipoUsario` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tblrol`
--

INSERT INTO `tblrol` (`idRol`, `vTipoUsario`) VALUES
(1, 'vAdministrador'),
(2, 'vOrganizador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbltorneos`
--

CREATE TABLE `tbltorneos` (
  `idTorneo` int(11) NOT NULL,
  `vNombreTorneo` varchar(50) NOT NULL,
  `vImagenTorneo` varchar(50) NOT NULL,
  `vSedeTorneo` varchar(25) NOT NULL,
  `vPremio01` varchar(25) NOT NULL,
  `vPremio02` varchar(25) NOT NULL,
  `vPremio03` varchar(25) NOT NULL,
  `vOtroPremio` varchar(25) NOT NULL,
  `vNombreOrganizador` varchar(40) NOT NULL,
  `vUsuarioOrganizador` varchar(10) NOT NULL,
  `vContrasenaOrganizador` varchar(255) NOT NULL,
  `vEstado` tinyint(1) NOT NULL DEFAULT 1,
  `idRol` tinyint(1) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbltorneos`
--

INSERT INTO `tbltorneos` (`idTorneo`, `vNombreTorneo`, `vImagenTorneo`, `vSedeTorneo`, `vPremio01`, `vPremio02`, `vPremio03`, `vOtroPremio`, `vNombreOrganizador`, `vUsuarioOrganizador`, `vContrasenaOrganizador`, `vEstado`, `idRol`) VALUES
(1, 'Apertura 2024', 'Bg-Logo04.jpg', 'Lopez Mateo', '10000', '5000', '2500', '1000', 'Juan Carlos Estrada', 'JuanCarl', '$2y$10$MA3e9Uq6hkIBTxnlwK413uEPWDly78jcf22GIdZ4K.Qj3CHSm1gY.', 1, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbladministrador`
--
ALTER TABLE `tbladministrador`
  ADD PRIMARY KEY (`idOrganizador`),
  ADD KEY `idRol` (`idRol`);

--
-- Indices de la tabla `tblcalendario`
--
ALTER TABLE `tblcalendario`
  ADD PRIMARY KEY (`idCalendario`),
  ADD KEY `idTorneo` (`idTorneo`),
  ADD KEY `idCategoria` (`idCategoria`);

--
-- Indices de la tabla `tbldefault`
--
ALTER TABLE `tbldefault`
  ADD PRIMARY KEY (`idDefault`),
  ADD KEY `idEquipo` (`idEquipo`),
  ADD KEY `idCalendario` (`idCalendario`),
  ADD KEY `idTorneo` (`idTorneo`);

--
-- Indices de la tabla `tblequipos`
--
ALTER TABLE `tblequipos`
  ADD PRIMARY KEY (`idEquipo`),
  ADD KEY `idGrupo` (`idGrupo`),
  ADD KEY `idTorneo` (`idTorneo`);

--
-- Indices de la tabla `tblgrupos`
--
ALTER TABLE `tblgrupos`
  ADD PRIMARY KEY (`idGrupo`),
  ADD KEY `idCategoria` (`idCategoria`),
  ADD KEY `idTorneo` (`idTorneo`);

--
-- Indices de la tabla `tblhistoricojugador`
--
ALTER TABLE `tblhistoricojugador`
  ADD PRIMARY KEY (`idHistoriCoJugador`);

--
-- Indices de la tabla `tbljugadores`
--
ALTER TABLE `tbljugadores`
  ADD PRIMARY KEY (`idJugador`),
  ADD KEY `idEquipo` (`idEquipo`),
  ADD KEY `idTorneo` (`idTorneo`),
  ADD KEY `idGrupo` (`idGrupo`);

--
-- Indices de la tabla `tblpatrocinadores`
--
ALTER TABLE `tblpatrocinadores`
  ADD PRIMARY KEY (`idPatrocinador`),
  ADD KEY `idTorneo` (`idTorneo`);

--
-- Indices de la tabla `tbltorneos`
--
ALTER TABLE `tbltorneos`
  ADD PRIMARY KEY (`idTorneo`),
  ADD KEY `idRol` (`idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbladministrador`
--
ALTER TABLE `tbladministrador`
  MODIFY `idOrganizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tblcalendario`
--
ALTER TABLE `tblcalendario`
  MODIFY `idCalendario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbldefault`
--
ALTER TABLE `tbldefault`
  MODIFY `idDefault` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tblequipos`
--
ALTER TABLE `tblequipos`
  MODIFY `idEquipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tblgrupos`
--
ALTER TABLE `tblgrupos`
  MODIFY `idGrupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tblhistoricojugador`
--
ALTER TABLE `tblhistoricojugador`
  MODIFY `idHistoriCoJugador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tbljugadores`
--
ALTER TABLE `tbljugadores`
  MODIFY `idJugador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tblpatrocinadores`
--
ALTER TABLE `tblpatrocinadores`
  MODIFY `idPatrocinador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbltorneos`
--
ALTER TABLE `tbltorneos`
  MODIFY `idTorneo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
