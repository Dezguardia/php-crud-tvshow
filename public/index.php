<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use Database\MyPdo;

MyPDO::setConfiguration('mysql:host=mysql;dbname=jonque01_tvshow;charset=utf8', 'houd0012', 'houd0012');

$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
    SELECT id, name, overview
    FROM tvshow
    ORDER BY name
SQL
);

$stmt->execute();
$page = new \Html\WebPage();
$page->setTitle('Liste TV show');
while (($ligne = $stmt->fetch()) !== false) {
    $page->appendContent(<<<HTML
        <div class='serie'>\n
            <p>{$ligne['name']}</p>\n
            <p>{$ligne['overview']}</p>\n
        </div>\n
    HTML);
}
echo $page->toHTML();
