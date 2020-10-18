<!-- Template principal de la section frontend -->

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Encodage affichage mobiles -->
    <!-- Bootstrap link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Css link -->
    <link rel="stylesheet" href="public/css/style.css">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="public/fontawesome/css/all.css">
    <!-- Googlefonts -->
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script&display=swap" rel="stylesheet">
    <title><?php echo $title ?></title>
  </head>
  <body>

    <header>
      <?php echo $headerContent ?>
    </header>

      <?php echo $bodyContent ?>

  <!-- Insertion du footer de template -->
      <?php include("view/footer.php"); ?>

  </body>
</html>
