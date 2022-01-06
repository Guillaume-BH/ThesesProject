<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>

    <?php
    include("../api/header.php");
    ?>
    <link rel="stylesheet" href="../css/style.css" />
    <title>Theses Eiffel</title>
</head>
<body>
    <section id="logo">
        <div class="typewriter">
            <div class="typewriter-text">
                <h1>Theses.fr</h1> <!-- <img src="../files/pictures/theses.png" alt="theses.fr logo"/> -->
            </div>
        </div>


    </section>
    <section>
        <div id="form">
            <nav class="navbar">
                <form action="result.php" method="get">
                    <input class="form-control mr-sm-2" type="search" type="text" name="search_these" placeholder="Rechercher" aria-label="Rechercher"/> <br />
                    <input class="form-check-input" type="checkbox" name="onlyOnline" value="true" id="flexCheckChecked"/>
                    <label class="form-check-label" for="flexCheckChecked">
                        Uniquement les thèses accessibles en ligne
                    </label>
                    <br>
                    <br>
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                        Rechercher
                    </button>
                </form>
            </nav>
        </div>
    </section>

    <!-- Menu de navigation des graphiques -->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="javascript:void(0)" class="redirectionCamembert" onclick="camembertDisplay()">Camembert</a>
        <a href="javascript:void(0)" class="redirectionMap" onclick="mapDisplay()">Map</a>
    </div>

    <!-- Boutton pour ouvrir le menu des graphiques -->
    <div id="btnGraphic">
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Graphiques</span>
    </div>

    <!-- Boutton pour retourner en haut de la page -->
    <button onclick="topFunction()" id="myBtn" title="Go to top">Haut de la page</button>

<!-- Affichage des graphiques -->
<section id="graphic">
    <div id="map"></div>
    <div id="camembert"></div>
</section>

<section id="result">

    <div id="listingTable">


    <?php

    //Initialisation des listes
    $listThese = array();
    $listDiscipline = array();
    $coordinates = array();

    //Vérification si il y a une thèse recherché
    if (!empty($_GET['search_these'])) {
        $result = $_GET['search_these'];
        $request = null;

        //Si on veut uniquement les thèses en ligne.
        if(!empty($_GET['onlyOnline'])){
            $request = PdoAccess::theseByAuthorTable($result, $_GET['onlyOnline']);
        } else {
            $request = PdoAccess::theseByAuthorTable($result, null);
        }
        //Récupération des thèses recherché
        $theseList = ($request->fetchAll());

        foreach ($theseList as $these){// Pour chaque thèse récupéré.
           $req =  PdoAccess::theseLocation($these[7]); //Récupération des coordonnées en fonctions de la location_id
           $tinyList = array(); //Création d'une liste temporaire.
           if($req != null){ //Si il y a une localisation.
               //Insertion dans la liste temporaire.
               array_push($tinyList, $req[0]['longitude']);
               array_push($tinyList, $req[0]['latitude']);
               array_push($tinyList, $req[0]['location_id']);
               if($tinyList != null){
                   //Ajout dans la liste global.
                   array_push($coordinates, $tinyList);
               }
           }

        }

        //Réutilisation de la requête car fetchAll() supprime la valeur de theseList
        if(!empty($_GET['onlyOnline'])){
            $request = PdoAccess::theseByAuthorTable($result, $_GET['onlyOnline']);
        } else {
            $request = PdoAccess::theseByAuthorTable($result, null);
        }

        //Affichage des thèses voulues
        $listDiscipline = PdoAccess::printTheseAuthor($request);


    }
    ?>

        <nav id="footer_nav_page">
            <!-- "Precedente" Button -->
            <li class="page-item disabled">

            </li>
        </nav>
</section>
    <script>
        // Initialisation du graphique
        Highcharts.chart('camembert', {
            chart: {
                type: 'pie',
                backgroundColor:'#29883c'
            },
            title: {
                text: 'Discipline',
                style: { "color": "white"}
            },
            subtitle: {
                text: 'Pourcentages de disciplines des thèses obtenus par rapport à la recherche.',
                style: { "color": "white"}
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                },
                point: {
                    valueSuffix: ''
                }
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:.1f}%'
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
            },
            series: [
                {
                    name: "discipline",
                    colorByPoint: true,
                    data: [
                        <?php
                        //Pour chaque discipline, affiché le nom ainsi que le nombre de fois où il s'agit de la discipline en question
                        foreach ($listDiscipline as $key=> $value){
                            echo '{name:"'.$key.'",y:'.$value.'},';
                        }
                        ?>
                    ]
                }
            ]
        });
    </script>

<script>
    // Initialisation de la map.
    Highcharts.mapChart('map', {

        chart: {
            map: 'countries/fr/fr-all',
            backgroundColor:'#29883c'
        },

        title: {
            text: 'Carte',
            style: { "color": "white"}
        },
        subtitle: {
            text: 'ID de localisation avec coordonnées des thèses obtenues.',
            style: { "color": "white"}
        },

        mapNavigation: {
            enabled: false
        },

        tooltip: {
            headerFormat: '',
            pointFormat: '{point.name} Lat: {point.lat}, Lon: {point.lon}'
        },

        series: [{
            name: 'Basemap',
            borderColor: '#A0A0A0',
            nullColor: 'rgba(200, 200, 200, 0.3)',
            showInLegend: false
        }, {
            name: 'Separators',
            type: 'mapline',
            nullColor: '#707070',
            showInLegend: false,
            enableMouseTracking: false
        }, {
            // Specify points using lat/lon
            type: 'mappoint',
            name: '',
            color: Highcharts.getOptions().colors[1],
            data:
                [
                    <?php
                    //Pour chaque liste de coordonnées
                    foreach ($coordinates as $value){
                        echo '{name:"'.$value[2]. //Affichage de l'ID de la localisation
                            '",lat:'.$value[1]. //Affichage de la latitude
                            ', lon:'.$value[0].'},'; //Affichage de la longitude
                    }
                    ?>
                ]
        }]
    });




</script>
    <script>
        //Fonction qui permet d'ouvrir le menu des graphiques.
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        //Fonction qui permet de fermet le menu des graphiques.
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script>
    <script>
        //Récupération du bouton
        var mybutton = document.getElementById("myBtn");

        // Quand l'utilisateur scroll en bas de la page, supérieur à 20 pixels, le boutton s'affiche.
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        // Quand l'utilisateur appuie sur le bouton, il est renvoyé vers le haut de la page.
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
    <script>
        //Fonction d'affichage du camembert ou non.
        function camembertDisplay(){
            const camambert = document.getElementById("camembert"); //Récupération de l'objet "camembert".
            const map = document.getElementById("map"); //Récupération de l'objet "map".
            console.log("Display map: "+map.style.display); //Debug pour voir si la map est affiché ou non.

            if(camambert.style.display === "none"){ //Condition qui vérifie si le camembert n'est pas visible.
                camambert.style.display = "block"; //Affiche le camembert.
                if(map.style.display === "none" || map.style.display === '' || map.style.display === null){ //Si la map n'est pas affiché.
                    camambert.style.marginTop = '1%'; //Ajustement de l'affichage.
                } else {
                    camambert.style.marginTop = '-25%';
                }
                camambert.scrollIntoView(); //Redirige vers le camembert.
            } else {
                camambert.style.display = "none"; //Masque le camembert si il est affiché.
            }
        }
    </script>

<script>
    function mapDisplay(){
        const map = document.getElementById("map"); //Récupération de l'objet "map".
        const camambert = document.getElementById("camembert"); //Récupération de l'objet "camembert".
        if(map.style.display === "none"){ //Condition qui vérifie si la map n'est pas visible.
            map.style.display = "block"; //Affiche le camembert.
            if(camambert.style.display === "none" || camambert.style.display === '' || camambert.style.display === null){ //Si le camembert n'est pas affiché.
                camambert.style.marginTop = '1%'; //Ajustement de l'affichage.
            } else {
                camambert.style.marginTop = '-25%';
            }
            map.scrollIntoView(); //Redirige vers la map.
        } else {
            camambert.style.marginTop = '1%'; //Ajustement de l'affichage du camembert.
            map.style.display = "none"; //Masque la map si elle est affichée.
        }
    }
</script>
</body>
</html>