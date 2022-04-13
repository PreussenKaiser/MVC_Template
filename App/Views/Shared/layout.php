<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>(Project Name Here)</title>
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.css"
    <link rel="stylesheet" href="Public/css/style.css">
</head>
<body class="bg-dark">
<nav class="navbar navbar-expand-lg navbar-dark bg-black">
    <div class="container">
        <a class="navbar-brand" href=".">(Project Name Here)</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
            </ul>
        </div>
    </div>
</nav>
<main class="container">
	<?php require_once($view) ?>
</main>
<footer class="footer text-white text-center">
    <div class="container p-3">
        &copy; 2022 - (Project Name Here)
    </div>
</footer>
<script src="vendor/twbs/dist/js/bootstrap.js"></script>
<script type="module" src="Public/js/out/site.js"></script>
</body>
</html>