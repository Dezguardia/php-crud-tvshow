<?php

declare(strict_types=1);
namespace Entity\Collection;

use Database\MyPdo;
use Entity\TvShow;
use PDO;

class TvShowCollection
{
    /**Search a database collection for a document or set of documents.
     * The found documents are returned as a CollectionFind object is
     * to further modify or fetch results from.
     * @return TvShow[]
     */
    public static function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
               SELECT id, name, overview
            FROM tvshow
            ORDER BY name
        SQL
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Entity\TvShow");
    }
}