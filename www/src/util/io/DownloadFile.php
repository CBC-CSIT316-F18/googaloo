<?php
/**
 * Created by PhpStorm.
 * User: Tycko Franklin
 * Date: 11/23/2018
 * Time: 10:56 PM
 */

namespace src\util\io\DownloadFile;

use mysqli_result;
use src\util\database\db_tools\db_tools;
use src\util\database\SelectQueryBuilder\SelectQueryBuilder;
use src\util\DTOs\LessonDTO\LessonDTO;

/**
 * Class DownloadFile
 *
 * Class what when instantiated with the file id, will serve the file as the request response
 *
 * @package src\util\io\DownloadFile
 */
class DownloadFile
{
    /** @var db_tools */
    private $dbTools = null;

    /**
     * UploadFile constructor.
     *
     * @param String $fileId
     *
     * @throws \Exception
     */
    public function __construct($fileId)
    {

        /* Connect to the database  */
        $this->dbTools = new db_tools();
        $dbc = $this->dbTools->db_connect();


        /*  Create the query  (might add a limit to the number of results) */
        /** @var SelectQueryBuilder $q */
        $q = (new SelectQueryBuilder())
            ->withFields("*")
            ->fromTable("uploads")
            ->withWhere("id = $fileId")
            ->build();

        /*  Run the query  */
        /** @var mysqli_result $r */
        $r = mysqli_query($dbc, $q);

        /* There should be one and only one result  */
        if ($r->num_rows === 1) { // If it ran OK.

            /*  Get the file DTO from the query result  */
            /** @var LessonDTO $file */
            $file = (new LessonDTO)->parseDatabaseResult($r->fetch_assoc());
            $filepath = DATA_FOLDER . $file->getFilealias();
            /*  Check that the file still exists, not sure what happened if it doesn't.... */
            if(!file_exists($filepath)){
                throw new \Exception("Could not find the file on the filesystem");
            }

            /* Serve up the file with the original (safe) file name  */
            /*  These headers and the readfile tell php and the clients that this is a file download */
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'. $file->getFilename() . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            readfile($filepath);
            exit;
        } else {
            throw new \Exception("Couldn't find file id");
        }
    }
}