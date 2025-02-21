<?php
  session_start();
  require_once("logout.php");
  require_once("connessione.php");
?>
<html>
  <head>
    <meta charset = "utf-8">
    <title> Gastronomia Gastaldi - Home </title>
    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel = "stylesheet" integrity = "sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin = "anonymous">
    <script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity = "sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin = "anonymous"></script>
    <script src = "https://code.jquery.com/jquery-latest.js"></script>
    <script src = "funzioni.js"> </script>
    <script src = "funzioni2.js"> </script>
    <script src = "funzioni3.js"> </script>
  </head>
  <body style = "background-color: #A0FAFF">
    <?php
      require_once("navbar.php");
    ?>
    <span>Sei qui: Home</span>
    <br/>
    <center><h1> Home </h1></center>
    <hr style = "color: #3199A0; height: 5px"/>
    <?php
      if (!isset($_SESSION["idUtente"])) {
    ?>
        <center><h5> Effettua il login oppure registrati se vuoi stilare una tua lista dei desideri su cosa vorresti acquistare nella nostra gastronomia ed eventualmente iniziare con noi una conversazione</h5> </center> <br/>
    <?php
      }
    ?>
    <div class="container" style="max-width: 95rem">
      <div class = "card-header" style = "background-color: #FFD698"> <center> <span data-bs-toggle="modal" data-bs-target="#infoGastronomia" role = "button"> LA NOSTRA GASTRONOMIA </span> </center> </div>
      <div class="modal fade" id="infoGastronomia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">La nostra gastronomia</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <center> Scopri i segreti della gastronomia dei fratelli Gastaldi a Camponogara e vieni ad acquistare e a degustare le prelibatezze che offriamo </center> <br/>
              <center>
                <a class = "btn" style = "background-color: #3199A0" role = "button" href = "storia.php"> La nostra storia </a>
                <a class = "btn" style = "background-color: #3199A0" role = "button" href = "contatti.php"> Contatti </a>
                <a class = "btn" style = "background-color: #3199A0" role = "button" href = "gallery.php"> Gallery </a>
              </center>
            </div>
          </div>
        </div>
      </div>
      <img src="bancoGastronomia.jpg" class="card-img-top">
    </div>
    <br/> <br/>
    <div class="container" style="max-width: 95rem">
      <div class = "card-header" style = "background-color: #FFD698"> <center> <span data-bs-toggle="modal" data-bs-target="#infoProdotti" role = "button"> I NOSTRI PRODOTTI </span> </center> </div>
      <div class="modal fade" id="infoProdotti" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">I nostri prodotti</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <center> Scopri cosa vendiamo, dai prodotti frechi alle grigliate, in modo da soddisfare un'ampia gamma di clienti </center> <br/>
              <center> <a class = "btn" style = "background-color: #3199A0" role = "button" href = "prodotti.php"> I nostri prodotti </a>
              <?php
                if (isset($_SESSION["idUtente"]) && $_SESSION["tipoUtente"] == "U") {
              ?>
                  <a class = "btn" style = "background-color: #3199A0" role = "button" href = "listaDesideri.php"> Lista dei desideri </a> </center>
              <?php
                }
              ?>
            </div>
          </div>
        </div>
      </div>
      <img src="camino.jpg" class="card-img-top" style = "max-height: 60rem">
    </div>
    <br/> <br/> <br/> <br/> <br/>
    <?php
      require_once("barraInfo.php");
    ?>
  </body>
</html>
