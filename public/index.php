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
echo "<html>\n";
echo "    <head>\n";
echo "    </head>\n";
echo "    <body>\n";
while (($ligne = $stmt->fetch()) !== false) {
    echo "        <div class='serie'>\n";
    echo "            <p>{$ligne['name']}</p>\n";
    echo "            <p>{$ligne['overview']}</p>\n";
    echo "        </div>\n";
}
echo "    </body>\n";
echo "</html>";