<?php 
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require 'connection.php';

$method = $_SERVER['REQUEST_METHOD'];

$response = [
    "success" => false,
    "message" => "",
    "data" => []
];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $result = $conn->query("SELECT * FROM services WHERE service_id = $id");
            if ($result->num_rows > 0) {
                $response["success"] = true;
                $response["message"] = "Service retrieved successfully";
                $response["data"] = $result->fetch_assoc();
            } else {
                $response["message"] = "Service not found";
            }
        } else {
            $result = $conn->query("SELECT * FROM services");
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row; // This will include availability, as it is part of the SELECT *
            }
            $response["success"] = true;
            $response["message"] = "Services retrieved successfully";
            $response["data"] = $data;
        }
        break;

    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);
        $name = $input['name'] ?? '';
        $price = $input['price'] ?? 0;
        $description = $input['description'] ?? '';
        $availability = $input['availability'] ?? 'available'; // New field for availability
        
        $query = $conn->prepare("INSERT INTO services (name, price, description, availability) VALUES (?, ?, ?, ?)");
        $query->bind_param("sdss", $name, $price, $description, $availability);
        
        if ($query->execute()) {
            $response["success"] = true;
            $response["message"] = "Service created successfully";
            $response["data"] = ["id" => $conn->insert_id, "name" => $name, "price" => $price, "description" => $description, "availability" => $availability];
        } else {
            $response["message"] = "Failed to create service";
        }
        break;

    case 'PUT':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $input = json_decode(file_get_contents("php://input"), true);
            $name = $input['name'] ?? '';
            $price = $input['price'] ?? 0;
            $description = $input['description'] ?? '';
            $availability = $input['availability'] ?? 'available'; // New field for availability

            $query = $conn->prepare("UPDATE services SET name = ?, price = ?, description = ?, availability = ? WHERE service_id = ?");
            $query->bind_param("sdssi", $name, $price, $description, $availability, $id);
            
            if ($query->execute()) {
                $response["success"] = true;
                $response["message"] = "Service updated successfully";
                $response["data"] = ["id" => $id, "name" => $name, "price" => $price, "description" => $description, "availability" => $availability];
            } else {
                $response["message"] = "Failed to update service";
            }
        } else {
            $response["message"] = "ID is required for updating";
        }
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            if ($conn->query("DELETE FROM services WHERE service_id = $id")) {
                $response["success"] = true;
                $response["message"] = "Service deleted successfully";
            } else {
                $response["message"] = "Failed to delete service";
            }
        } else {
            $response["message"] = "ID is required for deletion";
        }
        break;

    default:
        $response["message"] = "Invalid request method";
        break;
}

echo json_encode($response);

