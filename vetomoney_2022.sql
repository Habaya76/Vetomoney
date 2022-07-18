-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 18, 2022 at 02:54 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vetomoney_2022`
--

-- --------------------------------------------------------

--
-- Table structure for table `soldes`
--

CREATE TABLE `soldes` (
  `id_soldes` int(11) NOT NULL,
  `soldes` decimal(10,0) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id_Transaction` int(11) NOT NULL,
  `versement_reçu` decimal(10,0) DEFAULT NULL,
  `versement_envoi` decimal(10,0) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `id_soldes` int(11) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_admin`
--

CREATE TABLE `transaction_admin` (
  `id_Transaction` int(11) NOT NULL,
  `versement_reçu` decimal(10,0) DEFAULT NULL,
  `versement_envoi` decimal(10,0) DEFAULT NULL,
  `id_users` int(11) NOT NULL,
  `id_soldes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `pays` varchar(255) DEFAULT NULL,
  `telephone` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `est_valide` tinyint(1) NOT NULL,
  `clef` int(11) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `nom`, `prenom`, `pays`, `telephone`, `email`, `est_valide`, `clef`, `password`, `role`, `image`) VALUES
(1, 'diallo', 'diallo', 'Guinee', 111, 'diallo@gmail.fr', 1, 1, '$2y$10$e6fW98a6c7BXs8e7Jj7.GeGjiGW.pyZHx3E1M3EXYUWrKC2UaGq9W', 'administrateur', 'profils/diallo@gmail.fr/31695_50334_profil.png'),
(20, 'bb', 'bb', 'bb', 1111, 'bb@b', 0, 1, '$2y$10$wtA71/b0mRhX.YxUEJwAnOtbQ/.gEyQVGBJFG6Mb0p5zPMk.WpI3i', 'profils/profil.png', ''),
(21, 'aa', 'aa', 'aa', 11, 'aa@aa', 0, 1, '$2y$10$Yn84f2C8acwp4XMhFOLRFeqPw8BW2OTveReKxCcjo6CmKHCGp3ePO', 'utilisateur', ''),
(22, 'dd', 'dd', 'dd', 2, 'dd@dd', 0, 1, '$2y$10$rl/Bo2mBr1egDmGM55wCbuQaUV1jyK5ICv5eF9nqxajTV0Vrj85uC', NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `soldes`
--
ALTER TABLE `soldes`
  ADD PRIMARY KEY (`id_soldes`),
  ADD KEY `id_users` (`id_users`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id_Transaction`),
  ADD KEY `id_soldes` (`id_soldes`),
  ADD KEY `id_users` (`id_users`);

--
-- Indexes for table `transaction_admin`
--
ALTER TABLE `transaction_admin`
  ADD PRIMARY KEY (`id_Transaction`),
  ADD KEY `id_users` (`id_users`),
  ADD KEY `id_soldes` (`id_soldes`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `soldes`
--
ALTER TABLE `soldes`
  MODIFY `id_soldes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id_Transaction` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_admin`
--
ALTER TABLE `transaction_admin`
  MODIFY `id_Transaction` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `soldes`
--
ALTER TABLE `soldes`
  ADD CONSTRAINT `soldes_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`id_soldes`) REFERENCES `soldes` (`id_soldes`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`);

--
-- Constraints for table `transaction_admin`
--
ALTER TABLE `transaction_admin`
  ADD CONSTRAINT `transaction_admin_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`),
  ADD CONSTRAINT `transaction_admin_ibfk_2` FOREIGN KEY (`id_soldes`) REFERENCES `soldes` (`id_soldes`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
