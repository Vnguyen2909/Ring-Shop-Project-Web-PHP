<?php 
class Orders {
    public static function insert($pdo, $id_giohang,$id_nguoidung, $id_sanpham, $size_sanpham, $dongiasanpham, $soluongsanpham, $tongtien, $trangthai ) {
        $sql = "INSERT INTO dathang (id_giohang, id_nguoidung, id_sanpham, size_sanpham, dongiasanpham, soluongsanpham, tongtien, trangthai, date) 
                VALUES (:id_giohang, :id_nguoidung, :id_sanpham,:size_sanpham, :dongiasanpham, :soluongsanpham, :tongtien, :trangthai, :date)";
        $stmt = $pdo->prepare($sql);
        $date = date("Y-m-d");
        $stmt->execute(array(':id_giohang' => $id_giohang, ':id_nguoidung' => $id_nguoidung, ':id_sanpham' => $id_sanpham, ':size_sanpham' => $size_sanpham, ':dongiasanpham' => $dongiasanpham,':soluongsanpham' => $soluongsanpham, ':tongtien' => $tongtien, ':trangthai' => $trangthai, ':date' => $date));
    }
    public static function getOrdersByUserId($pdo, $id_nguoidung) {
        try {
            $sql = "SELECT * FROM dathang WHERE id_nguoidung = :id_nguoidung";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':id_nguoidung' => $id_nguoidung));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public static function getOrderById($pdo, $id) {
        try {
            $sql = "SELECT * FROM dathang WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':id' => $id));
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public static function deleteById($pdo, $id) {
        $sql = "DELETE FROM dathang WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':id' => $id));
    }

    public static function countAllOders($pdo) {
        try {
            $sql = "SELECT COUNT(*) FROM dathang";
            $stmt = $pdo->query($sql);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }
    public static function getAllOrders($pdo) {
        try {
            $sql = "SELECT * FROM dathang";
            $stmt = $pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public static function approveById($pdo, $id) {
        $sql = "UPDATE dathang SET trangthai = 1 WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':id' => $id));
    }

    public static function getTotalRevenue($pdo) {
        $stmt = $pdo->prepare("SELECT SUM(tongtien) as totalRevenue FROM dathang");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['totalRevenue'];
    }
}

?>
