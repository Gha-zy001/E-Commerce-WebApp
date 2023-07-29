<?php

class QueryBuilder{
    protected $pdo;
    


    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    //product_data_fetch_query_start
    public function getData($table)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$table}");
        $stmt->execute();
    
        $resultArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $resultArray;
    }
    
    public function getProduct($item_id, $table = 'product')
    {
        if (isset($item_id)) {
            $query = "SELECT * FROM {$table} WHERE item_id = :item_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
            $stmt->execute();
    
            $resultArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $resultArray;
        }
    
        return null;
    }
    
    //product_data_fetch_query_end
    
    //cart_data_fetch_query_start
    public function insertIntoCart($params = null, $table = "cart") {
        if ($this->pdo !== null && $params !== null) {
            $columns = implode(',', array_keys($params));
            $placeholders = ':' . implode(',:', array_keys($params));
    
            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    
            try {
                $statement = $this->pdo->prepare($sql);
                $statement->execute($params);
                return true;
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
    
        return false;
    }
    


    public function addToCart($userid, $itemid) {
        if (isset($userid) && isset($itemid)) {
            $params = array(
                "user_id" => $userid,
                "item_id" => $itemid
            );
            
            $this->insertIntoCart($params);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
    

    public function deleteCart($item_id, $table = 'cart'){
        if($item_id != null){
            $result = $this->pdo->prepare("DELETE FROM {$table} WHERE item_id={$item_id}");
            if($result){
                header("Location:" . $_SERVER['PHP_SELF']);
            }
            $result->execute();
        }
    }
    

    public function getCartId($cartArray, $key = "item_id"){
        if ($cartArray != null){
            $cart_id = array_map(function ($value) use($key){
                return $value[$key];
            }, $cartArray);
            return $cart_id;
        }
    }

    public function saveForLater($item_id = null, $saveTable = "wishlist", $fromTable = "cart"){
        if ($item_id != null){
            $query = "DELETE FROM {$fromTable} WHERE item_id={$item_id}; INSERT INTO {$saveTable} SELECT * FROM {$fromTable} WHERE item_id={$item_id};";

            // execute multiple query
            $result = $this->pdo->exec($query);

            if($result){
                header("Location :" . $_SERVER['PHP_SELF']);
            }
            return $result;
        }
    }

    public function getSum($arr){
        if(isset($arr)){
            $sum = 0;
            foreach ($arr as $item){
                $sum += floatval($item[0]);
            }
            return sprintf('%.2f' , $sum);
        }
    }
    //cart_data_fetch_query_end
}