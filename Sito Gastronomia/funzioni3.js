function aggiornaPassword () {
  const datiAggiornamentoPassword = {
    email: $("#modificaEmail").val(),
    vecchiaPassword: $("#modificaVecchiaPassword").val(),
    numeroSicurezza: $("#modificaNumeroSicurezza").val(),
    nuovaPassword: $("#modificaNuovaPassword").val()
  }

  if (datiAggiornamentoPassword["email"] != "" && datiAggiornamentoPassword["vecchiaPassword"] != "" && datiAggiornamentoPassword["numeroSicurezza"] >= 0 && datiAggiornamentoPassword["nuovaPassword"] != "") {
    let s = "";
    if (datiAggiornamentoPassword["nuovaPassword"] != $("#confermaModificaNuovaPassword").val()) {
      s = "Nuove password non corrispondenti";
    }
    else if (datiAggiornamentoPassword["nuovaPassword"] == datiAggiornamentoPassword["vecchiaPassword"]) {
      s = "Non puoi utilizzare di nuovo la stessa password";
    }
    if (s == "") {
      $.post("aggiornaPassword.php", datiAggiornamentoPassword, function (data) {
        alert(data);
        if (data == "Password aggiornata con successo" || data == "Non puoi aggiornare la password più di una volta alla settimana") {
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

function aggiornaEmail () {
  const datiAggiornamentoEmail = {
    vecchiaEmail: $("#aggiornaEmail").val(),
    numeroSicurezza: $("#aggiornaNumeroSicurezza").val(),
    nuovaEmail: $("#aggiornaNuovaEmail").val()
  }

  if (datiAggiornamentoEmail["vecchiaEmail"] != "" && datiAggiornamentoEmail["numeroSicurezza"] != "" && datiAggiornamentoEmail["nuovaEmail"] != "") {
    let s = "";
    if (datiAggiornamentoEmail["nuovaEmail"] != $("#confermaAggiornaNuovaEmail").val()) {
      s = "Nuove email non corrispondenti";
    }
    else if (datiAggiornamentoEmail["nuovaEmail"] == datiAggiornamentoEmail["vecchiaEmail"]) {
      s = "Non puoi utilizzare di nuovo la stessa email";
    }
    if (s == "") {
      $.post("aggiornaEmail.php", datiAggiornamentoEmail, function (data) {
        alert(data);
        if (data == "Email aggiornata con successo" || data == "Non puoi aggiornare l'email più di una volta alla settimana") {
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
