  <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    error_reporting(0);
    mysqli_report(MYSQLI_REPORT_STRICT);
    session_start();

    class Configdb_model extends CI_Model{

        public $dbconn4;

        public function __construct(){
        }

        public function startSession($user,$pass,$name,$lastname,$permissions){
             $_SESSION['id'] = $user;
             $_SESSION['pass'] = $pass;
             $_SESSION['name'] = $name;
             $_SESSION['lastname'] = $lastname;
             $_SESSION['permissions'] = $permissions;
        }

        // public function openSession(){
        //   $user = "AdminZTE";
        //   $pass = "a4b3c2d1";
        //   $db = "zte_fonade";
        //
        //   try {
        //     $connection = new mysqli('zte-col.cws6f2qsxddy.us-west-2.rds.amazonaws.com', $user, $pass, $db);
        //     $connection->set_charset("utf8");
        //   } catch (Exception $e ) {
        //      $connection = "false";
        //   }
        //   return $connection;
        // }

        public function openSession(){
          $user = "AdminZTE";
          $pass = "a4b3c2d1";
          $db = "zte_fonade";

          try {
            $connection = new mysqli('35.198.9.249', $user, $pass, $db);
            $connection->set_charset("utf8");
          } catch (Exception $e ) {
             $connection = "false";
          }
          return $connection;
        }




        public function closeSession($session){
          $session->close();
        }

        public function destroySession(){
            session_destroy();
        }

    }
?>
