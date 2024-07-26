-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 26-Jul-2024 às 15:59
-- Versão do servidor: 5.7.17
-- PHP Version: 7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hover_app`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tweets`
--

CREATE TABLE `tweets` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tweet` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `imagem_tweet` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tweets`
--

INSERT INTO `tweets` (`id`, `id_usuario`, `tweet`, `imagem_tweet`, `data`) VALUES
(40, 1, 'Hover App é uma rede social simples, projetada para oferecer uma experiência intuitiva e eficaz. Ao se cadastrar, você começará seguindo automaticamente um perfil de apresentação. Aqui estão algumas das funcionalidades que você pode explorar:', NULL, '2024-07-25 20:37:48'),
(38, 1, 'Espero que você aproveite a experiência e encontre valor neste projeto!', NULL, '2024-07-25 20:35:35'),
(39, 1, 'Postagens: Compartilhe suas ideias e imagens \r\nFeed de Postagens: Veja postagens dos usuários que você segue.\r\nBusca de Usuários: Encontre e siga outros usuários do Hover App.\r\nBusca de Postagens: Encontre publicações\r\nPersonalização de Perfil: Seja único', NULL, '2024-07-25 20:37:37'),
(42, 1, 'Me chamo Pedro Henrique Silva de Albuquerque, sou desenvolvedor fullstack e atualmente cursando Ciência da Computação na UFRRJ. Este projeto foi desenvolvido com o objetivo de consolidar e demonstrar meus conhecimentos em PHP e Web', NULL, '2024-07-25 20:38:45'),
(43, 1, 'Olá e seja muito bem-vindo ao Hover App!', NULL, '2024-07-25 20:38:53'),
(45, 19, 'Olá, eu sou o usuário 1', NULL, '2024-07-25 20:59:30'),
(46, 20, 'Olá, eu sou o usuário 2', NULL, '2024-07-25 20:59:30'),
(47, 21, 'Olá, eu sou o usuário 3', NULL, '2024-07-25 20:59:30'),
(48, 22, 'Olá, eu sou o usuário 4', NULL, '2024-07-25 20:59:30'),
(49, 23, 'Olá, eu sou o usuário 5', NULL, '2024-07-25 20:59:30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `imagem_topo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `imagem_topo`) VALUES
(1, 'Pedro H.', 'pedro24253567@gmail.com', 'bd639fccd54d202f93251a0e50dcef4d', 'img/topos/172195204966a2e73190510.jpg'),
(23, 'User 5', 'user5@gmail.com', '0a791842f52a0acfbb3a783378c066b8', NULL),
(19, 'User 1', 'user1@gmail.com', '24c9e15e52afc47c225b757e7bee1f9d', NULL),
(20, 'User 2', 'user2@gmail.com', '7e58d63b60197ceb55a1c487989a3720', NULL),
(21, 'User 3', 'user3@gmail.com', '92877af70a45fd6a2ed7fe81e1236b78', NULL),
(22, 'User 4', 'user4@gmail.com', '3f02ebe3d7929b091e3d8ccfde2f3bc6', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_seguidores`
--

CREATE TABLE `usuarios_seguidores` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_usuario_seguindo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `usuarios_seguidores`
--

INSERT INTO `usuarios_seguidores` (`id`, `id_usuario`, `id_usuario_seguindo`) VALUES
(11, 1, 23),
(10, 1, 20),
(9, 1, 19);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios_seguidores`
--
ALTER TABLE `usuarios_seguidores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tweets`
--
ALTER TABLE `tweets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `usuarios_seguidores`
--
ALTER TABLE `usuarios_seguidores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
