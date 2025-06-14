<?php


// inclure les configs qui contiennent les infos permettant de se connecter a la database
function setup($db_host, $db_user_read, $db_pass_read, $db_user_write, $db_pass_write, $base_url, $usertoken, $apptoken)
{ 
    define("DB_HOST", $db_host);
    define("DB_NAME_GLPI", "glpidb"); // A changer si le nom de la BDD dans MySQL de GLPI est différente
    define('DB_USER_GLPI_READ', $db_user_read);
    define('DB_PASS_GLPI_READ', $db_pass_read);
    define('DB_USER_GLPI_WRITE', $db_user_write);
    define('DB_PASS_GLPI_WRITE', $db_pass_write);
    define("BASE_URL_GLPI", $base_url);
    define("DB_CHARSET", "utf8");
    define('userToken', $usertoken);
    define('appToken', $apptoken);
    try {
        // Créer la connexion
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME_GLPI . ";charset=" . DB_CHARSET, DB_USER_GLPI_READ, DB_PASS_GLPI_READ);
        // Définir les erreurs
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // "Define" conn
        define("conn", $conn);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
};

?>