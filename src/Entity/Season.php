<?php
declare(strict_types=1);
namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use Entity\Collection\EpisodeCollection;
use PDO;

class Season
{
    private int $id;
    private int $tvShowId;
    private string $name;
    private int $seasonNumber;
    private int $posterId;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPosterId(): int
    {
        return $this->posterId;
    }

    /**
     * @return int
     */
    public function getSeasonNumber(): int
    {
        return $this->seasonNumber;
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
     * @return Season
     * @throws EntityNotFoundException
     */
    public function findById(int $seasonId): Season
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, tvShowId, name, seasonNumber, posterId
            FROM season
            WHERE id = :id
        SQL
        );
        $stmt->bindParam(':id', $seasonId);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Season::class);
        $season = $stmt->fetch();
        if ($season) {
            return $season;
        } else {
            throw new EntityNotFoundException('Entité introuvable');
        }
    }

    public function getEpisodes(): array
    {
        $episodes= new EpisodeCollection();
        return $episodes->findBySeasonId($this->getId());
    }
}