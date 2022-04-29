<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=TITLE?></title>
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="Public/css/style.css">
</head>
<body class="bg-dark">
<nav>
    <?php require_once('navigation.php'); ?>
</nav>

<!-- This is where the view will be rendered -->
<main class="mt-5">
    <?php require_once($view); ?>
</main>

<footer class="footer text-white text-center">
    <?php require_once('footer.php')?>
</footer>

<script src="vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>
<script type="module" src="Public/js/out/site.js"></script>
</body>
</html>