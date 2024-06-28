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
// define variables and set to empty values
$firstname =$lastname = $email = $gender =$address = $phoneno  = $age = "";
$firstnameErr =$lastnameErr= $emailErr = $genderErr = $addressErr=$phonenoErr = $ageErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $isValid = true;
 

  if(empty($_POST['firstname']))
  {$firstnameErr="Firstname is required.<br>";
    $isValid = false;}
  else{$firstname = test_input($_POST["firstname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)) {
        $firstnameErr = "Only letters and white space allowed";
        $isValid = false;
      }}
  if(empty($_POST['lastname']))
  {$lastnameErr="Lastname is required.<br>";
    $isValid = false;}
  else{$lastname = test_input($_POST["lastname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$lastname)) {
        $lastnameErr = "Only letters and white space allowed";
        $isValid = false;
      }}
  if(empty($_POST['address']))
  {$addressErr="Address is required.<br>";
    $isValid = false;}
  else{$address = test_input($_POST["address"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$address)) {
        $addressErr = "Only letters and white space allowed";
        $isValid = false;
      }}
  
      if(empty($_POST['gender']))
      {$genderErr="Gender is required.<br>";
        $isValid = false;}
      else{$gender = test_input($_POST["gender"]);
      $gender=$_POST['gender'];}
       

  if(empty($_POST['phoneno']))
  {$phonenoErr="Phone Number is required.<br>";
    $isValid = false;}
  else{$phoneno = test_input($_POST["phoneno"]);
    if (!preg_match("/^\d{10}$/",$phoneno)) {
        $phonenoErr = "Phone Number isn't allowed";
        $isValid = false;
      }}
  if(empty($_POST['age']))
  {$ageErr="Age is required.<br>";
    $isValid = false;}
  else{$age = test_input($_POST["age"]);
    if (!preg_match("/^\d+$/",$age)) {
        $ageErr = "Age isn't allowed";
        $isValid = false;
      }}
  if(empty($_POST['email']))
  {$emailErr="email is required.<br>";
    $isValid = false;}
  else{$email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $isValid = false;
      }}
      
      $target_dir = "PDFs/";
      $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
      $uploadOk = 1;
      $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      // Check if form was submitted
      if (isset($_POST["submit"]) && $isValid) {
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
         $isValid=false;
        echo "Sorry, your file was not uploaded.";
    } else {
        // Try to upload file
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            $pdf=htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
if($isValid){
   // Include the database connection file
   include "DBConn.php";
   $stmt = $conn->prepare("INSERT INTO info (firstname, lastname, email, phoneno, address, age, gender,pdf) VALUES (?, ?, ?, ?, ?, ?, ?,?)");
   $stmt->bind_param("sssssiss", $firstname, $lastname, $email, $phoneno, $address, $age, $gender,$pdf);
   if ($stmt->execute()) {
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
<h2 class="container ">Add User Details</h2>
<form name="myForm" class="container " method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">  
<label for="firstname" class="col-sm-2 col-form-label text-end">First Name <span class="text-danger">*</span>:</label>
<input  type="text" name="firstname" required>
  <span class="error"><?php echo $firstnameErr;?></span>
  <br><br>
  <label for="lastname" class="col-sm-2 col-form-label text-end">Last Name<span class="text-danger">*</span>:</label><input  type="text" name="lastname" required>
  <span class="error"><?php echo $lastnameErr;?></span>
  <br><br>
  <label for="phoneno" class="col-sm-2 col-form-label text-end">Phone Number<span class="text-danger">*</span>:</label><input type="number" name="phoneno" required>
  <span class="error"><?php echo $phonenoErr;?></span>
  <br><br>
  <label for="age" class="col-sm-2 col-form-label text-end">Age<span class="text-danger">*</span>:</label><input type="number"  name="age" required>
  <span class="error"> <?php echo $ageErr;?></span>
  <br><br>
  <label for="address" class="col-sm-2 col-form-label text-end">Address<span class="text-danger">*</span>:</label><input type="text"  name="address" required>
  <span class="error"><?php echo $addressErr;?></span>
  <br><br>
  <label for="email" class="col-sm-2 col-form-label text-end">E-mail<span class="text-danger">*</span>:</label><input type="text"  name="email" required>
  <span class="error"> <?php echo $emailErr;?></span>
  <br><br>
  
  <label for="gender" class="col-sm-2 col-form-label text-end">Gender<span class="text-danger">*</span>:</label>
  <input  type="radio" name="gender" value="female">Female
  <input  type="radio" name="gender" value="male">Male
  <input  type="radio" name="gender" value="other" >Other
  <span class="error"><?php echo $genderErr;?></span>
  <br><br>
  
  <div class="mb-3 row">
    <label for="fileToUpload" class="col-sm-2 col-form-label text-end">Identity-card(PDF) <span class="text-danger">*</span>:</label>
    <div class="col-sm-10">
        <div class="input-group">
            <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" accept="application/pdf" required>
        </div>
    </div>
</div>
 

  <input class="btn btn-primary" type="submit"  name="submit" value="Submit">  
 <br><br>
  
</form>


</body>
</html>