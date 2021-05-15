<?php 
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: host_login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('location: index.php');
}

// Include config file
require_once "server.php";
 
// Define variables and initialize with empty values
$username = $email = $name = $address = $phone = "";
$username_err = $email_err = $name_err = $address_err = $phone_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate username
    $input_username = trim($_POST["username"]);
    if(empty($input_username)){
        $username_err = "Please enter a username.";
    }
    else{
        $username = $input_username;
    }

    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter a email.";
    }
    else{
        $email = $input_email;
    }

    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    }
    else{
        $name = $input_name;
    }

    // Validate address 
    $input_address= trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate phone
    $input_phone = trim($_POST["phone"]);
    if(empty($input_phone)){
        $phone_err = "Please enter an phone.";     
    } else{
        $phone = $input_phone;
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($name_err) && empty($address_err)&& empty($phone_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET username=?, email=? , name=? , address=? , phone=? WHERE id=?";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssi", $param_username, $param_email, $param_name , $param_address, $param_phone, $param_id);
            
            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_name = $name;
            $param_address = $address;
            $param_phone = $phone;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: admin_customer.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){ //checkว่ามีไอดีมั้ย
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $username = $row["username"];
                    $email = $row["email"];
                    $name = $row["name"];
                    $address = $row["address"];
                    $phone = $row["phone"];

                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($conn);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer Information Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <style>
    .index-container{
      max-width: 1600px;
      margin: 0 auto;
    }
    .content-container{
      max-width: 1700px;
      margin: 0 auto;
    }
    .nav-c{
      height: 80px;
      border-radius: 10px 10px 10px 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #5f9ea0;

    }
    .nav-c ul li h3{
      font-size: 200%
    }
    .nav-c > ul{
      display: flex;
      height: 60px;
      align-items: center;
      list-style: none;
    }
    .nav-c > ul a{
      color: white;
      text-decoration:none;
      transition:.3s
    }
    .nav-c > ul a:hover{
      color: black;
      text-decoration:none;
      transition:.3s
    }
    .nav-f{
      width:70%;
      display :flex;
    }
    .nav-l{
      width:10%;
      display :flex;
    }
    .nav-f li,.nav-l li{
      margin-right:2rem;
      margin-left:2rem;
    }
    .nav-c > ul li h3{
      color: white;
    }
    .nav-l button[type="submit"]{
      padding: 10px;
    font-size: 10px;
    color: white;
    background: red;
    border: none;
    border-radius: 5px;
    }


    .section-c{
      display: grid;
      grid-template-columns: 250px 1fr;
      background: white;
    }
    .sidebar-c ul{
      list-style: none;
      margin:.5rem 0;
    }
    .sidebar-c ul li{
      padding: .8rem;
      background : #ccc;
      transition:.3s
    }
    .sidebar-c ul li:hover{
      background: red;
    }
    .sidebar-c ul li a{
      margin-right:1rem;
      color : #333;
      text-decoration:none;
    }

    .homecontent-c{
      padding: 1rem 2rem;
    }

    .ct-info{
      display:flex;
      margin-bottom: 1rem;
    }
    .ct-r{
      margin-left:1rem;
    }
    .ct-r p{
      font-size:14px;
      color:rgb(150,150,150)
    }
    .ct-r h3{
      color: #333;
    }
    .ct-h h2{
      margin-top:1rem;
      margin-bottom:2rem;
      border-bottom: 1px solid #ccc;
      padding-bottom:1rem;
    }
    .wrapper{
      width: 1400px;
      margin: 0 auto;
    }

    }
  </style>
</head>

<body>

  <nav>
    <div class="index-container">
    <img src="image/hotel_banner.jpg" style="width:1600px">
      <div class="nav-c">
        <ul class="nav-f">
        <li><h3>@HomeCat</h3></li>
          <li><a href="admin_index.php">เจ้าของโรงแรม/ที่พักแมว</a></li>
          <li><a href="admin_customers.php">ลูกค้า</a></li>
        </ul>

        <ul class ="nav-l">
          <!--form action="index.php">
          <li><button type="submit" name="logout" class="btn">LOGOUT<i class="fa fa-sign-out fa-2x" aria-hidden="true"></i>LOGOUT</button></li>
          </!--form-->
          <li><a href="#"><img width="100%" src="image/admin-icon.png"></a></li>
        </ul>

      </div>
      
    </div>
  </nav>



  <section>
    <div class="content-container">
      <div class="section-c">

        <div class="sidebar-c">

          <!-- logged in user information -->
          <?php if (isset($_SESSION['username'])) : ?>
            <ul class=info>
            <li><h2><strong>Welcome</strong></h2></li> <!--ชื่อคนlogin-->
              <li><img width="150px" hight="150px" src="image/admin.png"></li>
              <li><strong>ตอนนี้คุณLOGINโดยเป็น แอดมิน</strong></li>
              <li><strong>#</strong> <?php echo $_SESSION['id']; ?></li>
              <li><i class="fa fa-user fa-2x" aria-hidden="true"></i><strong>  ชื่อ : </strong> <?php echo $_SESSION['name']; ?></li>

          </ul>
                  <!--  notification message -->
                  <?php if (isset($_SESSION['success'])) : ?>
            <div class="success">
              <h3>
                <?php 
                  echo $_SESSION['success'];
                  unset($_SESSION['success']);
                ?>
              </h3>
            </div>
          <?php endif ?>
          <ul class=logout>
          <li><a href="index.php?logout='1'"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i>LOGOUT</a></li>
          </ul>
          <?php endif ?>
          

        </div>
        <div class="homecontent-c">
          <div class="content">
            <div class="ct-h">
              <h2><strong>แก้ไขข้อมูลลูกค้า</strong></h2>
            </div>

            <div class="ct-info">
              <div class="ct-l">
              </div>

              <div class="wrapper">
                    <div class="header">
                      <h2>ข้อมูลลูกค้า</h2>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="input-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>ชื่อ(ไอดี)</label>
                            <input type="text" name="username" value="<?php echo $username; ?>">
                            <?php echo $username_err; ?>
                        </div>

                        <div class="input-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>อีเมล์</label>
                            <input type="text" name="email" value="<?php echo $email; ?>">
                            <?php echo $email; ?>
                        </div>

                        <div class="input-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>ชื่อ</label>
                            <input type="text" name="name" value="<?php echo $name; ?>">
                            <?php echo $name; ?>
                        </div>

                        <div class="input-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>ที่อยู่</label>
                            <input type="text" name="address" value="<?php echo $address; ?>">
                            <?php echo $address; ?>
                        </div>

                        <div class="input-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                            <label>เบอร์โทรศัพท์</label>
                            <input type="tel" name="phone" placeholder="XXX-XXX-XXXX" pattern="[0]{1}[0-9]{2}-[0-9]{3}-[0-9]{4}" value="<?php echo $phone; ?>">
                            <?php echo $phone_err; ?>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" class="btn" value="Submit">
                        <a href="admin_customer.php" class="btn">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
  </section>
</body>
</html>