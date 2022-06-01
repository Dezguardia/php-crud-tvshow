<?php
declare(strict_types=1);
require_once '../vendor/autoload.php';

use Database\MyPdo;
use Entity\Collection\TvShowCollection;
use Html\WebPage;

MyPDO::setConfiguration('mysql:host=mysql;dbname=jonque01_tvshow;charset=utf8', 'houd0012', 'houd0012');

$page = new WebPage();
$page->setTitle('Liste TV show');
$page->appendCssUrl('css\style.css');

$stmt = new TvShowCollection();
$stmt = $stmt->findAll();

$page->appendContent("<h1>Séries TV</h1><div class=list>");
foreach ($stmt as $ligne) {
    $nom = WebPage::escapeString($ligne->getName());
    $tvShowId = WebPage::escapeString((string)$ligne->getId());
    $overview = WebPage::escapeString($ligne->getOverview());
    $page->appendContent(<<<HTML
        <div class='serie'><a href="tvshow.php?tvShowId=$tvShowId"> \n
            <h2>{$nom}</h2>\n
            <p>{$overview}</p>\n
        </a></div>\n
    HTML);
}
$page->appendContent('</div>');
echo $page->toHTML();
