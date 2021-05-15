<?php 
    session_start();
    include('server.php');

    $errors = array();

    if (isset($_POST['login_user'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);
        if (empty($username)) {
            array_push($errors, "Username is required");
        }

        if (empty($password)) {
            array_push($errors, "Password is required");
        }

        if (count($errors) == 0) {
            $password = md5($password);
            $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND role = '$role' ";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 1) {
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

                $_SESSION['success'] = "Your are now logged in";
                if($role == "user"){
                    header("location: user_index.php");
                 }
                 else if($role ==="host"){
                    header('location: host_index.php');
                 }
                 else if($role ==="admin"){
                     header('location: admin_index.php');
                  }
            } else {
                array_push($errors, "Wrong Username or Password or role");
                $_SESSION['error'] = "Wrong Username or Password or role !!!";
                if($role == "user"){
                    header("location: user_login.php");
                 }
                 else if($role ==="host"){
                    header('location: host_login.php');
                 }
                 else if($role ==="admin"){
                     header('location: admin_login.php');
                  }
            }
        } else {
            array_push($errors, "Username & Password is required");
            $_SESSION['error'] = "Username & Password is required";
            if($role == "user"){
                header("location: user_login.php");
             }
             else if($role ==="host"){
                header('location: host_login.php');
             }
             else if($role ==="admin"){
                 header('location: admin_login.php');
              }
        }
    }

?>