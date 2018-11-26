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

/**
 * Class UploadFile
 *
 * When instantiated, uploads or rather stores, the file
 * that has been sent in a post request from a file upload form.
 *
 * @package src\util\io\UploadFile
 */
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

        /*  Name of the file the user uploaded  */
        $fileName = $this->dbTools->escapeStringForDBUse($_FILES[$fileIdnetifier]["name"]);
        /*  The file name the file actually be stored as on the server  */
        $fileNameNew = $_SESSION['userID'] . "_" . md5($fileName) .  "_" . str_replace(".", "", microtime(true)) . ".data";
        $filepath = DATA_FOLDER . $fileNameNew;
        /*  Title the user gave the file  */
        $titleSafe = $this->dbTools->escapeStringForDBUse($title);
        /*  Description the user gave the file  */
        $descriptionSafe = $this->dbTools->escapeStringForDBUse($description);


        /*  Store the file  */
        /** @var boolean $result */
        $result = move_uploaded_file($_FILES[$fileIdnetifier]["tmp_name"], DATA_FOLDER . $fileNameNew) > 0 ? true : false;

        /*  If storing the file was a success, create an entry for it in the uploads table  */
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
            /* Doesn't work when in debug mode for some reason. Stack overflow had posts with similar issues */
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