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
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "server.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM users WHERE id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
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
                $role = $row["role"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
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
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View User Information</title>
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
    #customer-info {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #b0c4de;
    background: white;
    border-radius: 0px 0px 10px 10px;
}
.customer-info-header {
    width: 80%;
    margin: 50px auto 0px;
    color: white;
    background: #5f9ea0;
    text-align: center;
    border: 1px solid #b0c4de;
    border-bottom: none;
    border-radius: 10px 10px 0px 0px;
    padding: 20px;
}
    </style>
</head>
<body>
    <div class="wrapper">
    <div class="customer-info-header">
    <h1>ข้อมูลลูกค้า</h1>
                    </div>
                    <form action="#" method="post" id="customer-info">
                    <div class="input-group">
                        <label>ชื่อ(ไอดี)</label>
                        <input type="text" name="name" value="<?php echo $row["username"]; ?> " disabled>
                    </div>
                    <div class="input-group">
                        <label>อีเมล์</label>
                        <input type="text" name="name" value="<?php echo $row["email"]; ?> " disabled>
                    </div>
                    <div class="input-group">
                        <label>ชื่อ</label>
                        <input type="text" name="name" value="<?php echo $row["name"]; ?> " disabled>
                    </div>
                    <div class="input-group">
                        <label>ที่อยู่</label>
                        <input type="text" name="name" value="<?php echo $row["address"]; ?> " disabled >
                    </div>
                    <div class="input-group">
                        <label>เบอร์โทรศัพท์</label>
                        <input type="text" name="name" value="<?php echo $row["phone"]; ?> " disabled>
                    </div>
                    <div class="input-group">
                        <label>Type</label>
                        <input type="text" name="name" value="<?php echo $row["role"]; ?> " disabled>
                    </div>
                    <p><a href="admin_customer.php" class="btn">Back</a></p>  
    </form>
    </div>
</body>
</html>