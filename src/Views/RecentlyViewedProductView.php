<?php

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>thrive</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
<?php
include_once('_headerSection.php');
?>
<section>
    <div class="container">
        <div class="row">
            <?php foreach ($products as $product) : ?>
                <div class="card col-md-4 mb-4 p-0">
                    <div class="card-header">
                        Product <?= $product->getId() ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $product->getName() ?></h5>
                        <p class="card-text"><?= $product->getDescription() ?></p>
                        <a href="../Controllers/ProductController.php?action=removeRecentlyViewedForUser&pid=<?= $product->getId() ?>" class="btn btn-primary">Remove from this list</a>
                    </div>
                    <div class="card-footer text-muted">
                        $<?= $product->getPrice() ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
</body>

</html>