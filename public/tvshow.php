<?php

declare(strict_types=1);

use Database\MyPdo;
require_once "../src/Database/MyPdo.php";
require_once "../src/Html/WebPage.php";
require_once "../src/Entity/TvShow.php";
require_once "../src/Entity/Collection/SeasonCollection.php";
use Entity\TvShow;
use Entity\Collection\SeasonCollection;
use Entity\Season;
use Html\WebPage;

MyPDO::setConfiguration('mysql:host=mysql;dbname=jonque01_tvshow;charset=utf8', 'houd0012', 'houd0012');

$tvshowpage = new WebPage();
$tvshowpage->appendCssUrl('css\style.css');
$tvshowId = intval($_GET['tvShowId']);

if ($tvshowId == null) {
    header("Location: http://localhost:8000/");
    exit;
}

$tvshow = new TvShow();
$tvshow = $tvshow->findById($tvshowId);

$seasons = new SeasonCollection();
$stmt = $seasons->findByTVShowId($tvshowId);

$tvshowpage->setTitle("Séries TV : ".$tvshow->getName());

$showname = $tvshow->getName();
$showOriginalName = $tvshow->getOriginalName();
$showOverview = $tvshow->getOverview();
$tvshowPoster = $tvshow->getPosterId();

$tvshowpage->appendContent(<<<HTML
            <div class="header">
                <a href="http://localhost:8000"><img src="img/home.png" class="home"></a>
                <div class="titre">
                    <h1>Séries TV : {$tvshow->getName()}</h1>    
                </div>
            </div>
            <div class="list">
                <div class = 'poster_serie'>
                    <img src="poster.php?posterId=$tvshowPoster">
                    <div class="text">
                        <h2>$showname</h2>
                        <h2>$showOriginalName</h2>
                        <p>$showOverview</p>
                    </div>
                </div>
    HTML);

for ($i=0;$i<count($stmt);$i++) {
    $name = WebPage::escapeString($stmt[$i]->getName());
    $seasonId = WebPage::escapeString((string)$stmt[$i]->getId());
    $poster = strval($stmt[$i]->getPosterId());
    $tvshowpage->appendContent(<<<HTML
                <div class="case">
                <div class='poster_serie'>
                    <a href="season.php?tvShowId=$tvshowId&seasonId=$seasonId">
                        <div class ='alignement_gauche'>
                        <img src="poster.php?posterId=$poster" alt="">
                        <div class="text"> <h2>$name</h2> </div>
                        </div>
                    </a>
                </div>
                </div>
    HTML);
}
$tvshowpage->appendContent(<<<HTML
        </div>
HTML);
echo $tvshowpage->toHTML();
