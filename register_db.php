<?php 
    session_start();
    include('server.php');
    
    $errors = array();

    if (isset($_POST['reg_user'])) {
        //เก็บช้อมูลเข้าDatabase
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);

        if (empty($username)) {
            array_push($errors, "Username is required");
        }
        if (empty($email)) {
            array_push($errors, "Email is required");
        }
        if (empty($password_1)) {
            array_push($errors, "Password is required");
        }
        if ($password_1 != $password_2) {
            array_push($errors, "The two passwords do not match");
        }
        if (empty($name)) {
            array_push($errors, "Name-Surname is required");
        }
        if (empty($address)) {
            array_push($errors, "Address is required");
        }
        if (empty($phone)) {
            array_push($errors, "Telephone number is required");
        }
        if (empty($role)) {
            array_push($errors, "Role is required");
        }

        $user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email' OR name = '$name' OR address = '$address'  OR phone = '$phone' OR role = '$role'  LIMIT 1"; //เช็คตารางuserว่ามีชื่อหรือ email ซ้ำป่าว
        $query = mysqli_query($conn, $user_check_query); //ทำการquery
        $result = mysqli_fetch_assoc($query);

        if ($result) { // if user exists
            if ($result['username'] === $username) {
                array_push($errors, "Username already exists");
            }
            if ($result['email'] === $email) {
                array_push($errors, "Email already exists");
            }
            if ($result['name'] === $name) {
                array_push($errors, "name already exists");
            }
        }

        if (count($errors) == 0) { //นับจำนวนerror
            $password = md5($password_1); //เข้ข้ารหัสพาส

            $sql = "INSERT INTO users (username, email, password,name,address,phone,role) VALUES ('$username', '$email', '$password','$name','$address','$phone','$role')"; //นำลงฐานข้อมูล
            mysqli_query($conn, $sql); //ทำการ query
            
            $_SESSION['username'] = $username;
            $current_login= "SELECT * FROM users ORDER BY 1 DESC";
            $query_login = mysqli_query($conn,$current_login);
            while ($row = mysqli_fetch_array($query_login)){
                if($row['username'] == $username){
                    $email = $row['email'];
                    $phone = $row['phone'];
                    $id=$row['id'];
                    $name=$row['name'];
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    $_SESSION['phone'] = $phone;
                    $_SESSION['id'] = $id;
                    break;
                }
            }
            $_SESSION['success'] = "You are now logged in";
            if($role == "user"){
               header('location: user_index.php');//ย้ายไปที่หน้าindex
            }
            else if($role ==="host"){
               header('location: host_index.php');
            }
            else if($role ==="admin"){
                header('location: admin_index.php');
            }
        } else {
            array_push($errors, "Username or Email already exists");
            $_SESSION['error'] = "Username or Email already exists";
            header("location: register.php");
        }
    }

?>