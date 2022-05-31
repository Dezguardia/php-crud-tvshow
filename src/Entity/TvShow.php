<?php

declare(strict_types=1);

namespace Entity;

require_once "Season.php";
use Database\MyPdo;
use Entity\Collection\SeasonCollection;
use mysql_xdevapi\Exception;
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

    public function findById(int $showId): Artist
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, name, originalName, homepage, overview, posterId
            FROM tvshow
            WHERE id = :id
        SQL
        );
        $stmt->bindParam(':id', $showid);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Season::class);
        $tvshow= $stmt->fetch();

        if ($tvshow) {
            return $tvshow;
        } else {
            throw new Exception("Entité non trouvée");
        }
    }

    public function getSeasons(): array
    {
        $seasons= new SeasonCollection();
        return $seasons->findByTVShowId($this->getId());
    }

}
