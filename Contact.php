<?php 
require_once "includes/header.php";
?>
<section class="about">
  <div class="container mt-5">
    <h2 class="text-center font-weight-bold mb-5">Contact Us</h2>
    <form method="POST" action="ContactSuccess.php">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Tên</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="subject" class="form-label">Chủ đề</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Tin nhắn</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-outline-dark">Gửi Tin Nhắn</button>
    </form>
  </div>
</section>
<?php 
require_once "includes/footer.php";
?>
