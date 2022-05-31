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

$tvshowpage->appendContent("        <h1>Séries TV : ".$tvshow->getName()."</h1>\n");
$tvshowpage->appendContent("        <div class = 'tvshow_info'>\n");
$tvshowpage->appendContent("            <div class = 'tvshow_info_name'>$showname</div>\n");
$tvshowpage->appendContent("            <div class = 'tvshow_info_originalname'>$showOriginalName</div>\n");
$tvshowpage->appendContent("            <div class = 'tvshow_info_overview'>$showOverview</div>\n");
$tvshowpage->appendContent("        </div>\n");

for ($i=0;$i<count($stmt);$i++) {
    $name = WebPage::escapeString((string)$stmt[$i]->getName());
    $tvshowpage->appendContent("            <div class='season'>\n");
    $tvshowpage->appendContent("                <div class='season_name'><p>$name</p></div>\n");
    $tvshowpage->appendContent("            </div>\n");
}

echo $tvshowpage->toHTML();
