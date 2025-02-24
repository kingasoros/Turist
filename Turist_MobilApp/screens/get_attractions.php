<?php
require "db_conn.php";

header('Content-Type: application/json'); 

$search = isset($_GET['search']) ? $_GET['search'] : '';

try {
    $query = "SELECT * FROM attractions WHERE name LIKE :search";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $stmt->execute();

    $attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($attractions) {
        http_response_code(200); 
        echo json_encode($attractions);
    } else {
        http_response_code(404); 
        echo json_encode(['message' => 'Nincs találat az adatbázisban.']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Hiba történt az adatbázis lekérdezése során.', 'details' => $e->getMessage()]);
}
?>
