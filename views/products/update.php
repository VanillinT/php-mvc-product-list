<a href="/products" class="btn btn-secondary">Back to list</a>
<h1>Edit <?= $product['title'] ?> </h1>

<?php if ($product["imagePath"]) : ?>
    <img src='/<?= $product["imagePath"] ?>' class="full-size-image" />
<?php endif; ?>
<?php include_once("_form.php") ?>