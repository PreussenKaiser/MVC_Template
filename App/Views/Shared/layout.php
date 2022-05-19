<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=TITLE?></title>
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.css">
    <!-- Custom CSS-->
    <link rel="stylesheet" href="Public/css/style.css">
</head>
<body class="bg-dark">
<nav>
    <?php require_once('navigation.php'); ?>
</nav>

<main>
    <?php require_once($view); ?>
</main>

<footer class="footer text-white text-center">
    <?php require_once('footer.php')?>
</footer>

<!-- Vendor JS -->
<script src="vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>
<script src="vendor/tinymce/tinymce/tinymce.min.js"></script>
<!-- Custom JS -->
<script type="module" src="Public/js/out/site.js"></script>
<!-- TinyMCE Initializer -->
<script>
    tinymce.init({
        selector: '.note-content',
        height: 256
    });
</script>
</body>
</html>