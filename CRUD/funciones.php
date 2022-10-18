<?php
/*
Ataques XSS: Para evitar ataques XSS vamos a codificar los caracteres especiales en sus respectivas versiones HTML.
Luego se incluye el archivo funciones.php en la parte superior del archivo crear.php
Seguidamente, usa la función escapar con el elemento $_POST['nombre'] en el array $resultado
*/
function escapar($html) {
  return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

?>