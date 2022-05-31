<?php

declare(strict_types=1);

namespace Entity;

require_once "Season.php";
require_once "Exception/EntityNotFoundException.php";
use Database\MyPdo;
use Entity\Collection\SeasonCollection;
use Entity\Exception\EntityNotFoundException;
use PDO;
use Entity\Season;

class TvShow
{
    private int $id;
    private string $name;
    private string $originalName;
    private string $homepage;
    private string $overview;
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
     * @return string
     */
    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    /**
     * @return string
     */
    public function getHomepage(): string
    {
        return $this->homepage;
    }

    /**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @return int
     */
    public function getPosterId(): int
    {
        return $this->posterId;
    }

    /**
     * @param int $showId
     * @return TvShow
     */
    public function findById(int $showId): TvShow
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, name, originalName, homepage, overview, posterId
            FROM tvshow
            WHERE id = :id
        SQL
        );
        $stmt->bindParam(':id', $showId);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, TvShow::class);
        return $stmt->fetch();
    }

    /**
     * @return Season[]
     */
    public function getSeasons(): array
    {
        $seasons= new SeasonCollection();
        return $seasons->findByTVShowId($this->getId());
    }
}
