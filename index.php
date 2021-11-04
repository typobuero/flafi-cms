<!doctype html>

<html lang="en">
     
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=0.86, initial-scale=1, maximum-scale=10">
    <meta name="description" content="flafi CMS – Flat File Content Management System">
    <title>flafi CMS</title>
    
    <base href="/flafi-cms/">

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" sizes="16x16 24x24 32x32 64x64">
    <link rel="stylesheet" href="normalize.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

  <div id="page-wrapper">
    <header>
      <a target="_self" href="" title="Take me home!">
        flafi <span>CMS</span>
      </a>
    </header>

    <!-- generating <nav> and <main> by flafi CMS -->
    <?php include 'flafi.php' ?>

    
  </div>

  <footer>
    <span>The site-wide flafi sticky footer.</span>
  </footer>

</body>
</html>