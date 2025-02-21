<?php
  session_start();
  require_once("logout.php");
  require_once("connessione.php");
  if (isset($_SESSION["idUtente"])) {
    $idUtente = $_SESSION["idUtente"];
  }
?>
<html>
  <head>
    <meta charset = "utf-8">
    <title> Gastronomia Gastaldi - Contatti </title>
    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel = "stylesheet" integrity = "sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin = "anonymous">
    <script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity = "sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin = "anonymous"></script>
    <script src = "https://code.jquery.com/jquery-latest.js"></script>
    <script src = "funzioni.js"> </script>
    <script src = "funzioni2.js"> </script>
    <script src = "funzioni3.js"> </script>
  </head>
  <body style = "background-color: #F7EEA1">
    <?php
      require_once("navbar.php");
    ?>
    <span>Sei qui: Contatti</span>
    <br/>
    <center><h1> Contatti </h1></center>
    <hr style = "color: #3199A0; height: 5px"/>
    <?php
      if (isset($_POST["cancellaConversazione"])) {
        $queryCancellazioneMessaggio = $connessione -> prepare("delete from CONVERSAZIONE where IdU = ?");
        $queryCancellazioneMessaggio -> bind_param("i", $idUtente);
        $queryCancellazioneMessaggio -> execute();
      }
      if (isset($_POST["invioMessaggio"]) && isset($_SESSION["idUtente"]) && $_SESSION["tipoUtente"] == "U") {
        $messaggio = filter_var(substr($_POST["testoMessaggio"], 0, 1000), FILTER_SANITIZE_STRING);
        $dataInvio = date("Y-m-d H:i:s");
        $queryMessaggio = $connessione -> prepare("insert into CONVERSAZIONE (IdU, TipoMessaggio, DataInvio, TestoMessaggio) values (?, 'Richiesta', ?, ?)");
        $queryMessaggio -> bind_param("iss", $idUtente, $dataInvio, $messaggio);
        $queryMessaggio -> execute();
      }
      if (isset($_SESSION["idUtente"]) && $_SESSION["tipoUtente"] == "U") {
        $queryControlloPrimoMessaggio = $connessione -> prepare("select * from CONVERSAZIONE where IdU = ?");
        $queryControlloPrimoMessaggio -> bind_param("i", $idUtente);
        $queryControlloPrimoMessaggio -> execute();
        $risultatoControlloPrimoMessaggio = $queryControlloPrimoMessaggio -> get_result();
        if ($risultatoControlloPrimoMessaggio -> num_rows == 0) {
    ?>
        <center>
          <h3> Scrivici un messaggio ed inizia una conversazione con noi </h3>
          <form class = "container-fluid" action = "<?php echo $_SERVER["PHP_SELF"]; ?>" method = "POST">
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Ricordati di mantenere un tono educato e rispettoso</label>
            <textarea class="form-control" name = "testoMessaggio" maxlength = "1000" rows="3" required placeholder = "Testo del messaggio (massimo 1000 caratteri)"></textarea>
          </div>
          <button type="submit" class="btn btn-primary" name = "invioMessaggio" style = "background-color: #B9A505">Invia messaggio</button>
        </form></center>
        <br/>
    <?php
        }
        else {
    ?>
          <center><button class="btn btn-primary" id="navbarDropdown" role="button" data-bs-toggle="modal" data-bs-target="#conversazione" aria-expanded="false" style = "background-color: #B9A505"> Visualizza la tua conversazione con noi </button></center>
          <div class="modal fade" id="conversazione" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-xl-down modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Conversazione</h5> &nbsp; &nbsp;
                  <form method = "POST" action = "<?php echo $_SERVER["PHP_SELF"]; ?>" class = "mb-2 mb-lg-0">
                    <input type = "hidden" name = "cancellaConversazione">
                    <button type="submit" class="btn btn-danger" style = "background-color: #EC4145" onclick = "return confirm('Sei sicuro di voler cancellare la tua conversazione?')">Cancella conversazione</button>
                  </form>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <center><h6> La tua conversazione potrebbe essere cancellata da noi in qualsiasi momento, perciò mantieni sempre un tono educato e rispettoso.</h6></center><br/>
                  <?php
                    $queryOrdinamentoGiorni = $connessione -> prepare("select DataInvio, year(DataInvio) as 'Anno', month(DataInvio) as 'Mese', day(DataInvio) as 'Giorno' from CONVERSAZIONE where IdU = ? group by year(DataInvio), month(DataInvio), day(DataInvio)");
                    $queryOrdinamentoGiorni -> bind_param("i", $idUtente);
                    $queryOrdinamentoGiorni -> execute();
                    $risultatoOrdinamentoGiorni = $queryOrdinamentoGiorni -> get_result();
                    while ($ordinamentoGiorni = $risultatoOrdinamentoGiorni -> fetch_assoc()) {
                      $giorno = $ordinamentoGiorni["Giorno"];
                      $mese = $ordinamentoGiorni["Mese"];
                      $anno = $ordinamentoGiorni["Anno"];
                      $g = $giorni[date("w", strtotime($ordinamentoGiorni["DataInvio"]))];
                      $m = $mesi[date("n", strtotime($ordinamentoGiorni["DataInvio"])) - 1];
                      $numGiorno = date("d", strtotime($ordinamentoGiorni["DataInvio"]));
                      if ($numGiorno < 10) {
                        $numGiorno = substr($numGiorno, 1);
                      }
                    ?>
                      <center><b><small style = "border-radius: 10px; border: 3px solid #A2F5FF; background-color: #A2F5FF"><?php echo "$g $numGiorno $m $anno"; ?></small></b></center>
                    <?php
                    $queryConversazione = $connessione -> prepare("select * from CONVERSAZIONE where IdU = ? and year(DataInvio) = ? and month(DataInvio) = ? and day(DataInvio) = ? order by DataInvio");
                    $queryConversazione -> bind_param("iiii", $idUtente, $anno, $mese, $giorno);
                    $queryConversazione -> execute();
                    $risultatoConversazione = $queryConversazione -> get_result();
                    while ($messaggioConversazione = $risultatoConversazione -> fetch_assoc()) {
                      $ora = date("H", strtotime($messaggioConversazione["DataInvio"]));
                      $minuti = date("i", strtotime($messaggioConversazione["DataInvio"]));
                      $secondi = date("s", strtotime($messaggioConversazione["DataInvio"]));
                      if ($messaggioConversazione["TipoMessaggio"] == "Richiesta") {
                      ?>
                        <div class="row justify-content-end"> <small class="col-6"> <?php echo "$ora:$minuti:$secondi"; ?> </small> </div>
                        <div class="row justify-content-end"> <div style = "border-radius: 10px; border: 3px solid #FFD698; background-color: #FFD698" class="col-6"><?php echo $messaggioConversazione["TestoMessaggio"]; ?></div> </div> <br/>
                      <?php
                      }
                      else if ($messaggioConversazione["TipoMessaggio"] == "Risposta") {
                      ?>
                        <div class="row justify-content-start"> <small class="col-6"> <?php echo "$ora:$minuti:$secondi"; ?></small> </div>
                        <div class="row justify-content-start"> <div style = "border-radius: 10px; border: 3px solid #71F228; background-color: #71F228" class="col-6"><?php echo $messaggioConversazione["TestoMessaggio"]; ?></div> </div> <br/>
                      <?php
                        }
                      }
                    }
                  ?>
                  <form class = "container-fluid" action = "<?php echo $_SERVER["PHP_SELF"]; ?>" method = "POST">
                    <div class="mb-2">
                      <textarea class="form-control" name = "testoMessaggio" maxlength = "1000" rows="3" required placeholder = "Scrivi un messaggio (massimo 1000 caratteri)"></textarea>
                    </div>
                    <center><button type="submit" class="btn btn-primary" name = "invioMessaggio" style = "background-color: #B9A505">Invia messaggio</button></center>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <br/>
    <?php
        }
      }
      else if (!isset($_SESSION["idUtente"])) {
        echo "<center><h5> Effettua il login oppure registrati se vuoi iniziare o continuare una conversazione con noi </h5></center> <br/>";
      }
    ?>
    <center> <h4> Dove siamo - Camponogara (VE), Piazza Guglielmo Marconi 60 </h4> </center>
    <center> <iframe class = "container-fluid" src = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2802.2731758477616!2d12.06997431555477!3d45.38365997910008!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x477ec6533e3d8e4b%3A0xc6b01ede827ffb37!2sGastronomia%20Gastaldi!5e0!3m2!1sit!2sit!4v1625304459655!5m2!1sit!2sit" style = "height: 500px" style = "border:0;" allowfullscreen = "" loading = "lazy"></iframe> </center>
    <br/> <br/>
    <center> <h4> Chiamaci al numero 041 462998 oppure scrivici un'email all'indirizzo <a href = "mailto:gastronomia.gastaldi@outlook.it">gastronomia.gastaldi@outlook.it</a></h4></center><br/>
    <center> <h4> Seguici anche su
      <a href = "https://www.facebook.com/pg/Gastronomia-Gastaldi-1670023376618189"> <img src = "logoFacebook.svg" style = "width: 2rem">Facebook</a> e
      <a href = "https://www.instagram.com/gastronomiagastaldi"> <img src = "logoInstagram.png" style = "width: 2rem">Instagram</a> per rimanere sempre aggiornato
    </h4></center><br/>
    <center> <h4> Orari di apertura<br/><small> Dal Martedì al Sabato dalle 8:30 alle 12:30 e dalle 15:00 alle 19:30 <br/> Domenica dalle 8:30 alle 12:30 <br/> Chiuso il Lunedì </small> </h4> </center>
    <br/> <br/> <br/> <br/> <br/> <br/>
    <?php
      require_once("barraInfo.php");
    ?>
  </body>
</html>
