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
               SELECT id, name, originalName, homepage, overview, posterId
            FROM tvshow
            ORDER BY name
        SQL
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Entity\TvShow");
    }
    /**Search a database collection for a document or set of documents.
     * The found documents are returned as a CollectionFind object is
     * to further modify or fetch results from.
     * @return TvShow[]
     */
    public static function findByGenreName(string $genreName): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
               SELECT t.id, t.name, t.originalName, t.homepage, t.overview, t.posterId
            FROM tvshow t 
                INNER JOIN tvshow_genre tg ON (t.id=tg.tvShowId)
                INNER JOIN genre g ON (g.id=tg.genreId)
            WHERE g.name = :name
            ORDER BY name
        SQL
        );
        $stmt->bindParam(':name', $genreName);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Entity\TvShow");
    }
}