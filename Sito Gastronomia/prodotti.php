<?php
  session_start();
  require_once("logout.php");
  require_once("connessione.php");
?>
<html>
  <head>
    <meta charset = "utf-8">
    <title> Gastronomia Gastaldi - I nostri prodotti </title>
    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel = "stylesheet" integrity = "sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin = "anonymous">
    <script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity = "sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin = "anonymous"></script>
    <script src = "https://code.jquery.com/jquery-latest.js"></script>
    <script src = "funzioni.js"> </script>
    <script src = "funzioni2.js"> </script>
    <script src = "funzioni3.js"> </script>
  </head>
  <body style = "background-color: #FCDCB4">
    <?php
      require_once("navbar.php");
    ?>
    <span>Sei qui: I nostri prodotti</span>
    <br/>
    <center><h1> I nostri prodotti </h1></center>
    <hr style = "color: #3199A0; height: 5px"/>
    <div class = "container-fluid align-self-center">
      <table border = 1 class = "table" style = "border-color: orange">
    <?php
      $queryTipiCibo = $connessione -> prepare("select * from TIPO");
      $queryTipiCibo -> execute();
      $risultatoTipiCibo = $queryTipiCibo -> get_result();
      while ($tipoCibo = $risultatoTipiCibo -> fetch_assoc()) {
    ?>
        <tr style = "background-color: #FFAA44"> <th colspan = 2 style = "text-align: center"> <?php echo $tipoCibo["NomeTipo"]; ?> </th> </tr>
    <?php
        $tipoC = $tipoCibo["IdTipo"];
        $queryTipoProdotto = $connessione -> prepare("select * from PIATTO where IdT = ?");
        $queryTipoProdotto -> bind_param("i", $tipoC);
        $queryTipoProdotto -> execute();
        $risultatoTipoProdotto = $queryTipoProdotto -> get_result();
        while ($cibo = $risultatoTipoProdotto -> fetch_assoc()) {
    ?>
          <tr> <td valign = "middle" style = "text-align: center"> <?php echo $cibo["NomePiatto"]; ?> </td> <td valign = "middle" style = "text-align: center"> <?php echo $cibo["Descrizione"]; ?> </td> </tr>
    <?php
        }
      }
    ?>
      </table>
    </div>
    <br/> <br/> <br/> <br/> <br/>
    <?php
      require_once("barraInfo.php");
    ?>
  </body>
</html>
