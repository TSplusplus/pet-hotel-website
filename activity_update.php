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
$activity_name = $activity_type = "";
$activity_name_err = $activity_type_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["activity_num"]) && !empty($_POST["activity_num"])){
    // Get hidden input value
    $activity_num = $_POST["activity_num"];
    
    // Validate name
    $input_activity_name = trim($_POST["activity_name"]);
    if(empty($input_activity_name)){
        $activity_name_err = "Please enter a name.";
    }
    else{
        $activity_name = $input_activity_name;
    }
    
    // Validate address address
    $input_activity_type = trim($_POST["activity_type"]);
    if(empty($input_activity_type)){
        $activity_type_err = "Please enter an type.";     
    } else{
        $activity_type = $input_activity_type;
    }
    
    // Check input errors before inserting in database
    if(empty($activity_name_err) && empty($activity_type_err)){
        // Prepare an update statement
        $sql = "UPDATE activity_db SET activity_name=?, activity_type=? WHERE activity_num=?";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssi", $param_activity_name, $param_activity_type, $param_activity_num);
            
            // Set parameters
            $param_activity_name = $activity_name;
            $param_activity_type = $activity_type;
            $param_activity_num = $activity_num;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: host_activity.php");
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
    if(isset($_GET["activity_num"]) && !empty(trim($_GET["activity_num"]))){ //checkว่ามีไอดีมั้ย
        // Get URL parameter
        $activity_num =  trim($_GET["activity_num"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM activity_ab WHERE activity_num = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_activity_num);
            
            // Set parameters
            $param_activity_num = $activity_num;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $activity_name = $row["activity_name"];
                    $activity_type = $row["activity_type"];
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
    <title>Update activity Information Page</title>
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
          <li><a href="host_index.php">ข้อมูลลูกค้า</a></li>
          <li><a href="host_staff.php">พี่เลี้ยง</a></li>
          <li><a href="host_activity.php">กิจกรรม</a></li>
          <li><a href="host_driver.php">รถรับส่ง</a></li>
        </ul>

        <ul class ="nav-l">
          <!--form action="index.php">
          <li><button type="submit" name="logout" class="btn">LOGOUT<i class="fa fa-sign-out fa-2x" aria-hidden="true"></i>LOGOUT</button></li>
          </!--form-->
          <li><a href="#"><img width="70%" src="image/hotel-icon.png"></a></li>
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
              <li><strong>ตอนนี้คุณLOGINโดยเป็นที่พัก/โรงแรม</strong></li>
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
              <h2><strong>แก้ไขกิจกรรม</strong></h2>
            </div>

            <div class="ct-info">
              <div class="ct-l">
              </div>

              <div class="wrapper">
                    <div class="header">
                      <h2>รายละเอียดกิจกรรม</h2>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    
                        <div class="input-group <?php echo (!empty($activity_name_err)) ? 'has-error' : ''; ?>">
                            <label>ชื่อ</label>
                            <input type="text" name="activity_name" value="<?php echo $activity_name; ?>">
                            <?php echo $activity_name_err; ?>
                        </div>

                        <div class="input-group <?php echo (!empty($activity_type_err)) ? 'has-error' : ''; ?>">
                            <label for="activity_type">ประเภทของกิจกรรม</label>
                            <select name="activity_type" class="form-control"  >
                                <option value="" selected="selected">--เลือกประเภทของกิจกรรม-- </option>
                                <option value="sport">กีฬาน้องแมว</option>
                                <option value="train">ฝึกสอนน้องแมว</option>
                                <option value="clear">ทำความสะอาดน้องแมว</option>
                                <option value="travel">พาน้องแมวไปเที่ยว</option>
                                <option value="food">การรับประทานอาหาร</option>
                            </select>
                            <?php echo $activity_type_err; ?>
                        </div>
                        <input type="hidden" name="activity_num" value="<?php echo $activity_num; ?>">
                        <input type="submit" class="btn" value="Submit">
                        <a href="host_activity.php" class="btn">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
  </section>
</body>
</html>