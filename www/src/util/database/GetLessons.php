<?php
/**
 * Created by PhpStorm.
 * User: Tycko Franklin
 * Date: 11/24/2018
 * Time: 1:11 AM
 */

namespace src\util\database\GetLessons;

use src\util\database\db_tools\db_tools;
use src\util\database\SelectQueryBuilder\SelectQueryBuilder;
use src\util\DTOs\LessonDTO\LessonDTO;


class GetLessons
{
    /**
     * getLessons: gets the lessons from the database.
     * @throws \Exception
     *
     * @return LessonDTO[]
     */
    public static function getLessons()
    {
        $dbTools = new db_tools();
        $dbc = $dbTools->db_connect();

        /** @var SelectQueryBuilder $q */
        $q = (new SelectQueryBuilder())
            ->withFields("*")
            ->fromTable("uploads")
            ->withOrderBy("date_modified")
            ->build();

        $rows = mysqli_query($dbc, $q);

        /** @var LessonDTO[] $lessonsDTOs */
        $lessonsDTOs = [];
        foreach ($rows as $row) {
            array_push($lessonsDTOs, (new LessonDTO)->parseDatabaseResult($row));
        }
        return $lessonsDTOs;
    }
}