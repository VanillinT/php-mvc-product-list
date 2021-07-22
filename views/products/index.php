<h1>Product list</h1>
<div class="row align-items-start">
    <form class="input-group mb-3 col" action="index.php?search">
        <input type="text" class="form-control" placeholder="Search for products" name="search" value="<?= $query ?>">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
    </form>
    <nav class="col d-flex justify-content-end">
        <ul class="pagination mx-2">
            <?php
            $pageRange = 1;

            $minPageInRange = $page - $pageRange > 0 ? $page - $pageRange : 1;
            $displayFirst = $minPageInRange > 1;

            $maxPageInRange = $page + $pageRange < $total ? $page + $pageRange : $total;
            $displayLast =  $maxPageInRange < $total; ?>
            <?php if ($displayFirst) : ?>
                <li class="page-item<?= $n == 1 ? ' active' : '' ?>"><a class="page-link" href="/products?page=1">1</a></li>
                <li class="page-item disabled"><a class="page-link">...</a></li>
            <?php endif; ?>
            <?php foreach (range($minPageInRange, $maxPageInRange) as $n) : ?>
                <li class="page-item<?= $n == $page ? ' active' : '' ?>"><a class="page-link" href="/products?page=<?= $n ?>"><?= $n ?></a></li>
            <?php endforeach; ?>
            <?php if ($displayLast) : ?>
                <li class="page-item disabled"><a class="page-link">...</a></li>
                <li class="page-item<?= $n == $total ? ' active' : '' ?>"><a class="page-link" href="/products?page=<?= $total ?>"><?= $total ?></a></li>
            <?php endif; ?>
        </ul>
        <ul class="pagination">
            <li class="page-item<?= $page == 1 ? ' disabled' : '' ?>">
                <a class="page-link" href="/products?page=<?= $page - 1 ?>" tabindex="-1">
                    < </a>
            </li>
            <li class="page-item<?= $page == $total ? ' disabled' : '' ?>">
                <a class="page-link" href="/products?page=<?= $page + 1 ?>">></a>
            </li>
        </ul>
    </nav>

</div>
<table class="table">
    <thead>
        <th scope="col">#</th>
        <th scope="col">Image</th>
        <th scope="col">Title</th>
        <th scope="col">Price</th>
        <th scope="col">Description</th>
        <th scope="col">Created</th>
    </thead>
    <a class="btn btn-sm btn-primary" href="/products/create">+ New product</a>
    <tbody>
        <?php foreach ($products as $i => $product) : ?>
            <tr scope="row">
                <td><?= $offset + $i + 1 ?></td>
                <td>
                    <?php if ($product["image"]) : ?>
                        <figure class="figure">
                            <img src="/<?= $product['image'] ?>" class="figure-img rounded thumb-image" />
                        </figure>
                    <?php endif; ?>
                </td>
                <td><?= $product['title'] ?></td>
                <td><?= $product['price'] ?></td>
                <td><?= $product['description'] ?></td>
                <td><?= $product['create_date'] ?></td>
                <td>
                    <a href="/products/update?id=<?= $product["id"] ?>" class="btn btn-sm btn-outline-primary">
                        Edit
                    </a>
                </td>
                <td>
                    <form method="POST" action="/products/delete">
                        <input type="hidden" name="id" value="<?= $product["id"] ?>" />
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>