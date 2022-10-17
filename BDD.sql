DROP DATABASE IF EXISTS `lmb`;
CREATE DATABASE `lmb`;
USE `lmb`;

CREATE TABLE users(
   user_id INT,
   user_nom_prenom VARCHAR(50) NOT NULL,
   user_tel VARCHAR(15) NOT NULL,
   user_email VARCHAR(255) NOT NULL,
   user_adresse VARCHAR(255)  NOT NULL,
   user_cp INT NOT NULL,
   user_ville VARCHAR(50)  NOT NULL,
   user_pays VARCHAR(50)  NOT NULL,
   PRIMARY KEY(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`user_id`, `user_nom_prenom`, `user_tel`, `user_email`, `user_adresse`, `user_cp`, `user_ville`, `user_pays`) 
VALUES 
(1, 'Richard Jules', '07 51 25 08 10', 'richard@gmail.com', '5 rue Général Leclerc', 80000, 'Amiens', 'France'),
(2, 'Paul Michel', '07 50 27 81 18', 'p.michel@yahoo.fr', '52 rue Jean Jaures', 75000, 'Paris', 'France'),
(3, 'Mathieu Bompart', '01 23 45 67 89', 'bompart@homail.com', '836 rue du Mas de Verchant', 34000, 'Montpellier', 'France'),
(4, 'Celine Périk', '09 87 65 43 21', 'c-perik@gmail.com', '15 rue Général Leclerc', 13000, 'Marseille', 'France');