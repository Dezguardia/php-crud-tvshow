<?php

declare(strict_types=1);

use Database\MyPdo;
use Html\WebPage;
use Entity\Season;
use Entity\Collection\EpisodeCollection;
use Entity\TvShow;
use Entity\Episode;

require_once "../src/Database/MyPdo.php";
require_once "../src/Html/WebPage.php";
require_once "../src/Entity/TvShow.php";
require_once "../src/Entity/Collection/EpisodeCollection.php";
require_once "../src/Entity/Episode.php";

MyPDO::setConfiguration('mysql:host=mysql;dbname=jonque01_tvshow;charset=utf8', 'houd0012', 'houd0012');

$seasonpage = new WebPage();
$seasonpage->appendCssUrl("css\style.css");
$seasonId = intval($_GET['seasonId']);
$tvShowId = intval($_GET['tvShowId']);

//Redirection si mauvais id de saison
if ($seasonId == null) {
    header("Location: http://localhost:8000/");
    exit;
}

//Création des entités//

$tvshow = new TvShow();
$tvshow = $tvshow->findById($tvShowId);

$season = new Season();
$season = $season->findById($seasonId);

$episodes = new EpisodeCollection();
$stmt = $season->getEpisodes();

//Récupération des valeurs//

$showname = $tvshow->getName();
$seasonname = $season->getName();

$seasonpage->setTitle("Séries TV : ".$showname." ".$seasonname);

//Ajout des infos de saison//
$seasonpage->appendContent(<<<HTML
            <h1>Séries TV : $showname</h1>
            <h1>$seasonname</h1>
            <a   href="tvshow.php?tvShowId=$tvShowId"><h2>$showname</h2></a>
            <h2>$seasonname</h2>
            <div class = 'list'>
    HTML);

//Ajout des épisodes//
for ($i=0;$i<count($stmt);$i++) {
    $episodeNumber = WebPage::escapeString((string)$stmt[$i]->getEpisodeNumber());
    $name = WebPage::escapeString((string)$stmt[$i]->getName());
    $overview = WebPage::escapeString((string)$stmt[$i]->getOverview());
    if (!$overview) {
        $overview="Pas de description";
    }

    $seasonpage->appendContent(
        <<<HTML
    <div class="episode">
        <h3>Épisode n°$episodeNumber - $name</h3>
        <p>{$overview}</p>
    </div>
    HTML
    );
}
$seasonpage->appendContent('</div>');
echo $seasonpage->toHTML();
