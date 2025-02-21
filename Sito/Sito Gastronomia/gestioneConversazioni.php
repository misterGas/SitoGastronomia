<?php
  session_start();
  require_once("logout.php");
  require_once("connessione.php");
  if (isset($_SESSION["idUtente"]) && $_SESSION["tipoUtente"] == "G") {
?>
<html>
  <head>
    <meta charset = "utf-8">
    <title> Gastronomia Gastaldi - Gestione conversazioni </title>
    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel = "stylesheet" integrity = "sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin = "anonymous">
    <script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity = "sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin = "anonymous"></script>
    <script src = "https://code.jquery.com/jquery-latest.js"></script>
    <script src = "funzioni.js"> </script>
    <script src = "funzioni2.js"> </script>
    <script src = "funzioni3.js"> </script>
  </head>
  <body style = "background-color: #C2E5B9">
    <?php
      require_once("navbar.php");
    ?>
    <span>Sei qui: Gestione conversazioni</span>
    <br/>
    <center><h1> Gestione conversazioni </h1></center>
    <hr style = "color: #3199A0; height: 5px"/>
    <?php
          $queryNumeroConversazioni = $connessione -> prepare("select IdU from CONVERSAZIONE group by IdU");
          $queryNumeroConversazioni -> execute();
          $risultatoNumeroConversazioni = $queryNumeroConversazioni -> get_result();
          if ($risultatoNumeroConversazioni -> num_rows > 0) {
            while ($conversazione = $risultatoNumeroConversazioni -> fetch_assoc()) {
              $utente = $conversazione["IdU"];
              if (isset($_POST["cancellaConversazione$utente"])) {
                $queryCancellazioneMessaggio = $connessione -> prepare("delete from CONVERSAZIONE where IdU = ?");
                $queryCancellazioneMessaggio -> bind_param("i", $utente);
                $queryCancellazioneMessaggio -> execute();
                $queryNessunaConversazione = $connessione -> prepare("select * from CONVERSAZIONE");
                $queryNessunaConversazione -> execute();
                $risultatoNessunaConversazione = $queryNessunaConversazione -> get_result();
                if ($risultatoNessunaConversazione -> num_rows == 0) {
                  echo "<center><h2>Nessuna conversazione presente</h2></center>";
                }
              }
              if (isset($_POST["invioMessaggio$utente"])) {
                $messaggio = filter_var(substr($_POST["testoMessaggio$utente"], 0, 1000), FILTER_SANITIZE_STRING);
                $dataInvio = date("Y-m-d H:i:s");
                $queryMessaggio = $connessione -> prepare("insert into CONVERSAZIONE (IdU, TipoMessaggio, DataInvio, TestoMessaggio) values (?, 'Risposta', ?, ?)");
                $queryMessaggio -> bind_param("iss", $utente, $dataInvio, $messaggio);
                $queryMessaggio -> execute();
              }
              $queryEmailUtente = $connessione -> prepare("select EmailUtente from UTENTE where IdUtente = ?");
              $queryEmailUtente -> bind_param("i", $utente);
              $queryEmailUtente -> execute();
              $risultatoEmailUtente = $queryEmailUtente -> get_result();
              if ($risultatoEmailUtente -> num_rows == 1) {
                $rigaEmailUtente = $risultatoEmailUtente -> fetch_assoc();
                $email = $rigaEmailUtente["EmailUtente"];
                $queryControlloConversazione = $connessione -> prepare("select * from CONVERSAZIONE where IdU = ?");
                $queryControlloConversazione -> bind_param("i", $utente);
                $queryControlloConversazione -> execute();
                $risultatoControlloConversazione = $queryControlloConversazione -> get_result();
                if ($risultatoControlloConversazione -> num_rows > 0) {
                  echo "<center><h2>Conversazione con $email</h2></center>";
                ?>
                  <center><button class="btn btn-primary" id="navbarDropdown" role="button" data-bs-toggle="modal" data-bs-target="#conversazione<?php echo $utente; ?>" aria-expanded="false" style = "background-color: #35B812"> Visualizza conversazione con <?php echo $email; ?> </button></center>
                  <div class="modal fade" id="conversazione<?php echo $utente; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-xl-down modal-xl">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Conversazione</h5> &nbsp; &nbsp;
                          <form method = "POST" action = "<?php echo $_SERVER["PHP_SELF"]; ?>" class = "mb-2 mb-lg-0">
                            <input type = "hidden" name = "cancellaConversazione<?php echo $utente; ?>">
                            <button type="submit" class="btn btn-danger" style = "background-color: #EC4145" onclick = "return confirm('Sei sicuro di voler cancellare questa conversazione?')">Cancella conversazione</button>
                          </form>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <?php
                            $queryOrdinamentoGiorni = $connessione -> prepare("select DataInvio, year(DataInvio) as 'Anno', month(DataInvio) as 'Mese', day(DataInvio) as 'Giorno' from CONVERSAZIONE where IdU = ? group by year(DataInvio), month(DataInvio), day(DataInvio)");
                            $queryOrdinamentoGiorni -> bind_param("i", $utente);
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
                              $queryConversazione -> bind_param("iiii", $utente, $anno, $mese, $giorno);
                              $queryConversazione -> execute();
                              $risultatoConversazione = $queryConversazione -> get_result();
                              while ($messaggioConversazione = $risultatoConversazione -> fetch_assoc()) {
                                $ora = date("H", strtotime($messaggioConversazione["DataInvio"]));
                                $minuti = date("i", strtotime($messaggioConversazione["DataInvio"]));
                                $secondi = date("s", strtotime($messaggioConversazione["DataInvio"]));
                                if ($messaggioConversazione["TipoMessaggio"] == "Risposta") {
                              ?>
                                  <div class="row justify-content-end"> <small class="col-6"> <?php echo "$ora:$minuti:$secondi"; ?></small> </div>
                                  <div class="row justify-content-end"><div style = "border-radius: 10px; border: 3px solid #FFD698; background-color: #FFD698" class="col-6"><?php echo $messaggioConversazione["TestoMessaggio"]; ?></div></div> <br/>
                              <?php
                                }
                                else if ($messaggioConversazione["TipoMessaggio"] == "Richiesta") {
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
                              <textarea class="form-control" name = "testoMessaggio<?php echo $utente; ?>" maxlength = "1000" rows="3" required placeholder = "Scrivi un messaggio (massimo 1000 caratteri)"></textarea>
                            </div>
                            <center><button type="submit" class="btn btn-primary" name = "invioMessaggio<?php echo $utente; ?>" style = "background-color: #35B812">Invia messaggio</button></center>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br/>
                <?php
                }
              }
            }
          }
          else {
            echo "<center><h2>Nessuna conversazione presente</h2></center>";
          }
      }
      else {
        header("location: index.php");
      }
      require_once("barraInfo.php");
    ?>
  </body>
</html>
