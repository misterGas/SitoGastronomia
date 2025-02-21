<?php
    session_start();
    if (isset($_SESSION["idUtente"]) && $_SESSION["tipoUtente"] == "U") {
      $idUtente = $_SESSION["idUtente"];
      require_once("logout.php");
      require_once("connessione.php");
      if (isset($_POST["invioLista"])) {
        $queryEliminaLista = $connessione -> prepare("delete from PREFERENZA where IdU = ?");
        $queryEliminaLista -> bind_param("i", $idUtente);
        $queryEliminaLista -> execute();
        if (isset($_POST["cibi"])) {
          foreach($_POST["cibi"] as $idCibo) {
            $queryLista = $connessione -> prepare("insert into PREFERENZA (IdU, IdP) values (?, ?)");
            $queryLista -> bind_param("ii", $idUtente, $idCibo);
            $queryLista -> execute();
          }
        }
      }
      if (isset($_POST["cancellaLista"])) {
        $queryEliminaLista = $connessione -> prepare("delete from PREFERENZA where IdU = ?");
        $queryEliminaLista -> bind_param("i", $idUtente);
        $queryEliminaLista -> execute();
      }
?>
<html>
  <head>
    <meta charset = "utf-8">
    <title> Gastronomia Gastaldi - Lista dei desideri </title>
    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel = "stylesheet" integrity = "sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin = "anonymous">
    <script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity = "sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin = "anonymous"></script>
    <script src = "https://code.jquery.com/jquery-latest.js"></script>
    <script src = "funzioni.js"> </script>
    <script src = "funzioni2.js"> </script>
    <script src = "funzioni3.js"> </script>
  </head>
  <body style = "background-color: #06C7FF">
    <?php
      require_once("navbar.php");
    ?>
    <span>Sei qui: Lista dei desideri</span>
    <br/>
    <center><h1> Lista dei desideri </h1></center>
    <hr style = "color: #3199A0; height: 5px"/>
    <center><h5> In questa pagina puoi stilare una tua lista dei desideri su cosa vorresti acquistare nella nostra gastronomia. Puoi modificarla ogni volta che vuoi in modo che tu scelga, ogni volta che verrai nella nostra gastronomia, il cibo che ti aggrada di più in quel momento. La lista dei desideri è un qualcosa di personale, come una sorta di "lista della spesa". </h5> </center> <br/>
    <center>
      <form class = "container-fluid" action = "<?php echo $_SERVER["PHP_SELF"]; ?>" method = "POST">
        <div class="accordion" id="accordionPanelsStayOpenExample">
          <?php
            $queryTipiCibo = $connessione -> prepare("select * from TIPO");
            $queryTipiCibo -> execute();
            $risultatoTipiCibo = $queryTipiCibo -> get_result();
            while ($tipoCibo = $risultatoTipiCibo -> fetch_assoc()) {
          ?>
              <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-heading<?php echo $tipoCibo["IdTipo"]; ?>">
                  <button class="accordion-button collapsed" style = "background-color: #3199A0; color: white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?php echo $tipoCibo["IdTipo"]; ?>" aria-expanded="false" aria-controls="panelsStayOpen-collapse<?php echo $tipoCibo["IdTipo"]; ?>">
                    <?php echo $tipoCibo["NomeTipo"]; ?>
                  </button>
                </h2>
                <div id="panelsStayOpen-collapse<?php echo $tipoCibo["IdTipo"]; ?>" style = "background-color: #5FEFDD" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading<?php echo $tipoCibo["IdTipo"]; ?>">
                  <div class="accordion-body">
                    <table>
                    <?php
                      $categoriaCibo = $tipoCibo["IdTipo"];
                      $queryCibi = $connessione -> prepare("select IdPiatto, NomePiatto, Descrizione from PIATTO where IdT = ?");
                      $queryCibi -> bind_param("i", $categoriaCibo);
                      $queryCibi -> execute();
                      $risultatoCibi = $queryCibi -> get_result();
                      while ($cibo = $risultatoCibi -> fetch_assoc()) {
                        $idCiboCercato = $cibo["IdPiatto"];
                        $queryControlloCibo = $connessione -> prepare("select * from PREFERENZA where IdU = ? and IdP = ?");
                        $queryControlloCibo -> bind_param("ii", $idUtente, $idCiboCercato);
                        $queryControlloCibo -> execute();
                        $risultatoControlloCibo = $queryControlloCibo -> get_result();
                        if ($risultatoControlloCibo -> num_rows == 1) {
                    ?>
                          <tr>
                            <td valign = "middle"> <div class="form-check form-switch"> <input style = "border-color: #385ADA" class="form-check-input" type = "checkbox" name = "cibi[]" value = "<?php echo $cibo["IdPiatto"]; ?>" checked> </div> </td>
                            <td valign = "middle"> <?php echo $cibo["NomePiatto"]; ?> </td>
                            <td valign = "middle"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </td>
                            <td valign = "middle"> <?php echo $cibo["Descrizione"]; ?> </td>
                          </tr>
                    <?php
                        }
                        else {
                    ?>
                          <tr>
                            <td valign = "middle"> <div class="form-check form-switch"> <input style = "border-color: #385ADA" class="form-check-input" type = "checkbox" name = "cibi[]" value = "<?php echo $cibo["IdPiatto"]; ?>"> </div> </td>
                            <td valign = "middle"> <?php echo $cibo["NomePiatto"]; ?> </td>
                            <td valign = "middle"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </td>
                            <td valign = "middle"> <?php echo $cibo["Descrizione"]; ?> </td>
                          </tr>
                    <?php
                        }
                      }
                    ?>
                    </table>
                  </div>
                </div>
              </div>
          <?php
            }
          ?>
        </div>
        <br/>
        <input type = "submit" class="btn" style = "background-color: #29AA2C" value = "Conferma modifiche" name = "invioLista">
      </form>
      <form class = "container-fluid" action = "<?php echo $_SERVER["PHP_SELF"]; ?>" method = "POST">
        <input type = "hidden" name = "cancellaLista">
        <input type = "submit" class="btn" style = "background-color: #D4503D" value = "Resetta lista" onclick = "return confirm('Sei sicuro di voler resettare tutta la tua lista dei desideri?')">
      </form>
    </center>
    <br/> <br/> <br/> <br/> <br/>
    <?php
      }
      else {
        header("location: index.php");
      }
      require_once("barraInfo.php");
    ?>
  </body>
</html>
