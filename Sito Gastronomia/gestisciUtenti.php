<?php
	require_once("connessione.php");
    echo "<h1> Gestione Utenti </h1>";
    $utenti = $connessione -> query("select * from UTENTE where TipoUtente = 'U'");
    while ($riga = $utenti -> fetch_assoc()) {
    	echo $riga["NomeUtente"] . " " . $riga["CognomeUtente"] . ", " . $riga["EmailUtente"] . "<br/>";
    }
?>