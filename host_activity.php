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

    #activity tr td:last-child a{
      margin-right: 30px;
    }


    #activity {
      margin-top: 2rem;
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 70%;
}

#activity td, #customers th {
  border: 1px solid #ddd;
  padding: 8px 15px;
}

#activity tr:nth-child(even){background-color: #f2f2f2;}

#activity tr:hover {background-color: #ddd;}

#activity th {
  padding-top: 8px;
  padding-bottom: 8px;
  text-align: center;
  background: #660033;
  color: white;
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
              <h2><strong>กิจกรรม</strong></h2>
            </div>

            <div class="ct-info">
              <div class="wrapper">
                <div class="row">

                    <a href="activity_create.php">เพิ่มกิจกรรม</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "server.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM activity_db";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table id='activity'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th><strong>ชื่อกิจกรรม</strong></th>";
                                        echo "<th><strong>แก้ไข/ลบ</strong></th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                  if($row['id']==$_SESSION['id']){
                                    echo "<tr>";
                                        echo "<td>" . $row['activity_name'] . "</td>";
                                        //echo "<td>" . $row['driver_phone'] . "</td>";
                                        echo "<td>";
                                            //echo "<a href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='activity_update.php?activity_num=". $row['activity_num'] ."' title='Update activity Information Page' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
                                            echo "<a href='activity_delete.php?activity_num=". $row['activity_num'] ."' title='Delete Information Page' ><i class='fa fa-trash' aria-hidden='true'></i></a>";
                                        echo "</td>";
                                    echo "</tr>";

                                  }
                          }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>คุณยังไม่มีกิจกรรมใน โรงแรม/ที่พัก</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                    }
 
                    // Close connection
                    mysqli_close($conn);
                    ?>
                </div>
                </div>         
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>