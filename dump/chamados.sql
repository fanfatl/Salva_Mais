-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Tempo de geração: 22/05/2025 às 17:05
-- Versão do servidor: 10.3.39-MariaDB-1:10.3.39+maria~ubu2004
-- Versão do PHP: 8.2.28

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
-- Estrutura para tabela `chamados`
--

CREATE TABLE `chamados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `quantidade_pessoas` int(11) NOT NULL,
  `possui_animais` tinyint(1) NOT NULL,
  `quantidade_animais` int(11) DEFAULT NULL,
  `situacao` text DEFAULT NULL,
  `data_criacao` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'aberto'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `chamados`
--

INSERT INTO `chamados` (`id`, `usuario_id`, `rua`, `numero`, `bairro`, `cidade`, `quantidade_pessoas`, `possui_animais`, `quantidade_animais`, `situacao`, `data_criacao`, `status`) VALUES
(4, 4, 'Raquel Rossi', '119', '111', '111', 11, 0, NULL, '11', '2025-05-20', 'aberto'),
(5, 10, 'Rua Coronel Vicente', '1', 'Centro', 'Canoas', 1, 0, NULL, '2', '2025-05-20', 'aberto'),
(13, 5, 'Rua Coronel Vicente', '11', 'Centro', 'Porto Alegre', 1, 1, 2, 'estou quase morto', '2025-05-22', 'excluido');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `chamados`
--
ALTER TABLE `chamados`
  ADD PRIMARY KEY (`id`)

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `chamados`
--
ALTER TABLE `chamados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `chamados`
--
ALTER TABLE `chamados`
  ADD CONSTRAINT `chamados_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
