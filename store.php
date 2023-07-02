<?php
	$conn = new mysqli('localhost','root','','test');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} 
if (isset($_POST['submit']) && isset($_POST['Name']) && isset($_POST['email']) && isset($_FILES['report']) && isset($_POST['Age']) && isset($_POST['Weight'])) {
	$Name = $_POST['Name'];
	$Age = $_POST['Age'];
	$Weight = $_POST['Weight'];
	$email = $_POST['email'];
	$file = $_FILES['report'];

	$fileName = $file['name'];
    $fileSize = $file['size'];
    $fileType = $file['type'];
    $fileTmpPath = $file['tmp_name'];

 if ($fileType == 'application/pdf') {
        $fileData = file_get_contents($fileTmpPath);
        $sql = "INSERT INTO register (Name, Age, Weight, email, file_name, file_data) VALUES (?, ?, ?, ?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siissb", $Name, $Age, $Weight, $email,$fileName,$fileData);
        if ($stmt->execute()) {
            echo "File uploaded and data stored in the database.";
            header("Location:report_by_email.html");
        } else {
            echo "Error storing file and data in the database.";
        }
                $stmt->close();
    } else {
        echo "Only PDF files are allowed.";
    }
}

    $conn->close();
?>