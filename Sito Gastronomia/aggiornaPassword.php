<?php
  session_start();
  require_once("connessione.php");
  $emailUt = filter_var(substr($_POST["email"], 0, 50), FILTER_SANITIZE_EMAIL);
  $vecchiaPasswordUt = filter_var(substr($_POST["vecchiaPassword"], 0, 50), FILTER_SANITIZE_STRING);
  $numeroSicurezza = $_POST["numeroSicurezza"];
  $passwordUt = filter_var(substr($_POST["nuovaPassword"], 0, 50), FILTER_SANITIZE_STRING);
  $controlloNumero = (int)substr($_SESSION["sicurezzaAggPssw"], 0, 1) * (int)substr($_SESSION["sicurezzaAggPssw"], 1, 1) * (int)substr($_SESSION["sicurezzaAggPssw"], 2, 1) * (int)substr($_SESSION["sicurezzaAggPssw"], 3, 1);
  $queryIdUtente = $connessione -> prepare("select IdUtente from UTENTE where EmailUtente = ?");
  $queryIdUtente -> bind_param("s", $emailUt);
  $queryIdUtente -> execute();
  $risultatoIdUtente = $queryIdUtente -> get_result();
  $rigaIdUtente = $risultatoIdUtente -> fetch_assoc();
  $idU = $rigaIdUtente["IdUtente"];
  if ($idU == $_SESSION["idUtente"]) {
    if (!filter_var($emailUt, FILTER_VALIDATE_EMAIL)) {
      exit("Indirizzo email non valido");
    }
    else if ($numeroSicurezza != $controlloNumero) {
      exit("Non hai calcolato correttamente il prodotto delle cifre del numero di sicurezza. Se il numero di sicurezza è 1234 il prodotto delle cifre sarà 1 * 2 * 3 * 4 = 24");
    }
    else {
      $passwordHash = hash("sha1", $vecchiaPasswordUt);
      $queryControlloEmail = $connessione -> prepare("select * from UTENTE where EmailUtente = ? and PasswordUtente = ?");
      $queryControlloEmail -> bind_param("ss", $emailUt, $passwordHash);
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
          $queryAggiornaPassword = $connessione -> prepare("update UTENTE set PasswordUtente = ? where EmailUtente = ?");
          $queryAggiornaPassword -> bind_param("ss", $passwordHash, $emailUt);
          if ($queryAggiornaPassword -> execute()) {
            $queryAggiornamento = $connessione -> prepare("update UTENTE set UltimaModifica = ? where EmailUtente = ?");
            $queryAggiornamento -> bind_param("ss", $ultimaModifica, $emailUt);
            $queryAggiornamento -> execute();
            echo "Password aggiornata con successo";
          }
          else {
            exit("Password non aggiornata");
          }
        }
        else {
            echo "Non puoi aggiornare la password più di una volta alla settimana";
        }
      }
      else {
        exit("Indirizzo email e vecchia password non corretti");
      }
    }
  }
  else {
    exit("Indirizzo email non corretto");
  }
?>
