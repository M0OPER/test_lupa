<?php 
require_once("../controllers/conexionController.php"); 

$con = new ConexionController();
$con->initial();

?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <title>HOME</title>
  </head>
  <body>
    <?php 

    if (DEBUG_MODE) {
      // Activate PHP debugging
      ini_set('display_errors', 'On');
      error_reporting(E_ALL);
    } 

    require_once("../components/head.php"); require_once("../components/carousel.php"); require_once("../components/foot.php"); ?>

  </body>
</html>