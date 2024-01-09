-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03-Set-2022 às 00:26
-- Versão do servidor: 10.4.19-MariaDB
-- versão do PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `backend`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tab_log_tentativa`
--

CREATE TABLE `tab_log_tentativa` (
  `id` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `origem` varchar(300) NOT NULL,
  `bloqueado` char(3) NOT NULL,
  `data_hora` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tab_log_tentativa`
--

INSERT INTO `tab_log_tentativa` (`id`, `ip`, `email`, `origem`, `bloqueado`, `data_hora`) VALUES
(66, '::1', 'leozimcelo007@gmail.com', 'http://localhost/project-backend/login.php', 'NAO', '2022-05-06 15:04:54'),
(67, '::1', 'admin@admin.com', 'http://localhost/project-backend/login.php', 'NAO', '2022-05-06 15:20:00');

-- --------------------------------------------------------

-- Estrutura da tabela `users`
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_token` int(11) NOT NULL,
  `user_level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Extraindo dados da tabela `users`
INSERT INTO `users` (`user_id`, `user_firstname`, `user_email`, `user_password`, `user_token`, `user_level`) VALUES
(1, 'Jeferson', 'admin@admin.com', '$2y$10$b1tfQvUCDAri4AVFKSSr.eJy4hJEi1FKWKW0XYvph8vTKtimc38cm', 1234567890, '10'),
(13, 'elksandro', 'elk@gmail.com', '$2y$10$b1tfQvUCDAri4AVFKSSr.eJy4hJEi1FKWKW0XYvph8vTKtimc38cm', 1212121212, '8');

-- -------------------------------------------------------

-- Estrutura da tabela `users`
CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- -------------------------------------------------------

-- Estrutura da tabela `users`
CREATE TABLE `articles` (
  `article_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `resume` TEXT NOT NULL,
  `autors` varchar(500) NOT NULL,
  `pdf` TEXT NOT NULL,
  `date_post` DATETIME NOT NULL,
  `img_preview` TEXT NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Índices para tabelas despejadas

-- Índices para tabela `tab_log_tentativa`
ALTER TABLE `tab_log_tentativa`
  ADD PRIMARY KEY (`id`);

-- Índices para tabela `users`
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

-- Índices para tabela `users`
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`);

-- Índices para tabela `users`
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

-- Índices para tabela `articles`
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

-- Índices para tabela `users`
ALTER TABLE `articles`
  ADD CONSTRAINT fk_articles_category
  FOREIGN KEY (`category_id`) REFERENCES `category`(`category_id`);

-- Índices para tabela `articles`
ALTER TABLE `articles`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

-- AUTO_INCREMENT de tabela `tab_log_tentativa`
ALTER TABLE `tab_log_tentativa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

-- AUTO_INCREMENT de tabela `users`
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

-- Restrições para despejos de tabelas

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
