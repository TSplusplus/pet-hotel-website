<?php
    session_start();
    include('server.php'); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="header">
        <h2>User Login</h2>
    </div>

    <form action="login_db.php" method="post">
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="error">
                <h3>
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" name="username">
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" name="password">
        </div>
        <input type="hidden" name="role" value="user">
        <div class="input-group">
            <button type="submit" name="login_user" class="btn">Login</button>
        </div>
        <p>ตอนนี้คุณเป็นเจ้าของโรงแรมถ้าคุณต้องการเปลี่ยน<a href="index.php">คลิกที่นี่</a></p>
        <p>ถ้ายังไม่สมัครสมาชิกสมารถสมัครได้ที่นี้!!! <a href="register.php">สมัครสมาชิก</a></p>
        <img src="image/cat.png">
    </form>

</body>
</html>