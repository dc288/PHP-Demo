<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: home.php');
    exit();
}
?>

<?php
include 'navbar.php';
include "DBConn.php";
$firstname=$firstnameErr="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;
    if(empty($_POST['firstname']))
    {$firstnameErr="Firstname is required.<br>";
        $isValid = false;}
    else{$firstname = test_input($_POST["firstname"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)) {
            $firstnameErr = "Only letters and white space allowed";
            $isValid = false;
            }}}
        function test_input($data) {
            $data = trim($data);             //extra space,tab,newline will be removed
            $data = stripslashes($data);      //backslash removed
            $data = htmlspecialchars($data);  //html form
            return $data;
        }?>
<br>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>
<body>
<form name="myForm" class="container " method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<label for="firstname" class="col-sm-2 col-form-label text-end">First Name:</label>
<input  type="text" name="firstname" required>
  <span class="error"> <?php echo $firstnameErr;?></span>
  <input class="btn btn-primary" type="submit" name="submit" value="Search">
<?php
$s = "SELECT * FROM info";  //where clause + SELECT are used
$result = $conn->query($s);
$r="";

$ss="SELECT * FROM info WHERE firstname='$firstname'";      //where clause + SELECT are used
if(isset($_POST['firstname']) && $isValid){$r = $conn->query($ss);

}
?>

</form>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
        <a class="btn btn-primary ms-auto" href="Form.php">+ New User</a>
    </div>
    
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Id</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Phone Number</th>
                <th>Age</th>
            </tr>
        </thead>
        <tbody>
            <?php
                    if(isset($_POST['firstname']) ){
                if ($r && $r->num_rows > 0) {
                while ($row = $r->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["firstname"] . "</td>";
                    echo "<td>" . $row["lastname"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["Gender"] . "</td>";
                    echo "<td>" . $row["address"] . "</td>";
                    echo "<td>" . $row["phoneno"] . "</td>";
                    echo "<td>". $row["age"] . "</td>";
                    echo "<td>  <a class='btn btn-dark ms-auto' href='file.php?pdf=" . $row["pdf"] . "' target='_blank'>File</a>" . "</td>";
                    echo "<td>  <a class='btn btn-success ms-auto' href='Update.php?id=" . $row["id"] . "'>Update</a>" . "</td>";
                    echo "<td>  <a class='btn btn-danger ms-auto' href='Delete.php?id=" . $row["id"] . "'>Delete</a>" . "</td>";
                    echo "</tr>";
                }
                echo"<a class='btn btn-primary ms-auto' href='download.php?firstname=".urlencode($firstname). "'>Download</a>";}
                else{
                    echo "<tr><td colspan='8'>No results found</td></tr>";
                }
            }
                else if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["firstname"] . "</td>";
                    echo "<td>" . $row["lastname"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["Gender"] . "</td>";
                    echo "<td>" . $row["address"] . "</td>";
                    echo "<td>" . $row["phoneno"] . "</td>";
                    echo "<td>" . $row["age"] . "</td>";
                    echo "<td>  <a class='btn btn-dark ms-auto' href='file.php?pdf=" . $row["pdf"] . " ' target='_blank' >File</a>" . "</td>";
                    echo "<td>  <a class='btn btn-success ms-auto' href='Update.php?id=" . $row["id"] . "'>Update</a>" . "</td>";
                    echo "<td>  <a class='btn btn-danger ms-auto' href='Delete.php?id=" . $row["id"] . "'>Delete</a>" . "</td>";
                    echo "</tr>";
                }
                echo"<a class='btn btn-primary ms-auto' href='download.php?firstname=".urlencode($firstname)."'>Download</a>";
            } else {
                echo "<tr><td colspan='8'>No results found</td></tr>";
            }

            ?>
        </tbody>
    </table>
</div>
</body>
</html>