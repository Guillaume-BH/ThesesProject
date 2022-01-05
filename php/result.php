<!doctype html>
<html lang="en">
<head>

    <?php
    include("../api/header.php");
    ?>
    <title>Theses Eiffel</title>
</head>
<header>
    <button>EN</button>
    <button>FR</button>
    <button>SE CONNECTER</button>
    <button>?</button>
    <section class="logo">
        <a href="index.html">
            <img src="http://theses.fr/images/theses.gif">
        </a>

    </section>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="javascript:void(0)" class="redirectionCamembert" onclick="camembertDisplay()">Camembert</a>
        <a href="javascript:void(0)" class="redirectionMap" onclick="mapDisplay()">Map</a>
    </div>
    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Statistics</span>
    <button onclick="topFunction()" id="myBtn" title="Go to top">Haut de la page</button>

</header>
<body>


<section id="graphic">
    <div id="map"></div>
    <div id="camembert"></div>
</section>

<section id="result">
    <?php
    $list = array();
    if (!empty($_GET['search_these'])) {
        $result = $_GET['search_these'];
        $req = PdoAccess::theseByAuthorTable($result);
        $list = PdoAccess::printTheseAuthor($req);}
    ?>
</section>





    <script>
        // Creation du graphique.
        Highcharts.chart('camembert', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Discipline'
            },
            subtitle: {
                text: 'Les discplines des thèses obtenus par rapport à la recherche.'
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
                        format: '{point.name}: {point.y:.1f}'
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
                        foreach ($list as $key=>$value){
                            echo '{name:"'.$key.'",y:'.$value.'},';
                        }
                        ?>
                    ]
                }
            ]
        });
    </script>

<script>
    // Initialize the chart
    Highcharts.mapChart('map', {

        chart: {
            map: 'countries/fr/fr-all',
            backgroundColor:'#294688'
        },

        title: {
            text: 'Carte',
            style: { "color": "white"}
        },

        mapNavigation: {
            enabled: false
        },

        tooltip: {
            headerFormat: '',
            pointFormat: '<b>{point.name}</b><br>Lat: {point.lat}, Lon: {point.lon}'
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
                    foreach ($list as $key=>$value){
                        echo '{name:"'.$key.'",y:'.$value.'},';
                    }
                    ?>
                ]
        }]
    });

</script>
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script>
    <script>
        //Get the button
        var mybutton = document.getElementById("myBtn");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
    <script>
        function camembertDisplay(){
            const camambert = document.getElementById("camembert");
            const map = document.getElementById("map");
            console.log("Display map: "+map.style.display);
            if(camambert.style.display === "none"){
                camambert.style.display = "block";
                if(map.style.display === "none" || map.style.display === '' || map.style.display === null){
                    camambert.style.marginTop = '1%';
                } else {
                    camambert.style.marginTop = '-25%';
                }
                camambert.scrollIntoView();
            } else {
                camambert.style.display = "none";
            }
        }
    </script>

<script>
    function mapDisplay(){
        const map = document.getElementById("map");
        const camambert = document.getElementById("camembert");
        if(map.style.display === "none"){
            map.style.display = "block";
            if(camambert.style.display === "none" || camambert.style.display === '' || camambert.style.display === null){
                camambert.style.marginTop = '1%';
            } else {
                camambert.style.marginTop = '-25%';
            }
            map.scrollIntoView();
        } else {
            camambert.style.marginTop = '1%';
            map.style.display = "none";
        }
    }
</script>
</body>
</html>