<?php
  require_once "../class/Sanpham.php";
  require_once "../class/Database.php";
  require_once "../class/Loaisanpham.php";

  $db = new Database();
  $pdo = $db->getConnect();
  $sanpham = Sanpham::getAll(Database::getConnect());
  $loaisanpham = Loaisanpham::getAllLoaiSP(Database::getConnect());

  // Items per page
  $items_per_page = 6;
  // Get current page number
  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  // Calculate offset
  $offset = ($page - 1) * $items_per_page;
  // Fetch products for the current page

  // Fetch total number of products
  $total_products = Sanpham::countAll($pdo);


  // Calculate total pages
  $total_pages = ceil($total_products / $items_per_page);

  $category_filter = isset($_GET['result']) ? $_GET['result'] : null;
  $product_search = isset($_GET['search']) ? $_GET['search'] : null;

  $where_clause = "";
  if ($category_filter) {
    $where_clause .= " WHERE idLSP = $category_filter";
  } 

  if ($product_search) {
    $where_clause .= ($where_clause ? "AND" : " WHERE") . " tensp LIKE '%$product_search%'";
}
  // $sanphamthuocloai = Sanpham::Sanphamloai($pdo,$where_clause);
  $sanphamthuocloai = Sanpham::getProductsPerPage($pdo, $where_clause, $offset, $items_per_page);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['remove_product'])) {
        $productId = intval($_POST['product_id']);
        $sanpham = Sanpham::deleteProduct($pdo,$productId);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>
<?php require_once "../admin/includesAdmin/headerAdmin.php" ?>
<div class="container-md mt-5">
    <h1 class="text-center font-weight-bold mb-5">Manage Products</h1>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5">
        <a href='addproduct.php' class='btn btn-primary mb-2 mb-md-0'>
            <i class="fas fa-plus-circle mr-2"></i> Add Product
        </a>
        <form method="GET" action="" class="form-inline mt-2 mt-md-0 " style="margin:0">
            <div class="md-6">
                <select name="result" id="result" class="form-select" aria-label="Default select example" onchange="this.form.submit();">
                    <option value="0">Menu</option>
                    <?php
                    foreach($loaisanpham as $lsp)
                    {
                      echo "<option value='".$lsp->idLoaiSP. "'>". $lsp->tenloaisanpham. "</option>";
                      // $result = $lsp->idLoaiSP;
                    }
                    ?>
                </select>
            </div>
            <input type="text" autocomplete="off" name="search" placeholder="Tìm kiếm sản phẩm" class="form-control mr-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search mr-2"></i> Search
            </button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th scope="col"><a href="?sort=idsp&order=<?php echo $sort_column === 'idsp' ? ($sort_order === 'ASC' ? 'desc' : 'asc') : 'asc'; ?>">Product ID</a></th>
                    <th scope="col"><a href="?sort=hinhanh&order=<?php echo $sort_column === 'hinhanh' ? ($sort_order === 'ASC' ? 'desc' : 'asc') : 'asc'; ?>">Product IMG</a></th>
                    <th scope="col"><a href="?sort=hinhanh&order=<?php echo $sort_column === 'hinhanh' ? ($sort_order === 'ASC' ? 'desc' : 'asc') : 'asc'; ?>">Product Name</a></th>
                    <th scope="col"><a href="?sort=hinhanh&order=<?php echo $sort_column === 'hinhanh' ? ($sort_order === 'ASC' ? 'desc' : 'asc') : 'asc'; ?>">Product Brand</a></th>
                    <th scope="col"><a href="?sort=motasp&order=<?php echo $sort_column === 'motasp' ? ($sort_order === 'ASC' ? 'desc' : 'asc') : 'asc'; ?>">Product Description</a></th>
                    <th scope="col"><a href="?sort=dongia1&order=<?php echo $sort_column === 'dongia1' ? ($sort_order === 'ASC' ? 'desc' : 'asc') : 'asc'; ?>">Product Price</a></th>
                   
                    <th scope="col"><a href="?sort=khuyenmai&order=<?php echo $sort_column === 'khuyenmai' ? ($sort_order === 'ASC' ? 'desc' : 'asc') : 'asc'; ?>">Product Sale</a></th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
            <form method="POST">
            <?php foreach($sanphamthuocloai as $product) :?>
                <input type="hidden" name="product_id" value="<?= $product['idsp'] ?>">
                    <tr>
                        <td><?= $product['idsp']; ?></td>
                        <td><img src='../assets/images/<?=$product['hinhanh']?>' class="img-fluid" alt="Product Image" style="width:50px; height:50px;"></td>
                        <td><?= $product['tensp']?></td>
                        <td><?= $product['tenthuonghieu']?></td>
                        <td><?=$product['motasp']?></td>
                        <!-- <td><?= $product['tenloaisanpham']; ?></td> -->
                        <td><?= number_format($product['dongia1'], 0, ",", ".") ?></td>
                        <td><?= $product['khuyenmai']; ?></td>
                        <td>
                            <a href='editProduct.php?idsp=<?=$product['idsp'] ?>' class='btn btn-outline-dark'>Edit</a>
                        </td>
                        <td>
                            <button type="submit" name="remove_product" class="btn btn-outline-dark">Remove</button>
                        </td>
                    </tr>
                <?php endforeach?>
            </form>
            </tbody>
        </table>
    </div>
</div>
<!-- Pagination Links -->
<div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo ($page <= 1) ? 1 : ($page - 1); ?>"
                                aria-label="Previous" style="color: white;border-color: #000000;background-color: black">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>"><a class="page-link"
                                href="?page=<?php echo $i; ?>" style="background-color: white;color: black; border-color: #000000;"><?php echo $i; ?></a></li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <a class="page-link"
                                href="?page=<?php echo ($page >= $total_pages) ? $total_pages : ($page + 1); ?>"
                                aria-label="Next" style="color: white;border-color: #000000;background-color: black">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
          </div>


<?php require_once "../admin/includesAdmin/footerAdmin.php" ?>