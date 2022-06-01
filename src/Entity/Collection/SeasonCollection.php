<?php
declare(strict_types=1);
namespace Entity\Collection;

use Entity\Season;
use Database\MyPdo;
use PDO;

class SeasonCollection
{
    public function findByTVShowId(int $tvShowId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, tvShowId, name, seasonNumber, posterId
            FROM season
            WHERE tvShowId = :id
            ORDER BY seasonNumber
        SQL
        );
        $stmt->bindParam(':id', $tvShowId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Entity\Season');
    }
}
