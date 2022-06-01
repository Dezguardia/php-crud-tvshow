<?php
declare(strict_types=1);
namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

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
        $cover = $stmt->fetch();
        if ($cover) {
            return $cover;
        } else {
            throw new EntityNotFoundException('Entité introuvable');
        }
    }

}