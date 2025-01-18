<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$userId = $_SESSION['id'];

include('db_conn.php');

$tourQuery = "
    SELECT t.*, tf.id as favorite_id
    FROM tours t
    JOIN turist_favorites tf ON tf.tour_id = t.tour_id
    WHERE tf.id = :userId
    ORDER BY t.tour_id";

try {
    $tourStmt = $conn->prepare($tourQuery);
    $tourStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $tourStmt->execute();
    $tours = $tourStmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($tours) > 0) {
        $tourIds = implode(",", array_column($tours, 'tour_id'));
        $attractionsQuery = "
            SELECT 
                ta.tour_id, 
                a.name AS name,
                a.description AS description,
                a.address AS address,
                a.city_name AS city_name,
                a.created_by AS created_by,
                a.created_at AS created_at,
                a.type AS type,
                a.interest AS interest,
                a.image AS image
            FROM tour_attractions ta
            JOIN attractions a ON ta.attractions_id = a.attractions_id
            WHERE ta.tour_id IN ($tourIds)
            ORDER BY ta.tour_id, ta.attraction_order";

        $attractionsStmt = $conn->query($attractionsQuery);
        $attractions = $attractionsStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tours as &$tour) {
            $tour['attractions'] = [];
            foreach ($attractions as $attraction) {
                if ($attraction['tour_id'] == $tour['tour_id']) {
                    $attraction['image'] = !empty($attraction['image']) 
                        ? "http://192.168.1.6/Turist/Turist_MobilApp/img/" . $attraction['image'] 
                        : "http://192.168.1.6/Turist/Turist_MobilApp/img/default.jpg";
                    $tour['attractions'][] = $attraction;
                }
            }
        }

        echo json_encode(['success' => true, 'tours' => $tours]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No favorite tours found']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database query failed: ' . $e->getMessage()]);
}
?>
