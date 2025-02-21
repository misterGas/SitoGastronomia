<?php
  session_start();
  require_once("logout.php");
  require_once("connessione.php");
  if (isset($_SESSION["idUtente"]) && $_SESSION["tipoUtente"] == "G") {
    $queryTipoProdotto = $connessione -> prepare("select * from PIATTO");
    $queryTipoProdotto -> execute();
    $risultatoTipoProdotto = $queryTipoProdotto -> get_result();
    while ($tipo = $risultatoTipoProdotto -> fetch_assoc()) {
      if (isset($_POST["cancella" . $tipo["IdPiatto"]])) {
        $idProdotto = $tipo["IdPiatto"];
        $queryCancellaProdotto = $connessione -> prepare("delete from PIATTO where IdPiatto = ?");
        $queryCancellaProdotto -> bind_param("i", $idProdotto);
        $queryCancellaProdotto -> execute();
      }
      if (isset($_POST["modificaProdotto" . $tipo["IdPiatto"]])) {
        $idProdotto = $tipo["IdPiatto"];
        $nomeProd = filter_var(substr($_POST["nomeProdottoModifica" . $tipo["IdPiatto"]], 0, 70), FILTER_SANITIZE_STRING);
        $descrProd = filter_var(substr($_POST["descrizioneProdottoModifica" . $tipo["IdPiatto"]], 0, 200), FILTER_SANITIZE_STRING);
        $tipoProd = $_POST["tipoProdottoModifica" . $tipo["IdPiatto"]];
        $queryModificaProd = $connessione -> prepare("update PIATTO set NomePiatto = ? where IdPiatto = ?");
        $queryModificaProd -> bind_param("si", $nomeProd, $idProdotto);
        $queryModificaProd -> execute();
        if (strlen($descrProd) > 0) {
          $queryModificaProd = $connessione -> prepare("update PIATTO set Descrizione = ? where IdPiatto = ?");
          $queryModificaProd -> bind_param("si", $descrProd, $idProdotto);
          $queryModificaProd -> execute();
        }
        else {
          $queryModificaProd = $connessione -> prepare("update PIATTO set Descrizione = null where IdPiatto = ?");
          $queryModificaProd -> bind_param("i", $idProdotto);
          $queryModificaProd -> execute();
        }
        $queryModificaProd = $connessione -> prepare("update PIATTO set IdT = ? where IdPiatto = ?");
        $queryModificaProd -> bind_param("ii", $tipoProd, $idProdotto);
        $queryModificaProd -> execute();
      }
    }
?>
<html>
  <head>
    <meta charset = "utf-8">
    <title> Gastronomia Gastaldi - Gestione prodotti </title>
    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel = "stylesheet" integrity = "sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin = "anonymous">
    <script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity = "sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin = "anonymous"></script>
    <script src = "https://code.jquery.com/jquery-latest.js"></script>
    <script src = "funzioni.js"> </script>
    <script src = "funzioni2.js"> </script>
    <script src = "funzioni3.js"> </script>
    <script src = "gestisciProdotti.js"> </script>
  </head>
  <body style = "background-color: #F8CAFF">
    <?php
      require_once("navbar.php");
    ?>
    <span>Sei qui: Gestione prodotti</span>
    <br/>
    <center><h1> Gestione prodotti </h1></center>
    <hr style = "color: #3199A0; height: 5px"/>
    <center><button class="btn btn-danger" role="button" data-bs-toggle="modal" data-bs-target="#inserisciProdotto" aria-expanded="false" style = "background-color: #CD17BE"> Inserisci un nuovo prodotto </button></center>
    <div class="modal fade" id="inserisciProdotto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Inserisci un nuovo prodotto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class = "container-fluid">
              <center style = "color: red"> <b> Campo obbligatorio * </b> </center>
              <div class = "mb-2"> Nome prodotto<span style = "color: red">*</span> <input type = "text" id = "nomeProdotto" class="form-control" required placeholder = "Inserisci il nome del nuovo prodotto"> </div>
              <div class = "mb-2" style = "text-align: left"> Descrizione prodotto<input type = "text" id = "descrizioneProdotto" class="form-control" placeholder = "Inserisci la descrizione del nuovo prodotto"> </div>
              <div class = "mb-2"> Tipo prodotto<span style = "color: red">*</span><br/>
                  <?php
                    $queryTipoProdotto2 = $connessione -> prepare("select * from TIPO");
                    $queryTipoProdotto2 -> execute();
                    $risultatoTipoProdotto2 = $queryTipoProdotto2 -> get_result();
                    while ($tipo2 = $risultatoTipoProdotto2 -> fetch_assoc()) {
                  ?>
                      <input type = "radio" name = "tipoP" id = "tipoProdotto" value = "<?php echo $tipo2["IdTipo"]; ?>"> <?php echo $tipo2["NomeTipo"]; ?><br/>
                  <?php
                    }
                  ?>
              </div>
              <center><button type="submit" class="btn btn-danger" name = "inserimentoEvento" style = "background-color: #CD17BE" onclick = "inserisciProdotto()">Inserisci prodotto</button></center>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br/>
    <center><div class="row justify-content-around">
      <div class = "container-fluid align-self-center">
        <table border = 1 class = "table" style = "border-color: #CD17BE">
          <?php
            $queryTipiCibo = $connessione -> prepare("select * from TIPO");
            $queryTipiCibo -> execute();
            $risultatoTipiCibo = $queryTipiCibo -> get_result();
            while ($tipoCibo = $risultatoTipiCibo -> fetch_assoc()) {
              $tipoC = $tipoCibo["IdTipo"];
              $queryTipoProdotto = $connessione -> prepare("select * from PIATTO where IdT = ?");
              $queryTipoProdotto -> bind_param("i", $tipoC);
          ?>
            <tr style = "background-color: #FC44FF"> <th colspan = 4 style = "text-align: center"> <?php echo $tipoCibo["NomeTipo"]; ?> </th> </tr>
          <?php
              $queryTipoProdotto -> execute();
              $risultatoTipoProdotto = $queryTipoProdotto -> get_result();
              while ($tipo = $risultatoTipoProdotto -> fetch_assoc()) {
                if (isset($_POST["cancella" . $tipo["IdPiatto"]])) {
                  $idProdotto = $tipo["IdPiatto"];
                  $queryCancellaProdotto = $connessione -> prepare("delete from PIATTO where IdPiatto = ?");
                  $queryCancellaProdotto -> bind_param("i", $idProdotto);
                  $queryCancellaProdotto -> execute();
                }
          ?>
              <tr>
                <td valign = "middle"> <?php echo $tipo["NomePiatto"]; ?> </td>
                <td valign = "middle"> <?php echo $tipo["Descrizione"]; ?> </td>
                <form method = "POST" action = "<?php echo $_SERVER["PHP_SELF"]; ?>">
                  <input type = "hidden" name = "cancella<?php echo $tipo["IdPiatto"]; ?>">
                  <td align = "middle">
                    <input type = "submit" class = "btn btn-danger" value = "X" title = "Cancella prodotto" onclick = "return confirm('Sei sicuro di voler cancellare questo prodotto?')">
                  </td>
                </form>
                <td align = "middle">
                  <a role = "button" data-bs-toggle="modal" data-bs-target="#modifica<?php echo $tipo["IdPiatto"]; ?>" aria-expanded="false"> <img src = "modifica.png" style = "width: 2rem" title = "Modifica prodotto"> </a>
                </td>
              </tr>
              <div class="modal fade" id="modifica<?php echo $tipo["IdPiatto"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Modifica prodotto</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class = "container-fluid">
                        <center style = "color: red"> <b> Campo obbligatorio * </b> </center>
                        <form method = "POST" action = "<?php echo $_SERVER["PHP_SELF"]; ?>">
                          <div class = "mb-2" style = "text-align: left"> Nome prodotto<span style = "color: red">*</span> <input type = "text" name = "nomeProdottoModifica<?php echo $tipo["IdPiatto"]; ?>" class="form-control" value = "<?php echo $tipo["NomePiatto"]; ?>" required placeholder = "Inserisci il nome del prodotto"> </div>
                          <div class = "mb-2" style = "text-align: left"> Descrizione prodotto<input type = "text" name = "descrizioneProdottoModifica<?php echo $tipo["IdPiatto"]; ?>" class="form-control" value = "<?php echo $tipo["Descrizione"]; ?>" placeholder = "Inserisci la descrizione del prodotto"> </div>
                          <div class = "mb-2" style = "text-align: left"> Tipo prodotto<span style = "color: red">*</span><br/>
                              <?php
                                $queryTipoProdotto3 = $connessione -> prepare("select * from TIPO");
                                $queryTipoProdotto3 -> execute();
                                $risultatoTipoProdotto3 = $queryTipoProdotto3 -> get_result();
                                while ($tipo3 = $risultatoTipoProdotto3 -> fetch_assoc()) {
                                  if ($tipo3["IdTipo"] == $tipo["IdT"]) {
                              ?>
                                    <input type = "radio" name = "tipoProdottoModifica<?php echo $tipo["IdPiatto"]; ?>" value = "<?php echo $tipo3["IdTipo"]; ?>" checked> <?php echo $tipo3["NomeTipo"]; ?><br/>
                              <?php
                                  }
                                  else {
                              ?>
                                    <input type = "radio" name = "tipoProdottoModifica<?php echo $tipo["IdPiatto"]; ?>" value = "<?php echo $tipo3["IdTipo"]; ?>"> <?php echo $tipo3["NomeTipo"]; ?><br/>
                              <?php
                                  }
                                }
                              ?>
                          </div>
                          <center><button type="submit" class="btn btn-danger" name = "modificaProdotto<?php echo $tipo["IdPiatto"]; ?>" style = "background-color: #CD17BE">Modifica prodotto</button></center>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          <?php
              }
            }
          ?>
        </table>
      </div>
    </div></center>
    <?php
      }
      else {
        header("location: index.php");
      }
    ?>
    <br/> <br/> <br/> <br/> <br/>
    <?php
      require_once("barraInfo.php");
    ?>
  </body>
</html>
