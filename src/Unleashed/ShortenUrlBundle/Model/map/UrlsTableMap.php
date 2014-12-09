<?php

namespace Unleashed\ShortenUrlBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'urls' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Unleashed.ShortenUrlBundle.Model.map
 */
class UrlsTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Unleashed.ShortenUrlBundle.Model.map.UrlsTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('urls');
        $this->setPhpName('Urls');
        $this->setClassname('Unleashed\\ShortenUrlBundle\\Model\\Urls');
        $this->setPackage('src.Unleashed.ShortenUrlBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('full_url', 'FullUrl', 'VARCHAR', true, 350, null);
        $this->addColumn('url_code', 'UrlCode', 'VARCHAR', true, 10, null);
        $this->addColumn('date_added', 'DateAdded', 'TIMESTAMP', true, null, null);
        $this->addColumn('redirect_count', 'RedirectCount', 'INTEGER', true, null, 0);
        $this->addColumn('qr_code', 'QrCode', 'VARCHAR', false, 250, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('UsersByIp', 'Unleashed\\ShortenUrlBundle\\Model\\UsersByIp', RelationMap::ONE_TO_MANY, array('id' => 'url_id', ), null, null, 'UsersByIps');
    } // buildRelations()

} // UrlsTableMap
