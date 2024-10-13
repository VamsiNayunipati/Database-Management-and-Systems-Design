<?php
$host = 'localhost';
$dbname = 'library';
$username = 'root';
$password = 'Aviabi@#9499';

// Create a new PDO instance
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
   // echo "<p>Connection successful.</p>";  // Display a success message
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

function insertReader($readerData) {
    global $conn;  // Use the global database connection

    $sql = "INSERT INTO READER (RTYPE, RNAME, RADDRESS, PHONE_NO) VALUES (:rtype, :rname, :raddress, :phone_no)";
    try {
        $stmt = $conn->prepare($sql);
        // Bind parameters correctly
        $stmt->bindParam(':rtype', $readerData['rtype']);
        $stmt->bindParam(':rname', $readerData['rname']);
        $stmt->bindParam(':raddress', $readerData['raddress']);
        $stmt->bindParam(':phone_no', $readerData['phone_no']);

        // Execute the statement
        $stmt->execute();
        return true; // Successful insertion
    } catch (PDOException $e) {
        // It's good to log this error to a file or a logging system
        echo "Insertion failed: " . $e->getMessage();
        return false;
    }
}

?>
