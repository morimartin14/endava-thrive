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
            <?php foreach ($pagination['products'] as $product) : ?>
                <div class="card col-md-4 mb-4 p-0">
                    <div class="card-header">
                        Product <?= $product->getId() ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $product->getName() ?></h5>
                        <p class="card-text"><?= $product->getDescription() ?></p>
                        <?php if (isset($_GET['action']) && $_GET['action'] != 'getRecentlyViewed'):?>
                        <a href="../Controllers/ProductController.php?action=viewMore&pid=<?= $product->getId() ?>" class="btn btn-primary">View More</a>
                        <?php endif ?>
                    </div>
                    <div class="card-footer text-muted">
                        $<?= $product->getPrice() ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="bd-example">
                <nav aria-label="Standard pagination example">
                    <ul class="pagination">
                        <?php if ($pagination['previousPage']): ?>
                            <li class="page-item">
                                <a class="page-link" href="../Controllers/ProductController.php?action=getProducts&currentPage=<?= $pagination['previousPage'] ?>">
                                    <?= $pagination['previousPage'] ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (isset($currentPage)): ?>
                            <li class="page-item active"><a class="page-link" href="#"><?= $currentPage ?></a></li>
                        <?php endif; ?>
                        <?php if ($pagination['nextPage']): ?>
                            <li class="page-item"><a class="page-link" href="../Controllers/ProductController.php?action=getProducts&currentPage=<?= $pagination['nextPage'] ?>">
                                    <?= $pagination['nextPage'] ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>
</body>

</html>