<?php
    require_once("inc/config.php");
    require_once(ROOT_PATH . "inc/database.php");

    try {
        $results = $db->prepare("SELECT * FROM products WHERE sku = ?");
        $results->bindValue(1,108);
        $results->execute();
    } catch (Exception $e) {
        echo "Data could not be retrieved from the database.";
        exit;
    }
    
    $product = $results->fetch(PDO::FETCH_ASSOC);
    
    if ($product === false) return $product;
    
    $product["sizes"] = array();
    
    try {
        $results = $db->prepare("
            SELECT size 
            FROM products_sizes ps 
            INNER JOIN sizes s ON ps.size_id = s.id
            WHERE product_sku = ?
            order by `order`");
        $results->bindValue(1,108);
        $results->execute();
    } catch (Exception $e) {
        echo "Data could not be retrieved from the database.";
        exit;
    }
    
    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
        $product["sizes"][] = $row["size"];
    }
    
    var_dump($product);
?>