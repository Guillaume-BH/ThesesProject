<?php
ini_set('max_execution_time', '0');
// A dé-commenter pour upload sur la bdd

class Dump
{

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

    /*$liste = array();
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
    }*/


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
       $authorId = $these->getAuthorId();
       $title = $these->getTitle();
       $theseDirector = $these->getTheseDirector();
       $theseDirectorInFirstName = $these->getTheseDirectorInFirstName();
       $directorId = $these->getDirectorId();
       $locationSustenance = $these->getLocationSustenance();
       $locationId = $these->getLocationId();
       $discipline = $these->getDiscipline();
       $theseStatus = $these->getStatus();
       $dateFirstInscriptionDoc = self::correctDate($these->getDateFirstInscriptionDoc());
       $dateSustenance = self::correctDate($these->getDateSustenance());
       $theseLanguage = $these->getTheseLanguage();
       $theseId = $these->getTheseId();
       $onlineAccessibility = $these->getOnlineAccessibility();
       if($dateSustenance == ""){
           $dateSustenance = NULL;
       }
       $datePublication = self::correctDate($these->getDatePublication());
       if($datePublication== ""){
           $datePublication = NULL;
       }
       $dateUpdateThese = self::correctDate($these->getDateUpdateThese());
        /*
        echo "<br>Author:";
        echo $author;

        echo "<br>Author ID:";
        echo $authorId;

        echo "<br>Title:";
        echo $title;

        echo "<br>Director";
        echo $theseDirector;

        echo "<br>Director In First Name:";
        echo $theseDirectorInFirstName;

        echo "<br>Director ID:";
        echo $directorId;

        echo "<br>Location Sustenance:";
        echo $locationSustenance;

        echo "<br>Location ID:";
        echo $locationId;

        echo "<br>Discipline:";
        echo $discipline;

        echo "<br>These Status:";
        echo $theseStatus;

        echo "<br>First Inscription Doc:";
        echo $dateFirstInscriptionDoc;



        echo "<br>Date Sustenance:";
        echo $dateSustenance;


        echo "<br>Online Accessibility:";
        echo $onlineAccessibility;


        echo "<br>Date Publication:";
        echo $datePublication;


        echo "<br>Date Update These:";
        echo $dateUpdateThese;

        echo "<br>";
        echo "<br>";
        echo "<br>";*/
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
   public static function setDataMap($path){
       $file = file_get_contents($path);
       header("Content-Type: application/json; charset=utf-8");
       include("../api/JsonFormat.php");
       JsonFormat::prettyPrint($file);
   }

}
