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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host Home Page</title>
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
      border-bottom: .5px solid #ccc;
    }
    .ct-r{
      margin-left:1rem;
    }
    .ct-r p{
      font-size:20px;
      color:#585858
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
              <h2><strong>ข้อมูลลูกค้า</strong></h2>
            </div>


            <?php 
              require_once "server.php";
              $count_activity = 0;
              $flag=0;
              $customer = "SELECT * FROM users";
              $booking_search = "SELECT * FROM booking_db";
              $run_customer = mysqli_query($conn, $customer);
              $run_booking_search = mysqli_query($conn, $booking_search);
              while ($row = mysqli_fetch_array($run_booking_search)) {
                if($row['host_id']== $_SESSION['id']){
                  $flag = 1;
                  $booking_number = $row['booking_id'];
                  $customer_id = $row['customer_id'];
                  $booking_staff_name = $row['booking_staff_name'];
                  $booking_driver_name = $row['booking_driver_name'];
                  $booking_activity_name = $row['booking_activity_name'];
              if($flag==1){
              while ($row = mysqli_fetch_array($run_customer)) {
                if($row['id']==$customer_id){
                  $email = $row['email'];
                  $name = $row['name'];
                  $address = $row['address'];
                  $phone = $row['phone'];
                } 
              }
              ?>
              <div class="ct-info">
              <div class="ct-l">
              <img width="200px" hight="200px" src="image/cat_pic.png">
              </div>

              <div class="ct-r">
                <h2>ชื่อลูกค้า :<?php echo $name; ?></h2>
                <p>อีเมล์ติดต่อ : <?php echo $email; ?></p>
                <p>ที่อยู่ : <?php echo $address; ?></p>
                <p>เบอร์ติดต่อ : <?php echo $phone; ?></p>
                <p>พี่เลี้ยง : <?php echo $booking_staff_name; ?></p>
                <p>รถรับส่ง : <?php echo $booking_driver_name ?></p>
                <p>กิจกรรม : <?php echo $booking_activity_name ?></p> 
                <?php
                echo "<a href='booking_sucess.php?booking_number=". $booking_number ."' title='Sucess'><i class='fa fa-check-circle fa-2x' aria-hidden='true'></i></a>";
                ?>
                </div>
            </div>
            <?php 
              }
             }
            }
            if($flag==0){
              echo "<p class='lead'><em>ยังไม่มี ลูกค้า</em></p>";
          } ?>
        </div>
      </div>
    </div>
  </section>
</body>
</html>