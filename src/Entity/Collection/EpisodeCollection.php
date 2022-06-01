<?php
declare(strict_types=1);
namespace Entity\Collection;

use PDO;
use Database\MyPdo;
use Entity\Episode;

class EpisodeCollection
{
    /**Search a database collection for a document or set of documents.
     * The found documents are returned as a CollectionFind object is
     * to further modify or fetch results from.
     * @return Episode[]
     */
    public static function findBySeasonId(int $saisonId): array
    {
        $episode = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, seasonId, name, overview, episodeNumber
            FROM episode
            WHERE seasonId = :id
            ORDER BY episodeNumber;
        SQL
        );
        $episode->bindParam(':id', $saisonId);
        $episode->execute();
        return $episode->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Entity\Episode");
    }
}