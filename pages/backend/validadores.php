
<?php

$email = trim($_POST["correo"]);

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "1";
} else {
   echo "0";
}
//echo json_encode($respuestaValidacion);


/* ahora lo imprimes 
  IMPORTANTE !! IMPORTANTE !! IMPORTANTE !! IMPORTANTE !!
  No imprimas otra cosa más que la respuesta */

//Convertimos el array a JSON y lo imprimimos para que pueda recuperarlo el JS
?>

