<?php
/**
 * Created by PhpStorm.
 * User: TyckoFranklin
 * Date: 10/9/2018
 * Time: 12:15 AM
 */

namespace src\util\database\InsertQueryBuilder;


class InsertQueryBuilder
{
    private $table = null;
    private $fieldNames = [];
    private $fieldValues = [];

    /**
     * InsertQueryBuilder constructor.
     * @return InsertQueryBuilder
     */
    public function __construct()
    {
        return $this;
    }


    /**
     * @param string $table
     * @return InsertQueryBuilder
     */
    public function intoTable($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * field name, and field with quotes around it
     * @param $fieldName
     * @param $fieldValue
     * @return InsertQueryBuilder
     */
    public function withField($fieldName, $fieldValue)
    {
        array_push($this->fieldValues, "'$fieldValue'");
        array_push($this->fieldNames, $fieldName);
        return $this;
    }

    /**
     * field name, and special field value without quotes around it
     * @param $fieldName
     * @param $fieldValue
     * @return InsertQueryBuilder
     */
    public function withSpecialField($fieldName, $fieldValue)
    {
        array_push($this->fieldValues, $fieldValue);
        array_push($this->fieldNames, $fieldName);
        return $this;
    }

    /**
     * @return string
     */
    public function build(){
        /* insert into table */
        $query = "INSERT INTO $this->table (";

        /*  field names  */
        $comma = false;
        foreach ($this->fieldNames as $name){
            if ($comma){
                $query .= ", ";
            }
            $query .= "$name";
            $comma = true;
        }
        $query .= ") ";

        /* field values */
        $query .= " VALUES (";
        $comma = false;
        foreach ($this->fieldValues as $value){
            if ($comma){
                $query .= ", ";
            }
            $query .= "$value";
            $comma = true;
        }
        $query .= ") ";

        return $query;
    }

}