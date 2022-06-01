<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\TvShowGenre;

class TvShowGenreCollection
{
    /**Search a database collection for a document or set of documents.
     * The found documents are returned as a CollectionFind object is
     * to further modify or fetch results from.
     * @return TvShowGenre[]
     */
    public static function findByTvShowId(int $tvShowGenreId): array
    {
        $tvShowGenre = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, genreId, tvShowId
            FROM tvshow_genre
            WHERE tvShowId = :id
            ORDER BY id;
        SQL
        );
        $tvShowGenre->bindParam(':id', $tvShowGenreId);
        $tvShowGenre->execute();
        return $tvShowGenre->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Entity\Genre");
    }
}