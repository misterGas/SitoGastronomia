function inserisciProdotto () {
  const datiInserimento = {
    nome: $("#nomeProdotto").val(),
    descrizione: $("#descrizioneProdotto").val(),
    tipo: $("input#tipoProdotto:checked").val()
  }

  if (datiInserimento["nome"] != "") {
    $.post("inserisciProdotto.php", datiInserimento, function(data) {
      alert(data);
      if (data == "Inserimento del prodotto avvenuto con successo") {
        window.location.replace("gestioneProdotti.php");
      }
    })
  }
  else {
    alert("I campi nome e tipo prodotto sono obbligatori");
  }
}
