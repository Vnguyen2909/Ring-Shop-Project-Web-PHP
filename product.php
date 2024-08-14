<?php
  require "class/Product.php";
  require "class/Database.php";

  $data = Sanpham::getAll(Database::getConnect());
  $pdo = Database::getConnect();
  
?>
  <!-- ======= Menu Section ======= -->
  <section id="menu" class="menu">
  <div class="container">
            <div class="row gy-5">
            <?php foreach ($data as $product) :?>
                <div class="col-lg-4 menu-item">
                  <a href="">
                    <img src="assets/images/<?=$product['hinhanh']?>" class="menu-img img-fluid">
                  </a>
                  <h4><?= $product['tensp']?></h4>
                  <p class="ingredients">
                    <?= $product['motasp'] ?>
                  </p>
                  <p class="price">
                    <?= $product['dongia1'] ?>
                  </p>
               </div><!-- Menu Item -->
            <?php endforeach?>
          </div>
          <div style="text-align:center; margin: 40px">
            <a class="btn-see-more" href="#book-a-table">Xem thêm</a>
          </div>
  </div>
</section>
    <!-- End Menu Section -->
