<?php
  require_once("connessione.php");
  $emailUt = filter_var(substr($_POST["email"], 0, 50), FILTER_SANITIZE_EMAIL);
  $passwordUt = filter_var(substr($_POST["password"], 0, 50), FILTER_SANITIZE_STRING);
  if (!filter_var($emailUt, FILTER_VALIDATE_EMAIL)) {
    exit("Indirizzo email non valido");
  }
  else {
    $passwordHash = hash("sha1", $passwordUt);
    $queryControlloLogin = $connessione -> prepare("select * from UTENTE where EmailUtente = ? and PasswordUtente = ?");
    $queryControlloLogin -> bind_param("ss", $emailUt, $passwordHash);
    $queryControlloLogin -> execute();
    $risultatoControlloLogin = $queryControlloLogin -> get_result();
    if ($risultatoControlloLogin -> num_rows == 1) {
      $rigaControlloLogin = $risultatoControlloLogin -> fetch_assoc();
      session_start();
      $_SESSION["idUtente"] = $rigaControlloLogin["IdUtente"];
      $_SESSION["tipoUtente"] = $rigaControlloLogin["TipoUtente"];
      echo "Login effettuato con successo";

    }
    else {
      exit("Login non effettuato. Email o password non corretti");
    }
  }
?>
