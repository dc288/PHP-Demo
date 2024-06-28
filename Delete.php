<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php
include 'navbar.php';
include "DBConn.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    // Fetch PDF file name from the database based on ID
    $sql = "SELECT pdf FROM info WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $pdf = $row['pdf']; // Assuming 'pdf' is the column name where PDF file name is stored
        $filePath = "c:/xampp/htdocs/Something/PDFs/" . $pdf;

        // Delete the PDF file if it exists
        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                echo "File $filePath has been deleted successfully.<br>";
            } else {
                echo "Error: Unable to delete the file $filePath.<br>";
            }
        } else {
            echo "Error: File $filePath does not exist.<br>";
        }

        // Delete record from the database
        $sqlDelete = "DELETE FROM info WHERE id='$id'";
        if (mysqli_query($conn, $sqlDelete)) {
            echo "Record with ID $id has been deleted from the database.";
            header("Location: Details.php");
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } else {
        echo "Error: Record with ID $id not found.";
    }
}
?>
</body>
</html>
