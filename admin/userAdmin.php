<?php 
require_once "../class/Auth.php";
require_once "../class/Database.php";

$db = new Database();
$pdo = $db->getConnect();
$Allusers = Auth::AllUser($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];

    if (isset($_POST['remove_user'])) {
        if (Auth::removeUser($pdo, $userId)) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            echo "<script>alert('Xóa người dùng thành công!!!');</script>";
        } else {
            echo "<script>alert('Xóa người dùng thất bại!!!');</script>";
        }
    }
}

$total_products = Auth::countAllUser($pdo);

// Items per page
$items_per_page = 6;
// Get current page number
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// Calculate offset
$offset = ($page - 1) * $items_per_page;
  // Calculate total pages
$total_pages = ceil($total_products / $items_per_page);

?>
<?php require_once "../admin/includesAdmin/headerAdmin.php" ?>
<section class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center font-weight-bold mb-5">Manage Users</h1>
        <div class="row">
            <?php foreach($Allusers as $user) :?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 p-2">
                       <div style="text-align: center;">
                            <img src="../<?=$user['imageUser']; ?>" alt="User Image" style="border-radius: 50%; object-fit: cover; width: 200px; height: 200px;" class="lab">
                        </div>


                        <div class="card-body">
                            <p class="card-title h5">User ID: <?=$user['id'] ?></p>
                            <p class="card-text"><strong>Name:</strong> <?=$user['fullname'] ?></p>
                            <p class="card-text"><strong>Username:</strong> <?=$user['username']?></p>
                            <p class="card-text"><strong>Password:</strong> <?=$user['password'] ?></p>
                            <p class="card-text"><strong>Email:</strong> <?= $user['email'] ?></p>
                            <p class="card-text"><strong>Role:</strong> <?= $user['role']?></p>
                            <p class="card-text"><strong>Address:</strong> <?= $user['address'] ?></p>
                            <p class="card-text"><strong>Phone:</strong> <?= $user['phone'] ?></p>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <form method="post" class="mb-0">
                                <a href='editUser.php?user_id=<?=$user['id'] ?>' class='btn btn-warning me-2'>Edit</a>
                                <input type="hidden" name="user_id" value="<?= ($user['id']); ?>">
                                <button type="submit" name="remove_user" class='btn btn-danger'>Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>
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
