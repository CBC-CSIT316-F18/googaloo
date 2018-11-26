<?php
/**
 * Created by PhpStorm.
 * User: Tycko Franklin
 * Date: 11/24/2018
 * Time: 11:24 AM
 */

namespace src\util\DTOs\LessonDTO;

use mysqli_result;

/**
 * Class LessonDTO
 *
 * Stores uploaded lessons in a format that can be easily accessed and passed around.
 *
 * @package src\util\DTOs\LessonDTO
 */
class LessonDTO
{

    /** @var String $id */
    private $id;
    /** @var String $userid */
    private $userid;
    /** @var String $title */
    private $title;
    /** @var String $filealias */
    private $filealias;
    /** @var String $filename */
    private $filename;
    /** @var String $filedescription */
    private $filedescription;
    /** @var String $date_created */
    private $date_created;
    /** @var String $date_modified */
    private $date_modified;

    /**
     * @param $row
     * @return LessonDTO
     */
    public function parseDatabaseResult($row)
    {
        foreach ($row as $column => $field) {
            switch ($column){
                case "id":
                    $this->id = $field;
                    break;
                case "userid":
                    $this->userid = $field;
                    break;
                case "title":
                    $this->title = $field;
                    break;
                case "filealias":
                    $this->filealias = $field;
                    break;
                case "filename":
                    $this->filename = $field;
                    break;
                case "filedescription":
                    $this->filedescription = $field;
                    break;
                case "date_created":
                    $this->date_created = $field;
                    break;
                case "date_modified":
                    $this->date_modified = $field;
                    break;
                default:
                    echo "Unhandled field";
            }
        }
        return $this;
    }

    /**
     * @return String
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return String
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @return String
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return String
     */
    public function getFilealias()
    {
        return $this->filealias;
    }

    /**
     * @return String
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return String
     */
    public function getFiledescription()
    {
        return $this->filedescription;
    }

    /**
     * @return String
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @return String
     */
    public function getDateModified()
    {
        return $this->date_modified;
    }


}