<?php
$pdf = isset($_GET['pdf']) ? $_GET['pdf'] : null;

$filename = "c:/xampp/htdocs/Something/PDFs/". $pdf;

if (file_exists($filename)) {
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="' . basename($filename) . '"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    @readfile($filename);
} else {
    echo "Error: File '$filename' does not exist.";
}
?>
