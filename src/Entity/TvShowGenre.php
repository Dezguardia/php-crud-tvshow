<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class TvShowGenre
{
    private int $id;
    private int $genreId;
    private int $tvShowId;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getGenreId(): int
    {
        return $this->genreId;
    }

    /**
     * @return int
     */
    public function getTvShowId(): int
    {
        return $this->tvShowId;
    }
    /**
     * @param int $seasonId
     * @return TvShowGenre
     * @throws EntityNotFoundException
     */
    public function findById(int $tvshow_genreId): TvShowGenre
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, genreId, tvShowId
            FROM tvshow_genre
            WHERE id = :id
        SQL
        );
        $stmt->bindParam(':id', $tvshow_genreId);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Season::class);
        $tvshow_genreId = $stmt->fetch();
        if ($tvshow_genreId) {
            return $tvshow_genreId;
        } else {
            throw new EntityNotFoundException('Entité introuvable');
        }
    }
}
