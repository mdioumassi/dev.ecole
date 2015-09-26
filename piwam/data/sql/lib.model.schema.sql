
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- piwam_data
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `piwam_data`;


CREATE TABLE `piwam_data`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`key` VARCHAR(255)  NOT NULL,
	`value` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `piwam_data_U_1` (`key`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- piwam_acl_module
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `piwam_acl_module`;


CREATE TABLE `piwam_acl_module`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`libelle` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- piwam_acl_action
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `piwam_acl_action`;


CREATE TABLE `piwam_acl_action`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`acl_module_id` INTEGER  NOT NULL,
	`libelle` VARCHAR(255)  NOT NULL,
	`code` VARCHAR(100)  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `piwam_acl_action_FI_1` (`acl_module_id`),
	CONSTRAINT `piwam_acl_action_FK_1`
		FOREIGN KEY (`acl_module_id`)
		REFERENCES `piwam_acl_module` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- piwam_acl_credential
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `piwam_acl_credential`;


CREATE TABLE `piwam_acl_credential`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`membre_id` INTEGER  NOT NULL,
	`acl_action_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `piwam_acl_credential_FI_1` (`membre_id`),
	CONSTRAINT `piwam_acl_credential_FK_1`
		FOREIGN KEY (`membre_id`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_acl_credential_FI_2` (`acl_action_id`),
	CONSTRAINT `piwam_acl_credential_FK_2`
		FOREIGN KEY (`acl_action_id`)
		REFERENCES `piwam_acl_action` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- piwam_config_categorie
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `piwam_config_categorie`;


CREATE TABLE `piwam_config_categorie`
(
	`code` VARCHAR(20)  NOT NULL,
	`libelle` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`code`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- piwam_config_variable
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `piwam_config_variable`;


CREATE TABLE `piwam_config_variable`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`code` VARCHAR(20)  NOT NULL,
	`categorie_code` VARCHAR(20)  NOT NULL,
	`libelle` VARCHAR(255)  NOT NULL,
	`description` TEXT,
	`type` VARCHAR(255)  NOT NULL,
	`default_value` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `piwam_config_variable_FI_1` (`categorie_code`),
	CONSTRAINT `piwam_config_variable_FK_1`
		FOREIGN KEY (`categorie_code`)
		REFERENCES `piwam_config_categorie` (`code`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- piwam_config_value
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `piwam_config_value`;


CREATE TABLE `piwam_config_value`
(
	`config_variable_id` INTEGER  NOT NULL,
	`association_id` INTEGER  NOT NULL,
	`custom_value` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`config_variable_id`,`association_id`),
	CONSTRAINT `piwam_config_value_FK_1`
		FOREIGN KEY (`config_variable_id`)
		REFERENCES `piwam_config_variable` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_config_value_FI_2` (`association_id`),
	CONSTRAINT `piwam_config_value_FK_2`
		FOREIGN KEY (`association_id`)
		REFERENCES `piwam_association` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- piwam_activite
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `piwam_activite`;


CREATE TABLE `piwam_activite`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`libelle` VARCHAR(255)  NOT NULL,
	`actif` TINYINT default 1,
	`association_id` INTEGER  NOT NULL,
	`enregistre_par` INTEGER,
	`mis_a_jour_par` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `piwam_activite_FI_1` (`association_id`),
	CONSTRAINT `piwam_activite_FK_1`
		FOREIGN KEY (`association_id`)
		REFERENCES `piwam_association` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_activite_FI_2` (`enregistre_par`),
	CONSTRAINT `piwam_activite_FK_2`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_activite_FI_3` (`mis_a_jour_par`),
	CONSTRAINT `piwam_activite_FK_3`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- piwam_association
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `piwam_association`;


CREATE TABLE `piwam_association`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nom` VARCHAR(120)  NOT NULL,
	`description` VARCHAR(255),
	`site_web` VARCHAR(255),
	`enregistre_par` INTEGER,
	`mis_a_jour_par` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `piwam_association_FI_1` (`enregistre_par`),
	CONSTRAINT `piwam_association_FK_1`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_association_FI_2` (`mis_a_jour_par`),
	CONSTRAINT `piwam_association_FK_2`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- piwam_compte
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `piwam_compte`;


CREATE TABLE `piwam_compte`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`libelle` VARCHAR(255)  NOT NULL,
	`association_id` INTEGER  NOT NULL,
	`reference` VARCHAR(64)  NOT NULL,
	`actif` TINYINT default 1,
	`enregistre_par` INTEGER,
	`mis_a_jour_par` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `piwam_compte_FI_1` (`association_id`),
	CONSTRAINT `piwam_compte_FK_1`
		FOREIGN KEY (`association_id`)
		REFERENCES `piwam_association` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_compte_FI_2` (`enregistre_par`),
	CONSTRAINT `piwam_compte_FK_2`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_compte_FI_3` (`mis_a_jour_par`),
	CONSTRAINT `piwam_compte_FK_3`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- piwam_cotisation
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `piwam_cotisation`;


CREATE TABLE `piwam_cotisation`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`compte_id` INTEGER  NOT NULL,
	`cotisation_type_id` INTEGER  NOT NULL,
	`membre_id` INTEGER  NOT NULL,
	`date` DATE  NOT NULL,
	`enregistre_par` INTEGER  NOT NULL,
	`montant` DECIMAL(10,2)  NOT NULL,
	`mis_a_jour_par` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `piwam_cotisation_FI_1` (`compte_id`),
	CONSTRAINT `piwam_cotisation_FK_1`
		FOREIGN KEY (`compte_id`)
		REFERENCES `piwam_compte` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_cotisation_FI_2` (`cotisation_type_id`),
	CONSTRAINT `piwam_cotisation_FK_2`
		FOREIGN KEY (`cotisation_type_id`)
		REFERENCES `piwam_cotisation_type` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_cotisation_FI_3` (`membre_id`),
	CONSTRAINT `piwam_cotisation_FK_3`
		FOREIGN KEY (`membre_id`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_cotisation_FI_4` (`enregistre_par`),
	CONSTRAINT `piwam_cotisation_FK_4`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_cotisation_FI_5` (`mis_a_jour_par`),
	CONSTRAINT `piwam_cotisation_FK_5`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- piwam_cotisation_type
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `piwam_cotisation_type`;


CREATE TABLE `piwam_cotisation_type`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`libelle` VARCHAR(255)  NOT NULL,
	`association_id` INTEGER  NOT NULL,
	`valide` INTEGER  NOT NULL,
	`montant` DECIMAL(10,2)  NOT NULL,
	`actif` TINYINT default 1,
	`enregistre_par` INTEGER  NOT NULL,
	`mis_a_jour_par` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `piwam_cotisation_type_FI_1` (`association_id`),
	CONSTRAINT `piwam_cotisation_type_FK_1`
		FOREIGN KEY (`association_id`)
		REFERENCES `piwam_association` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_cotisation_type_FI_2` (`enregistre_par`),
	CONSTRAINT `piwam_cotisation_type_FK_2`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_cotisation_type_FI_3` (`mis_a_jour_par`),
	CONSTRAINT `piwam_cotisation_type_FK_3`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- piwam_depense
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `piwam_depense`;


CREATE TABLE `piwam_depense`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`libelle` VARCHAR(255)  NOT NULL,
	`montant` DECIMAL(10,2)  NOT NULL,
	`association_id` INTEGER  NOT NULL,
	`compte_id` INTEGER  NOT NULL,
	`activite_id` INTEGER  NOT NULL,
	`date` DATE  NOT NULL,
	`payee` TINYINT default 1,
	`enregistre_par` INTEGER  NOT NULL,
	`mis_a_jour_par` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `piwam_depense_FI_1` (`association_id`),
	CONSTRAINT `piwam_depense_FK_1`
		FOREIGN KEY (`association_id`)
		REFERENCES `piwam_association` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_depense_FI_2` (`compte_id`),
	CONSTRAINT `piwam_depense_FK_2`
		FOREIGN KEY (`compte_id`)
		REFERENCES `piwam_compte` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_depense_FI_3` (`activite_id`),
	CONSTRAINT `piwam_depense_FK_3`
		FOREIGN KEY (`activite_id`)
		REFERENCES `piwam_activite` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_depense_FI_4` (`enregistre_par`),
	CONSTRAINT `piwam_depense_FK_4`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_depense_FI_5` (`mis_a_jour_par`),
	CONSTRAINT `piwam_depense_FK_5`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- piwam_membre
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `piwam_membre`;


CREATE TABLE `piwam_membre`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nom` VARCHAR(255)  NOT NULL,
	`prenom` VARCHAR(255)  NOT NULL,
	`pseudo` VARCHAR(255),
	`password` VARCHAR(255),
	`statut_id` INTEGER  NOT NULL,
	`date_inscription` DATE  NOT NULL,
	`exempte_cotisation` TINYINT  NOT NULL,
	`rue` VARCHAR(255),
	`cp` VARCHAR(8),
	`ville` VARCHAR(255),
	`pays` VARCHAR(8),
	`email` VARCHAR(255),
	`website` VARCHAR(255),
	`tel_fixe` VARCHAR(16),
	`tel_portable` VARCHAR(16),
	`actif` TINYINT default 1,
	`association_id` INTEGER  NOT NULL,
	`enregistre_par` INTEGER,
	`mis_a_jour_par` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `piwam_membre_U_1` (`pseudo`),
	INDEX `piwam_membre_FI_1` (`statut_id`),
	CONSTRAINT `piwam_membre_FK_1`
		FOREIGN KEY (`statut_id`)
		REFERENCES `piwam_statut` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_membre_FI_2` (`association_id`),
	CONSTRAINT `piwam_membre_FK_2`
		FOREIGN KEY (`association_id`)
		REFERENCES `piwam_association` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_membre_FI_3` (`enregistre_par`),
	CONSTRAINT `piwam_membre_FK_3`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_membre_FI_4` (`mis_a_jour_par`),
	CONSTRAINT `piwam_membre_FK_4`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- piwam_recette
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `piwam_recette`;


CREATE TABLE `piwam_recette`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`libelle` VARCHAR(255)  NOT NULL,
	`association_id` INTEGER  NOT NULL,
	`montant` DECIMAL(10,2)  NOT NULL,
	`compte_id` INTEGER  NOT NULL,
	`activite_id` INTEGER  NOT NULL,
	`date` DATE  NOT NULL,
	`percue` TINYINT default 1,
	`enregistre_par` INTEGER  NOT NULL,
	`mis_a_jour_par` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `piwam_recette_FI_1` (`association_id`),
	CONSTRAINT `piwam_recette_FK_1`
		FOREIGN KEY (`association_id`)
		REFERENCES `piwam_association` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_recette_FI_2` (`compte_id`),
	CONSTRAINT `piwam_recette_FK_2`
		FOREIGN KEY (`compte_id`)
		REFERENCES `piwam_compte` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_recette_FI_3` (`activite_id`),
	CONSTRAINT `piwam_recette_FK_3`
		FOREIGN KEY (`activite_id`)
		REFERENCES `piwam_activite` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_recette_FI_4` (`enregistre_par`),
	CONSTRAINT `piwam_recette_FK_4`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_recette_FI_5` (`mis_a_jour_par`),
	CONSTRAINT `piwam_recette_FK_5`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- piwam_statut
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `piwam_statut`;


CREATE TABLE `piwam_statut`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nom` VARCHAR(255)  NOT NULL,
	`association_id` INTEGER  NOT NULL,
	`actif` TINYINT default 1,
	`enregistre_par` INTEGER,
	`mis_a_jour_par` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `piwam_statut_FI_1` (`association_id`),
	CONSTRAINT `piwam_statut_FK_1`
		FOREIGN KEY (`association_id`)
		REFERENCES `piwam_association` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_statut_FI_2` (`enregistre_par`),
	CONSTRAINT `piwam_statut_FK_2`
		FOREIGN KEY (`enregistre_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE,
	INDEX `piwam_statut_FI_3` (`mis_a_jour_par`),
	CONSTRAINT `piwam_statut_FK_3`
		FOREIGN KEY (`mis_a_jour_par`)
		REFERENCES `piwam_membre` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
