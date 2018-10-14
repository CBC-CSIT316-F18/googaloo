<?php
/**
 * Created by PhpStorm.
 * User: TyckoFranklin
 * Date: 10/13/2018
 * Time: 9:09 PM
 */

namespace src\util\database\SelectQueryBuilder;


class SelectQueryBuilder
{
    /** @var string $table */
    private $table = null;
    /** @var string $fields */
    private $fields = null;
    /** @var string $where */
    private $where = null;
    /** @var string $groupby */
    private $groupBy = null;


    /**
     * InsertQueryBuilder constructor.
     * @return SelectQueryBuilder
     */
    public function __construct()
    {
        return $this;
    }

    /**
     * @param string $table
     * @return SelectQueryBuilder
     */
    public function fromTable($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @param string $fields
     * @return SelectQueryBuilder
     */
    public function withFields($fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @param string $where
     * @return SelectQueryBuilder
     */
    public function withWhere($where)
    {
        $this->where = $where;
        return $this;
    }

    /**
     * @param string $groupBy
     * @return SelectQueryBuilder
     */
    public function withGroupBy($groupBy)
    {
        $this->groupBy = $groupBy;
        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function build(){
        if(is_null($this->fields)){
            throw new \Exception("Need Fields for Select");
        }

        if(is_null($this->table)){
            throw new \Exception("Need Table for Select");
        }

        /* build select statment */
        $query = "select {$this->fields} from {$this->table}";
        if(!is_null($this->where)){
            $query .= " where {$this->where}";
        }

        if(!is_null($this->groupBy)){
            $query .= " groupby {$this->groupBy}";
        }
        return $query;
    }
}