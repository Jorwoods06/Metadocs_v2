-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 27-07-2025 a las 21:23:38
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
-- Base de datos: `metadocs`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id_actividad` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_visualizacion` datetime DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `tipo_actividad` varchar(255) DEFAULT NULL,
  `mensaje` varchar(255) DEFAULT NULL,
  `usuario_destinatario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id_actividad`, `id_usuario`, `fecha_visualizacion`, `fecha_creacion`, `tipo_actividad`, `mensaje`, `usuario_destinatario`) VALUES
(75, 26, NULL, '2025-06-23 21:52:42', 'expediente_rechazado', '{\"texto\":\"Tu expediente \'x\' fue rechazado\",\"motivo\":\"sssssssssssssssssssssss\",\"titulo_expediente\":\"x\"}', 'metadocs pruebas Bv'),
(76, 26, NULL, '2025-06-23 21:53:12', 'expediente_aprobado', '{\"texto\":\"Tu expediente \'aprobar\' fue aprobado con éxito\",\"titulo_expediente\":\"aprobar\"}', 'metadocs pruebas Bv'),
(77, 26, NULL, '2025-06-23 21:55:00', 'documento_aprobado', '{\"texto\":\"Tu documento \'Canal de distribución TaT\' fue aprobado con éxito\",\"titulo_documento\":\"Canal de distribución TaT\",\"categoria\":\"Operativos\",\"expediente_destino\":\"Aprobar\"}', 'metadocs pruebas Bv'),
(78, 26, NULL, '2025-06-23 21:55:06', 'documento_rechazado', '{\"texto\":\"Tu documento \'Anexo_Formato_vision_emprendedora[1]\' fue rechazado\",\"motivo\":\"peneeeeeeeeeeee\",\"titulo_documento\":\"Anexo_Formato_vision_emprendedora[1]\",\"categoria\":\"Soporte\",\"expediente_destino\":\"Aprobar\"}', 'metadocs pruebas Bv'),
(79, 26, NULL, '2025-06-23 21:56:49', 'solicitud_documento', '{\"categoria\":\"Estratégicos\",\"expediente_destinado\":\"Expediente\",\"descripcion\":\"sssssssssssssssssssss\"}', 'metadocs pruebas Bv'),
(80, 26, NULL, '2025-06-23 22:08:16', 'expediente_aprobado', '{\"texto\":\"Tu expediente \'s\' fue aprobado con éxito\",\"titulo_expediente\":\"s\"}', 'yelen yelencio'),
(81, 26, '2025-07-06 11:12:14', '2025-06-29 15:51:14', 'solicitud_documento', '{\"categoria\":\"Legales\",\"expediente_destinado\":\"Expediente\",\"descripcion\":\"xd\"}', 'metadocs pruebas Bv'),
(82, 26, NULL, '2025-06-29 16:50:58', 'documento_aprobado', '{\"texto\":\"Tu documento \'MY OWN INTERVIEW 1[1]\' fue aprobado con éxito\",\"titulo_documento\":\"MY OWN INTERVIEW 1[1]\",\"categoria\":\"Estratégicos\",\"expediente_destino\":\"aprobar\"}', 'metadocs pruebas Bv'),
(83, 26, NULL, '2025-06-29 16:51:00', 'documento_aprobado', '{\"texto\":\"Tu documento \'LISTENING CARDINAL NUMBERS AND NOMINAL NUMBERS\' fue aprobado con éxito\",\"titulo_documento\":\"LISTENING CARDINAL NUMBERS AND NOMINAL NUMBERS\",\"categoria\":\"Estratégicos\",\"expediente_destino\":\"aprobar\"}', 'metadocs pruebas Bv'),
(84, 26, NULL, '2025-06-29 17:14:06', 'expediente_rechazado', '{\"texto\":\"Tu expediente \'agh\' fue rechazado\",\"motivo\":\"xddddddddddddddd\",\"titulo_expediente\":\"agh\"}', 'metadocs pruebas Bv'),
(85, 26, NULL, '2025-06-29 17:16:33', 'expediente_aprobado', '{\"texto\":\"Tu expediente \'sx\' fue aprobado con éxito\",\"titulo_expediente\":\"sx\"}', 'metadocs pruebas Bv'),
(86, 26, NULL, '2025-06-29 17:19:56', 'documento_aprobado', '{\"texto\":\"Tu documento \'E- MAIL ADDRESSES\' fue aprobado con éxito\",\"titulo_documento\":\"E- MAIL ADDRESSES\",\"categoria\":\"Estratégicos\",\"expediente_destino\":\"aprobar\"}', 'metadocs pruebas Bv'),
(87, 26, NULL, '2025-06-29 17:19:58', 'documento_aprobado', '{\"texto\":\"Tu documento \'ALPHABET AND LINKS\' fue aprobado con éxito\",\"titulo_documento\":\"ALPHABET AND LINKS\",\"categoria\":\"Operativos\",\"expediente_destino\":\"aprobar\"}', 'metadocs pruebas Bv'),
(88, 26, NULL, '2025-06-29 17:19:59', 'documento_aprobado', '{\"texto\":\"Tu documento \'Riesgos_Laborales_Desarrollo__Software (1)\' fue aprobado con éxito\",\"titulo_documento\":\"Riesgos_Laborales_Desarrollo__Software (1)\",\"categoria\":\"Operativos\",\"expediente_destino\":\"aprobar\"}', 'metadocs pruebas Bv'),
(89, 26, NULL, '2025-06-29 17:20:00', 'documento_aprobado', '{\"texto\":\"Tu documento \'referencia_personal\' fue aprobado con éxito\",\"titulo_documento\":\"referencia_personal\",\"categoria\":\"Soporte\",\"expediente_destino\":\"aprobar\"}', 'metadocs pruebas Bv'),
(90, 26, '2025-06-29 21:45:16', '2025-06-29 20:53:38', 'expediente_aprobado', '{\"texto\":\"Tu expediente \'xddd\' fue aprobado con éxito\",\"titulo_expediente\":\"xddd\"}', 'metadocs pruebas Bv'),
(91, 26, NULL, '2025-07-12 15:26:02', 'documento_aprobado', '{\"texto\":\"Tu documento \'Documento archivado 13\' fue aprobado con éxito\",\"titulo_documento\":\"Documento archivado 13\",\"categoria\":\"Estratégicos\",\"expediente_destino\":\"aprobar\"}', 'jorge xd Galeano'),
(92, 26, NULL, '2025-07-12 15:26:19', 'expediente_aprobado', '{\"texto\":\"Tu expediente \'.\' fue aprobado con éxito\",\"titulo_expediente\":\".\"}', 'metadocs pruebas Bv'),
(93, 26, NULL, '2025-07-12 15:36:30', 'documento_aprobado', '{\"texto\":\"Tu documento \'Documento archivado 15\' fue aprobado con éxito\",\"titulo_documento\":\"Documento archivado 15\",\"categoria\":\"Estratégicos\",\"expediente_destino\":\"aprobar\"}', 'jorge xd Galeano'),
(94, 26, NULL, '2025-07-12 15:45:15', 'documento_aprobado', '{\"texto\":\"Tu documento \'bucles y arreglos kotlin\' fue aprobado con éxito\",\"titulo_documento\":\"bucles y arreglos kotlin\",\"categoria\":\"Estratégicos\",\"expediente_destino\":\"sdexo\"}', 'metadocs pruebas Bv'),
(95, 26, NULL, '2025-07-12 15:45:18', 'expediente_aprobado', '{\"texto\":\"Tu expediente \'xd\' fue aprobado con éxito\",\"titulo_expediente\":\"xd\"}', 'metadocs pruebas Bv'),
(96, 26, NULL, '2025-07-12 15:49:05', 'expediente_rechazado', '{\"texto\":\"Tu expediente \'asdjkas\' fue rechazado\",\"motivo\":\"por gayyyyyyy\",\"titulo_expediente\":\"asdjkas\"}', 'metadocs pruebas Bv'),
(97, 26, NULL, '2025-07-12 15:59:49', 'solicitud_documento', '{\"categoria\":\"Estratégicos\",\"expediente_destinado\":\"Expediente\",\"descripcion\":\"xd\"}', 'metadocs pruebas Bv'),
(98, 26, NULL, '2025-07-12 16:42:39', 'expediente_aprobado', '{\"texto\":\"Tu expediente \'adsdasd\' fue aprobado con éxito\",\"titulo_expediente\":\"adsdasd\"}', 'metadocs pruebas Bv'),
(99, 26, NULL, '2025-07-12 16:45:51', 'documento_aprobado', '{\"texto\":\"Tu documento \'1114240641_Jorge_Galeano_2825817\' fue aprobado con éxito\",\"titulo_documento\":\"1114240641_Jorge_Galeano_2825817\",\"categoria\":\"Estratégicos\",\"expediente_destino\":\"xd\"}', 'metadocs pruebas Bv'),
(100, 26, NULL, '2025-07-12 16:45:57', 'documento_rechazado', '{\"texto\":\"Tu documento \'1114240641_Jorge_Galeano_2825817\' fue rechazado\",\"motivo\":\"geyyyyyyyyy\",\"titulo_documento\":\"1114240641_Jorge_Galeano_2825817\",\"categoria\":\"Soporte\",\"expediente_destino\":\"que so\"}', 'metadocs pruebas Bv'),
(101, 26, NULL, '2025-07-12 16:46:02', 'expediente_rechazado', '{\"texto\":\"Tu expediente \'xd\' fue rechazado\",\"motivo\":\"jkasdaksdjasjkldjklasd\",\"titulo_expediente\":\"xd\"}', 'metadocs pruebas Bv'),
(102, 26, NULL, '2025-07-12 16:52:23', 'solicitud_documento', '{\"categoria\":\"Operativos\",\"expediente_destinado\":\"buscalo :v\",\"descripcion\":\"xd\"}', 'yelen yelencio'),
(103, 26, NULL, '2025-07-12 16:54:14', 'documento_aprobado', '{\"texto\":\"Tu documento \'bucles y arreglos kotlin\' fue aprobado con éxito\",\"titulo_documento\":\"bucles y arreglos kotlin\",\"categoria\":\"Soporte\",\"expediente_destino\":\"que so\"}', 'metadocs pruebas Bv'),
(104, 26, NULL, '2025-07-12 17:44:15', 'documento_rechazado', '{\"texto\":\"Tu documento \'1114240641_Jorge_Galeano_2825817.pdf\' fue rechazado\",\"motivo\":\"xdddddddddddddd\",\"titulo_documento\":\"1114240641_Jorge_Galeano_2825817.pdf\",\"categoria\":\"Legales\",\"expediente_destino\":\"que so\"}', 'metadocs pruebas Bv'),
(105, 26, NULL, '2025-07-12 18:11:07', 'solicitud_documento', '{\"categoria\":\"Legales\",\"expediente_destinado\":\"xd\",\"descripcion\":\"xd\"}', 'metadocs pruebas Bv');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area_acceso`
--

CREATE TABLE `area_acceso` (
  `id_area` int(11) NOT NULL,
  `nombre` enum('administracion','logistica','contabilidad','otro') DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `area_acceso`
--

INSERT INTO `area_acceso` (`id_area`, `nombre`, `fecha_creacion`) VALUES
(1, 'logistica', '2024-12-31 10:33:15'),
(2, 'contabilidad', '2025-01-05 08:59:58'),
(3, 'administracion', '2025-01-03 20:34:03'),
(4, 'otro', '2025-01-03 20:53:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contraseña_resets`
--

CREATE TABLE `contraseña_resets` (
  `reset_id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expira_en` datetime NOT NULL,
  `creado_en` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contraseña_resets`
--

INSERT INTO `contraseña_resets` (`reset_id`, `id_usuario`, `token`, `expira_en`, `creado_en`) VALUES
(32, 26, 'ae36ca2a68779bedfc670946528f910fa5093a291f611385f21f37f9151412c9', '2025-03-13 19:41:29', '2025-03-13 12:41:29'),
(34, 26, '9e5d77c4fcb42feb413cbf455bf3cdcf6ced38d19f96d93b08d136f1279a6b53', '2025-05-05 03:26:27', '2025-05-04 19:26:27'),
(38, 26, 'c6c2f6cd1ca58b3ea5a9d1111a1d5509adb77036b0e490b72ee57f89a26eb440', '2025-05-21 05:08:37', '2025-05-20 21:08:37'),
(40, 26, '69a93d8ec30e56f0e80744351ce30fd6476b564ab5d3febee2cc591bb429a25a', '2025-05-22 19:34:53', '2025-05-22 11:34:53'),
(45, 26, '008210ea09d069807e41ea355d3e4360b793a1d541bd96fb0f4048c01dceb30a', '2025-05-22 20:06:45', '2025-05-22 12:06:45'),
(47, 26, '2e44bb7cdb786c628e0ace06886da751a05cfa62fefd2330ced54e35801d0565', '2025-05-24 04:02:19', '2025-05-23 20:02:19'),
(49, 26, '91fceb0fe5da9462fa16b7a4796ba5c0399172c52a9c3f4fa4ac59c676f764bf', '2025-05-28 04:38:24', '2025-05-27 20:38:24'),
(50, 26, '2d18d2e286982609e6b3bf4612af1871521998c98de27e395e6879b604eb15ca', '2025-05-28 05:09:55', '2025-05-27 21:09:55'),
(54, 26, 'a943fc12258e1dbfcb99c5dba386c8d06609f16abf4f0b9307e30d26b45fbf16', '2025-05-28 05:38:02', '2025-05-27 21:38:02'),
(55, 26, '82a322b3a0d17c6aacca7001e047784e9a1d5b368efbd74d5789c13956fdf93f', '2025-05-28 05:38:06', '2025-05-27 21:38:06'),
(59, 26, '2640ca95770e6a2fbda458c8b397705856e1836855354bc330b4de1c97844636', '2025-06-03 01:11:56', '2025-06-02 17:11:56'),
(61, 26, 'dd6b809983fa711534ef38e6561e080290434fe80ec957664d4f366ce62447ed', '2025-06-03 01:27:13', '2025-06-02 17:27:13'),
(62, 51, '5621162622945354cae37c87e3c9bba36880d26f5eb34c7de78a30b2f2296784', '2025-06-05 04:02:21', '2025-06-04 20:02:21'),
(63, 26, 'd9065108967cf0bf08ffe4a86dd3fc00a8bcfa6e9951c126a58afd400e885e8a', '2025-06-10 20:59:55', '2025-06-10 12:59:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id_documento` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL DEFAULT current_timestamp(),
  `id_expediente` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `estado` enum('aprobado','revision','rechazado') DEFAULT NULL,
  `autor` int(255) DEFAULT NULL,
  `estado_retencion` enum('archivado','activo') DEFAULT NULL,
  `id_retencion` int(11) DEFAULT NULL,
  `fin_retencion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id_documento`, `fecha_creacion`, `id_expediente`, `id_area`, `titulo`, `path`, `tipo`, `estado`, `autor`, `estado_retencion`, `id_retencion`, `fin_retencion`) VALUES
(135, '2025-06-29', 118, 4, 'MY OWN INTERVIEW 1[1]', '../../uploads/MY OWN INTERVIEW 1[1].docx', 'docx', 'aprobado', 40, 'activo', 1, '2026-11-29'),
(136, '2025-06-29', 118, 2, 'LISTENING CARDINAL NUMBERS AND NOMINAL NUMBERS', '../../uploads/LISTENING CARDINAL NUMBERS AND NOMINAL NUMBERS.docx', 'docx', 'aprobado', 40, 'activo', 1, '2026-11-29'),
(137, '2025-06-29', 118, 4, 'E- MAIL ADDRESSES', '../../uploads/E- MAIL ADDRESSES.docx', 'docx', 'aprobado', 40, 'activo', 1, '2026-11-29'),
(138, '2025-06-29', 118, 4, 'ALPHABET AND LINKS', '../../uploads/ALPHABET AND LINKS.docx', 'docx', 'aprobado', 40, 'activo', 2, '2035-06-29'),
(139, '2025-06-29', 118, 4, 'referencia_personal', '../../uploads/referencia_personal.docx', 'docx', 'aprobado', 40, 'activo', 3, '2026-06-29'),
(140, '2025-06-29', 118, 4, 'Riesgos_Laborales_Desarrollo__Software (1)', '../../uploads/Riesgos_Laborales_Desarrollo__Software (1).docx', 'docx', 'aprobado', 40, 'activo', 2, '2035-06-29'),
(141, '2025-06-29', 118, 4, 'Documento archivado 1', '../uploads/Documento_archivado_1.docx', 'docx', 'aprobado', 26, 'archivado', 1, '2030-06-29'),
(142, '2025-06-29', 118, 4, 'Documento archivado 2', '../uploads/Documento_archivado_2.docx', 'docx', 'aprobado', 26, 'archivado', 1, '2030-06-29'),
(143, '2025-06-29', 118, 4, 'Documento archivado 3', '../uploads/Documento_archivado_3.docx', 'docx', 'aprobado', 26, 'archivado', 1, '2030-06-29'),
(144, '2025-06-29', 118, 4, 'Documento archivado 4', '../uploads/Documento_archivado_4.docx', 'docx', 'aprobado', 26, 'archivado', 1, '2030-06-29'),
(145, '2025-06-29', 118, 4, 'Documento archivado 5', '../uploads/Documento_archivado_5.docx', 'docx', 'aprobado', 26, 'archivado', 1, '2030-06-29'),
(146, '2025-06-29', 118, 4, 'Documento archivado 6', '../uploads/Documento_archivado_6.docx', 'docx', 'aprobado', 26, 'archivado', 1, '2030-06-29'),
(147, '2025-06-29', 118, 4, 'Documento archivado 7', '../uploads/Documento_archivado_7.docx', 'docx', 'aprobado', 26, 'archivado', 1, '2030-06-29'),
(148, '2025-06-29', 118, 4, 'Documento archivado 8', '../uploads/Documento_archivado_8.docx', 'docx', 'aprobado', 26, 'archivado', 1, '2030-06-29'),
(149, '2025-06-29', 118, 4, 'Documento archivado 9', '../uploads/Documento_archivado_9.docx', 'docx', 'aprobado', 26, 'archivado', 1, '2030-06-29'),
(150, '2025-06-29', 118, 4, 'Documento archivado 10', '../uploads/Documento_archivado_10.docx', 'docx', 'aprobado', 26, 'archivado', 1, '2030-06-29'),
(151, '2025-06-29', 118, 4, 'Documento archivado 11', '../uploads/Documento_archivado_11.docx', 'docx', 'aprobado', 26, 'archivado', 1, '2030-06-29'),
(152, '2025-06-29', 118, 4, 'Documento archivado 12', '../uploads/Documento_archivado_12.docx', 'docx', 'aprobado', 26, 'activo', 1, '2030-06-29'),
(153, '2025-06-29', 118, 4, 'Documento archivado 13', '../uploads/Documento_archivado_13.docx', 'docx', 'aprobado', 26, 'archivado', 1, '2030-06-29'),
(154, '2025-06-29', 118, 4, 'Documento archivado 14', '../uploads/Documento_archivado_14.docx', 'docx', 'aprobado', 26, 'archivado', 1, '2030-06-29'),
(155, '2025-06-29', 118, 4, 'Documento archivado 15', '../uploads/Documento_archivado_15.docx', 'docx', 'aprobado', 26, 'archivado', 1, '2030-06-29'),
(156, '2025-07-12', 118, 4, 'bucles y arreglos kotlin', '../../uploads/bucles y arreglos kotlin.docx', 'docx', 'aprobado', 40, 'activo', 1, '2026-12-12'),
(157, '2025-07-12', 133, 4, '1114240641_Jorge_Galeano_2825817', '../../uploads/1114240641_Jorge_Galeano_2825817.pdf', 'pdf', 'aprobado', 40, 'activo', 1, '2026-12-12'),
(158, '2025-07-12', 120, 4, '1114240641_Jorge_Galeano_2825817', '../../uploads/1114240641_Jorge_Galeano_2825817_(1).pdf', 'pdf', 'rechazado', 40, 'activo', 3, '2026-07-12'),
(159, '2025-07-12', 120, 4, 'bucles y arreglos kotlin', '../../uploads/bucles y arreglos kotlin_(1).docx', 'docx', 'aprobado', 40, 'activo', 3, '2026-07-12'),
(160, '2025-07-12', 120, 4, '1114240641_Jorge_Galeano_2825817.pdf', '../../uploads/1114240641_Jorge_Galeano_2825817.pdf.docx', 'docx', 'rechazado', 40, 'activo', 4, '2026-07-12');

--
-- Disparadores `documentos`
--
DELIMITER $$
CREATE TRIGGER `trigger_verificar_retencion` BEFORE INSERT ON `documentos` FOR EACH ROW BEGIN
    -- Si la fecha de fin de retención ya pasó, cambiar automáticamente a archivado
    IF NEW.fin_retencion <= CURDATE() AND NEW.estado_retencion = 'activo' THEN
        SET NEW.estado_retencion = 'archivado';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trigger_verificar_retencion_update` BEFORE UPDATE ON `documentos` FOR EACH ROW BEGIN
    -- Si la fecha de fin de retención ya pasó, cambiar automáticamente a archivado
    IF NEW.fin_retencion <= CURDATE() AND NEW.estado_retencion = 'activo' THEN
        SET NEW.estado_retencion = 'archivado';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expedientes`
--

CREATE TABLE `expedientes` (
  `id_expediente` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_creacion` date DEFAULT current_timestamp(),
  `expediente_padre` int(11) DEFAULT NULL,
  `id_area` int(11) DEFAULT NULL,
  `estado` enum('aprobado','revision','rechazado') DEFAULT NULL,
  `autor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `expedientes`
--

INSERT INTO `expedientes` (`id_expediente`, `nombre`, `descripcion`, `fecha_creacion`, `expediente_padre`, `id_area`, `estado`, `autor`) VALUES
(80, 'Expediente', 'dxd', '2025-06-19', 0, 4, 'aprobado', 40),
(83, 'Prueba ', 'Prueba ', '2025-06-21', 80, 4, 'aprobado', 40),
(89, 'Prueba para aprobar ', 'Prueba ', '2025-06-22', 0, 4, 'rechazado', 40),
(90, 'Prueba para rechazar ', 'Prueba ', '2025-06-22', 0, 4, 'rechazado', 40),
(91, 'Expedienté prueba aprobar ', 'Xdp', '2025-06-23', 0, 4, 'aprobado', 40),
(92, 'Pruebas notificación ', 'Ptm', '2025-06-23', 0, 4, 'aprobado', 40),
(93, 'Que', 'So', '2025-06-23', 0, 4, 'aprobado', 40),
(94, 'Prueba', 'Sos', '2025-06-23', 0, 4, 'aprobado', 40),
(95, 'Vppp', 'H', '2025-06-23', 0, 4, 'rechazado', 40),
(96, 'Putq', 'Egh', '2025-06-23', 0, 4, 'rechazado', 40),
(97, 'Vrcct', 'Vtcyv', '2025-06-23', 0, 4, 'rechazado', 40),
(98, 'Vrcct', 'Vtcyv', '2025-06-23', 0, 4, 'rechazado', 40),
(99, 'Vrcct', 'Vtcyv', '2025-06-23', 0, 4, 'rechazado', 40),
(100, 'Prueba 1', 'Prueba ', '2025-06-23', 0, 4, 'rechazado', 40),
(101, 'Prueba 2', 'Sea', '2025-06-23', 0, 4, 'aprobado', 40),
(102, 'Prueba ', 'D', '2025-06-23', 80, 4, 'rechazado', 40),
(103, 'pene', 'xd', '2025-06-23', 0, 4, 'aprobado', 40),
(104, 'xd', 'xd', '2025-06-23', 0, 4, 'aprobado', 40),
(105, 'xd', 'xdd', '2025-06-23', 0, 4, 'aprobado', 40),
(106, 'prueba', 'prueba', '2025-06-23', 0, 4, 'rechazado', 40),
(107, 'a', 'as', '2025-06-23', 103, 4, 'aprobado', 40),
(108, 'Hola', 'Xd', '2025-06-23', 103, 4, 'aprobado', 40),
(109, 'Rechazar ', 'Lol', '2025-06-23', 103, 4, 'rechazado', 40),
(110, 'G', 'G', '2025-06-23', 0, 4, 'aprobado', 40),
(111, 's', 's', '2025-06-23', 0, 4, 'aprobado', 40),
(112, 'xdd', 'xdd', '2025-06-23', 0, 4, 'rechazado', 40),
(113, 's', 'dsa', '2025-06-23', 0, 4, 'aprobado', 40),
(114, 'asdas', 'asdasdsa', '2025-06-23', 0, 4, 'rechazado', 40),
(115, 'xd', 'xd', '2025-06-23', 0, 4, 'rechazado', 40),
(116, 'xdas', 'asdas', '2025-06-23', 0, 4, 'aprobado', 40),
(117, 'x', 'x', '2025-06-23', 0, 4, 'rechazado', 40),
(118, 'aprobar ', 'asd', '2025-06-23', 0, 4, 'aprobado', 40),
(119, 's', 's', '2025-06-23', 0, 4, 'aprobado', 53),
(120, 'que so ', 'xd', '2025-06-29', 0, 4, 'aprobado', 26),
(121, 'xd', 'xd', '2025-06-29', 118, 4, 'aprobado', 40),
(122, '._.', 'xd', '2025-06-29', 118, 4, 'aprobado', 40),
(123, 'vea', 'vea', '2025-06-29', 118, 4, 'aprobado', 40),
(124, '.-.', 'xd', '2025-06-29', 118, 4, 'aprobado', 40),
(125, 'xd', 'xd', '2025-06-29', 0, 4, 'aprobado', 40),
(126, 'agh', 'xd', '2025-06-29', 0, 4, 'rechazado', 40),
(127, 'xd', 'xd', '2025-06-29', 0, 4, 'aprobado', 40),
(128, 'sx', 'sx', '2025-06-29', 0, 4, 'aprobado', 40),
(129, 'xddd', 'xddd', '2025-06-29', 0, 4, 'aprobado', 40),
(130, 'sdexo', 'vea', '2025-07-06', 0, 4, 'aprobado', 40),
(131, 'hola', 'xd', '2025-07-06', 0, 4, 'aprobado', 40),
(132, 'xd', 'xd', '2025-07-06', 0, 4, 'aprobado', 40),
(133, 'xd', 'xd', '2025-07-12', 0, 4, 'aprobado', 40),
(134, 'asdjkas', 'xddd', '2025-07-12', 0, 4, 'rechazado', 40),
(135, 'xd', 'xd', '2025-07-12', 0, 4, 'rechazado', 40),
(136, 'adsdasd', 'asdasd', '2025-07-12', 0, 4, 'aprobado', 40),
(137, 'xd', 'xd', '2025-07-12', 120, 4, 'revision', 40),
(138, 'xd', 'xd', '2025-07-12', 120, 4, 'revision', 40),
(139, 'que ._.', 'xd', '2025-07-12', 0, 4, 'revision', 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_archivado`
--

CREATE TABLE `log_archivado` (
  `id` int(11) NOT NULL,
  `fecha_proceso` date NOT NULL,
  `documentos_archivados` int(11) NOT NULL,
  `fecha_ejecucion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `log_archivado`
--

INSERT INTO `log_archivado` (`id`, `fecha_proceso`, `documentos_archivados`, `fecha_ejecucion`) VALUES
(1, '2025-06-23', 0, '2025-06-24 03:56:18'),
(2, '2025-06-23', 0, '2025-06-24 04:05:58'),
(3, '2025-06-23', 0, '2025-06-24 04:05:58'),
(4, '2025-06-23', 0, '2025-06-24 04:10:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pista_auditoria`
--

CREATE TABLE `pista_auditoria` (
  `id_auditoria` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `accion` varchar(255) DEFAULT NULL,
  `fecha_accion` datetime DEFAULT NULL,
  `entidad` varchar(255) DEFAULT NULL,
  `entidad_id` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `rol` enum('documentador','auditor') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pista_auditoria`
--

INSERT INTO `pista_auditoria` (`id_auditoria`, `id_area`, `accion`, `fecha_accion`, `entidad`, `entidad_id`, `id_usuario`, `rol`) VALUES
(9, 4, 'subió', '2025-07-12 16:42:26', 'expediente', 136, 40, NULL),
(10, 4, 'aprobó', '2025-07-12 16:42:39', 'expediente', 136, 26, 'auditor'),
(14, 4, 'aprobó', '2025-07-12 16:45:51', 'documento', 157, 26, 'auditor'),
(15, 4, 'rechazó', '2025-07-12 16:45:57', 'documento', 158, 26, 'auditor'),
(16, 4, 'rechazó', '2025-07-12 16:46:02', 'expediente', 135, 26, 'auditor'),
(17, 4, 'editó', '2025-07-12 16:48:36', 'expediente', 118, 26, 'auditor'),
(18, 4, 'subió', '2025-07-12 16:50:47', 'documento', 160, 40, 'documentador'),
(19, 4, 'subió', '2025-07-12 16:50:51', 'expediente', 138, 40, 'documentador'),
(20, 4, 'solicitó', '2025-07-12 16:52:23', 'documento', 102, 26, 'auditor'),
(21, 4, 'aprobó', '2025-07-12 16:54:14', 'documento', 159, 26, 'auditor'),
(22, 4, 'rechazó', '2025-07-12 17:44:15', 'documento', 160, 26, 'auditor'),
(23, 4, 'solicito', '2025-07-12 18:11:07', 'documento', 105, 26, 'auditor'),
(24, 4, 'subió', '2025-07-12 18:36:52', 'expediente', 139, 40, 'documentador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retencion`
--

CREATE TABLE `retencion` (
  `id_retencion` int(11) NOT NULL,
  `categoria` enum('Estratégicos','Operativos','Soporte','Legales','Financieros','Correspondencia') DEFAULT NULL,
  `duracion_año` int(11) DEFAULT NULL,
  `duracion_mes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `retencion`
--

INSERT INTO `retencion` (`id_retencion`, `categoria`, `duracion_año`, `duracion_mes`) VALUES
(1, 'Estratégicos', 1, 5),
(2, 'Operativos', 10, 0),
(3, 'Soporte', 1, 0),
(4, 'Legales', 1, 0),
(5, 'Financieros', 1, 0),
(6, 'Correspondencia', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion_fisico`
--

CREATE TABLE `ubicacion_fisico` (
  `id_ubicacion` int(11) NOT NULL,
  `tipo_ubicacion` enum('Archivo','Estante','Caja','Bóveda','Otro') DEFAULT NULL,
  `id_documento` int(11) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `edificio` enum('principal','anexo_a','anexo_b','deposito','archivo_central') DEFAULT NULL,
  `piso` enum('sotano','planta_baja','primer_piso','segundo_piso','tercer_piso','cuarto_piso') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubicacion_fisico`
--

INSERT INTO `ubicacion_fisico` (`id_ubicacion`, `tipo_ubicacion`, `id_documento`, `observaciones`, `edificio`, `piso`) VALUES
(61, 'Archivo', 135, '', 'principal', 'sotano'),
(62, 'Archivo', 136, 'xd', 'principal', 'sotano'),
(63, 'Archivo', 137, '', 'anexo_a', 'primer_piso'),
(64, 'Estante', 138, 'xd', 'anexo_b', 'tercer_piso'),
(65, 'Estante', 139, '', 'anexo_a', 'primer_piso'),
(66, 'Estante', 140, '', 'anexo_a', 'primer_piso'),
(67, 'Estante', 156, 'xddd', 'anexo_a', 'sotano'),
(68, 'Archivo', 157, 'xdd', 'principal', 'planta_baja'),
(69, 'Estante', 158, 'xd', 'anexo_b', 'tercer_piso'),
(70, 'Estante', 159, 'xd', 'anexo_a', 'segundo_piso'),
(71, 'Estante', 160, 'xd', 'anexo_b', 'segundo_piso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `rol` enum('administrador','visualizador','documentador','auditor') NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contraseña` varchar(50) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_area` int(11) NOT NULL,
  `cedula` varchar(20) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `rol`, `nombres`, `apellidos`, `correo`, `contraseña`, `fecha_creacion`, `fecha_actualizacion`, `id_area`, `cedula`, `telefono`, `estado`) VALUES
(26, 'auditor', 'jorge xd', 'Galeano', 'jorgemulato206@gmail.com', 'e0a0bbdf18ef381b4c5924026a79bb06', '2025-01-03 20:34:03', '2025-06-15 16:57:14', 4, '1114240641', '3145062530', 'activo'),
(40, 'documentador', 'metadocs pruebas', 'Bv', 'metadocs7@gmail.com', 'e13453ceb91a91816509a2b74ff97785', '2025-01-11 17:14:45', '2025-06-29 15:49:49', 4, '159', '3145062530', 'activo'),
(51, 'administrador', 'Jorge Admin', 'Admin', 'dg244049@gmail.com', '5a0f035db329cea241ae3509ad2b824f', '2025-06-02 17:15:57', '2025-06-15 10:08:06', 3, '14445454', '314506253', 'activo'),
(52, 'documentador', 'root', 'admin', 'pruebaroot@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2025-06-03 07:21:45', '2025-06-23 09:00:32', 2, '1444464664', '3201542078', 'activo'),
(53, 'documentador', 'yelen', 'yelencio', 'yelen@gmail.com', '3b7aab6f0b5bb0d8855e5acc6c6d7eb2', '2025-06-15 10:13:55', '2025-06-23 01:50:02', 4, '1444464664', '123456789', 'activo'),
(54, 'administrador', 'Daniel Alejandro', 'xd', 'daniel@gmail.com', 'b5ea8985533defbf1d08d5ed2ac8fe9b', '2025-06-17 11:05:51', '2025-06-26 19:07:15', 3, '1444464664', '3201542078', 'activo'),
(55, 'administrador', 'Daniel Alejandro', 'anardo', 'rosero1@gmail.com', '1d518dbb0a2a3b47e520a136cfaea8fd', '2025-06-24 08:27:17', '2025-06-24 08:27:27', 1, '1444464664', '3201542078', 'inactivo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id_actividad`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `area_acceso`
--
ALTER TABLE `area_acceso`
  ADD PRIMARY KEY (`id_area`);

--
-- Indices de la tabla `contraseña_resets`
--
ALTER TABLE `contraseña_resets`
  ADD PRIMARY KEY (`reset_id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id_documento`),
  ADD KEY `id_expediente` (`id_expediente`),
  ADD KEY `id_area` (`id_area`),
  ADD KEY `fk_autor_documento` (`autor`),
  ADD KEY `fk_retencion_doc` (`id_retencion`);

--
-- Indices de la tabla `expedientes`
--
ALTER TABLE `expedientes`
  ADD PRIMARY KEY (`id_expediente`),
  ADD KEY `fk_expediente_area` (`id_area`),
  ADD KEY `fk_autor_usuario` (`autor`);

--
-- Indices de la tabla `log_archivado`
--
ALTER TABLE `log_archivado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pista_auditoria`
--
ALTER TABLE `pista_auditoria`
  ADD PRIMARY KEY (`id_auditoria`),
  ADD KEY `idx_id_area` (`id_area`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `retencion`
--
ALTER TABLE `retencion`
  ADD PRIMARY KEY (`id_retencion`);

--
-- Indices de la tabla `ubicacion_fisico`
--
ALTER TABLE `ubicacion_fisico`
  ADD PRIMARY KEY (`id_ubicacion`),
  ADD KEY `fk_documento2` (`id_documento`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `fk_area_acceso_usuarios` (`id_area`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id_actividad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT de la tabla `area_acceso`
--
ALTER TABLE `area_acceso`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `contraseña_resets`
--
ALTER TABLE `contraseña_resets`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT de la tabla `expedientes`
--
ALTER TABLE `expedientes`
  MODIFY `id_expediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT de la tabla `log_archivado`
--
ALTER TABLE `log_archivado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pista_auditoria`
--
ALTER TABLE `pista_auditoria`
  MODIFY `id_auditoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `retencion`
--
ALTER TABLE `retencion`
  MODIFY `id_retencion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ubicacion_fisico`
--
ALTER TABLE `ubicacion_fisico`
  MODIFY `id_ubicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `contraseña_resets`
--
ALTER TABLE `contraseña_resets`
  ADD CONSTRAINT `contraseña_resets_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `documentos_ibfk_4` FOREIGN KEY (`id_expediente`) REFERENCES `expedientes` (`id_expediente`),
  ADD CONSTRAINT `documentos_ibfk_5` FOREIGN KEY (`id_area`) REFERENCES `area_acceso` (`id_area`),
  ADD CONSTRAINT `fk_autor_documento` FOREIGN KEY (`autor`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `fk_retencion_doc` FOREIGN KEY (`id_retencion`) REFERENCES `retencion` (`id_retencion`);

--
-- Filtros para la tabla `expedientes`
--
ALTER TABLE `expedientes`
  ADD CONSTRAINT `fk_autor_usuario` FOREIGN KEY (`autor`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `fk_expediente_area` FOREIGN KEY (`id_area`) REFERENCES `area_acceso` (`id_area`);

--
-- Filtros para la tabla `pista_auditoria`
--
ALTER TABLE `pista_auditoria`
  ADD CONSTRAINT `pista_auditoria_ibfk_1` FOREIGN KEY (`id_area`) REFERENCES `area_acceso` (`id_area`),
  ADD CONSTRAINT `pista_auditoria_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `ubicacion_fisico`
--
ALTER TABLE `ubicacion_fisico`
  ADD CONSTRAINT `fk_documento2` FOREIGN KEY (`id_documento`) REFERENCES `documentos` (`id_documento`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_area_acceso_usuarios` FOREIGN KEY (`id_area`) REFERENCES `area_acceso` (`id_area`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
