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
    private ?int $id;
    private string $name;
    private string $originalName;
    private string $homepage;
    private string $overview;
    private int $posterId;

    /**
     * @return int|null
     */
    public function getId(): ?int
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
     * @param int|null $id
     * @return TvShow
     */
    public function setId(?int $id): TvShow
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $name
     * @return TvShow
     */
    public function setName(string $name): TvShow
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $originalName
     * @return TvShow
     */
    public function setOriginalName(string $originalName): TvShow
    {
        $this->originalName = $originalName;
        return $this;
    }

    /**
     * @param string $homepage
     * @return TvShow
     */
    public function setHomepage(string $homepage): TvShow
    {
        $this->homepage = $homepage;
        return $this;
    }

    /**
     * @param string $overview
     * @return TvShow
     */
    public function setOverview(string $overview): TvShow
    {
        $this->overview = $overview;
        return $this;
    }

    /**
     * @param int $posterId
     * @return TvShow
     */
    public function setPosterId(int $posterId): TvShow
    {
        $this->posterId = $posterId;
        return $this;
    }

    /**
     * @param int $showId
     * @return TvShow
     * @throws EntityNotFoundException
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
        $tvshow = $stmt->fetch();
        if ($tvshow) {
            return $tvshow;
        } else {
            throw new EntityNotFoundException('Entit?? introuvable');
        }
    }

    /**
     * @return Season[]
     */
    public function getSeasons(): array
    {
        $seasons= new SeasonCollection();
        return $seasons->findByTVShowId($this->getId());
    }

    /**
     * Supprime la s??rie de la base de donn??es dont l'id correspond ?? celui de l'instance courante.
     * Rend nul l'id de l'instance courante et la retourne.
     * @return $this
     */
    public function delete(): TvShow
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
        DELETE
        FROM tvshow
        WHERE id = :id
        SQL
        );
        $id = $this->getId();
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $this->setId(null);
    }

    /**
     * Change le nom de la s??rie dans la base de donn??es correspondant ?? l'id en lui attribuant la valeur de name de l'instance courante.
     * @return $this
     */
    public function update(): TvShow
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
        UPDATE
        tvshow
        SET name = :name
        WHERE id = :id
        SQL
        );
        $name = $this->getName();
        $id = $this->getId();
        $stmt->bindParam('name', $name);
        $stmt->bindParam('id', $id);
        $stmt->execute();
        return $this;
    }

    /**
     * Cr??e une instance de tvshow avec le nom pass?? le param??tre et l'id facultatif initialis?? ?? null
     * @param string $name
     * @param int|null $id
     * @return TvShow
     */
    public function create(string $name, int $id = null): TvShow
    {
        $tvshow = new TvShow();
        $tvshow->setName($name);
        if ($id) {
            $tvshow->setId($id);
        }
        return $tvshow;
    }

    /**
     * Ajoute l'instance courante dans la base de donn??es.
     * @return TvShow
     */
    public function insert(): TvShow
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
        INSERT INTO tvshow(id, name, originalName, homepage, overview, posterId)
        values :id, :name, :originalName, :homepage, :overview, :posterId
        SQL
        );
        $id = $this->getId();
        $name = $this->getName();
        $ogname = $this->getOriginalName();
        $homepage = $this->getHomepage();
        $overview = $this->getOverview();
        $posterId = $this->getPosterId();
        $stmt->bindParam('id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':originalName', $ogname);
        $stmt->bindParam(':homepage', $homepage);
        $stmt->bindParam(':overview', $overview);
        $stmt->bindParam(':posterId', $posterId);
        $stmt->execute();
        return $this;
    }

    /**
     * Execute insert ou update selon que la valeur de id est respectivement null ou non.
     * @return $this
     */
    public function save(): TvShow
    {
        if ($this->getId()) {
            $this->update();
        } else {
            $this->insert();
        }
        return $this;
    }
}
