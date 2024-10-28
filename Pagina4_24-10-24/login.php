<?php
$servername = "localhost";
$username = "root"; // Por defecto, el usuario es root
$password = ""; // La contraseña está vacía por defecto
$dbname = "usuarios_bd";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $bdname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

header('Content-Type: application/json');

$requestPayload = json_decode(file_get_contents("php://input"));

if (isset($requestPayload->username) && isset($requestPayload->password)) {
    $user = $requestPayload->username;
    $pass = $requestPayload->password;

    // Consulta para buscar el usuario
    $stmt = $conn->prepare("SELECT password FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($pass, $hashedPassword)) {
            echo json_encode(["success" => true]);
        } else {
            http_response_code(401);
            echo json_encode(["message" => "Credenciales incorrectas"]);
        }
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Credenciales incorrectas"]);
    }

    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode(["message" => "Solicitud no válida"]);
}

$conn->close();
?>
