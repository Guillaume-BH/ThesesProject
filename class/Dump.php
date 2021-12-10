<?php
ini_set('max_execution_time', '0');
class Dump
{

    private static $user = "guillaume.grisolet";
    private static $pass = "guigui";
    private static $database = "guillaume.grisolet_db";
    private static $host = "sqletud.u-pem.fr";
    private static $pdo;

    public static function load($path)
    {
        $file = fopen($path, 'r');
        fgetcsv($file, 0, ";"); //Lecture des noms des tableaux
        $new_array = new ArrayObject();
        while (!feof($file)) {
            $array = fgetcsv($file, 0, ";");
            if($array != null && $array != ""){
                $these = self::createTheseWithList($array);
            }
        }
        fclose($file);
    }


    public static function theseByAuthorTable($author){
        $pdo = self::getPdo();
        $sqlAuthor = "SELECT * FROM public.theses_db WHERE author LIKE :author";
        $stmt = $pdo->prepare($sqlAuthor);
        $stmt->bindParam(":author", $author);
        $stmt->execute();
        return $stmt;
    }

    public static function printTheseAuthor($stmt)
    {
        $result = $stmt->fetchAll();

        // Affichage des données récoltées par ligne
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['author'] . "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['these_director'] . "</td>";
            echo "<td>" . $row['discipline'] . "</td>";

            echo "</tr>";
        }
    }

    public function createTheseWithList($array): These
   {
        $index = 0;
        $these = new These();
        $these->setAuthor($array[$index++]);
        $these->setAuthorId($array[$index++]);
        $these->setTitle($array[$index++]);
        $these->setTheseDirector($array[$index++]);
        $these->setTheseDirectorInFirstName($array[$index++]);
        $these->setDirectorId($array[$index++]);
        $these->setLocationSustenance($array[$index++]);
        $these->setLocationId($array[$index++]);
        $these->setDiscipline($array[$index++]);
        $these->setStatus($array[$index++]);
        $these->setDateFirstInscriptionDoc($array[$index++]);
        $these->setDateSustenance($array[$index++]);
        $these->setTheseLanguage($array[$index++]);
        $these->setTheseId($array[$index++]);
        $these->setOnlineAccessibility($array[$index]++);
        $index++;
        $these->setDatePublication($array[$index++]);
        $these->setDateUpdateThese($array[$index++]);
        self::addToBDD($these);
        return $these;
   }

    public function correctDate($date_param){
        /*if($date_param == ""){
            return $date_param;
        }
        $var = explode($date_param, '-');
        $d = $var[2].'-'.$var[1].'-'.$var[0];
        return $d;*/
        return substr($date_param, 6, 9).substr($date_param, 2, 3).substr($date_param, -5, -4).substr($date_param, 0, 2);
    }

   public function addToBDD(These $these){
        echo "<br>";
        include("../php/connexion.inc.php");

        $author = $these->getAuthor();
        echo "<br>Author:";
        echo $author;
        $authorId = $these->getAuthorId();
        echo "<br>Author ID:";
        echo $authorId;
        $title = $these->getTitle();
        echo "<br>Title:";
        echo $title;
        $theseDirector = $these->getTheseDirector();
        echo "<br>Director";
        echo $theseDirector;
        $theseDirectorInFirstName = $these->getTheseDirectorInFirstName();
        echo "<br>Director In First Name:";
        echo $theseDirectorInFirstName;
        $directorId = $these->getDirectorId();
        echo "<br>Director ID:";
        echo $directorId;
        $locationSustenance = $these->getLocationSustenance();
        echo "<br>Location Sustenance:";
        echo $locationSustenance;
        $locationId = $these->getLocationId();
        echo "<br>Location ID:";
        echo $locationId;
        $discipline = $these->getDiscipline();
        echo "<br>Discipline:";
        echo $discipline;
        $theseStatus = $these->getStatus();
        echo "<br>These Status:";
        echo $theseStatus;
        $dateFirstInscriptionDoc = self::correctDate($these->getDateFirstInscriptionDoc());
        echo "<br>First Inscription Doc:";
        echo $dateFirstInscriptionDoc;

        $dateSustenance = self::correctDate($these->getDateSustenance());
        if($dateSustenance == ""){
            $dateSustenance = NULL;
        }
        echo "<br>Date Sustenance:";
        echo $dateSustenance;

        $theseLanguage = $these->getTheseLanguage();
        $theseId = $these->getTheseId();
        $onlineAccessibility = $these->getOnlineAccessibility();
        echo "<br>Online Accessibility:";
        echo $onlineAccessibility;

        $datePublication = self::correctDate($these->getDatePublication());
        if($datePublication== ""){
            $datePublication = NULL;
        }
        echo "<br>Date Publication:";
        echo $datePublication;

        $dateUpdateThese = self::correctDate($these->getDateUpdateThese());
        echo "<br>Date Update These:";
        echo $dateUpdateThese;

        echo "<br>";
        echo "<br>";
        echo "<br>";
        $req = $cnx->prepare('INSERT INTO theses_db
        (author,
        author_id,
        title,
        these_director,
        these_director_in_first_name,
        director_id,
        location_sustenance,
        location_id,
        discipline,
        these_status,
        date_first_inscription_doc,
        date_sustenance,
        these_language,
        these_id,
        online_accessibility,
        date_publication,
        date_update_these)
        
        VALUES 
        (:author,
        :authorId,
        :title,
        :theseDirector,
        :theseDirectorInFirstName,
        :directorId,
        :locationSustenance,
        :locationId,
        :discipline,
        :theseStatus,
        :dateFirstInscriptionDoc,
        :dateSustenance,
        :theseLanguage,
        :theseId,
        :onlineAccessibility,
        :datePublication,
        :dateUpdateThese);');

        $req->bindParam('author',$author,PDO::PARAM_STR,500);
        $req->bindParam('authorId',$authorId,PDO::PARAM_STR,500);
        $req->bindParam('title',$title,PDO::PARAM_STR,500);
        $req->bindParam('theseDirector',$theseDirector,PDO::PARAM_STR,500);
        $req->bindParam('theseDirectorInFirstName',$theseDirectorInFirstName,PDO::PARAM_STR,500);
        $req->bindParam('directorId',$directorId,PDO::PARAM_STR,500);
        $req->bindParam('locationSustenance',$locationSustenance,PDO::PARAM_STR,500);
        $req->bindParam('locationId',$locationId,PDO::PARAM_STR,500);
        $req->bindParam('discipline',$discipline,PDO::PARAM_STR,500);
        $req->bindParam('theseStatus',$theseStatus,PDO::PARAM_STR,500);
        $req->bindParam('dateFirstInscriptionDoc',$dateFirstInscriptionDoc,PDO::PARAM_STR,500);
        $req->bindParam('dateSustenance',$dateSustenance,PDO::PARAM_STR,500);
        $req->bindParam('theseLanguage',$theseLanguage,PDO::PARAM_STR,500);
        $req->bindParam('theseId',$theseId,PDO::PARAM_STR,500);
        $req->bindParam('onlineAccessibility',$onlineAccessibility,PDO::PARAM_STR,500);
        $req->bindParam('datePublication',$datePublication,PDO::PARAM_STR,500);
        $req->bindParam('dateUpdateThese',$dateUpdateThese,PDO::PARAM_STR,500);

        try {
            $req->execute();
        } catch (\Throwable $th) {
            echo "Non";
            print_r($req);
        }

   }

    public static function getPdo(): PDO
    {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO('pgsql:host=' .Dump::$host . ';dbname=' . Dump::$database, Dump::$user, Dump::$pass);
            } catch (PDOException $e) {
                echo "ERREUR : La connexion a échouée<br>\n";
                echo $e->getMessage() . "<br>\n";
            }
        }
        return self::$pdo;
    }

}
