<?php
  session_start();
  require_once("logout.php");
  require_once("connessione.php");
?>
<html>
  <head>
    <meta charset = "utf-8">
    <title> Gastronomia Gastaldi - La nostra storia </title>
    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel = "stylesheet" integrity = "sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin = "anonymous">
    <script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity = "sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin = "anonymous"></script>
    <script src = "https://code.jquery.com/jquery-latest.js"></script>
    <script src = "funzioni.js"> </script>
    <script src = "funzioni2.js"> </script>
    <script src = "funzioni3.js"> </script>
  </head>
  <body style = "background-color: #E6EDD7">
    <?php
      require_once("navbar.php");
    ?>
    <span>Sei qui: La nostra storia</span>
    <br/>
    <center><h1> La nostra storia </h1></center>
    <hr style = "color: #3199A0; height: 5px"/>
    <center> <img src = "storia1.jpg" class="card-img-top" style = "max-width: 1000px; max-height: 900px"> </center>
    <center> <div class="container">
      <div class="row justify-content-start">
        <div class = "col-24">
          La vendita al dettaglio e il commercio per la famiglia Gastaldi sono sempre stati una prerogativa. Già negli anni '50 papà Danilo aveva una sua attività di generi alimentari nel comune di Campolongo Maggiore, quando la somministrazione di generi quali l'olio, il caffè e lo zucchero, veniva venduta sfusa.
        </div>
      </div>
    </div> </center>
    <br/> <br/>
    <center> <img src = "esterno.jpg" class="card-img-top" style = "max-width: 1000px; max-height: 1200px"> </center>
    <center> <div class="container">
      <div class="row justify-content-start">
        <div class = "col-24">
          Nel 1961 Danilo sposa Eleonora ed insieme si trasferiscono a Camponogara dove aprono la loro attività, sempre di generi alimentari. Successivamente l'attività si trasforma in gastronomia grazie anche al supporto dei figli Marino e Simone, oggi titolari.
        </div>
      </div>
    </div> </center>
    <br/> <br/>
    <center> <img src = "fornelli.jpg" class="card-img-top" style = "max-width: 1000px; max-height: 1200px"> </center>
    <center> <div class="container">
      <div class="row justify-content-start">
        <div class = "col-24">
          La passione per l'arte culinaria e la lunga esperienza maturata negli anni ci rende orgogliosi di soddisfare ogni esigenza dei nostri clienti.
        </div>
      </div>
    </div> </center>
    <br/> <br/>
    <center> <img src = "scaffaliAlti1.jpg" class="card-img-top" style = "max-width: 1000px; max-height: 1200px"> <img src = "scaffaliAlti2.jpg" class="card-img-top" style = "max-width: 1000px; max-height: 1200px"> </center>
    <center> <div class="container">
      <div class="row justify-content-start">
        <div class = "col-24">
          Il nuovo posto accogliente dopo la ristrutturazione nel 2017 ha reso la nostra gastronomia più moderna, ma non ha cambiato la nostra missione, che è quella di offrire cibo e soddisfare le richieste dei nostri clienti, prima necessità per tutti noi.
        </div>
      </div>
    </div> </center>
    <br/> <br/> <br/> <br/> <br/>
    <?php
      require_once("barraInfo.php");
    ?>
  </body>
</html>
