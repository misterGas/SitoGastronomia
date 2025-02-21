<?php
  session_start();
  require_once("connessione.php");
  $vecchiaEmailUt = filter_var(substr($_POST["vecchiaEmail"], 0, 50), FILTER_SANITIZE_EMAIL);
  $numeroSicurezza = $_POST["numeroSicurezza"];
  $nuovaEmailUt = filter_var(substr($_POST["nuovaEmail"], 0, 50), FILTER_SANITIZE_STRING);
  $controlloNumero = (int)substr($_SESSION["sicurezzaAggEmail"], 0, 1) - (int)substr($_SESSION["sicurezzaAggEmail"], 1, 1) - (int)substr($_SESSION["sicurezzaAggEmail"], 2, 1) - (int)substr($_SESSION["sicurezzaAggEmail"], 3, 1);
  $queryIdUtente = $connessione -> prepare("select IdUtente from UTENTE where EmailUtente = ?");
  $queryIdUtente -> bind_param("s", $emailUt);
  $queryIdUtente -> execute();
  $risultatoIdUtente = $queryIdUtente -> get_result();
  $rigaIdUtente = $risultatoIdUtente -> fetch_assoc();
  $idU = $rigaIdUtente["IdUtente"];
  if ($idU == $_SESSION["idUtente"]) {
    if (!filter_var($vecchiaEmailUt, FILTER_VALIDATE_EMAIL)) {
      exit("Vecchio indirizzo email non valido");
    }
    else if (!filter_var($nuovaEmailUt, FILTER_VALIDATE_EMAIL)) {
      exit("Nuovo indirizzo email non valido");
    }
    else if ($numeroSicurezza != $controlloNumero) {
      exit("Non hai calcolato correttamente la differenza delle cifre del numero di sicurezza. Se il numero di sicurezza è 1234 la differenza delle cifre sarà 1 - 2 - 3 - 4 = -8");
    }
    else {
      $queryControlloEmail = $connessione -> prepare("select * from UTENTE where EmailUtente = ?");
      $queryControlloEmail -> bind_param("s", $vecchiaEmailUt);
      $queryControlloEmail -> execute();
      $risultatoControlloEmail = $queryControlloEmail -> get_result();
      if ($risultatoControlloEmail -> num_rows == 1) {
        $queryUltimaModifica = $connessione -> prepare("select UltimaModifica from UTENTE where EmailUtente = ?");
        $queryUltimaModifica -> bind_param("s", $vecchiaEmailUt);
        $queryUltimaModifica -> execute();
        $risultatoUltimaModifica = $queryUltimaModifica -> get_result();
        $rigaModifica = $risultatoUltimaModifica -> fetch_assoc();
        if (strtotime(date("Y-m-d H:i:s")) - strtotime($rigaModifica["UltimaModifica"]) > 604800) {
          $ultimaModifica = date("Y-m-d H:i:s");
          $queryAggiornaEmail = $connessione -> prepare("update UTENTE set EmailUtente = ? where EmailUtente = ?");
          $queryAggiornaEmail -> bind_param("ss", $nuovaEmailUt, $vecchiaEmailUt);
          if ($queryAggiornaEmail -> execute()) {
            $queryAggiornamento = $connessione -> prepare("update UTENTE set UltimaModifica = ? where EmailUtente = ?");
            $queryAggiornamento -> bind_param("ss", $ultimaModifica, $nuovaEmailUt);
            $queryAggiornamento -> execute();
            echo "Email aggiornata con successo";
          }
          else {
            exit("Email non aggiornata");
          }
        }
        else {
            echo "Non puoi aggiornare l'email più di una volta alla settimana";
        }
      }
      else {
        exit("Vecchio indirizzo email non corretto");
      }
    }
  }
  else {
    exit("Vecchio indirizzo email non corretto");
  }
?>
