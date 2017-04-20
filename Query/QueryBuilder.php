<?php

namespace Akeneo\SalesForce\Query;

/**
 * @author Anael Chardan <anael.chardan@akeneo.com>
 */
class QueryBuilder
{
    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var string
     */
    protected $query = '';

    /**
     * @param string $field
     *
     * @return QueryBuilder
     */
    public function select(string $field): QueryBuilder
    {
        $this->query = sprintf('SELECT %s', $field);

        return $this;
    }

    /**
     * @param string $field
     *
     * @return QueryBuilder
     */
    public function addSelect(string $field): QueryBuilder
    {
        $this->query = sprintf('%s, %s', $this->query, $field);

        return $this;
    }

    /**
     * @param string $table
     *
     * @return QueryBuilder
     */
    public function from(string $table): QueryBuilder
    {
        $this->query = sprintf('%s FROM %s', $this->query, $table);

        return $this;
    }

    /**
     * @param string $condition
     *
     * @return QueryBuilder
     */
    public function where(string $condition): QueryBuilder
    {
        $this->query = sprintf('%s WHERE %s', $this->query, $condition);

        return $this;
    }

    /**
     * @param string $fieldName
     * @param string $value
     *
     * @return string
     */
    public function getEqualCondition(string $fieldName, string $value): string
    {
        return sprintf('%s = \'%s\'', $fieldName, $value);
    }

    /**
     * @param string $fieldName
     * @param string $value
     *
     * @return string
     */
    public function getNotEqualCondition(string $fieldName, string $value): string
    {
        return sprintf('%s != \'%s\'', $fieldName, $value);
    }

    /**
     * @param string $condition
     *
     * @return QueryBuilder
     */
    public function andWhere(string $condition): QueryBuilder
    {
        $this->query = sprintf('%s AND %s', $this->query, $condition);

        return $this;
    }

    /**
     * @param string $condition
     *
     * @return QueryBuilder
     */
    public function orWhere(string $condition): QueryBuilder
    {
        $this->query = sprintf('%s OR %s', $this->query, $condition);

        return $this;
    }

    /**
     * @param string $condition
     *
     * @return QueryBuilder
     */
    public function orderBy(string $fieldName): QueryBuilder
    {
        $this->query = sprintf('%s ORDER BY %s', $this->query, $fieldName);

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return QueryBuilder
     */
    public function setParameter(string $name, string $value): QueryBuilder
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        $result = $this->query;

        foreach ($this->parameters as $parameterKey => $parameterValue) {
            $result = str_replace(sprintf(':%s', $parameterKey), $parameterValue, $result);
        }

        return $result;
    }
}
