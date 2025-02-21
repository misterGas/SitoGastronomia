function registra () {
  const datiRegistrazione = {
    nome: $("#nomeRegistrazione").val(),
    cognome: $("#cognomeRegistrazione").val(),
    email: $("#emailRegistrazione").val(),
    password: $("#passwordRegistrazione").val()
  }

  if (datiRegistrazione["nome"] != "" && datiRegistrazione["cognome"] != "" && datiRegistrazione["email"] != "" && datiRegistrazione["password"] != "") {
    let s = "";
    if (datiRegistrazione["email"] != $("#confermaEmailRegistrazione").val() && s != "") {
      s += "\nIndirizzi email non corrispondenti";
    }
    else if (datiRegistrazione["email"] != $("#confermaEmailRegistrazione").val()) {
      s += "Indirizzi email non corrispondenti";
    }
    if (datiRegistrazione["password"] != $("#confermaPasswordRegistrazione").val() && s != "") {
      s += "\nPassword non corrispondenti";
    }
    else if (datiRegistrazione["password"] != $("#confermaPasswordRegistrazione").val()) {
      s += "Password non corrispondenti";
    }
    if (s == "") {
      $.post("registrazione.php", datiRegistrazione, function (data) {
        alert(data);
        if (data == "Registrazione effettuata con successo") {
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

function login () {
  const datiLogin = {
    email: $("#emailLogin").val(),
    password: $("#passwordLogin").val()
  }

  if (datiLogin["email"] != "" && datiLogin["password"] != "") {
    let s = "";
    if (s == "") {
      $.post("login.php", datiLogin, function (data) {
        alert(data);
        if (data == "Login effettuato con successo") {
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
