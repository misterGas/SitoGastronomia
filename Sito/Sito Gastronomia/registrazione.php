<?php
  require_once("connessione.php");
  $nomeUt = filter_var(substr($_POST["nome"], 0, 50), FILTER_SANITIZE_STRING);
  $cognomeUt = filter_var(substr($_POST["cognome"], 0, 50), FILTER_SANITIZE_STRING);
  $emailUt = filter_var(substr($_POST["email"], 0, 50), FILTER_SANITIZE_EMAIL);
  $passwordUt = filter_var(substr($_POST["password"], 0, 50), FILTER_SANITIZE_STRING);
  if (!filter_var($emailUt, FILTER_VALIDATE_EMAIL)) {
    exit("Indirizzo email non valido");
  }
  else {
    $queryControlloEmail = $connessione -> prepare("select EmailUtente from UTENTE where EmailUtente = ?");
    $queryControlloEmail -> bind_param("s", $emailUt);
    $queryControlloEmail -> execute();
    $risultatoControlloEmail = $queryControlloEmail -> get_result();
    if ($risultatoControlloEmail -> num_rows == 0) {
      $passwordHash = hash("sha1", $passwordUt);
      $queryRegistrazione = $connessione -> prepare("insert into UTENTE (NomeUtente, CognomeUtente, EmailUtente, PasswordUtente, TipoUtente) values (?, ?, ?, ?, 'U')");
      $queryRegistrazione -> bind_param("ssss", $nomeUt, $cognomeUt, $emailUt, $passwordHash);
      if ($queryRegistrazione -> execute()) {
        $queryInfoUtente = $connessione -> prepare("select IdUtente, TipoUtente from UTENTE where EmailUtente = ?");
        $queryInfoUtente -> bind_param("s", $emailUt);
        $queryInfoUtente -> execute();
        $risultatoInfoUtente = $queryInfoUtente -> get_result();
        if ($risultatoInfoUtente -> num_rows == 1) {
          $rigaInfoUtente = $risultatoInfoUtente -> fetch_assoc();
          session_start();
          $_SESSION["idUtente"] = $rigaInfoUtente["IdUtente"];
          $_SESSION["tipoUtente"] = $rigaInfoUtente["TipoUtente"];
          echo "Registrazione effettuata con successo";
        }
        else {
          exit("Registrazione non effettuata");
        }
      }
      else {
        exit("Registrazione non effettuata");
      }
    }
    else {
      exit("Indirizzo email già in uso");
    }
  }
?>
