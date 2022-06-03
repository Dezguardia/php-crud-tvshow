<?php

declare(strict_types=1);
require_once '../vendor/autoload.php';

use Database\MyPdo;
use Entity\Collection\GenreCollection;
use Entity\Collection\TvShowCollection;
use Html\WebPage;
MyPDO::setConfiguration('mysql:host=mysql;dbname=jonque01_tvshow;charset=utf8', 'houd0012', 'houd0012');

$page = new WebPage();
$page->setTitle('Liste TV show');
$page->appendCssUrl('css\style.css');

//Récupération de la list des genres
$genrelist = new GenreCollection();
$genrelist = $genrelist->findAll();
$page->appendContent(<<<HTML
    <h1>Séries TV</h1>
    <form>
        <label>
        <p>Filtrage par genre : </p>
            <select name="genre" required>
                <option value="Tous">Tous</option>
    HTML);
foreach ($genrelist as $ligne) {
    $nom = WebPage::escapeString($ligne->getName());
    $page->appendContent("<option value='$nom'>$nom</option>");
}
$page->appendContent(<<<HTML
            </select>
        </label>
        <button type="submit">Envoyer</button>
    </form>
    <div class=list>
HTML);
//Récupération du genre choisie

$stmt = new TvShowCollection();
$filtre = $_GET['genre'];
if ($filtre == null) {
    header("Location: http://localhost:8000?genre=Tous");
    $show = $stmt->findAll();
} elseif ($_GET['genre'] != "Tous") {
    $show = $stmt->findByGenreName($filtre);
} else{
    $show = $stmt->findAll();
}

$res = 0;
foreach ($show as $ligne) {
    $res += 1;
    if (($res%2) == 1) {
        $div = "alignement_gauche";
    } else {
        $div = "alignement_droite";
    }
    $nom = WebPage::escapeString($ligne->getName());
    $tvShowId = WebPage::escapeString((string)$ligne->getId());
    $overview = WebPage::escapeString($ligne->getOverview());
    $posterId = strval($ligne->getPosterId());
    $page->appendContent(<<<HTML
        <div class="case">
        <a href="tvshow.php?tvShowId=$tvShowId" class="$div">
            <img src='poster.php?posterId=$posterId'>
            <div class="text">
                <h3>$nom</h3>
                <p>$overview</p>
            </div>
        </a>
        </div>
    HTML);
}
$page->appendContent('</div>');
echo $page->toHTML();
