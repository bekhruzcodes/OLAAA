<?php
    function getProductsForPage($offset, $limit) {
    global $db; // Assuming $db is your database connection object
    $stmt = $db->prepare("SELECT * FROM products LIMIT ?, ?");
    $stmt->bind_param("ii", $offset, $limit);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getAllProducts() {
    global $db; // Assuming $db is your database connection object
    $stmt = $db->query("SELECT * FROM products");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

?>