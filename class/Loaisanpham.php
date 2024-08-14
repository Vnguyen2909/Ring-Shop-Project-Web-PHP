<?php 
class Loaisanpham{
    public $idLSP;
    public $tenloaisanpham;
    public $idnsx;

    public static function getAllLoaiSP($pdo){
        $sql = "SELECT * FROM `loaisanpham`";
        $stmt = $pdo->prepare($sql);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS,"Loaisanpham");
            return $stmt->fetchAll();
        }
    }
}
?>