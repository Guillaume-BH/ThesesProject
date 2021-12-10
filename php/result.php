<!doctype html>
<html lang="en">
<head>

    <?php
    include("../api/header.php");
    ?>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>Theses Eiffel</title>
</head>

<body>
    <header>
        <button>EN</button>
        <button>FR</button>
        <button>SE CONNECTER</button>
        <button>?</button>
        <section class="logo">
            <img src="http://theses.fr/images/theses.gif">
        </section>
    </header>
</body>


<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        <?php echoPieDiscipline(); ?>
        <script>initPageManager();</script>
        <script>createPieDiscipline(lines);</script>
    </p>
</figure>


<?php



if (!empty($_GET['search_these'])) {
    $result = $_GET['search_these'];
    $req = Dump::theseByAuthorTable($result);

    Dump::printTheseAuthor($req);
    $liste = array();
    while ($ligne = $req->fetch(PDO::FETCH_OBJ)) {
        $these = new These();
        $api = new JsonObj();
        $these->setAuthor($ligne->author);
        $these->setAuthorId($ligne->author_id);
        $these->setTitle($ligne->title);
        $these->setTheseDirector($ligne->these_director);
        $these->setTheseDirectorInFirstName($ligne->these_director_in_first_name);
        $these->setDirectorId($ligne->director_id);
        $these->setLocationSustenance($ligne->location_sustenance);
        $these->setLocationId($ligne->location_id);
        $these->setDiscipline($ligne->discipline);
        $these->setStatus($ligne->these_status);
        $these->setDateFirstInscriptionDoc($ligne->date_first_inscription_doc);
        $these->setDateSustenance($ligne->date_sustenance);
        $these->setTheseLanguage($ligne->these_language);
        $these->setTheseId($ligne->these_id);
        $these->setOnlineAccessibility($ligne->online_accessibility);
        $these->setDatePublication($ligne->date_publication);
        $these->setDateUpdateThese($ligne->date_update_these);
        $api->setThese($these);
        array_push($liste, $api);
    }
}


?>




</html>