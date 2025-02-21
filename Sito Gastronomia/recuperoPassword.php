<?php
  session_start();
  require_once("connessione.php");
  $emailUt = filter_var(substr($_POST["email"], 0, 50), FILTER_SANITIZE_EMAIL);
  $numeroSicurezza = $_POST["numeroSicurezza"];
  $passwordUt = filter_var(substr($_POST["nuovaPassword"], 0, 50), FILTER_SANITIZE_STRING);
  $controlloNumero = (int)substr($_SESSION["sicurezzaRec"], 0, 1) + (int)substr($_SESSION["sicurezzaRec"], 1, 1) + (int)substr($_SESSION["sicurezzaRec"], 2, 1) + (int)substr($_SESSION["sicurezzaRec"], 3, 1);
  if (!filter_var($emailUt, FILTER_VALIDATE_EMAIL)) {
    exit("Indirizzo email non valido");
  }
  else if ($numeroSicurezza != $controlloNumero) {
    exit("Non hai calcolato correttamente la somma delle cifre del numero di sicurezza. Se il numero di sicurezza è 1234 la somma delle cifre sarà 1 + 2 + 3 + 4 = 10");
  }
  else {
    $queryControlloEmail = $connessione -> prepare("select * from UTENTE where EmailUtente = ?");
    $queryControlloEmail -> bind_param("s", $emailUt);
    $queryControlloEmail -> execute();
    $risultatoControlloEmail = $queryControlloEmail -> get_result();
    if ($risultatoControlloEmail -> num_rows == 1) {
      $queryUltimaModifica = $connessione -> prepare("select UltimaModifica from UTENTE where EmailUtente = ?");
      $queryUltimaModifica -> bind_param("s", $emailUt);
      $queryUltimaModifica -> execute();
      $risultatoUltimaModifica = $queryUltimaModifica -> get_result();
      $rigaModifica = $risultatoUltimaModifica -> fetch_assoc();
      if (strtotime(date("Y-m-d H:i:s")) - strtotime($rigaModifica["UltimaModifica"]) > 604800) {
        $passwordHash = hash("sha1", $passwordUt);
        $ultimaModifica = date("Y-m-d H:i:s");
        $queryRecuperoPassword = $connessione -> prepare("update UTENTE set PasswordUtente = ? where EmailUtente = ?");
        $queryRecuperoPassword -> bind_param("ss", $passwordHash, $emailUt);
        if ($queryRecuperoPassword -> execute()) {
          $queryModifica = $connessione -> prepare("update UTENTE set UltimaModifica = ? where EmailUtente = ?");
          $queryModifica -> bind_param("ss", $ultimaModifica, $emailUt);
          $queryModifica -> execute();
          echo "Password modificata con successo";
        }
        else {
          exit("Password non modificata");
        }
      }
      else {
          echo "Non puoi modificare la password più di una volta alla settimana";
      }
    }
    else {
      exit("Indirizzo email non presente");
    }
  }
?>
