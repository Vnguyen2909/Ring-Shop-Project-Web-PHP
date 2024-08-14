<?php 
class Sanpham{

    public static function getAll($pdo)
    {
      $sql = "SELECT * FROM sanpham";
      $stmt = $pdo->prepare($sql);

      if($stmt->execute()){
          $stmt->setFetchMode(PDO::FETCH_ASSOC);
          return $stmt->fetchAll();
      }
    }

    public static function getOneById($pdo, $id){
        $sql = "SELECT * FROM sanpham WHERE idsp=:id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetch();
        }
    }

    public static function getLastId($data) {
      foreach($data as $row) {
        return $row['id'] ;
      }
    }

    public static function Sanphamloai($pdo, $id){
        $sql = "SELECT * FROM sanpham $id";
          $stmt = $pdo->prepare($sql);
    
          $stmt->bindParam("$id",$id,PDO::PARAM_STR);
    
          if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
            // return $stmt->fetchAll($stmt->setFetchMode(PDO::FETCH_ASSOC, "Sanpham"));
          }
    }
    

    public static function countAll($pdo) {
      try {
          $sql = "SELECT COUNT(*) FROM sanpham";
          $stmt = $pdo->query($sql);
          return $stmt->fetchColumn();
      } catch (PDOException $e) {
          return 0;
      }
  }
 
  public static function getProductsPerPage($pdo, $where_clause, $offset, $items_per_page) {
    try {
        $query = "SELECT * FROM sanpham";
        // Nếu có điều kiện WHERE, thêm vào câu truy vấn
        if (!empty($where_clause)) {
            $query .= $where_clause;
        }
        // Thêm LIMIT và OFFSET cho phân trang
        $query .= " LIMIT :items_per_page OFFSET :offset";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':items_per_page', $items_per_page, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        // Trả về kết quả
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Xử lý lỗi nếu có
        echo "Error: " . $e->getMessage();
        return false;
    }
  }

  public static function addProduct($pdo, $tensp, $motasp, $dongia1, $hinhanh, $hinhanh1, $hinhanh2, $khuyenmai, $size, $idLSP, $tenthuonghieu, $soluongsp) {
    try {
        $sql ="INSERT INTO sanpham (tensp, motasp, dongia1, hinhanh, hinhanh1, hinhanh2, khuyenmai, size, idLSP, tenthuonghieu, soluongsp) 
               VALUES (:tensp, :motasp, :dongia1, :hinhanh, :hinhanh1, :hinhanh2, :khuyenmai, :size, :idLSP, :tenthuonghieu, :soluongsp)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':tensp', $tensp);
        $stmt->bindParam(':motasp', $motasp);
        $stmt->bindParam(':dongia1', $dongia1);
        $stmt->bindParam(':hinhanh', $hinhanh);
        $stmt->bindParam(':hinhanh1', $hinhanh1);
        $stmt->bindParam(':hinhanh2', $hinhanh2);
        $stmt->bindParam(':khuyenmai', $khuyenmai);
        $stmt->bindParam(':size', $size);
        $stmt->bindParam(':idLSP', $idLSP);
        $stmt->bindParam(':tenthuonghieu', $tenthuonghieu);
        $stmt->bindParam(':soluongsp', $soluongsp);
        $stmt->execute();
        return $stmt->rowCount() > 0; 
    } catch (PDOException $e) {
        return false;
    }
  }
  public static function deleteProduct($pdo, $id) {
    try {
        $sql = "DELETE FROM sanpham WHERE idsp = :id";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        return false;
    }
}
public static function updateProduct($pdo, $idsp, $tensp, $tenthuonghieu, $motasp, $dongia1,$soluongsp, $khuyenmai, $imageUser, $hinhanh1, $hinhanh2)
    {
        $sql = "UPDATE sanpham SET 
                tensp = :tensp, 
                tenthuonghieu = :tenthuonghieu, 
                motasp = :motasp, 
                dongia1 = :dongia1,
                soluongsp = :soluongsp,
                khuyenmai = :khuyenmai, 
                hinhanh = :imageUser,
                hinhanh1 = :hinhanh1,
                hinhanh2 = :hinhanh2 
                WHERE idsp = :idsp";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':idsp' => $idsp,
            ':tensp' => $tensp,
            ':tenthuonghieu' => $tenthuonghieu,
            ':motasp' => $motasp,
            ':dongia1' => $dongia1,
            ':soluongsp' => $soluongsp,
            ':khuyenmai' => $khuyenmai,
            ':imageUser' => $imageUser,
            ':hinhanh1' => $hinhanh1,
            ':hinhanh2' => $hinhanh2
        ]);
    }
    public static function decreaseQuantity($pdo, $idsp, $soluongsp) {
        $stmt = $pdo->prepare("UPDATE sanpham SET soluongsp = soluongsp - :soluongsp WHERE idsp = :idsp");
        $stmt->execute(array(':idsp' => $idsp, ':soluongsp' => $soluongsp));
    }

}
?>