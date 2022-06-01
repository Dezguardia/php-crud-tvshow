<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Genre;
use PDO;

class GenreCollection
{
    /**Search a database collection for a document or set of documents.
     * The found documents are returned as a CollectionFind object is
     * to further modify or fetch results from.
     * @return Genre[]
     */
    public static function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
               SELECT id, name
            FROM genre
            ORDER BY name
        SQL
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Entity\Genre");
    }
}
