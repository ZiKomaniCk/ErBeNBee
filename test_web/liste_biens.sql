-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Listage de la structure de la table test_web. liste_biens
CREATE TABLE IF NOT EXISTS `liste_biens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre_article` varchar(50) NOT NULL DEFAULT '0',
  `prix` int(11) NOT NULL DEFAULT '0',
  `nbr_personnes` int(11) NOT NULL DEFAULT '1',
  `descriptions` varchar(500) NOT NULL DEFAULT '0',
  `id_user` int(11) DEFAULT NULL,
  `path_photo` varchar(50) DEFAULT 'assets/photos_biens/',
  `ville` varchar(50) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_liste_biens_inscription` (`id_user`),
  CONSTRAINT `FK_liste_biens_inscription` FOREIGN KEY (`id_user`) REFERENCES `inscription` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=latin1;

-- Listage des données de la table test_web.liste_biens : ~4 rows (environ)
/*!40000 ALTER TABLE `liste_biens` DISABLE KEYS */;
INSERT INTO `liste_biens` (`id`, `titre_article`, `prix`, `nbr_personnes`, `descriptions`, `id_user`, `path_photo`, `ville`, `adresse`) VALUES
	(144, 'Joli Cabanon', 60, 2, 'Joli petit cabanon parfait pour découvrir la ville.', 61, '../../assets/photos_biens/144/', 'Bordeaux', '12 Rue Tastet'),
	(145, 'Chambre d\'hôte', 30, 1, 'Magnifique chambre d\'hôte qui sera vous faire passer un bon séjour.', 61, '../../assets/photos_biens/145/', 'Le Bessou', 'Rue de la Chapelle'),
	(146, 'Chambre de Château', 150, 2, 'Lalande-de-Pomerol', 60, '../../assets/photos_biens/146/', 'Dordogne', 'Route de Musset'),
	(147, 'Château de Peyrignac', 390, 8, 'Sublime château et son domaine, parfait pour vos weekend a la campagne en famille, ou entre amis ! ', 60, '../../assets/photos_biens/147/', 'Peyrignac', 'Route de la Chapoulie');
/*!40000 ALTER TABLE `liste_biens` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
