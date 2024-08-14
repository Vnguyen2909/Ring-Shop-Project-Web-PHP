<?php 
 class Cart{
    public static function insert($pdo, $idUser, $idSPcart, $ring_size, $quantity) {
        $sql = "INSERT INTO cart (idUser, idSPcart, ring_size, quantity) 
                VALUES (:idUser, :idSPcart, :ring_size, :quantity)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':idUser' => $idUser,
            ':idSPcart' => $idSPcart,
            ':ring_size' => $ring_size,
            ':quantity' => $quantity
        ));
        return $pdo->lastInsertId();
    }

    public static function findByidUserandidSP($pdo,$idUser,$idSPcart){
        global $countCart;
        $sql = "SELECT * from cart where idUser=$idUser and idSPcart=$idSPcart"; 
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $countCart = $stmt->rowCount();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public static function findByidUser($pdo,$idUser){
        global $countCart;
        $sql = "SELECT * FROM cart WHERE idUser=$idUser"; 
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $countCart = $stmt->rowCount();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function updateQuantity($pdo, $userId, $idSPcart, $quantity) {
        $stmt = $pdo->prepare("UPDATE cart SET quantity = :quantity WHERE idUser = :userId AND idSPcart = :idSPcart");
        $stmt->execute(array(':quantity' => $quantity, ':userId' => $userId, ':idSPcart' => $idSPcart));
    }

    public static function deleteByidUserandidSP($pdo, $idUser, $idSPcart) {
        $sql = "DELETE FROM cart WHERE idUser = :idUser AND idSPcart = :idSPcart";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':idUser' => $idUser, ':idSPcart' => $idSPcart));
    }

    public static function deleteByidUser($pdo, $idUser) {
        $sql = "DELETE FROM cart WHERE idUser = :idUser";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':idUser' => $idUser));
    }
}
?>