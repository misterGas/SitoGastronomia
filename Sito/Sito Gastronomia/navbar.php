<?php
  $giorni = array("DOMENICA", "LUNEDÌ", "MARTEDÌ", "MERCOLEDÌ", "GIOVEDÌ", "VENERDÌ", "SABATO");
  $mesi = array("GENNAIO", "FEBBRAIO", "MARZO", "APRILE", "MAGGIO", "GIUGNO", "LUGLIO", "AGOSTO", "SETTEMBRE", "OTTOBRE", "NOVEMBRE", "DICEMBRE");
  $giorniMin = array("Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato");
  $mesiMin = array("Gennaio", "Febbario", "Marzo", "Aprile", "MAGGIO", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");
?>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #BFBFBF;">
  <div class="container-fluid">
    <div style="width: 6rem;">
      <a href = "index.php"> <img src="logoGastronomia.jpg" class="card-img-top"> </a>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="storia.php">La nostra storia</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="contatti.php">Contatti</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="gallery.php">Gallery</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="prodotti.php">I nostri prodotti</a>
        </li>
        <?php
          if (isset($_SESSION["idUtente"]) && $_SESSION["tipoUtente"] == "U") {
        ?>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="listaDesideri.php">Lista dei desideri</a>
          </li>
        <?php
          }
          if (isset($_SESSION["idUtente"]) && $_SESSION["tipoUtente"] == "G") {
        ?>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="gestioneProdotti.php">Gestione prodotti</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="gestioneConversazioni.php">Gestione conversazioni</a>
          </li>
        <?php
          }
        ?>
        <li class="nav-item">
          <?php
            if (isset($_SESSION["idUtente"])) {
          ?>
            <form method = "POST" action = "<?php echo $_SERVER["PHP_SELF"]; ?>" class = "mb-2 mb-lg-0">
              <input type = "hidden" name = "logout">
              <button type = "submit" class="btn" style = "background-color: #EC4145" onclick = "return confirm('Sei sicuro di voler effettuare il logout?')"> Logout </button>
            </form>
          <?php
            }
            else {
          ?>
              <button class="btn" id="navbarDropdown" role="button" data-bs-toggle="modal" data-bs-target="#finestraLogin" aria-expanded="false" style = "background-color: #FFD698"> Login </button>
              <div class="modal fade" id="finestraLogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <center style = "color: red"> <b> Campo obbligatorio * </b> </center> <br/>
                      <div class="mb-3"> Indirizzo email<span style = "color: red">*</span> <input type="email" id = "emailLogin" class="form-control" placeholder="Inserisci il tuo indirizzo email" required> </div>
                      <div class="mb-3"> Password<span style = "color: red">*</span> <input type="password" id = "passwordLogin" class="form-control" placeholder="Inserisci la password" required> </div>
                      <center>
                        <p> <button class="btn" type="submit" style = "background-color: #FFD6BB" onclick = "login()">Login</button>
                        <button class="btn" role="button" data-bs-toggle="collapse" data-bs-target="#recuperaPasswordLogin" aria-expanded="false" style = "background-color: #FFD6BB"> Password dimenticata? </button> </p>
                      </center>
                      <div class="collapse" id="recuperaPasswordLogin">
                        <div class="card card-body">
                          <center style = "color: red"> Puoi recuperare la tua password una sola volta alla settimana</center><br/>
                          <center style = "color: red"> <b> Campo obbligatorio * </b> </center> <br/>
                          <div class="mb-3"> Indirizzo email<span style = "color: red">*</span> <input type="email" id = "recuperoEmailLogin" class="form-control" placeholder="Inserisci il tuo indirizzo email" required> </div>
                          <div class="mb-3"> Numero di sicurezza: <?php $sicurezzaRecupero = rand(1000, 9999); echo $sicurezzaRecupero; $_SESSION["sicurezzaRec"] = (int)substr($sicurezzaRecupero, 0, 1) + (int)substr($sicurezzaRecupero, 1, 1) + (int)substr($sicurezzaRecupero, 2, 1) + (int)substr($sicurezzaRecupero, 3, 1); ?><span style = "color: red">*</span> <input type="number" id = "recuperoNumeroSicurezzaLogin" class="form-control" placeholder="Scrivi la somma delle cifre del numero di sicurezza" required> </div>
                          <div class="mb-3"> Nuova password<span style = "color: red">*</span> <input type="password" id = "recuperoPasswordLogin" class="form-control" placeholder="Inserisci la nuova password" required> </div>
                          <div class="mb-3"> Conferma nuova password<span style = "color: red">*</span> <input type="password" id = "confermaRecuperoPasswordLogin" class="form-control" placeholder="Conferma la nuova password" required> </div>
                          <center><button class="btn" type="submit" style = "background-color: #FFD6BB" onclick = "recupero()">Recupera password</button></center>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <button class="btn" id="navbarDropdown" role="button" data-bs-toggle="modal" data-bs-target="#finestraRegistrazione" aria-expanded="false" style = "background-color: #71F228"> Registrati </button>
              <div class="modal fade" id="finestraRegistrazione" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Registrati</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <center style = "color: red"> <b> Campo obbligatorio * </b> </center> <br/>
                        <div class="mb-3"> Nome<span style = "color: red">*</span> <input type="text" id = "nomeRegistrazione" class="form-control" placeholder="Inserisci il tuo nome" required> </div>
                        <div class="mb-3"> Cognome<span style = "color: red">*</span> <input type="text" id = "cognomeRegistrazione" class="form-control" placeholder="Inserisci il tuo cognome" required> </div>
                        <div class="mb-3"> Email<span style = "color: red">*</span> <input type="email" id = "emailRegistrazione" class="form-control" placeholder="Inserisci il tuo indirizzo email" required> </div>
                        <div class="mb-3"> Conferma email<span style = "color: red">*</span> <input type="email" id = "confermaEmailRegistrazione" class="form-control" placeholder="Conferma il tuo indirizzo email" required> </div>
                        <div class="mb-3"> Password<span style = "color: red">*</span> <input type="password" id = "passwordRegistrazione" class="form-control" placeholder="Inserisci la password" required> </div>
                        <div class="mb-3"> Conferma password<span style = "color: red">*</span> <input type="password" id = "confermaPasswordRegistrazione" class="form-control" placeholder="Conferma la password" required> </div>
                        <center> <button class="btn" id = "bottoneRegistrazione" type="submit" style = "background-color: #71F2AA" onclick = "registra()">Registrati</button></center>
                    </div>
                  </div>
                </div>
              </div>
          <?php
            }
          ?>
        </li>
      </ul>
    </div>
    <?php
      if (isset($_SESSION["idUtente"])) {
        $idUtente = $_SESSION["idUtente"];
        $queryNomeUtente = $connessione -> prepare("select NomeUtente, CognomeUtente from UTENTE where IdUtente = ?");
        $queryNomeUtente -> bind_param("i", $idUtente);
        $queryNomeUtente -> execute();
        $risultatoNomeUtente = $queryNomeUtente -> get_result();
        if ($risultatoNomeUtente -> num_rows == 1) {
          $infoUtente = $risultatoNomeUtente -> fetch_assoc();
    ?>
    <div style="width: 5rem">
      <button class="btn" role="button" data-bs-toggle="modal" data-bs-target="#infoLogin" aria-expanded="false"><img src="login.png" class="card-img-top"><small><?php echo $infoUtente["NomeUtente"] . " " . $infoUtente["CognomeUtente"];
      if ($_SESSION["tipoUtente"] == "G") { echo "<br/>(Gestore)"; } else if ($_SESSION["tipoUtente"] == "A") { echo "<br/>(Admin)"; }?></small></button>
      <div class="modal fade" id="infoLogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Gestisci utente</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <center style = "color: red"> Puoi modificare la password o l'email una sola volta alla settimana. Se hai recuperato la password e vuoi modificarla dovrai attendere una settimana</center><br/>
              <?php
                $queryUltimaModifica = $connessione -> prepare("select UltimaModifica from UTENTE where IdUtente = ?");
                $queryUltimaModifica -> bind_param("i", $idUtente);
                $queryUltimaModifica -> execute();
                $risultatoUltimaModifica = $queryUltimaModifica -> get_result();
                $modifica = $risultatoUltimaModifica -> fetch_assoc();
                $giorno = $giorniMin[date("w", strtotime($modifica["UltimaModifica"]))];
                $mese = $mesiMin[date("n", strtotime($modifica["UltimaModifica"])) - 1];
                $numGiorno = date("d", strtotime($modifica["UltimaModifica"]));
                if ($numGiorno < 10) {
                  $numGiorno = substr($numGiorno, 1);
                }
                $anno = date("Y", strtotime($modifica["UltimaModifica"]));
                $ora = date("H", strtotime($modifica["UltimaModifica"]));
                $minuti = date("i", strtotime($modifica["UltimaModifica"]));
                $secondi = date("s", strtotime($modifica["UltimaModifica"]));
                if ($modifica["UltimaModifica"] != null) {
              ?>
                <center><small>Ultima modifica sul tuo profilo: <?php echo "$giorno $numGiorno $mese $anno, $ora:$minuti:$secondi"; ?> </small></center><br/>
              <?php
                }
              ?>
              <center>
                <p><button class="btn" role="button" data-bs-toggle="collapse" data-bs-target="#modificaPassword" aria-expanded="false" style = "background-color: #D6FF66"> Modifica password </button> </p>
              </center>
              <div class="collapse" id="modificaPassword">
                <div class="card card-body">
                  <center style = "color: red"> <b> Campo obbligatorio * </b> </center> <br/>
                  <div class="mb-3"> Indirizzo email<span style = "color: red">*</span> <input type="email" id = "modificaEmail" class="form-control" placeholder="Inserisci il tuo indirizzo email" required> </div>
                  <div class="mb-3"> Vecchia password<span style = "color: red">*</span> <input type="password" id = "modificaVecchiaPassword" class="form-control" placeholder="Inserisci la vecchia password" required> </div>
                  <div class="mb-3"> Numero di sicurezza: <?php $sicurezzaAggiornamentoPssw = rand(1000, 9999); echo $sicurezzaAggiornamentoPssw; $_SESSION["sicurezzaAggPssw"] = $sicurezzaAggiornamentoPssw; ?><span style = "color: red">*</span> <input type="number" id = "modificaNumeroSicurezza" class="form-control" placeholder="Scrivi il prodotto delle cifre del numero di sicurezza" required> </div>
                  <div class="mb-3"> Nuova password<span style = "color: red">*</span> <input type="password" id = "modificaNuovaPassword" class="form-control" placeholder="Inserisci la nuova password" required> </div>
                  <div class="mb-3"> Conferma nuova password<span style = "color: red">*</span> <input type="password" id = "confermaModificaNuovaPassword" class="form-control" placeholder="Conferma la nuova password" required> </div>
                  <center><button class="btn" type="submit" style = "background-color: #63FFCB" onclick = "aggiornaPassword()">Modifica password</button></center>
                </div>
              </div>
              <p></p>
              <center>
                <p><button class="btn" role="button" data-bs-toggle="collapse" data-bs-target="#aggiornaIndirizzoEmail" aria-expanded="false" style = "background-color: #D6FF66"> Modifica email </button> </p>
              </center>
              <div class="collapse" id="aggiornaIndirizzoEmail">
                <div class="card card-body">
                  <center style = "color: red"> <b> Campo obbligatorio * </b> </center> <br/>
                  <div class="mb-3"> Indirizzo email<span style = "color: red">*</span> <input type="email" id = "aggiornaEmail" class="form-control" placeholder="Inserisci il tuo indirizzo email" required> </div>
                  <div class="mb-3"> Numero di sicurezza: <?php $sicurezzaAggiornamentoEmail = rand(1000, 9999); echo $sicurezzaAggiornamentoEmail; $_SESSION["sicurezzaAggEmail"] = $sicurezzaAggiornamentoEmail; ?><span style = "color: red">*</span> <input type="number" id = "aggiornaNumeroSicurezza" class="form-control" placeholder="Scrivi la differenza delle cifre del numero di sicurezza" required> </div>
                  <div class="mb-3"> Nuovo indirizzo email<span style = "color: red">*</span> <input type="email" id = "aggiornaNuovaEmail" class="form-control" placeholder="Inserisci il tuo nuovo indirizzo email" required> </div>
                  <div class="mb-3"> Conferma nuovo indirizzo email<span style = "color: red">*</span> <input type="email" id = "confermaAggiornaNuovaEmail" class="form-control" placeholder="Conferma il tuo nuovo indirizzo email" required> </div>
                  <center><button class="btn" type="submit" style = "background-color: #63FFCB" onclick = "aggiornaEmail()">Modifica email</button></center>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
        }
      }
    ?>
  </div>
</nav>
