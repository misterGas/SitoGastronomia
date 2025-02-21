function recupero () {
  const datiRecuperoPassword = {
    email: $("#recuperoEmailLogin").val(),
    numeroSicurezza: $("#recuperoNumeroSicurezzaLogin").val(),
    nuovaPassword: $("#recuperoPasswordLogin").val()
  }

  if (datiRecuperoPassword["email"] != "" && datiRecuperoPassword["numeroSicurezza"] != 0 && datiRecuperoPassword["nuovaPassword"] != "") {
    let s = "";
    if (datiRecuperoPassword["nuovaPassword"] != $("#confermaRecuperoPasswordLogin").val()) {
      s = "Password non corrispondenti";
    }
    if (s == "") {
      $.post("recuperoPassword.php", datiRecuperoPassword, function (data) {
        alert(data);
        if (data == "Password modificata con successo" || data == "Non puoi aggiornare la password più di una volta alla settimana") {
        window.location.replace("index.php");
        }
      })
    }
    else {
      alert(s);
    }
  }
  else {
    s = "Tutti i campi sono obbligatori";
    alert(s);
  }
}
