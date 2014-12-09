<?php

namespace Unleashed\ShortenUrlBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Unleashed\ShortenUrlBundle\Model\UsersByIp;
use Unleashed\ShortenUrlBundle\Model\UsersByIpPeer;
use Unleashed\ShortenUrlBundle\Model\UsersByIpQuery;

/**
 * @method UsersByIpQuery orderById($order = Criteria::ASC) Order by the id column
 * @method UsersByIpQuery orderByIpAddress($order = Criteria::ASC) Order by the ip_address column
 * @method UsersByIpQuery orderByUrlId($order = Criteria::ASC) Order by the url_id column
 * @method UsersByIpQuery orderByCookie($order = Criteria::ASC) Order by the cookie column
 * @method UsersByIpQuery orderByLastRedirect($order = Criteria::ASC) Order by the last_redirect column
 * @method UsersByIpQuery orderByRedirectCount($order = Criteria::ASC) Order by the redirect_count column
 *
 * @method UsersByIpQuery groupById() Group by the id column
 * @method UsersByIpQuery groupByIpAddress() Group by the ip_address column
 * @method UsersByIpQuery groupByUrlId() Group by the url_id column
 * @method UsersByIpQuery groupByCookie() Group by the cookie column
 * @method UsersByIpQuery groupByLastRedirect() Group by the last_redirect column
 * @method UsersByIpQuery groupByRedirectCount() Group by the redirect_count column
 *
 * @method UsersByIpQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method UsersByIpQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method UsersByIpQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method UsersByIp findOne(PropelPDO $con = null) Return the first UsersByIp matching the query
 * @method UsersByIp findOneOrCreate(PropelPDO $con = null) Return the first UsersByIp matching the query, or a new UsersByIp object populated from the query conditions when no match is found
 *
 * @method UsersByIp findOneByIpAddress(string $ip_address) Return the first UsersByIp filtered by the ip_address column
 * @method UsersByIp findOneByUrlId(int $url_id) Return the first UsersByIp filtered by the url_id column
 * @method UsersByIp findOneByCookie(int $cookie) Return the first UsersByIp filtered by the cookie column
 * @method UsersByIp findOneByLastRedirect(string $last_redirect) Return the first UsersByIp filtered by the last_redirect column
 * @method UsersByIp findOneByRedirectCount(int $redirect_count) Return the first UsersByIp filtered by the redirect_count column
 *
 * @method array findById(int $id) Return UsersByIp objects filtered by the id column
 * @method array findByIpAddress(string $ip_address) Return UsersByIp objects filtered by the ip_address column
 * @method array findByUrlId(int $url_id) Return UsersByIp objects filtered by the url_id column
 * @method array findByCookie(int $cookie) Return UsersByIp objects filtered by the cookie column
 * @method array findByLastRedirect(string $last_redirect) Return UsersByIp objects filtered by the last_redirect column
 * @method array findByRedirectCount(int $redirect_count) Return UsersByIp objects filtered by the redirect_count column
 */
abstract class BaseUsersByIpQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseUsersByIpQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'default';
        }
        if (null === $modelName) {
            $modelName = 'Unleashed\\ShortenUrlBundle\\Model\\UsersByIp';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new UsersByIpQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   UsersByIpQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return UsersByIpQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof UsersByIpQuery) {
            return $criteria;
        }
        $query = new UsersByIpQuery(null, null, $modelAlias);

        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   UsersByIp|UsersByIp[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UsersByIpPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(UsersByIpPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 UsersByIp A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 UsersByIp A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `ip_address`, `url_id`, `cookie`, `last_redirect`, `redirect_count` FROM `users_by_ip` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new UsersByIp();
            $obj->hydrate($row);
            UsersByIpPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return UsersByIp|UsersByIp[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|UsersByIp[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return UsersByIpQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UsersByIpPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return UsersByIpQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UsersByIpPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UsersByIpQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UsersByIpPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UsersByIpPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersByIpPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the ip_address column
     *
     * Example usage:
     * <code>
     * $query->filterByIpAddress('fooValue');   // WHERE ip_address = 'fooValue'
     * $query->filterByIpAddress('%fooValue%'); // WHERE ip_address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ipAddress The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UsersByIpQuery The current query, for fluid interface
     */
    public function filterByIpAddress($ipAddress = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ipAddress)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ipAddress)) {
                $ipAddress = str_replace('*', '%', $ipAddress);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UsersByIpPeer::IP_ADDRESS, $ipAddress, $comparison);
    }

    /**
     * Filter the query on the url_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUrlId(1234); // WHERE url_id = 1234
     * $query->filterByUrlId(array(12, 34)); // WHERE url_id IN (12, 34)
     * $query->filterByUrlId(array('min' => 12)); // WHERE url_id >= 12
     * $query->filterByUrlId(array('max' => 12)); // WHERE url_id <= 12
     * </code>
     *
     * @param     mixed $urlId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UsersByIpQuery The current query, for fluid interface
     */
    public function filterByUrlId($urlId = null, $comparison = null)
    {
        if (is_array($urlId)) {
            $useMinMax = false;
            if (isset($urlId['min'])) {
                $this->addUsingAlias(UsersByIpPeer::URL_ID, $urlId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($urlId['max'])) {
                $this->addUsingAlias(UsersByIpPeer::URL_ID, $urlId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersByIpPeer::URL_ID, $urlId, $comparison);
    }

    /**
     * Filter the query on the cookie column
     *
     * Example usage:
     * <code>
     * $query->filterByCookie(1234); // WHERE cookie = 1234
     * $query->filterByCookie(array(12, 34)); // WHERE cookie IN (12, 34)
     * $query->filterByCookie(array('min' => 12)); // WHERE cookie >= 12
     * $query->filterByCookie(array('max' => 12)); // WHERE cookie <= 12
     * </code>
     *
     * @param     mixed $cookie The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UsersByIpQuery The current query, for fluid interface
     */
    public function filterByCookie($cookie = null, $comparison = null)
    {
        if (is_array($cookie)) {
            $useMinMax = false;
            if (isset($cookie['min'])) {
                $this->addUsingAlias(UsersByIpPeer::COOKIE, $cookie['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cookie['max'])) {
                $this->addUsingAlias(UsersByIpPeer::COOKIE, $cookie['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersByIpPeer::COOKIE, $cookie, $comparison);
    }

    /**
     * Filter the query on the last_redirect column
     *
     * Example usage:
     * <code>
     * $query->filterByLastRedirect('2011-03-14'); // WHERE last_redirect = '2011-03-14'
     * $query->filterByLastRedirect('now'); // WHERE last_redirect = '2011-03-14'
     * $query->filterByLastRedirect(array('max' => 'yesterday')); // WHERE last_redirect < '2011-03-13'
     * </code>
     *
     * @param     mixed $lastRedirect The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UsersByIpQuery The current query, for fluid interface
     */
    public function filterByLastRedirect($lastRedirect = null, $comparison = null)
    {
        if (is_array($lastRedirect)) {
            $useMinMax = false;
            if (isset($lastRedirect['min'])) {
                $this->addUsingAlias(UsersByIpPeer::LAST_REDIRECT, $lastRedirect['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastRedirect['max'])) {
                $this->addUsingAlias(UsersByIpPeer::LAST_REDIRECT, $lastRedirect['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersByIpPeer::LAST_REDIRECT, $lastRedirect, $comparison);
    }

    /**
     * Filter the query on the redirect_count column
     *
     * Example usage:
     * <code>
     * $query->filterByRedirectCount(1234); // WHERE redirect_count = 1234
     * $query->filterByRedirectCount(array(12, 34)); // WHERE redirect_count IN (12, 34)
     * $query->filterByRedirectCount(array('min' => 12)); // WHERE redirect_count >= 12
     * $query->filterByRedirectCount(array('max' => 12)); // WHERE redirect_count <= 12
     * </code>
     *
     * @param     mixed $redirectCount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UsersByIpQuery The current query, for fluid interface
     */
    public function filterByRedirectCount($redirectCount = null, $comparison = null)
    {
        if (is_array($redirectCount)) {
            $useMinMax = false;
            if (isset($redirectCount['min'])) {
                $this->addUsingAlias(UsersByIpPeer::REDIRECT_COUNT, $redirectCount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($redirectCount['max'])) {
                $this->addUsingAlias(UsersByIpPeer::REDIRECT_COUNT, $redirectCount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersByIpPeer::REDIRECT_COUNT, $redirectCount, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   UsersByIp $usersByIp Object to remove from the list of results
     *
     * @return UsersByIpQuery The current query, for fluid interface
     */
    public function prune($usersByIp = null)
    {
        if ($usersByIp) {
            $this->addUsingAlias(UsersByIpPeer::ID, $usersByIp->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
