<?php 
    session_start();
    include('server.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="header">
        <h2>สมัครสมาชิก(Register)</h2>
    </div>

    <form action="register_db.php" method="post">
        <?php include('errors.php'); ?>
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
            <label for="username">ชื่อที่ใช้ล็อคอิน(ID)</label>
            <input type="text" name="username">
        </div>
        <div class="input-group">
            <label for="email">อีเมล์(Email)</label>
            <input type="email" name="email">
        </div>
        <div class="input-group">
            <label for="password_1">รหัสผ่าน(Password)</label>
            <input type="password" name="password_1">
        </div>
        <div class="input-group">
            <label for="password_2">ยินยันรหัสผ่าน(Confirm Password)</label>
            <input type="password" name="password_2">
        </div>
        <div class="input-group">
            <label for="name">ชื่อผู้ใช้/ชื่อที่พัก(ชื่อนี้จะถูกแสดงบนเว็บ)</label>
            <input type="text" name="name">
        </div>

        <div class="input-group">
            <label for="address">ที่อยู่</label>
            <input type="text" name="address">
        </div>
        <div class="input-group">
            <label for="phone">เบอร์ติดต่อ</label>
            <input type="tel" name="phone" placeholder="XXX-XXX-XXXX" pattern="[0]{1}[0-9]{2}-[0-9]{3}-[0-9]{4}">
        </div>

        <div class="input-group">
            <label for="role">Selct Type</label>
            <select name="role" class="form-control"  >
            <option value="" selected="selected">--เลือกหน้าที่ของคุณ-- </option>
            <option value="admin">คุณเป็นผู้ดูแล(Admin)</option>
            <option value="host">คุณเป็นเจ้าของที่พัก(Host)</option>
            <option value="user">คุณเป็นเจ้าของแมว(User)</option>
            </select>
        </div>
        <div class="input-group">
            <button type="submit" name="reg_user" class="btn">Register</button>
        </div>
        <p>เป็นสมาชิกอยู่แล้วให้ไปหน้าLogin<a href="index.php">ที่นี้</a></p>
    </form>

</body>
</html>