<?php
  require "class/Product.php";
  require "class/Database.php";
  require "class/Loaisanpham.php";

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
  var_dump($total_products);

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

?>
<?php 
  require_once "includes/header.php";
?>
<!-- ======= Menu Section ======= -->
<section id="menu" class="menu" style="margin-top: 1rem">
      <div class="container">
        <div class="section-header">
          <h2>SẢN PHẨM</h2>
          <p>Danh sách <span>sản phẩm</span></p>
        </div>
        <form action="shop.php" method="get">
          <div class="row justify-content g-2 g-lg-3 ">
            <div class="col-md-6">
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
            <div class="col-md-6">
              <div class="input-group">
                <input type="search"  autocomplete="off"  class="form-control" name="search" id="search" placeholder="Tìm kiếm sản phẩm..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                &nbsp;
                <div class="input-group-append">
                    <button type="submit" class="btn btn-outline-dark" style="padding: 10px"><i class="bi bi-search"></i></button>
                </div>
              </div>
              <div id="autocomplete-results"></div>
            </div>
          </div>
        </form>
        <div class="row gy-5">
            <?php foreach($sanphamthuocloai as $product) :?>
                <div class="col-lg-4 menu-item">
                  <div class="">
                    <a href="detail.php?id=<?=$product['idsp']?>" class="glightbox">
                      <img src="assets/images/<?=$product['hinhanh']?>" class="menu-img img-fluid" style="max-height: 90vh;">
                    </a>
                  </div>
                  <h7 style="text-align: center;height:40px"><?= $product['tensp']?></h7>
                  <h6 style="text-align: center;font-weight:600"><?= $product['tenthuonghieu']?></h6>
                  <p class="price" style="font-size: 20px">
                    <?php 
                        $product['dongia2'] = $product['dongia1'] - $product['dongia1'] * $product['khuyenmai']/100;
                      ?>
                      <?php echo number_format($product['dongia2'], 0 ).' '.' ₫' ; ?>
                  </p>
                  <!-- <a href="detail.php?id=<?=$product['idsp']?>" class="btn btn-primary">View</a> -->   
               </div><!-- Menu Item -->
            <?php endforeach?>
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
      </div>
</section>
<?php 
  require_once "includes/footer.php";
?>