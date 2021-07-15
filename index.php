<!DOCTYPE HTML>
<html>
<head>
    <title>thrive</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <section>
        <div class="container mt-4 mb-4">
            <!--hard codding user id to avoid develop a login system-->
            <h2>User id: 14</h2>
            <h3><a href="src/Controllers/ProductController.php?action=getRecentlyViewed&uid=14">Recently viewed Product</a></h3>
            <h3><a href="src/Controllers/ProductController.php?action=getProducts">All Products</a></h3>
            <h3><a href="src/Controllers/ProductController.php?action=save">New Rand Product</a></h3>
            <h3><a href="src/Controllers/ProductController.php?action=add100Products">Create 100 new Rand Products</a></h3>
            <h3><a href="src/Controllers/ProductController.php?action=add100RecentlyViewedProducts">Add 100 Rand Products and send them to Recently viewed List</a></h3>
        </div>
    </section>

</body>

</html>