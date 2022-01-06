<?php
ini_set('max_execution_time', '0');
class PdoAccess
{

    private static $user = "guillaume.grisolet";
    private static $pass = "guigui";
    private static $database = "guillaume.grisolet_db";
    private static $host = "sqletud.u-pem.fr";
    private static $pdo;


    public static function theseByAuthorTable($author_name, $onlineAccess){
        $pdo = self::getPdo();
        $sqlAuthor = null;
        if($onlineAccess != null) {
            $sqlAuthor .= "SELECT * FROM public.theses_db WHERE online_accessibility == 'oui' theses_db.author LIKE '%".$author_name."%'" ;
        } else {
            $sqlAuthor .= "SELECT * FROM public.theses_db WHERE theses_db.author LIKE '%".$author_name."%'" ;
        }
        $stmt = $pdo->prepare($sqlAuthor);
        $stmt->execute();
        return $stmt;
    }

    public static function theseLocation($locationId){
        $pdo = self::getPdo();
        $sql = "SELECT * FROM public.theses_db_coord WHERE theses_db_coord.location_id = '".$locationId."'" ;
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res;
    }

    public static function getPdo(): PDO
    {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO('pgsql:host=' .self::$host . ';dbname=' . self::$database, self::$user, self::$pass);
            } catch (PDOException $e) {
                echo "ERREUR : La connexion a échouée<br>\n";
                echo $e->getMessage() . "<br>\n";
            }
        }
        return self::$pdo;
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

    public static function insertCoordinates($longitude,$latitude,$locationId){
        $pdo = self::getPdo();
        $sql = "INSERT INTO theses_db_coord (longitude,latitude,location_id) VALUES (:longitude, :latitude, :locationId)";
        $req = $pdo->prepare($sql);
        $req->bindParam('longitude', $longitude);
        $req->bindParam('latitude', $latitude);
        $req->bindParam('locationId', $locationId);
        try {
            $req->execute();
            echo 'Insertion réussit !';
        } catch (\Throwable $th) {
            echo "Insertion échouée !";
        }


    }

    public static function printTheseAuthor($stmt)
    {
        $list = array();
        $result = $stmt->fetchAll();
        // Affichage des données récoltées par ligne
        $len = count($result);
        echo '<div class="numberResult">
               
                    <h4>Nombre de résultat: '.$len.'</h4>
              </div>';
        if($result != null){
            foreach ($result as $row) {

                if(isset($list[$row['discipline']])){
                    $list[$row['discipline']]++;
                } else {
                    $list[$row['discipline']] = 1;
                }

                echo "<div class='rectangle'>
                    <p>".$row['author']."</p>
                    <p>".$row['author_id']."</p>
                    <p>".$row['title']."</p>
                    <p>".$row['discipline']."</p>
                    </div>";
                echo "<br>";
            }
        } else {
            echo '<div class="noValue">
                   <h1>Aucune donnée trouvée !</h1> 
                </div>';
        }
        return $list;
    }
}