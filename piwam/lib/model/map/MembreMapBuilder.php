<?php


/**
 * This class adds structure of 'piwam_membre' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Mon Nov  9 18:14:02 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class MembreMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.MembreMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(MembrePeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(MembrePeer::TABLE_NAME);
		$tMap->setPhpName('Membre');
		$tMap->setClassname('Membre');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('NOM', 'Nom', 'VARCHAR', true, 255);

		$tMap->addColumn('PRENOM', 'Prenom', 'VARCHAR', true, 255);

		$tMap->addColumn('PSEUDO', 'Pseudo', 'VARCHAR', false, 255);

		$tMap->addColumn('PASSWORD', 'Password', 'VARCHAR', false, 255);

		$tMap->addForeignKey('STATUT_ID', 'StatutId', 'INTEGER', 'piwam_statut', 'ID', true, null);

		$tMap->addColumn('DATE_INSCRIPTION', 'DateInscription', 'DATE', true, null);

		$tMap->addColumn('EXEMPTE_COTISATION', 'ExempteCotisation', 'BOOLEAN', true, null);

		$tMap->addColumn('RUE', 'Rue', 'VARCHAR', false, 255);

		$tMap->addColumn('CP', 'Cp', 'VARCHAR', false, 8);

		$tMap->addColumn('VILLE', 'Ville', 'VARCHAR', false, 255);

		$tMap->addColumn('PAYS', 'Pays', 'VARCHAR', false, 8);

		$tMap->addColumn('PICTURE', 'Picture', 'VARCHAR', false, 255);

		$tMap->addColumn('EMAIL', 'Email', 'VARCHAR', false, 255);

		$tMap->addColumn('WEBSITE', 'Website', 'VARCHAR', false, 255);

		$tMap->addColumn('TEL_FIXE', 'TelFixe', 'VARCHAR', false, 16);

		$tMap->addColumn('TEL_PORTABLE', 'TelPortable', 'VARCHAR', false, 16);

		$tMap->addColumn('ACTIF', 'Actif', 'INTEGER', false, null);

		$tMap->addForeignKey('ASSOCIATION_ID', 'AssociationId', 'INTEGER', 'piwam_association', 'ID', true, null);

		$tMap->addForeignKey('ENREGISTRE_PAR', 'EnregistrePar', 'INTEGER', 'piwam_membre', 'ID', false, null);

		$tMap->addForeignKey('MIS_A_JOUR_PAR', 'MisAJourPar', 'INTEGER', 'piwam_membre', 'ID', false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // MembreMapBuilder
