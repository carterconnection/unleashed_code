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
use Unleashed\ShortenUrlBundle\Model\Urls;
use Unleashed\ShortenUrlBundle\Model\UrlsPeer;
use Unleashed\ShortenUrlBundle\Model\UrlsQuery;

/**
 * @method UrlsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method UrlsQuery orderByFullUrl($order = Criteria::ASC) Order by the full_url column
 * @method UrlsQuery orderByUrlCode($order = Criteria::ASC) Order by the url_code column
 * @method UrlsQuery orderByDateAdded($order = Criteria::ASC) Order by the date_added column
 * @method UrlsQuery orderByRedirectCount($order = Criteria::ASC) Order by the redirect_count column
 * @method UrlsQuery orderByQrCode($order = Criteria::ASC) Order by the qr_code column
 *
 * @method UrlsQuery groupById() Group by the id column
 * @method UrlsQuery groupByFullUrl() Group by the full_url column
 * @method UrlsQuery groupByUrlCode() Group by the url_code column
 * @method UrlsQuery groupByDateAdded() Group by the date_added column
 * @method UrlsQuery groupByRedirectCount() Group by the redirect_count column
 * @method UrlsQuery groupByQrCode() Group by the qr_code column
 *
 * @method UrlsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method UrlsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method UrlsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method Urls findOne(PropelPDO $con = null) Return the first Urls matching the query
 * @method Urls findOneOrCreate(PropelPDO $con = null) Return the first Urls matching the query, or a new Urls object populated from the query conditions when no match is found
 *
 * @method Urls findOneByFullUrl(string $full_url) Return the first Urls filtered by the full_url column
 * @method Urls findOneByUrlCode(string $url_code) Return the first Urls filtered by the url_code column
 * @method Urls findOneByDateAdded(string $date_added) Return the first Urls filtered by the date_added column
 * @method Urls findOneByRedirectCount(int $redirect_count) Return the first Urls filtered by the redirect_count column
 * @method Urls findOneByQrCode(string $qr_code) Return the first Urls filtered by the qr_code column
 *
 * @method array findById(int $id) Return Urls objects filtered by the id column
 * @method array findByFullUrl(string $full_url) Return Urls objects filtered by the full_url column
 * @method array findByUrlCode(string $url_code) Return Urls objects filtered by the url_code column
 * @method array findByDateAdded(string $date_added) Return Urls objects filtered by the date_added column
 * @method array findByRedirectCount(int $redirect_count) Return Urls objects filtered by the redirect_count column
 * @method array findByQrCode(string $qr_code) Return Urls objects filtered by the qr_code column
 */
abstract class BaseUrlsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseUrlsQuery object.
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
            $modelName = 'Unleashed\\ShortenUrlBundle\\Model\\Urls';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new UrlsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   UrlsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return UrlsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof UrlsQuery) {
            return $criteria;
        }
        $query = new UrlsQuery(null, null, $modelAlias);

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
     * @return   Urls|Urls[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UrlsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(UrlsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Urls A model object, or null if the key is not found
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
     * @return                 Urls A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `full_url`, `url_code`, `date_added`, `redirect_count`, `qr_code` FROM `urls` WHERE `id` = :p0';
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
            $obj = new Urls();
            $obj->hydrate($row);
            UrlsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Urls|Urls[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Urls[]|mixed the list of results, formatted by the current formatter
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
     * @return UrlsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UrlsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return UrlsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UrlsPeer::ID, $keys, Criteria::IN);
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
     * @return UrlsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UrlsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UrlsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UrlsPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the full_url column
     *
     * Example usage:
     * <code>
     * $query->filterByFullUrl('fooValue');   // WHERE full_url = 'fooValue'
     * $query->filterByFullUrl('%fooValue%'); // WHERE full_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fullUrl The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UrlsQuery The current query, for fluid interface
     */
    public function filterByFullUrl($fullUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fullUrl)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fullUrl)) {
                $fullUrl = str_replace('*', '%', $fullUrl);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UrlsPeer::FULL_URL, $fullUrl, $comparison);
    }

    /**
     * Filter the query on the url_code column
     *
     * Example usage:
     * <code>
     * $query->filterByUrlCode('fooValue');   // WHERE url_code = 'fooValue'
     * $query->filterByUrlCode('%fooValue%'); // WHERE url_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $urlCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UrlsQuery The current query, for fluid interface
     */
    public function filterByUrlCode($urlCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($urlCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $urlCode)) {
                $urlCode = str_replace('*', '%', $urlCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UrlsPeer::URL_CODE, $urlCode, $comparison);
    }

    /**
     * Filter the query on the date_added column
     *
     * Example usage:
     * <code>
     * $query->filterByDateAdded('2011-03-14'); // WHERE date_added = '2011-03-14'
     * $query->filterByDateAdded('now'); // WHERE date_added = '2011-03-14'
     * $query->filterByDateAdded(array('max' => 'yesterday')); // WHERE date_added < '2011-03-13'
     * </code>
     *
     * @param     mixed $dateAdded The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UrlsQuery The current query, for fluid interface
     */
    public function filterByDateAdded($dateAdded = null, $comparison = null)
    {
        if (is_array($dateAdded)) {
            $useMinMax = false;
            if (isset($dateAdded['min'])) {
                $this->addUsingAlias(UrlsPeer::DATE_ADDED, $dateAdded['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateAdded['max'])) {
                $this->addUsingAlias(UrlsPeer::DATE_ADDED, $dateAdded['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UrlsPeer::DATE_ADDED, $dateAdded, $comparison);
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
     * @return UrlsQuery The current query, for fluid interface
     */
    public function filterByRedirectCount($redirectCount = null, $comparison = null)
    {
        if (is_array($redirectCount)) {
            $useMinMax = false;
            if (isset($redirectCount['min'])) {
                $this->addUsingAlias(UrlsPeer::REDIRECT_COUNT, $redirectCount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($redirectCount['max'])) {
                $this->addUsingAlias(UrlsPeer::REDIRECT_COUNT, $redirectCount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UrlsPeer::REDIRECT_COUNT, $redirectCount, $comparison);
    }

    /**
     * Filter the query on the qr_code column
     *
     * Example usage:
     * <code>
     * $query->filterByQrCode('fooValue');   // WHERE qr_code = 'fooValue'
     * $query->filterByQrCode('%fooValue%'); // WHERE qr_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $qrCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UrlsQuery The current query, for fluid interface
     */
    public function filterByQrCode($qrCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($qrCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $qrCode)) {
                $qrCode = str_replace('*', '%', $qrCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UrlsPeer::QR_CODE, $qrCode, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   Urls $urls Object to remove from the list of results
     *
     * @return UrlsQuery The current query, for fluid interface
     */
    public function prune($urls = null)
    {
        if ($urls) {
            $this->addUsingAlias(UrlsPeer::ID, $urls->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
