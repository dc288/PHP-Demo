<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php  include 'navbar.php';
include 'DBConn.php';
$id = isset($_GET['id']) ? $_GET['id'] : null;
if($id){
 $qu="SELECT * FROM info WHERE id='$id'";
 $re=mysqli_query($conn, $qu);
 if($re && mysqli_num_rows($re)>0){
  $rw=mysqli_fetch_assoc($re);
  $firstname=$rw['firstname'];
  $lastname=$rw['lastname'];
  $email=$rw['email'];
  $gender = $rw['Gender'];
  $phoneno = $rw['phoneno'];
  $address = $rw['address'];
  $age = $rw['age'];
  $pdf = $rw['pdf'];
 }
 else{
  Echo ('ERROR: no user found');
  exit();
 }

}

// define variables and set to empty values
$firstnamen =$lastnamen = $emailn = $gendern =$addressn = $phonenon  = $agen = "";
$firstnameErrn =$lastnameErrn= $emailErrn = $genderErrn = $addressErrn=$phonenoErrn = $ageErrn = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $isValid = true;
  if(empty($_POST['firstnamen']))
  {$firstnameErrn="Firstname is required.<br>";
    $isValid = false;}
  else{$firstnamen = test_input($_POST["firstnamen"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$firstnamen)) {
        $firstnameErrn = "Only letters and white space allowed";
        $isValid = false;
      }}
  if(empty($_POST['lastnamen']))
  {$lastnameErrn="Lastname is required.<br>";
    $isValid = false;}
  else{$lastnamen = test_input($_POST["lastnamen"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$lastnamen)) {
        $lastnameErrn = "Only letters and white space allowed";
        $isValid = false;
      }}
  if(empty($_POST['addressn']))
  {$addressErrn="Address is required.<br>";
    $isValid = false;}
  else{$addressn = test_input($_POST["addressn"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$addressn)) {
        $addressErrn = "Only letters and white space allowed";
        $isValid = false;
      }}

      if(empty($_POST['gendern']))
      {$genderErrn="Gender is required.<br>";
        $isValid = false;}
      else{$gendern = test_input($_POST["gendern"]);
      $gendern=$_POST['gendern'];}

  if(empty($_POST['phonenon']))
  {$phonenoErrn="Phone Number is required.<br>";
    $isValid = false;}
  else{$phonenon = test_input($_POST["phonenon"]);
    if (!preg_match("/^\d{10}$/",$phonenon)) {
        $phonenoErrn = "Phone Number isn't allowed";
        $isValid = false;
      }}
  if(empty($_POST['agen']))
  {$ageErrn="Age is required.<br>";
    $isValid = false;}
  else{$agen = test_input($_POST["agen"]);
    if (!preg_match("/^\d+$/",$agen)) {
        $ageErrn = "Age isn't allowed";
        $isValid = false;
      }}
  if(empty($_POST['emailn']))
  {$emailErrn="email is required.<br>";
    $isValid = false;}
  else{$emailn = test_input($_POST["emailn"]);
    if (!filter_var($emailn, FILTER_VALIDATE_EMAIL)) {
        $emailErrn = "Invalid email format";
        $isValid = false;
      }}
      $target_dir = "PDFs/";
      $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
      $uploadOk = 1;
      $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      // Check if form was submitted
      if (isset($_POST["submit"]) && $isValid && isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] != UPLOAD_ERR_NO_FILE) {
        // Check if file is a PDF
    $mimeType = mime_content_type($_FILES["fileToUpload"]["tmp_name"]);
    if ($mimeType == "application/pdf" && $fileType == "pdf") {
        echo "File is a PDF - " . $mimeType . ".";
        $uploadOk = 1;
      } else {
        echo "File is not a PDF.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Allow only PDF files
    if ($fileType != "pdf") {
        echo "Sorry, only PDF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        $isValid=false;
    } else {
        // Try to upload file
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            $pdf=htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));
        } else {
            echo "Sorry, there was an error uploading your file.";
            $isValid=false;
        }
    }
}
      if($isValid){
         // Include the database connection file
          include "DBConn.php";
          if ($id) {
          // Fetch PDF file name from the database based on ID
          $sql = "SELECT pdf FROM info WHERE id = '$id'";
          $result = mysqli_query($conn, $sql);
          if ($result && mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_assoc($result);
              $pdfn = $row['pdf']; // Assuming 'pdf' is the column name where PDF file name is stored
              $filePath = "c:/xampp/htdocs/Something/PDFs/" . $pdfn;

              // Delete the PDF file if it exists
              if (file_exists($filePath) && isset($_POST['fileToUpload'])) {
                  if (unlink($filePath)) {
                      echo "File $filePath has been deleted successfully.<br>";
                  } else {
                      echo "Error: Unable to delete the file $filePath.<br>";
                  }
              } else {
                  echo "Error: File $filePath does not exist.<br>";
              }}
        }
        $sn="UPDATE info SET firstname='$firstnamen', lastname='$lastnamen', email='$emailn', phoneno='$phonenon',address='$addressn',age='$agen' , Gender='$gendern',pdf='$pdf'  WHERE id='$id' " ;
          if (mysqli_query($conn,$sn)) {
             // Redirect to home page after successful insertion
              header("Location: Details.php");
              exit();
          } else {
              echo "Error: " . $stmt->error;
          }
          $stmt->close();
          $conn->close();
        }
}

function test_input($data) {
  $data = trim($data);             //extra space,tab,newline will be removed
  $data = stripslashes($data);      //backslash removed
  $data = htmlspecialchars($data);  //html form
  return $data;
}
?>
<br>
<h2 class="container ">Update Details</h2>
<form name="myForm" class="container " method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $id; ?>" enctype="multipart/form-data">  
<label for="firstnamen" class="col-sm-2 col-form-label text-end">First Name<span class="text-danger">*</span>:</label>
<input  type="text" name="firstnamen" value="<?php echo $firstname; ?>" required>
  <span class="error"> <?php echo $firstnameErrn;?></span>
  <br><br>
  <label for="lastnamen" class="col-sm-2 col-form-label text-end">Last Name<span class="text-danger">*</span>:</label><input  type="text" name="lastnamen" value="<?php echo $lastname; ?>" required>
  <span class="error"> <?php echo $lastnameErrn;?></span>
  <br><br>
  <label for="phonenon" class="col-sm-2 col-form-label text-end">Phone Number<span class="text-danger">*</span>:</label><input type="number" name="phonenon" value="<?php echo $phoneno; ?>"required>
  <span class="error"> <?php echo $phonenoErrn;?></span>
  <br><br>
  <label for="agen" class="col-sm-2 col-form-label text-end">Age<span class="text-danger">*</span>:</label><input type="number"  name="agen" value="<?php echo $age; ?>" required>
  <span class="error"> <?php echo $ageErrn;?></span>
  <br><br>
  <label for="addressn" class="col-sm-2 col-form-label text-end">Address<span class="text-danger">*</span>:</label><input type="text"  name="addressn" value="<?php echo $address; ?>" required>
  <span class="error"> <?php echo $addressErrn;?></span>
  <br><br>
  <label for="emailn" class="col-sm-2 col-form-label text-end">E-mail<span class="text-danger">*</span>:</label><input type="text"  name="emailn" value="<?php echo $email; ?>" required>
  <span class="error"> <?php echo $emailErrn;?></span>
  <br><br>

  <label for="gendern" class="col-sm-2 col-form-label text-end">Gender<span class="text-danger">*</span>:</label>
  <input  type="radio" name="gendern" value="female"<?php if(strcasecmp($gender,"female")==0) echo "checked";?>>Female
  <input  type="radio" name="gendern" value="male"<?php if(strcasecmp($gender,"male")==0) echo "checked";?>>Male
  <input  type="radio" name="gendern" value="other" <?php if(strcasecmp($gender,"other")==0) echo "checked";?>>Other
  <span class="error"> <?php echo $genderErrn;?></span>
  <br><br>
  <div class="mb-3 row">
    <label for="fileToUpload" class="col-sm-2 col-form-label text-end">Identity-card(PDF) <span class="text-danger">*</span>:</label>
    <div class="col-sm-10">
        <div class="input-group">
            <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
            <a class='btn btn-primary ms-auto' href='file.php?pdf=<?php echo $pdf;?>'><?php echo $pdf;?></a>
        </div>
    </div>
</div>
  <input class="btn btn-primary" type="submit"  name="submit" value="Submit">  <br><br>

</form>
</body>
</html>