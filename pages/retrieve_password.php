<?php
include('../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    if (empty($email)) {
        echo json_encode(['success' => false, 'message' => 'Please enter your email.']);
        exit();
    }

    $con = connection();
    $sql = "SELECT `OriginalPassword` FROM `patient` WHERE `Email` = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode(['success' => true, 'password' => $user['OriginalPassword']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Email not found.']);
    }

    $stmt->close();
    $con->close();
}
?>
