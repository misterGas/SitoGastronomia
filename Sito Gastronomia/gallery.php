<?php
  session_start();
  require_once("logout.php");
  require_once("connessione.php");
?>
<html>
  <head>
    <meta charset = "utf-8">
    <title> Gastronomia Gastaldi - Gallery </title>
    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel = "stylesheet" integrity = "sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin = "anonymous">
    <script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity = "sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin = "anonymous"></script>
    <script src = "https://code.jquery.com/jquery-latest.js"></script>
    <script src = "funzioni.js"> </script>
    <script src = "funzioni2.js"> </script>
    <script src = "funzioni3.js"> </script>
  </head>
  <body style = "background-color: #FFBFCA">
    <?php
      require_once("navbar.php");
    ?>
    <span>Sei qui: Gallery</span>
    <br/>
    <center><h1> Gallery </h1></center>
    <hr style = "color: #3199A0; height: 5px"/>
    <center><h5> In questa pagina puoi visualizzare tutte le nostre foto della nostra gastronomia. Scopri molte pietanze che vendiamo, oppure gli arredamenti del negozio e della cucina! Buona esplorazione! </h5> </center>
    <div class="container-fluid">
      <div class="row align-items-start">
        <img src = "bancoGastronomia.jpg" class = "figure-img img-fluid rounded">
        <img src = "foto1.jpg" class = "figure-img img-fluid rounded">
        <img src = "foto2.jpg" class = "figure-img img-fluid rounded">
        <img src = "forni.jpg" class = "figure-img img-fluid rounded">
        <img src = "salami.jpg" class = "figure-img img-fluid rounded">
        <img src = "cibo1.jpg" class = "figure-img img-fluid rounded">
        <img src = "cibo2.jpg" class = "figure-img img-fluid rounded">
        <img src = "cibo3.jpg" class = "figure-img img-fluid rounded">
        <img src = "cibo4.jpg" class = "figure-img img-fluid rounded">
        <img src = "cibo5.jpeg" class = "figure-img img-fluid rounded">
        <img src = "cibo6.jpeg" class = "figure-img img-fluid rounded">
      </div>
    </div>
    <br/> <br/> <br/> <br/> <br/> <br/>
    <?php
      require_once("barraInfo.php");
    ?>
  </body>
</html>
