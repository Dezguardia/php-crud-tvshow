<?php

declare(strict_types=1);

use Database\MyPdo;
use Html\WebPage;
use Entity\Season;

$seasonpage = new WebPage();

$seasonId = intval($_GET['seasonId']);

if ($seasonId == null) {
    header("Location: http://localhost:8000/");
    exit;
}

$season = new Season();
$season = $season->findBySeasonId($seasonId);