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
$res = 0;
$page->appendContent("<h1>Séries TV</h1><div class=list>");
foreach ($stmt as $ligne) {
    $res += 1;
    if (($res%2) == 1) {
        $div = "gauche";
    } else {
        $div = "droite";
    }
    $nom = WebPage::escapeString($ligne->getName());
    $tvShowId = WebPage::escapeString((string)$ligne->getId());
    $overview = WebPage::escapeString($ligne->getOverview());
    $posterId = strval($ligne->getPosterId());
    $page->appendContent(<<<HTML
        <a href="tvshow.php?tvShowId=$tvShowId" class="serie">
            <img src='poster.php?posterId=$posterId' class="$div">
            <h3>$nom</h3>
            <p>$overview</p>
        </a>
    HTML);
}
$page->appendContent('</div>');
echo $page->toHTML();
