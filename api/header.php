<?php

echo '
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/graphic.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/result-table.css">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="../js/graphic.js"></script>
    <script src="../js/result-manager.js"></script>

    
';

include("../api/highchart-page-builder.php");
include("../api/connexion.inc.php");
include("../class/Dump.php");
include("../class/These.php");
include("../api/JsonObj.php");
include("../api/JsonFormat.php");

