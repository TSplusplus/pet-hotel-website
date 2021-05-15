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
    <title>Home Page</title>
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

    }
  </style>
</head>

<body>

  <nav>
    <div class="index-container">
    <img src="image/admin_banner.jpg" style="width:1600px">
      <div class="nav-c">
        <ul class="nav-f">
          <li><h3>@HomeCat</h3></li>
          <li><a href="admin_index.php">เจ้าของโรงแรม/ที่พักแมว</a></li>
          <li><a href="admin_customer.php">ลูกค้า</a></li>
        </ul>

        <ul class ="nav-l">
          <!--form action="index.php">
          <li><button type="submit" name="logout" class="btn">LOGOUT<i class="fa fa-sign-out fa-2x" aria-hidden="true"></i>LOGOUT</button></li>
          </!--form-->
          <li><a href="#"><img width="90%" src="image/admin-icon.png"></a></li>
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
              <h2><strong>ข้อมูลลูกค้า</strong></h2>
            </div>


            <?php 
              require_once "server.php";
              $count_staff = 0;
              $count_driver = 0;
              $count_activity = 0;
              $flag=0;
              $host = "SELECT * FROM users";
              $driver = "SELECT * FROM driver";
              $activity = "SELECT * FROM activity_db";
              $run_host = mysqli_query($conn, $host);
              while ($row = mysqli_fetch_array($run_host)) {
                if($row['role']=="host"){
                  $count_staff = 0;
                  $count_driver = 0;
                  $count_activity = 0;
                  $flag = 1;
                  $id = $row['id'];
                  $email = $row['email'];
                  $name = $row['name'];
                  $address = $row['address'];
                  $phone = $row['phone'];

                  $staff = "SELECT * FROM staff_person WHERE id = '$id'";
                  $run_staff = mysqli_query($conn, $staff);
                  $count_staff = mysqli_num_rows($run_staff);

                  $driver = "SELECT * FROM driver WHERE id = '$id'";
                  $run_driver = mysqli_query($conn, $driver);
                  $count_driver = mysqli_num_rows($run_driver);

                  $activity = "SELECT * FROM activity_db WHERE id = '$id'";
                  $run_activity = mysqli_query($conn, $activity);
                  $count_activity = mysqli_num_rows($run_activity);
              ?>
              <div class="ct-info">
              <div class="ct-l">
              <img width="300px" hight="300px" src="image/hotel_pic.jpg">
              </div>

              <div class="ct-r">
                <h2><?php echo $name; ?></h2>
                <p>อีเมล์ติดต่อ : <?php echo $email; ?></p>
                <p>ที่อยู่ : <?php echo $address; ?></p>
                <p>เบอร์ติดต่อ : <?php echo $phone; ?></p>
                <p>จำนวนพี่เลี้ยง : <?php echo $count_staff; ?></p>
                <p>จำนวนรถรับส่ง : <?php echo $count_driver; ?></p>
                <p>จำนวนกิจกรรม : <?php echo $count_activity; ?></p>
                <?php echo "<a href='admin_host_delete.php?id=". $id ."' title='Delete Information Page' ><i class='fa fa-trash fa-2x' aria-hidden='true'></i></a>";?>
              </div>
            </div>
            <?php }  
             }
            if($flag==0){
              echo "<p class='lead'><em>ยังไม่มี โรงแรม/ที่พัก</em></p>";
           } ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>