SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `Etudiant` (
  `Id` int PRIMARY KEY AUTO_INCREMENT,
  `Cin` varchar(10) NOT NULL,
  `Nom` text NOT NULL,
  `Prenom` text NOT NULL,
  `Diplome` varchar(10) NOT NULL,
  `DateNaissance` date NOT NULL,
  `Image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
