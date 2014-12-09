<?php

namespace Unleashed\ShortenUrlBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'users_by_ip' table.
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
class UsersByIpTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Unleashed.ShortenUrlBundle.Model.map.UsersByIpTableMap';

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
        $this->setName('users_by_ip');
        $this->setPhpName('UsersByIp');
        $this->setClassname('Unleashed\\ShortenUrlBundle\\Model\\UsersByIp');
        $this->setPackage('src.Unleashed.ShortenUrlBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('ip_address', 'IpAddress', 'VARCHAR', true, 15, null);
        $this->addForeignKey('url_id', 'UrlId', 'INTEGER', 'urls', 'id', true, null, null);
        $this->addColumn('cookie', 'Cookie', 'INTEGER', false, null, null);
        $this->addColumn('last_redirect', 'LastRedirect', 'TIMESTAMP', true, null, null);
        $this->addColumn('redirect_count', 'RedirectCount', 'INTEGER', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Urls', 'Unleashed\\ShortenUrlBundle\\Model\\Urls', RelationMap::MANY_TO_ONE, array('url_id' => 'id', ), null, null);
    } // buildRelations()

} // UsersByIpTableMap
