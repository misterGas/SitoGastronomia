<?php
  $connessione = new mysqli("localhost", "root", "", "GASTRONOMIA");
  if ($connessione -> connect_errno) {
    echo "Impossibile connettersi al server: " . $connessione -> connect_error;
  }
?>
