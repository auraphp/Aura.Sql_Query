<?php
/**
 *
 * This file is part of Aura for PHP.
 *
 * @package Aura.Sql_Query
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 */
namespace Aura\Sql_Query\Common;

use Aura\Sql_Query\AbstractQuery;
use Aura\Sql_Query\Traits;

/**
 *
 * An object for UPDATE queries.
 *
 * @package Aura.Sql_Query
 *
 */
class Update extends AbstractQuery implements UpdateInterface
{
    use Traits\ValuesTrait;

    /**
     *
     * The table to update.
     *
     * @var string
     *
     */
    protected $table;

    /**
     *
     * Sets the table to update.
     *
     * @param string $table The table to update.
     *
     * @return $this
     *
     */
    public function table($table)
    {
        $this->table = $this->quoteName($table);
        return $this;
    }
    
    /**
     * 
     * Builds this query object into a string.
     * 
     * @return string
     * 
     */
    protected function build()
    {
        $this->stm = 'UPDATE';
        $this->buildFlags();
        $this->buildTable();
        $this->buildValuesForUpdate();
        $this->buildWhere();
        return $this->stm;
    }
    
    /**
     * 
     * Builds the table clause.
     * 
     * @return null
     * 
     */
    protected function buildTable()
    {
        $this->stm .= " {$this->table}";
    }

    /**
     *
     * Adds a WHERE condition to the query by AND. If the condition has
     * ?-placeholders, additional arguments to the method will be bound to
     * those placeholders sequentially.
     *
     * @param string $cond The WHERE condition.
     * @param mixed ...$bind arguments to bind to placeholders
     *
     * @return $this
     *
     */
    public function where($cond)
    {
        $bind = func_get_args();
        array_shift($bind);

        $this->addWhere($cond, 'AND', $bind);

        return $this;
    }

    /**
     *
     * Adds a WHERE condition to the query by OR. If the condition has
     * ?-placeholders, additional arguments to the method will be bound to
     * those placeholders sequentially.
     *
     * @param string $cond The WHERE condition.
     * @param mixed ...$bind arguments to bind to placeholders
     *
     * @return $this
     *
     * @see where()
     *
     */
    public function orWhere($cond)
    {
        $bind = func_get_args();
        array_shift($bind);

        $this->addWhere($cond, 'OR', $bind);

        return $this;
    }
}
