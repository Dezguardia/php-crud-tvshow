<?php
declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Poster;
require_once "../src/Entity/Poster.php";
try {
    $id = intval($_GET['posterId']);
    if ($id) {
        $poster = new Poster();
        $poster = $poster->findById($id);
        header('Content-Type: image/jpeg');
        echo $poster->getJpeg();
    } else {
        http_response_code(400);
    }
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
