<!-- Template principal de la section backend -->

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
    <!-- Tiny MCE API CDN link -->
    <script src="https://cdn.tiny.cloud/1/ap3ws4up4zey4cecb360l3ctoj2w9z3wfuu6l251n0kkuybj/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({
      selector: '#articleContent',
      theme: 'silver',
      mode:"textareas",
      elements:"contenu",
    	entity_encoding : "raw",
    	encoding: "UTF-8",
      mobile: {
        theme: 'mobile',
        plugins: [ 'autosave', 'lists', 'autolink' ],
        toolbar: [ 'undo', 'bold', 'italic', 'styleselect', 'fontsizeselect' ]
      }
    });</script>

    <title><?php echo $title ?></title>
  </head>
  <body>

    <header>
      <?php echo $headerContent ?>
    </header>

      <?php echo $bodyContent ?>

  </body>
</html>
