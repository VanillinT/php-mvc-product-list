<form method="POST" enctype="multipart/form-data">
    <div class="form-group mb-3">
        <label for="image" class="form-label"> Image </label>
        <input id="image" type="file" name="image" class="form-control">
    </div>
    <div class="form-group mb-3">
        <label class="form-text required" for="title">Title</label>
        <input id="title" type="text" name="title" class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>" value="<?= $product['title'] ?>">
        <?php if (isset($errors['title'])) : ?>
            <div class="invalid-feedback"><?= $errors['title'] ?></div>
        <?php endif; ?>
    </div>
    <div class="form-group mb-3">
        <label class="form-text" for="description">Description</label>
        <textarea id="description" name="description" class="form-control"><?= $product['description'] ?></textarea>
    </div>
    <div class="form-group mb-3">
        <label for="price" class="form-text  required">Price</label>
        <input id="price" type="number" step=".01" name="price" class="form-control <?= isset($errors['price']) ? 'is-invalid' : '' ?>" value="<?= $product['price'] ?>">
        <?php if (isset($errors['price'])) : ?>
            <div class="invalid-feedback"><?= $errors['price'] ?></div>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>