<?php
$page = 'all_products';
require_once '../path.php';
include_once 'header.php';
$products = get_all_products('RAND()',50);

$num_columns = 9;

$column_indexes = range(0, $num_columns - 1);

// Create an array of column definition objects
$column_defs = array();
for ($i = 0; $i < $num_columns; $i++) {
    $column_defs = array(
        array('data' => '', 'title' => 'id'),
        array('data' => 'col_' . $i, 'title' => 'id'),
        array('data' => 'product_image', 'title' => 'Image'),
        array('data' => 'product_name', 'title' => 'Name'),
        array('data' => 'product_email', 'title' => 'Email'),
        array('data' => 'product_phone', 'title' => 'Phone'),
        array('data' => 'product_address', 'title' => 'Address'),
        array('data' => 'product_gender', 'title' => 'Gender'),
        array('data' => '', 'title' => 'Action')
    );
}
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">View</span> products</h4>

    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="datatables-basic table border-top">
                <thead>
                    <tr>
                        <th></th>

                        <th>id</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cnt = 1;
                    foreach ($products as $product) {
                        $product_id = encrypt($product['product_id']);
                    ?>
                        <tr>
                            <td></td>
                            <td><?= $cnt ?></td>
                            <td>
                                <img alt="product image" src="<?= file_url . $product['product_image'] ?>" style="width:100px; height:auto; border-radius:5px;" title="<?= $product['product_name'] ?>">
                            </td>
                            <td> <?= $product['product_name'] ?> </td>
                            <td> <?= $product['product_email'] ?> </td>
                            <td> <?= $product['product_phone'] ?> </td>
                            <td> <?= $product['product_address'] ?> </td>
                            <td> <?= $product['product_gender'] ?> </td>
                            <td>
                                <a href="<?= admin_url ?>product?id=<?= $product_id ?>" class="btn btn-success">
                                    <i class='bx bx-edit'></i>
                                </a>
                                <a href="<?= delete_url ?>id=<?= $product_id ?>&table=<?= encrypt('product') ?>&page=<?= encrypt('view_products') ?>&method=product" class="btn btn-danger">
                                    <i class='bx bx-trash'></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                        $cnt++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>



</div>
<!-- / Content -->


<?php
include_once 'footer.php';
?>