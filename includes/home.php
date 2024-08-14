<?php
  require "class/Product.php";
  // require "class/Database.php";

  $db = new Database();
  $pdo = $db->getConnect();
  $data = Sanpham::getAll($pdo);

  // var_dump($data)

  // $data = Article::getAll(Database::getConnect());
  // var_dump($data)

?>
<!-- ======= Hero Section ======= -->
<section id="hero" class="hero d-flex align-items-center section-bg">
    <div class="container">
    <div class="section-header">
          <h2>Giới thiệu</h2>
          <p>iVshop <span>Xin chào bạn!</span></p>
        </div>
      <div class="row justify-content-between gy-5">
        <div class="col-lg-5 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start">
          <h2>iV<span>SHOP</span></h2>
          <p>iV Shop không chỉ là nơi mua sắm, mà còn là điểm đến của những người đam mê nghệ thuật trang sức và phong cách độc đáo. Tại đây, chúng tôi không chỉ cung cấp những sản phẩm đẳng cấp về trang sức, mà còn là nguồn cảm hứng không ngừng cho sự sáng tạo và tự tin. Với sứ mệnh mang lại sự quyến rũ và tinh tế, iV Shop không ngừng khám phá, đổi mới để tạo ra những trải nghiệm mua sắm độc đáo và thú vị nhất cho khách hàng. Hãy đồng hành cùng chúng tôi, để mỗi bước đi của bạn là một tuyên ngôn về phong cách và cá nhân đầy tự tin</p>
          <div class="d-flex">
          </div>
        </div>
        <div class="col-lg-5 text-center text-lg-start">
          <img src="assets/images/chForeverRing_4.webp" class="img-fluid" alt="">
        </div>
      </div>
    </div>
  </section>
  <!-- End Hero Section -->

<!-- ======= Menu Section ======= -->
<section id="menu" class="menu">
      <div class="container">
        <div class="section-header">
          <h2>Nổi bật</h2>
          <p>Một số sản phẩm <span>Khuyến mãi</span></p>
        </div>
            <div class="row gy-5">
              <?php foreach ($data as $product) :?>
                <?php if($product['khuyenmai'] >= 40){?>
                <div class="col-lg-4 menu-item">
                  <div class="">
                    <a href="detail.php?id=<?=$product['idsp']?>" class="glightbox">
                      <img src="assets/images/<?=$product['hinhanh']?>" class="menu-img img-fluid" style="max-height: 90vh;">
                    </a>
                  </div>
                  <h7 style="text-align: center;height:40px"><?= $product['tensp']?></h7>
                  <h6 style="text-align: center;font-weight:600"><?= $product['tenthuonghieu']?></h6>  
               </div><!-- Menu Item -->
                <?php } ?>
            <?php endforeach?>
          </div>
          <div style="text-align:center; margin: 40px">
            <a class="btn-see-more" href="shop.php">Xem thêm</a>
          </div>
        </div>
      </div>
    </section>
    <!-- End Menu Section -->

  <!-- ======= Ship Section ======= -->
  <section id="about" class="about section-bg">
      <div class="container">

        <div class="section-header">
          <h2>Vận chuyển</h2>
          <p>Miễn phí<span> vận chuyển</span></p>
        </div>

        <div class="row gy-4">
          <!-- <div class="col-lg-7 position-relative about-img" style="background-image: url(assets/images/vanchuyen.jpg)">
          </div> -->
          <div class="col-lg-7 text-center text-lg-start">
            <img src="assets/images/vanchuyen.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-5 d-flex align-items-end">
            <div class="content ps-0 ps-lg-5">
              <p class="fst-italic" style="font-weight: 700">
                GIAO HÀNG TẬN NHÀ VÀ CHUYỂN PHÁT TOÀN QUỐC
              </p>
              <ul>
                <li><i class="bi bi-check2-all"></i> Đối với khách hàng ở khu vực TP Hồ Chí Minh:</li>
                  <p>
                    - Trường hợp giao hàng trực tiếp: Khách hàng vui lòng tham khảo kĩ sản phẩm trang sức mình định lấy. Tuỳ từng sản phẩm mà có được miễn phí vận chuyển hoặc không. Thời gian giao hàng có thể phụ thuộc vào trạng thái kho hàng gần quý khách nhất.<br>
                    - Trường hợp giao hàng qua chuyển phát nhanh: Đối với khách hàng ở Hà Nội nhưng không thuận tiện đi lại: Khách hàng chuyển khoản vào tài khoản ngân hàng của chúng tôi, sau đó chúng tôi sẽ gửi hàng qua chuyển phát nhanh đến tận nơi theo yêu cầu của khách hàng. Vui lòng liên hệ trực tiếp với chúng tôi để biết thêm thông tin.<br>
                    - Vui lòng liên hệ trực tiếp với chúng tôi để có thông tin tốt hơn. Hotline: 0706679158
                  </p>
                <li><i class="bi bi-check2-all"></i> Đối với khách hàng không ở khu vực TP Hồ Chí Minh:</li>
                <p>
                  - Khách hàng vui lòng tìm hiểu kỹ về sản phẩm trang sức mình định đặt hàng. 
                    Sau đó chuyển tiền trước cho chúng tôi qua tài khoản ngân hàng (cước phí chuyển phát nhanh chúng tôi áp dụng là 35k đối với toàn bộ đơn hàng dưới 2kg, một số trường hợp chúng tôi sẽ hỗ trợ vận chuyển miễn phí). 
                    Sau khi tiếp nhận đơn hàng, nhân viên giao hàng sẽ giao hàng đến địa chỉ do khách hàng cung cấp. Tại thời điểm giao hàng, khách hàng kiểm tra đơn hàng theo đơn đặt hàng (số lượng, số tiền). Khách hàng vui lòng thanh toán bằng tiền mặt hoặc chuyển khoản. 
                </p>
              </ul>
              
            </div>
          </div>
        </div>

      </div>
  </section>
  <!-- End Ship Section -->
