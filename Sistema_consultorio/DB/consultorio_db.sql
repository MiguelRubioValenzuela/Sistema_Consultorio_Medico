-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2025 at 04:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `consultorio_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `citas`
--

CREATE TABLE `citas` (
  `Folio_cita` int(2) NOT NULL,
  `Fecha_cita` date NOT NULL,
  `Horario` float NOT NULL,
  `CURP_Paciente` varchar(18) NOT NULL,
  `ID_Usuario` varchar(8) NOT NULL,
  `stat` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comprobante_abastecimiento`
--

CREATE TABLE `comprobante_abastecimiento` (
  `Folio_compra_proveedores` int(11) NOT NULL,
  `ID_usuario` varchar(8) NOT NULL,
  `Proveedor` varchar(30) NOT NULL,
  `Fecha_compra` date NOT NULL DEFAULT current_timestamp(),
  `stat` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comprobante_abastecimiento`
--

INSERT INTO `comprobante_abastecimiento` (`Folio_compra_proveedores`, `ID_usuario`, `Proveedor`, `Fecha_compra`, `stat`) VALUES
(1, '00000000', '', '2025-01-11', 'Espera');

-- --------------------------------------------------------

--
-- Table structure for table `medicamentos`
--

CREATE TABLE `medicamentos` (
  `ID_medicamento` varchar(16) NOT NULL,
  `Nombre_medicamento` varchar(100) NOT NULL,
  `Descripcion` varchar(500) NOT NULL,
  `Tipo_de_medicamento` varchar(16) NOT NULL,
  `Cantidad` int(2) NOT NULL,
  `Via_administracion` varchar(25) NOT NULL,
  `Precio` float NOT NULL,
  `Proveedor` varchar(50) NOT NULL,
  `stat` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicamentos_abastecidos`
--

CREATE TABLE `medicamentos_abastecidos` (
  `Folio_medicamento_comprado` int(2) NOT NULL,
  `Folio_compra_proveedores` int(2) NOT NULL,
  `ID_medicamento` varchar(16) NOT NULL,
  `Cantidad_medicamento` int(2) NOT NULL,
  `Precio_medicamento_actual` float NOT NULL,
  `stat` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicamentos_receta`
--

CREATE TABLE `medicamentos_receta` (
  `Folio_Medicamento_Receta` int(2) NOT NULL,
  `Folio_Receta` int(2) NOT NULL,
  `ID_Medicamento` varchar(16) NOT NULL,
  `Cantidad_Medicamento` int(2) NOT NULL,
  `Dosis` varchar(500) NOT NULL,
  `stat` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicamento_ventas`
--

CREATE TABLE `medicamento_ventas` (
  `Folio_Medicamento_Venta` int(2) NOT NULL,
  `Folio_venta` int(2) NOT NULL,
  `ID_Medicamento` varchar(16) NOT NULL,
  `Cantidad_Medicamento` int(2) NOT NULL,
  `Precio_Medicamento_Actual` float NOT NULL,
  `stat` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paciente`
--

CREATE TABLE `paciente` (
  `Curp_paciente` varchar(18) NOT NULL,
  `Telefono_paciente` varchar(10) NOT NULL,
  `Correo_electronico_paciente` varchar(100) NOT NULL,
  `Nombre_completo_paciente` varchar(150) NOT NULL,
  `Fecha_nacimiento` date NOT NULL,
  `sexo` varchar(1) NOT NULL,
  `stat` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paciente`
--

INSERT INTO `paciente` (`Curp_paciente`, `Telefono_paciente`, `Correo_electronico_paciente`, `Nombre_completo_paciente`, `Fecha_nacimiento`, `sexo`, `stat`) VALUES
('OKKNASOKDNAOKSDNOA', '5571618281', 'Alber@gmail.com', 'Alberto Rubio', '1965-06-01', 'M', ''),
('RUVM001209HJCBLGA4', '3326145590', 'miguelangelrubiov@gmail.com', 'Miguel Angel Rubio Valenzuela', '2000-12-09', 'M', 'Activo');

-- --------------------------------------------------------

--
-- Table structure for table `recetas`
--

CREATE TABLE `recetas` (
  `Folio_Receta` int(2) NOT NULL,
  `CURP_Paciente` varchar(18) NOT NULL,
  `ID_usuario` varchar(8) NOT NULL,
  `Diagnostico` varchar(500) NOT NULL,
  `Peso` float NOT NULL,
  `Altura` float NOT NULL,
  `Temperatura` float NOT NULL,
  `Pulso` float NOT NULL,
  `Fecha_prescripcion` date NOT NULL,
  `Comentarios` varchar(500) NOT NULL,
  `stat` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_usuario` varchar(8) NOT NULL,
  `Contraseña` varchar(250) NOT NULL,
  `Nombre_completo_usuario` varchar(150) NOT NULL,
  `Correo_electronico_usuario` varchar(100) NOT NULL,
  `Telefono_usuario` varchar(10) NOT NULL,
  `Curp_usuario` varchar(18) NOT NULL,
  `Tipo` varchar(10) NOT NULL,
  `stat` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`ID_usuario`, `Contraseña`, `Nombre_completo_usuario`, `Correo_electronico_usuario`, `Telefono_usuario`, `Curp_usuario`, `Tipo`, `stat`) VALUES
('00000000', 'd54d1702ad0f8326224b817c796763c9', 'Miguel Angel Rubio Valenzuela', 'miguelangelrubiov@gmail.com', '3326145590', 'RUVM001209HJCBLGA4', 'Admin', 'Activo');

-- --------------------------------------------------------

--
-- Table structure for table `ventas`
--

CREATE TABLE `ventas` (
  `Folio_ventas` int(2) NOT NULL,
  `ID_usuario` varchar(10) NOT NULL,
  `Curp_paciente` varchar(18) NOT NULL,
  `Fecha` date NOT NULL DEFAULT current_timestamp(),
  `stat` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`Folio_cita`),
  ADD KEY `fk_citas_usuario_ID` (`ID_Usuario`),
  ADD KEY `fk_citas_paciente_curp` (`CURP_Paciente`);

--
-- Indexes for table `comprobante_abastecimiento`
--
ALTER TABLE `comprobante_abastecimiento`
  ADD PRIMARY KEY (`Folio_compra_proveedores`),
  ADD KEY `fk_CompAbas_usuario_ID` (`ID_usuario`);

--
-- Indexes for table `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD PRIMARY KEY (`ID_medicamento`);

--
-- Indexes for table `medicamentos_abastecidos`
--
ALTER TABLE `medicamentos_abastecidos`
  ADD PRIMARY KEY (`Folio_medicamento_comprado`),
  ADD KEY `fk_MedAbas_CompAbas_FolCom` (`Folio_compra_proveedores`),
  ADD KEY `fk_MedAbas_Med_ID` (`ID_medicamento`);

--
-- Indexes for table `medicamentos_receta`
--
ALTER TABLE `medicamentos_receta`
  ADD PRIMARY KEY (`Folio_Medicamento_Receta`),
  ADD KEY `fk_MedRec_Med_ID` (`ID_Medicamento`),
  ADD KEY `fk_MedRec_Rec_FoRec` (`Folio_Receta`);

--
-- Indexes for table `medicamento_ventas`
--
ALTER TABLE `medicamento_ventas`
  ADD KEY `fk_MedVen_Ven_FolVen` (`Folio_venta`),
  ADD KEY `fk_MedVen_Med_ID` (`ID_Medicamento`);

--
-- Indexes for table `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`Curp_paciente`),
  ADD UNIQUE KEY `Telefono_paciente` (`Telefono_paciente`),
  ADD UNIQUE KEY `Correo_electronico_paciente` (`Correo_electronico_paciente`);

--
-- Indexes for table `recetas`
--
ALTER TABLE `recetas`
  ADD PRIMARY KEY (`Folio_Receta`),
  ADD KEY `fk_recetas_paciente_curp` (`CURP_Paciente`),
  ADD KEY `fk_recetas_usuario_id` (`ID_usuario`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_usuario`),
  ADD UNIQUE KEY `Correo_electronico_usuario` (`Correo_electronico_usuario`),
  ADD UNIQUE KEY `Telefono_usuario` (`Telefono_usuario`,`Curp_usuario`);

--
-- Indexes for table `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`Folio_ventas`),
  ADD KEY `fk_ventas_paciente_curp` (`Curp_paciente`),
  ADD KEY `fk_ventas_usuario_ID` (`ID_usuario`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `fk_citas_paciente_curp` FOREIGN KEY (`CURP_Paciente`) REFERENCES `paciente` (`Curp_paciente`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_citas_usuario_ID` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_usuario`) ON UPDATE CASCADE;

--
-- Constraints for table `comprobante_abastecimiento`
--
ALTER TABLE `comprobante_abastecimiento`
  ADD CONSTRAINT `fk_CompAbas_usuario_ID` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`) ON UPDATE CASCADE;

--
-- Constraints for table `medicamentos_abastecidos`
--
ALTER TABLE `medicamentos_abastecidos`
  ADD CONSTRAINT `fk_MedAbas_CompAbas_FolCom` FOREIGN KEY (`Folio_compra_proveedores`) REFERENCES `comprobante_abastecimiento` (`Folio_compra_proveedores`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_MedAbas_Med_ID` FOREIGN KEY (`ID_medicamento`) REFERENCES `medicamentos` (`ID_medicamento`) ON UPDATE CASCADE;

--
-- Constraints for table `medicamentos_receta`
--
ALTER TABLE `medicamentos_receta`
  ADD CONSTRAINT `fk_MedRec_Med_ID` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamentos` (`ID_medicamento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_MedRec_Rec_FoRec` FOREIGN KEY (`Folio_Receta`) REFERENCES `recetas` (`Folio_Receta`) ON UPDATE CASCADE;

--
-- Constraints for table `medicamento_ventas`
--
ALTER TABLE `medicamento_ventas`
  ADD CONSTRAINT `fk_MedVen_Med_ID` FOREIGN KEY (`ID_Medicamento`) REFERENCES `medicamentos` (`ID_medicamento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_MedVen_Ven_FolVen` FOREIGN KEY (`Folio_venta`) REFERENCES `ventas` (`Folio_ventas`) ON UPDATE CASCADE;

--
-- Constraints for table `recetas`
--
ALTER TABLE `recetas`
  ADD CONSTRAINT `fk_recetas_paciente_curp` FOREIGN KEY (`CURP_Paciente`) REFERENCES `paciente` (`Curp_paciente`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_recetas_usuario_id` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`) ON UPDATE CASCADE;

--
-- Constraints for table `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_ventas_paciente_curp` FOREIGN KEY (`Curp_paciente`) REFERENCES `paciente` (`Curp_paciente`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ventas_usuario_ID` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
