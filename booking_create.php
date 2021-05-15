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
$booking_staff_name = $booking_driver_name = $booking_activity_name = "";
$booking_staff_name_err = $booking_driver_name_err = $booking_activity_name_err = "";
 
// Processing form data when form is submitted
  //echo $host_id;
  //echo $customer_id;
  //echo "55555555555555555555555555555555555555";
  if(isset($_POST["host_id"]) && !empty($_POST["host_id"]) && isset($_POST["customer_id"]) && !empty($_POST["customer_id"])){
  $host_id = $_POST["host_id"];
  $customer_id = $_POST["customer_id"];
    // Validate name
    $input_booking_staff_name = trim($_POST["booking_staff_name"]);//ตัดช่องว่างต้อนล้ะท้าย 
    if(empty($input_booking_staff_name)){
        $booking_staff_name_err = "Please enter a name.";
    } else{
        $booking_staff_name = $input_booking_staff_name;
    }
    
        // Validate address
    $input_booking_driver_name = trim($_POST["booking_driver_name"]);
      if(empty($input_booking_driver_name)){
          $booking_driver_name_err = "Please enter an driver name.";     
      } else{
          $booking_driver_name = $input_booking_driver_name;
      }
    // Validate address
    $input_booking_activity_name = trim($_POST["booking_activity_name"]);
    if(empty($input_booking_activity_name)){
        $booking_activity_name_err = "Please enter an name.";     
    } else{
        $booking_activity_name = $input_booking_activity_name;
    }
    

    // Check input errors before inserting in database
    if(empty($booking_staff_name_err) && empty($booking_driver_name_err) && empty($booking_activity_name_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO booking_db (customer_id , host_id , booking_staff_name ,booking_driver_name ,booking_activity_name) VALUES (?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt,"iisss",$param_customer_id,$param_host_id, $param_booking_staff_name, $param_booking_driver_name,$param_booking_activity_name);
            
            // Set parameters
            $param_customer_id = $customer_id;
            $param_host_id = $host_id;
            $param_booking_staff_name = $booking_staff_name;
            $param_booking_driver_name = $booking_driver_name;
            $param_booking_activity_name = $booking_activity_name;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: user_index.php");
                exit();
            } else{
               //echo $param_id;
                echo "Something went wrong. Please try again later55.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
      }  
    // Close connection
    mysqli_close($conn);
}
  else{
    // Check existence of id parameter before processing further
    if( isset($_GET["host_id"]) && !empty(trim($_GET["host_id"])) && isset($_GET["customer_id"]) && !empty(trim($_GET["customer_id"]))){ //checkว่ามีไอดีมั้ย
        // Get URL parameter
        $host_id =  trim($_GET["host_id"]);
        $customer_id =  trim($_GET["customer_id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_host_id);
            
            // Set parameters
            $param_host_id = $host_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $host_name = $row["name"];
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
        //mysqli_close($conn);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: errorrr555.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
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
    #booking-info {
    width: 200%;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #b0c4de;
    background: white;
    border-radius: 0px 0px 10px 10px;
}
.booking-info-header {
    width: 200%;
    margin: 50px auto 0px;
    color: white;
    background: #5f9ea0;
    text-align: center;
    border: 1px solid #b0c4de;
    border-bottom: none;
    border-radius: 10px 10px 0px 0px;
    padding: 20px;
}
    }
  </style>
</head>

<body>

  <nav>
    <div class="index-container">
    <img src="image/cat_banner5.jpg" style="width:1600px">
      <div class="nav-c">
        <ul class="nav-f">
          <li><h3>@HomeCat</h3></li>
          <li><a href="user_index.php">การจอง</a></li>
        </ul>

        <ul class ="nav-l">
          <!--form action="index.php">
          <li><button type="submit" name="logout" class="btn">LOGOUT<i class="fa fa-sign-out fa-2x" aria-hidden="true"></i>LOGOUT</button></li>
          </!--form-->
          <li><a href="#"><img width="70%" src="image/cat-icon.png"></a></li>
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
    <li><strong>ตอนนี้คุณLOGINโดยเป็น เจ้าของแมว</strong></li>
    <li><strong>#</strong> <?php echo $_SESSION['id']; ?></li>
    <li><i class="fa fa-user fa-2x" aria-hidden="true"></i><strong>  ชื่อ : </strong> <?php echo $_SESSION['name']; ?></li>
    <li><i class="fa fa-envelope fa-2x" aria-hidden="true"></i><strong>  อีเมล : </strong> <?php echo $_SESSION['email']; ?></li>
    <li><i class="fa fa-phone fa-2x" aria-hidden="true"></i><strong>  เบอร์ : </strong> <?php echo $_SESSION['phone']; ?></li>

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
              <h2><strong>จองที่พัก/โรงแรม</strong></h2>
            </div>

            <div class="ct-info">
            <?php 
              // $host_id = $_GET["host_id"];
              // $customer_id = $_GET["customer_id"];
              // echo $host_id;
              // echo $customer_id;
            //require_once "server.php";
            //  $host = "SELECT * FROM users";
            //  $run_host = mysqli_query($conn, $host);

            //  while ($row = mysqli_fetch_array($run_host)) {
            //    if($row['id' ]== $_GET["host_id"]){
            //     $host_name = $row['name'];
            //    }
            //  }
              ?>
              <div class="ct-l">
              </div>

              <div class="wrapper">
                    <p>กรอกรายละเอียดข้างล่างเพื่อจอง ที่พัก/โรงแรม</p>
                    <div class="booking-info-header" >
                      <h2>รายละเอียดการจอง ที่พัก/โรงแรม</h2>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="booking-info">


                        <div class="input-group">
                            <label>ชื่อที่พัก/โรงแรม</label>
                            <input type="text" name="host_name" value="<?php echo $host_name; ?>" disabled>
                        </div>

                        <div class="input-group <?php echo (!empty($booking_staff_name_err)) ? 'has-error' : ''; ?>">
                            <label for="booking_staff_name">พี่เลี้ยง</label>
                            <select name="booking_staff_name" class="form-control"  >
                                <option value="" selected="selected">--เลือกพี่เลี้ยง-- </option>
                                <?php 
                                  //require_once "server.php";
                                  $staff = "SELECT * FROM staff_person";
                                  $run_staff = mysqli_query($conn, $staff);

                                  while ($row = mysqli_fetch_array($run_staff)) {
                                    if($row['id' ]== $host_id){
                                    echo "<option value='".$row[staff_name]."'>".$row[staff_name]."</option>";
                                    }
                                  }
                                  ?>
                            </select>
                            <?php echo $booking_staff_name_err; ?>
                        </div>

                        <div class="input-group <?php echo (!empty($booking_driver_name_err)) ? 'has-error' : ''; ?>">
                            <label for="booking_driver_name">รถรับส่ง</label>
                            <select name="booking_driver_name" class="form-control"  >
                                <option value="" selected="selected">--เลือกคนขับรถรับส่ง-- </option>
                                <option value="No">ไม่ต้องการบริการรับส่ง</option>
                                <?php 
                                  //require_once "server.php";
                                  $driver = "SELECT * FROM driver";
                                  $run_driver = mysqli_query($conn, $driver);

                                  while ($row = mysqli_fetch_array($run_driver)) {
                                    if($row['id' ]== $host_id){
                                    echo "<option value='".$row[driver_name]."'>".$row[driver_name]."</option>";
                                    }
                                  }
                                  ?>
                            </select>
                            <?php echo $booking_driver_name_err; ?>
                        </div>

                        <div class="input-group <?php echo (!empty($booking_activity_name_err)) ? 'has-error' : ''; ?>">
                            <label>กิจกรรม</label>
                            <input type="text" name="booking_activity_name" value="<?php echo $booking_activity_name; ?>">
                            <?php echo $booking_activity_name_err; ?>
                        </div>
                        <input type="hidden" name="host_id" value="<?php echo $host_id; ?>">
                        <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
                        <input type="submit" class="btn" value="Submit">
                        <a href="user_index.php" class="btn">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>

    </div>
  </section>
</body>
</html>