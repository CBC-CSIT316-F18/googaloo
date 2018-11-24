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

class DownloadFile
{
    /** @var db_tools */
    private $dbTools = null;

    /**
     * UploadFile constructor.
     * @param String $fileId
     * @throws \Exception
     */
    public function __construct($fileId)
    {

        $this->dbTools = new db_tools();
        $dbc = $this->dbTools->db_connect();


        /** @var SelectQueryBuilder $q */
        $q = (new SelectQueryBuilder())
            ->withFields("*")
            ->fromTable("uploads")
            ->withWhere("id = $fileId")
            ->build();

        /** @var mysqli_result $r */
        $r = mysqli_query($dbc, $q);


        if ($r->num_rows === 1) { // If it ran OK.
            /** @var LessonDTO $file */
            $file = (new LessonDTO)->parseDatabaseResult($r->fetch_assoc());
            $filepath = DATA_FOLDER . $file->getFilealias();
            if(!file_exists($filepath)){
                throw new \Exception("Could not find the file on the filesystem");
            }
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