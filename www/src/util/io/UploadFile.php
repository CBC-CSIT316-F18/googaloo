<?php
/**
 * Created by PhpStorm.
 * User: Tycko Franklin
 * Date: 11/23/2018
 * Time: 10:56 PM
 */
namespace src\util\io\UploadFile;

use src\util\database\db_tools\db_tools;
use src\util\database\InsertQueryBuilder\InsertQueryBuilder;

class UploadFile
{
    /** @var db_tools */
    private $dbTools = null;

    /**
     * UploadFile constructor.
     * @param String $fileIdnetifier
     * @param String $description
     *
     * @return boolean
     */
    public function __construct($fileIdnetifier, $title, $description)
    {
        /* Check to see if data folder exists, if not, created it  */
        if(!file_exists(DATA_FOLDER)){
            mkdir(DATA_FOLDER);
        }

        $this->dbTools = new db_tools();
        $dbc = $this->dbTools->db_connect();

        $fileNameNew = $_SESSION['userID'] . "_". str_replace(".", "", microtime(true)) . ".data";



        $fileName = $this->dbTools->escapeStringForDBUse($_FILES[$fileIdnetifier]["name"]);
        $titleSafe = $this->dbTools->escapeStringForDBUse($title);
        $descriptionSafe = $this->dbTools->escapeStringForDBUse($description);

        /** @var boolean $result */
        $result = move_uploaded_file($_FILES[$fileIdnetifier]["tmp_name"], DATA_FOLDER . $fileNameNew) > 0 ? true : false;

        if($result){
            $q = (new InsertQueryBuilder())
                ->intoTable("uploads")
                ->withField("userid", $_SESSION['userID'])
                ->withField("title", $titleSafe)
                ->withField("filealias", $fileNameNew)
                ->withField("filename", $fileName)
                ->withField("filedescription", $descriptionSafe)
                ->withSpecialField("date_created", "CURRENT_TIMESTAMP")
                ->withSpecialField("date_modified", "CURRENT_TIMESTAMP")
                ->build();

            /*
             *
              userid,
              title,
              filealias,
              filename,
              filedescription,
              date_created,
              date_modified
             */

            $r = mysqli_query($dbc, $q);

            $A = mysqli_affected_rows($dbc);
            if (mysqli_affected_rows($dbc) === 1) { // If it ran OK.
                $result &= true;
            } else {
                /*  Delete the file since database has issues.  */
                unlink(DATA_FOLDER . $fileNameNew);
                $result &= false;
            }
        }

        return $result;
    }
}