<!-- Connection to DB -->
<?php
    header("Content-type:text/html;charset=utf-8");
    try
    {
        // Input Authentication
        if(isset($_COOKIE['id'])){
            $login_id = $_COOKIE['id'];
        }else{
            if(!isset($_REQUEST['id']) or $_REQUEST['id'] == ""){
                echo "<script>alert('User ID is not filled.');location.href='index.php';</script>";
            }else{
                $login_id = $_REQUEST['id'];
            }
        }

        if(isset($_COOKIE['name'])){
            $login_name = $_COOKIE['name'];
        }else{
            if(!isset($_REQUEST['name']) or $_REQUEST['name'] == ""){
                echo "<script>alert('User NAME is not filled.');location.href='index.php';</script>";
            }else{
                $login_name = $_REQUEST['name'];
            }
        }

        if(isset($_COOKIE['password'])){
            $login_passwd = $_COOKIE['password'];
        }else{
            if(!isset($_REQUEST['password']) or $_REQUEST['password'] == ""){
                echo "<script>alert('PASSWORD is not filled.');location.href='index.php';</script>";            
            }else{
                $login_passwd = $_REQUEST['password'];
            }
        }

        $login_pre_password = $login_passwd;

        if(isset($_COOKIE['staff'])){
            $login_staff = $_COOKIE['staff'];
        }else{
            if(!isset($_REQUEST['staff']) or $_REQUEST['staff'] == ""){
                $login_staff = 0;
            }else{
                if($_REQUEST['staff'] == "Y" or $_REQUEST['staff'] == "T" or $_REQUEST['staff'] == "1" or $_REQUEST['staff'] == "y" or $_REQUEST['staff'] == "yes" or $_REQUEST['staff'] == "t" or $_REQUEST['staff'] == "true"){
                    $login_staff = 1;
                }else{
                    $login_staff = 0;
                } 
            }
        }

        // Data Base Preparatory Work
        $dsn="mysql:host=localhost";
        $user="root";
        $password='';
        $pdo=new PDO($dsn,$user,$password);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        echo "<h3 style='text-align:center; color:green;'>Database Connected, Entering Login/Registration Phase. You will be redirected to the login page once confirmed.</h3>";

        try{
            $sql = "CREATE DATABASE IF NOT EXISTS 23111cw2weicheng";
            $pdo->query($sql);

            $pdo = new pdo('mysql:host=localhost; dbname=23111cw2weicheng', $user, $password);
            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            echo "<h3 style='text-align:center; color:green;'>Database Connected.</h3>";

            $sql = "

            CREATE TABLE IF NOT EXISTS `xxxxxx` (
              `student_id` int NOT NULL,
              PRIMARY KEY (`student_id`)
            );

            ";
            $pdo->query($sql);

            // Login and Registration Main Function Code Snippet
            // Query if this user is Staff, if so we insert it to the Staff table.
            if($login_staff == 1){
                $sql = "SELECT * FROM staff WHERE staff_id = ".$login_id.";";
                $re = $pdo -> query($sql);
                $rows = $re->fetchAll();
                if($rows == null){
                    // echo '<p id="editor">'.$rows[$i]['editor'].'</p>';
                    // We have no such staff, proceed to register.
                    $login_passwd = password_hash($login_passwd, PASSWORD_DEFAULT);

                    $sql = "INSERT INTO `staff` (`staff_id`, `staff_name`, `password`) VALUES ('".$login_id."', '".$login_name."', '".$login_passwd."')";
                    $re = $pdo -> query($sql);
                    $rows = $re->fetchAll();
                    // print_r ($rows);
                    echo "<p>Registration Successful.</p>";
                    setcookie("id", $login_id, time()+3600);
                    setcookie("password", $login_pre_password, time()+3600);
                    setcookie("name", $login_name,time()+3600);
                    setcookie("staff", $login_staff, time()+3600);

                    echo "<script>alert('Registration Successful, now automatically login by using cookies.');location.href='login.php';</script>";

                }else{
                    // Staff Exists, proceed to authenticate.
                    $sql = "SELECT password FROM staff WHERE staff_id = ".$login_id." AND staff_name = ".$login_name." ;";
                    $re = $pdo -> query($sql);
                    $rows = $re->fetchAll();
                    if($rows == null){
                        // THIS PERSON DOES NOT EXIST.
                        echo "<script>alert('Login Failed. Please check your Username and Password again.');location.href='index.php';</script>";
                    }else{
                        // PASSWORD MATCHING
                        if(password_verify($login_pre_password, $rows[0][0])){
                            if(!isset($_COOKIE['id'])){
                                setcookie("id", $login_id, time()+3600);
                                setcookie("password", $login_pre_password, time()+3600);
                                setcookie("name", $login_name,time()+3600);
                                setcookie("staff", $login_staff, time()+3600);
                            }
                            echo "<script>alert('Login Successful, staff password matched. We reserve your cookie for 1 hour.');location.href='index.php';</script>";
                        }else{
                            echo "<script>alert('Login Failed. Please check your Username and Password again.');location.href='index.php';</script>";
                        }
                    }
                }

            }else{
                // Otherwise we insert it to Student table.
                $sql = "SELECT * FROM student WHERE student_id = ".$login_id.";";
                $re = $pdo -> query($sql);
                $rows = $re->fetchAll();
                if($rows == null){
                    // echo '<p id="editor">'.$rows[$i]['editor'].'</p>';
                    // We have no such student, proceed to register.
                    $login_passwd = password_hash($login_passwd, PASSWORD_DEFAULT);

                    $sql = "INSERT INTO `student` (`student_id`, `student_name`, `password`) VALUES ('".$login_id."', '".$login_name."', '".$login_passwd."')";
                    $re = $pdo -> query($sql);
                    $rows = $re->fetchAll();
                    // print_r ($rows);
                    echo "<p>Registration Successful.</p>";
                    setcookie("id", $login_id, time()+3600);
                    setcookie("password", $login_pre_password, time()+3600);
                    setcookie("name", $login_name,time()+3600);
                    setcookie("staff", $login_staff, time()+3600);

                    echo "<script>alert('Registration Successful, now automatically login by using cookies.');location.href='login.php';</script>";

                }else{
                    // Student Exists, proceed to authenticate.
                    $sql = "SELECT password FROM student WHERE student_id = ".$login_id." AND student_name = ".$login_name." ;";
                    $re = $pdo -> query($sql);
                    $rows = $re->fetchAll();
                    if($rows == null){
                        // THIS PERSON DOES NOT EXIST.
                        echo "<script>alert('Login Failed. Please check your Username and Password again.');location.href='index.php';</script>";
                    }else{
                        // PASSWORD MATCHING
                        if(password_verify($login_pre_password, $rows[0][0])){
                            if(!isset($_COOKIE['id'])){
                                setcookie("id", $login_id, time()+3600);
                                setcookie("password", $login_pre_password, time()+3600);
                                setcookie("name", $login_name,time()+3600);
                                setcookie("staff", $login_staff, time()+3600);
                            }
                            echo "<script>alert('Login Successful, student password matched. We reserve your cookie for 1 hour.');location.href='index.php';</script>";
                        }else{
                            echo "<script>alert('Login Failed. Please check your Username and Password again.');location.href='index.php';</script>";
                        }
                    }
                }
            }

        }catch(PDOException $e){
            echo "<h3 style='text-align:center; color:red;'>Database Disconnected.</h3>";
            echo "<script>alert('Can not connect to Data Base, please check your mysql or php configurations.');location.href='index.php';</script>";
        }
    }
    catch(PDOException $e)
    {
        echo "<h3 style='text-align:center; color:red;'>Database Disconnected.</h3>";
        echo "<script>alert('Can not connect to Data Base, please check your mysql or php configurations.');location.href='index.php';</script>";
    }

?>