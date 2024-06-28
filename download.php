<?php
include("DBConn.php");

$firstname=urldecode($_GET['firstname']);

$filename = "data_export.csv";

// Set the headers to trigger download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

$output = fopen('php://output', 'w');


if($firstname==="") {
// You need to define your SQL query based on $result_param and $r_param
$sql = "SELECT * FROM info";  // Adjust your SQL query based on the parameters

} else {

    $sql = "SELECT * FROM info WHERE firstname='$firstname'";

}

// Perform the query
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    // Fetch the field names
    $fields = mysqli_fetch_fields($result);
    $fieldNames = array();
    foreach ($fields as $field) {
        $fieldNames[] = $field->name;
    }

    // Write the field names to the CSV file
    fputcsv($output, $fieldNames);

    // Write the table rows to the CSV file
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
}

fclose($output);
mysqli_close($conn);
exit();
?>