<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

require_once(__DIR__."/../Database/MyPdo.php");
MyPDO::setConfiguration('mysql:host=mysql;dbname=jonque01_tvshow;charset=utf8', 'houd0012', 'houd0012');

class Poster
{
    private int $id;
    private string $jpeg;

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
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**
     * @param int $id
     * @return Poster
     * @throws EntityNotFoundException
     */
    public function findById(int $id): Poster
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, jpeg
            FROM poster
            WHERE id = :id
        SQL
        );
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Poster::class);
        $poster = $stmt->fetch();
        if ($poster) {
            return $poster;
        } else {
            throw new EntityNotFoundException('Entité introuvable');
        }
    }
}
