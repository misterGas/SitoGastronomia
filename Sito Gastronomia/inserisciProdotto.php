<?php
  session_start();
	require_once("connessione.php");
  if (isset($_SESSION["idUtente"]) && $_SESSION["tipoUtente"] == "G") {
		$idUtente = $_SESSION["idUtente"];
    $nome = filter_var(substr($_POST["nome"], 0, 70), FILTER_SANITIZE_STRING);
    $descrizione = filter_var(substr($_POST["descrizione"], 0, 200), FILTER_SANITIZE_STRING);
    $tipo = $_POST["tipo"];
    if ($tipo == null) {
      exit("Il campo tipo prodotto è obbligatorio");
    }
    $queryInserimentoProdotto = $connessione -> prepare("insert into PIATTO (NomePiatto, Descrizione, IdT) values (?, ?, ?)");
    $queryInserimentoProdotto -> bind_param("ssi", $nome, $descrizione, $tipo);
    if ($queryInserimentoProdotto -> execute()) {
      echo "Inserimento del prodotto avvenuto con successo";
    }
    else {
      exit("Prodotto non inserito");
    }
  }
?>
