-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/05/2025 às 03:04
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `salvamais`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `funcao` enum('ilhado','voluntario') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `cpf`, `email`, `senha`, `funcao`) VALUES
(1, 'gabriel', '11', 'gabriel@oi.com', '$2y$10$yv1qberDpwKy1b3MhYRsN.J7jNGv4oNvgMGvzZKyapwgaEODYRJ1C', 'ilhado'),
(2, 'gabriel', '1112', 'gabrielvol@oi.com', '$2y$10$QSKd/yy1dwIoSBIkh50FEuUWBQOVwpBp/ob.TUPEiMrde9FQarOBm', 'voluntario'),
(3, 'Gabriel (Fanfa)', '057.493.130-93', 'gabrielfrossi1906@gmail.com', '$2y$10$eqgDVeNJt.lW69h6jIywSe3qsSO7QF446HkCTa9o9beiGoL3vsxLe', 'ilhado'),
(4, 'fanfa', '123.456.789-99', 'xxzootelxx@gmail.com', '$2y$10$0f7vvmMlV/drCST6NAxWFeB0p1eXDCDOKXTUACTN3OtH8CDh.j6H.', 'voluntario'),
(5, 'teste', 'teste', 'teste@teste', '$2y$10$tYMNMrufuRsjAqPV42k6ruev776.eDXXsCyKI6EZb/H.bzsAZ9Yw6', 'ilhado'),
(6, 'testev', 'testev', 'testev@testev', '$2y$10$mOHAUrVnqRAdbK1MGLYm.Oj/.Wq5czSUiNIh7ZMu4jlKfBLgA6lfO', 'voluntario'),
(7, 'Artur Pretto', '11111111111', 'aap051059@gmail.com', '$2y$10$6bZAqMzt3yy/Y/TygZf8GObfbxuwA8GfQm949gMNYJgEJ.UMRx1tO', 'ilhado');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
