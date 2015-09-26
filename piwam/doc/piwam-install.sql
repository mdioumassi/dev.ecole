-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Dim 15 Novembre 2009 à 22:58
-- Version du serveur: 5.0.67
-- Version de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Structure de la table `piwam_acl_action`
--

CREATE TABLE IF NOT EXISTS `piwam_acl_action` (
  `id` int(11) NOT NULL auto_increment,
  `acl_module_id` int(11) default NULL,
  `libelle` varchar(255) collate utf8_bin NOT NULL,
  `code` varchar(100) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `acl_action_FI_1` (`acl_module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=39 ;

--
-- Contenu de la table `piwam_acl_action`
--

INSERT INTO `piwam_acl_action` VALUES(1, 1, 'Éditer et configurer l''association', 'edit_association');
INSERT INTO `piwam_acl_action` VALUES(2, 1, 'Utiliser l''outil de mailing', 'mailing');
INSERT INTO `piwam_acl_action` VALUES(3, 1, 'Utiliser l''outil d''export', 'export');
INSERT INTO `piwam_acl_action` VALUES(4, 1, 'Voir les bilans', 'bilan');
INSERT INTO `piwam_acl_action` VALUES(5, 4, 'Enregistrer une activité', 'add_activite');
INSERT INTO `piwam_acl_action` VALUES(6, 4, 'Éditer une activité', 'edit_activite');
INSERT INTO `piwam_acl_action` VALUES(7, 4, 'Supprimer une activité', 'del_activite');
INSERT INTO `piwam_acl_action` VALUES(8, 4, 'Lister les activités', 'list_activite');
INSERT INTO `piwam_acl_action` VALUES(9, 4, 'Voir les détails d''une activités', 'show_activite');
INSERT INTO `piwam_acl_action` VALUES(10, 2, 'Enregistrer un membre', 'add_membre');
INSERT INTO `piwam_acl_action` VALUES(11, 2, 'Éditer un membre', 'edit_membre');
INSERT INTO `piwam_acl_action` VALUES(12, 2, 'Supprimer un membre', 'del_membre');
INSERT INTO `piwam_acl_action` VALUES(13, 2, 'Lister les membres', 'list_membre');
INSERT INTO `piwam_acl_action` VALUES(14, 2, 'Afficher les détails d''un membre', 'show_membre');
INSERT INTO `piwam_acl_action` VALUES(15, 8, 'Ajouter un statut', 'add_statut');
INSERT INTO `piwam_acl_action` VALUES(16, 8, 'Éditer un statut', 'edit_statut');
INSERT INTO `piwam_acl_action` VALUES(17, 8, 'Supprimer un statut', 'del_statut');
INSERT INTO `piwam_acl_action` VALUES(18, 8, 'Lister les statuts', 'list_statut');
INSERT INTO `piwam_acl_action` VALUES(19, 7, 'Enregistrer une cotisation', 'add_cotisation');
INSERT INTO `piwam_acl_action` VALUES(20, 7, 'Éditer une cotisation', 'edit_cotisation');
INSERT INTO `piwam_acl_action` VALUES(21, 7, 'Supprimer une cotisation', 'del_cotisation');
INSERT INTO `piwam_acl_action` VALUES(22, 7, 'Lister les cotisations', 'list_cotisation');
INSERT INTO `piwam_acl_action` VALUES(23, 7, 'Gérer les types de cotisations', 'config_cotisations');
INSERT INTO `piwam_acl_action` VALUES(24, 3, 'Enregistrer un compte', 'add_compte');
INSERT INTO `piwam_acl_action` VALUES(25, 3, 'Éditer un compte', 'edit_compte');
INSERT INTO `piwam_acl_action` VALUES(26, 3, 'Supprimer un compte', 'del_compte');
INSERT INTO `piwam_acl_action` VALUES(27, 3, 'Lister les comptes', 'list_compte');
INSERT INTO `piwam_acl_action` VALUES(28, 6, 'Enregistrer une recette', 'add_recette');
INSERT INTO `piwam_acl_action` VALUES(29, 6, 'Éditer une recette', 'edit_recette');
INSERT INTO `piwam_acl_action` VALUES(30, 6, 'Supprimer une recette', 'del_recette');
INSERT INTO `piwam_acl_action` VALUES(31, 6, 'Lister les recettes', 'list_recette');
INSERT INTO `piwam_acl_action` VALUES(32, 5, 'Enregistrer une dépense', 'add_depense');
INSERT INTO `piwam_acl_action` VALUES(33, 5, 'Éditer une dépense', 'edit_depense');
INSERT INTO `piwam_acl_action` VALUES(34, 5, 'Supprimer une dépense', 'del_depense');
INSERT INTO `piwam_acl_action` VALUES(35, 5, 'Lister les dépenses', 'list_depense');
INSERT INTO `piwam_acl_action` VALUES(36, 2, 'Gérer les droits', 'edit_acl');
INSERT INTO `piwam_acl_action` VALUES(37, 9, 'Mettre à jour Piwam', 'update_piwam');
INSERT INTO `piwam_acl_action` VALUES(38, 9, 'Éditer les préférences', 'edit_piwam_preferences');

-- --------------------------------------------------------

--
-- Structure de la table `piwam_acl_credential`
--

CREATE TABLE IF NOT EXISTS `piwam_acl_credential` (
  `id` int(11) NOT NULL auto_increment,
  `membre_id` int(11) default NULL,
  `acl_action_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `acl_credential_FI_1` (`membre_id`),
  KEY `acl_credential_FI_2` (`acl_action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Contenu de la table `piwam_acl_credential`
--


-- --------------------------------------------------------

--
-- Structure de la table `piwam_acl_module`
--

CREATE TABLE IF NOT EXISTS `piwam_acl_module` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=10 ;

--
-- Contenu de la table `piwam_acl_module`
--

INSERT INTO `piwam_acl_module` VALUES(1, 'Association');
INSERT INTO `piwam_acl_module` VALUES(2, 'Membre');
INSERT INTO `piwam_acl_module` VALUES(3, 'Compte');
INSERT INTO `piwam_acl_module` VALUES(4, 'Activité');
INSERT INTO `piwam_acl_module` VALUES(5, 'Dépense');
INSERT INTO `piwam_acl_module` VALUES(6, 'Recette');
INSERT INTO `piwam_acl_module` VALUES(7, 'Cotisations');
INSERT INTO `piwam_acl_module` VALUES(8, 'Statuts');
INSERT INTO `piwam_acl_module` VALUES(9, 'Piwam');

-- --------------------------------------------------------

--
-- Structure de la table `piwam_activite`
--

CREATE TABLE IF NOT EXISTS `piwam_activite` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) collate utf8_bin NOT NULL,
  `actif` tinyint(4) default '1',
  `association_id` int(11) NOT NULL,
  `enregistre_par` int(11) default NULL,
  `mis_a_jour_par` int(11) default NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `activite_FI_1` (`association_id`),
  KEY `activite_FI_2` (`enregistre_par`),
  KEY `activite_FI_3` (`mis_a_jour_par`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Contenu de la table `piwam_activite`
--


-- --------------------------------------------------------

--
-- Structure de la table `piwam_association`
--

CREATE TABLE IF NOT EXISTS `piwam_association` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(120) collate utf8_bin NOT NULL,
  `description` varchar(255) collate utf8_bin default NULL,
  `site_web` varchar(255) collate utf8_bin default NULL,
  `enregistre_par` int(11) default NULL,
  `mis_a_jour_par` int(11) default NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `association_FI_1` (`enregistre_par`),
  KEY `association_FI_2` (`mis_a_jour_par`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Contenu de la table `piwam_association`
--


-- --------------------------------------------------------

--
-- Structure de la table `piwam_compte`
--

CREATE TABLE IF NOT EXISTS `piwam_compte` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) collate utf8_bin NOT NULL,
  `association_id` int(11) NOT NULL,
  `reference` varchar(64) collate utf8_bin NOT NULL,
  `actif` tinyint(4) default '1',
  `enregistre_par` int(11) default NULL,
  `mis_a_jour_par` int(11) default NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `compte_FI_1` (`association_id`),
  KEY `compte_FI_2` (`enregistre_par`),
  KEY `compte_FI_3` (`mis_a_jour_par`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Contenu de la table `piwam_compte`
--


-- --------------------------------------------------------

--
-- Structure de la table `piwam_config_categorie`
--

CREATE TABLE IF NOT EXISTS `piwam_config_categorie` (
  `code` varchar(25) collate utf8_bin NOT NULL,
  `libelle` varchar(255) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `piwam_config_categorie`
--

INSERT INTO `piwam_config_categorie` VALUES('affichage', 'Affichage');
INSERT INTO `piwam_config_categorie` VALUES('mailing', 'Mailing');
INSERT INTO `piwam_config_categorie` VALUES('services', 'services');

-- --------------------------------------------------------

--
-- Structure de la table `piwam_config_value`
--

CREATE TABLE IF NOT EXISTS `piwam_config_value` (
  `config_variable_id` int(11) NOT NULL,
  `association_id` int(11) NOT NULL,
  `custom_value` varchar(255) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`config_variable_id`,`association_id`),
  KEY `config_value_FI_2` (`association_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `piwam_config_value`
--


-- --------------------------------------------------------

--
-- Structure de la table `piwam_config_variable`
--

CREATE TABLE IF NOT EXISTS `piwam_config_variable` (
  `id` int(11) NOT NULL auto_increment,
  `code` varchar(25) collate utf8_bin NOT NULL,
  `categorie_code` varchar(25) collate utf8_bin NOT NULL,
  `libelle` varchar(255) collate utf8_bin NOT NULL,
  `description` text collate utf8_bin,
  `type` varchar(255) collate utf8_bin NOT NULL,
  `default_value` varchar(255) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `config_variable_FI_1` (`categorie_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=11 ;

--
-- Contenu de la table `piwam_config_variable`
--

INSERT INTO `piwam_config_variable` VALUES(1, 'address', 'mailing', 'Adresse expéditeur', 0x4c657320656d61696c7320656e766f79c3a97320617070617261c3ae74726f6e7420636f6d6d6520657870c3a96469c3a973206176656320636574746520616472657373652e, 'EMAIL', 'info@piwam.org');
INSERT INTO `piwam_config_variable` VALUES(2, 'method', 'mailing', 'Méthode', 0x4dc3a974686f64652061766563206c617175656c6c65207365726f6e7420656e766f79c3a973206c657320652d6d61696c73, '{mail,smtp,gmail,sendmail}', 'mail');
INSERT INTO `piwam_config_variable` VALUES(3, 'gmail_username', 'mailing', 'Gmail: Identifiant', 0x4164726573736520474d61696c2064616e73206c65206361647265206427756e20656e766f69206176656320474d61696c, 'EMAIL', '');
INSERT INTO `piwam_config_variable` VALUES(4, 'gmail_password', 'mailing', 'GMail: Password', 0x4d6f7420646520706173736520706f757220656e766f796572206c6573206d61696c732076696120474d61696c, 'VARCHAR', '');
INSERT INTO `piwam_config_variable` VALUES(5, 'smtp_server', 'mailing', 'SMTP: Serveur', 0x5365727665757220534d5450207574696c6973c3a920706f7572206c27656e766f69206465206d61696c73, 'VARCHAR', '');
INSERT INTO `piwam_config_variable` VALUES(6, 'smtp_username', 'mailing', 'SMTP: Identifiant', 0x4964656e74696669616e7420706f757220736520636f6e6e6563746572206175207365727665757220534d5450, 'VARCHAR', '');
INSERT INTO `piwam_config_variable` VALUES(7, 'smtp_password', 'mailing', 'SMTP: Mot de passe', 0x4d6f74206465207061737365207574696c6973c3a920706f757220736520636f6e6e6563746572206175207365727665757220534d54502e, 'VARCHAR', '');
INSERT INTO `piwam_config_variable` VALUES(8, 'sendmail_path', 'mailing', 'Sendmail', 0x416363c3a8732061752062696e616972652053656e646d61696c, 'VARCHAR', '/usr/bin/sendmail');
INSERT INTO `piwam_config_variable` VALUES(9, 'users_by_page', 'affichage', 'Membres par page', 0x4e6f6d627265206465206d656d6272657320c3a02061666669636865722070617220706167652064616e73206c65206c697374696e672e, 'INTEGER', '20');
INSERT INTO `piwam_config_variable` VALUES(10, 'googlemap_key', 'services', 'Clé Google Map', 0x436cc3a9207574696c6973c3a96520706f757220616363c3a964657220c3a020476f6f676c65204d61702e2047c3a96ec3a972657a206c6120766f7472652073757220687474703a2f2f636f64652e676f6f676c652e636f6d2f696e746c2f66722d46522f617069732f6d6170732f7369676e75702e68746d6c2e, 'VARCHAR', 'ABQIAAAAL8IvKFhg9nRCwpMHeoYEKhQu6C5tfcTOznQAfibWXRksA7VQJxQAvTbET15fVW6RQnHsk3BmZqGKLw');

-- --------------------------------------------------------

--
-- Structure de la table `piwam_cotisation`
--

CREATE TABLE IF NOT EXISTS `piwam_cotisation` (
  `id` int(11) NOT NULL auto_increment,
  `compte_id` int(11) NOT NULL,
  `cotisation_type_id` int(11) NOT NULL,
  `membre_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `enregistre_par` int(11) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `mis_a_jour_par` int(11) default NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `cotisation_FI_1` (`compte_id`),
  KEY `cotisation_FI_2` (`cotisation_type_id`),
  KEY `cotisation_FI_3` (`membre_id`),
  KEY `cotisation_FI_4` (`enregistre_par`),
  KEY `cotisation_FI_5` (`mis_a_jour_par`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Contenu de la table `piwam_cotisation`
--


-- --------------------------------------------------------

--
-- Structure de la table `piwam_cotisation_type`
--

CREATE TABLE IF NOT EXISTS `piwam_cotisation_type` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) collate utf8_bin NOT NULL,
  `association_id` int(11) NOT NULL,
  `valide` int(11) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `actif` tinyint(4) default '1',
  `enregistre_par` int(11) NOT NULL,
  `mis_a_jour_par` int(11) default NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `cotisation_type_FI_1` (`association_id`),
  KEY `cotisation_type_FI_2` (`enregistre_par`),
  KEY `cotisation_type_FI_3` (`mis_a_jour_par`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Contenu de la table `piwam_cotisation_type`
--


-- --------------------------------------------------------

--
-- Structure de la table `piwam_data`
--

CREATE TABLE IF NOT EXISTS `piwam_data` (
  `id` int(11) NOT NULL auto_increment,
  `key` varchar(255) collate utf8_bin NOT NULL,
  `value` varchar(255) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `piwam_depense`
--

CREATE TABLE IF NOT EXISTS `piwam_depense` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) collate utf8_bin NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `association_id` int(11) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `activite_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `payee` tinyint(4) default '1',
  `enregistre_par` int(11) NOT NULL,
  `mis_a_jour_par` int(11) NOT NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `depense_FI_1` (`association_id`),
  KEY `depense_FI_2` (`compte_id`),
  KEY `depense_FI_3` (`activite_id`),
  KEY `depense_FI_4` (`enregistre_par`),
  KEY `depense_FI_5` (`mis_a_jour_par`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Contenu de la table `piwam_depense`
--


-- --------------------------------------------------------

--
-- Structure de la table `piwam_membre`
--

CREATE TABLE IF NOT EXISTS `piwam_membre` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) collate utf8_bin NOT NULL,
  `pseudo` varchar(255) character set utf8 collate utf8_unicode_ci default NULL,
  `password` varchar(255) collate utf8_bin default NULL,
  `statut_id` int(11) NOT NULL,
  `date_inscription` date NOT NULL,
  `exempte_cotisation` tinyint(4) NOT NULL,
  `rue` varchar(255) collate utf8_bin default NULL,
  `cp` varchar(8) collate utf8_bin default NULL,
  `ville` varchar(255) collate utf8_bin default NULL,
  `pays` varchar(8) collate utf8_bin default NULL,
  `picture` varchar(255) collate utf8_bin NOT NULL,
  `email` varchar(255) collate utf8_bin default NULL,
  `website` varchar(255) collate utf8_bin default NULL,
  `tel_fixe` varchar(16) collate utf8_bin default NULL,
  `tel_portable` varchar(16) collate utf8_bin default NULL,
  `actif` tinyint(4) default '1',
  `association_id` int(11) NOT NULL,
  `enregistre_par` int(11) default NULL,
  `mis_a_jour_par` int(11) default NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `membre_U_1` (`pseudo`),
  KEY `membre_FI_1` (`statut_id`),
  KEY `membre_FI_2` (`association_id`),
  KEY `membre_FI_3` (`enregistre_par`),
  KEY `membre_FI_4` (`mis_a_jour_par`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Contenu de la table `piwam_membre`
--


-- --------------------------------------------------------

--
-- Structure de la table `piwam_recette`
--

CREATE TABLE IF NOT EXISTS `piwam_recette` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(255) collate utf8_bin NOT NULL,
  `association_id` int(11) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `activite_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `percue` tinyint(4) default '1',
  `enregistre_par` int(11) NOT NULL,
  `mis_a_jour_par` int(11) NOT NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `recette_FI_1` (`association_id`),
  KEY `recette_FI_2` (`compte_id`),
  KEY `recette_FI_3` (`activite_id`),
  KEY `recette_FI_4` (`enregistre_par`),
  KEY `recette_FI_5` (`mis_a_jour_par`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Contenu de la table `piwam_recette`
--


-- --------------------------------------------------------

--
-- Structure de la table `piwam_statut`
--

CREATE TABLE IF NOT EXISTS `piwam_statut` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(255) collate utf8_bin NOT NULL,
  `association_id` int(11) NOT NULL,
  `actif` tinyint(4) default '1',
  `enregistre_par` int(11) default NULL,
  `mis_a_jour_par` int(11) default NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `statut_FI_1` (`association_id`),
  KEY `statut_FI_2` (`enregistre_par`),
  KEY `statut_FI_3` (`mis_a_jour_par`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Contenu de la table `piwam_statut`
--


--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `piwam_acl_action`
--
ALTER TABLE `piwam_acl_action`
  ADD CONSTRAINT `piwam_acl_action_ibfk_1` FOREIGN KEY (`acl_module_id`) REFERENCES `piwam_acl_module` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `piwam_acl_credential`
--
ALTER TABLE `piwam_acl_credential`
  ADD CONSTRAINT `piwam_acl_credential_ibfk_2` FOREIGN KEY (`acl_action_id`) REFERENCES `piwam_acl_action` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `piwam_acl_credential_ibfk_1` FOREIGN KEY (`membre_id`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `piwam_activite`
--
ALTER TABLE `piwam_activite`
  ADD CONSTRAINT `activite_FK_1` FOREIGN KEY (`association_id`) REFERENCES `piwam_association` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activite_FK_2` FOREIGN KEY (`enregistre_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activite_FK_3` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `piwam_association`
--
ALTER TABLE `piwam_association`
  ADD CONSTRAINT `association_FK_1` FOREIGN KEY (`enregistre_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `association_FK_2` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `piwam_compte`
--
ALTER TABLE `piwam_compte`
  ADD CONSTRAINT `compte_FK_1` FOREIGN KEY (`association_id`) REFERENCES `piwam_association` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `compte_FK_2` FOREIGN KEY (`enregistre_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `compte_FK_3` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `piwam_config_value`
--
ALTER TABLE `piwam_config_value`
  ADD CONSTRAINT `config_value_FK_1` FOREIGN KEY (`config_variable_id`) REFERENCES `piwam_config_variable` (`id`),
  ADD CONSTRAINT `config_value_FK_2` FOREIGN KEY (`association_id`) REFERENCES `piwam_association` (`id`);

--
-- Contraintes pour la table `piwam_config_variable`
--
ALTER TABLE `piwam_config_variable`
  ADD CONSTRAINT `piwam_config_variable_ibfk_1` FOREIGN KEY (`categorie_code`) REFERENCES `piwam_config_categorie` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `piwam_cotisation`
--
ALTER TABLE `piwam_cotisation`
  ADD CONSTRAINT `cotisation_FK_1` FOREIGN KEY (`compte_id`) REFERENCES `piwam_compte` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotisation_FK_2` FOREIGN KEY (`cotisation_type_id`) REFERENCES `piwam_cotisation_type` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotisation_FK_3` FOREIGN KEY (`membre_id`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotisation_FK_4` FOREIGN KEY (`enregistre_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotisation_FK_5` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `piwam_cotisation_type`
--
ALTER TABLE `piwam_cotisation_type`
  ADD CONSTRAINT `cotisation_type_FK_1` FOREIGN KEY (`association_id`) REFERENCES `piwam_association` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotisation_type_FK_2` FOREIGN KEY (`enregistre_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotisation_type_FK_3` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `piwam_depense`
--
ALTER TABLE `piwam_depense`
  ADD CONSTRAINT `depense_FK_1` FOREIGN KEY (`association_id`) REFERENCES `piwam_association` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `depense_FK_2` FOREIGN KEY (`compte_id`) REFERENCES `piwam_compte` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `depense_FK_3` FOREIGN KEY (`activite_id`) REFERENCES `piwam_activite` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `depense_FK_4` FOREIGN KEY (`enregistre_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `depense_FK_5` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `piwam_membre`
--
ALTER TABLE `piwam_membre`
  ADD CONSTRAINT `membre_FK_1` FOREIGN KEY (`statut_id`) REFERENCES `piwam_statut` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `membre_FK_2` FOREIGN KEY (`association_id`) REFERENCES `piwam_association` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `membre_FK_3` FOREIGN KEY (`enregistre_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `membre_FK_4` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `piwam_recette`
--
ALTER TABLE `piwam_recette`
  ADD CONSTRAINT `recette_FK_1` FOREIGN KEY (`association_id`) REFERENCES `piwam_association` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recette_FK_2` FOREIGN KEY (`compte_id`) REFERENCES `piwam_compte` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recette_FK_3` FOREIGN KEY (`activite_id`) REFERENCES `piwam_activite` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recette_FK_4` FOREIGN KEY (`enregistre_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recette_FK_5` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `piwam_statut`
--
ALTER TABLE `piwam_statut`
  ADD CONSTRAINT `statut_FK_1` FOREIGN KEY (`association_id`) REFERENCES `piwam_association` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `statut_FK_2` FOREIGN KEY (`enregistre_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `statut_FK_3` FOREIGN KEY (`mis_a_jour_par`) REFERENCES `piwam_membre` (`id`) ON DELETE CASCADE;


 --
 -- Think about updating the version !!
 --
 
 INSERT INTO `piwam_data` (`id`, `key`, `value`) VALUES
(1, 'dbversion', '190');