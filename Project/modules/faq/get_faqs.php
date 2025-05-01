<?php
include '../../config/config.php';

$sql = "SELECT * FROM polumpong.faq";
$result = $conn->query($sql);

$faq = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $faqs[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($faqs);

$conn->close();
?>
