<?php
include '../connection/connection.php';

$conn = connection();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['dentist'])) {
    $dentist = $_POST['dentist'];
    
    $stmt = $conn->prepare("SELECT serviceoffered FROM dentist WHERE fullname = ?");
    $stmt->bind_param('s', $dentist);
    $stmt->execute();
    $result = $stmt->get_result();

    $services = [];
    while ($row = $result->fetch_assoc()) {
        $services[] = $row['serviceoffered'];
    }

    echo json_encode($services);

    $stmt->close();
}

$conn->close();
?>
