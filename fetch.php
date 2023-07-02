<?php

$email = $_POST['email']; 


$conn = new mysqli('localhost','root','','test');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT file_name, file_data FROM register WHERE email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);

$stmt->execute();

$stmt->bind_result($fileName, $fileData);

if ($stmt->fetch()) {
    header("Content-type: application/pdf");
    header("Content-Disposition: attachment; filename=" . $fileName);

    echo $fileData;

} else {
    echo "No file found for the given email.";
}

$stmt->close();
$conn->close();
?>
