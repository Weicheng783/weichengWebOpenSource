<?php
    if(!isset($_REQUEST['id']) or $_REQUEST['id'] == ""){
        echo "<script>alert('Quiz ID is not filled.');location.href='create.php';</script>";
    }else{
        $quiz_id = $_REQUEST['id'];
    }

    if(!isset($_REQUEST['name']) or $_REQUEST['name'] == ""){
        echo "<script>alert('Quiz NAME is not filled.');location.href='create.php';</script>";
    }else{
        $quiz_name = $_REQUEST['name'];
    }

    if(!isset($_REQUEST['available']) or $_REQUEST['available'] == ""){
        $quiz_available = 0;
    }else{
        $quiz_available = 1;
    }

    if(!isset($_REQUEST['score']) or $_REQUEST['score'] == ""){
        echo "<script>alert('You haven't set your quiz score.');location.href='create.php';</script>";
    }else{
        $quiz_score = $_REQUEST['score'];
    }

    if(!isset($_REQUEST['duration']) or $_REQUEST['duration'] == ""){
        echo "<script>alert('You haven't set your quiz duration.');location.href='create.php';</script>";
    }else{
        $quiz_duration = $_REQUEST['duration'];
    }

    // Input Validation Successful

    // TEST Mysql Connection
    $dsn="mysql:host=localhost";
    $user="root";
    $password='';
    $pdo=new PDO($dsn,$user,$password);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    echo "<h3 style='text-align:center; color:green;'>Database Connected, Entering Login/Registration Phase. You will be redirected to the login page once confirmed.</h3>";

    try{

        $pdo = new pdo('mysql:host=localhost; dbname=23111cw2weicheng', $user, $password);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        // echo "<h3 style='text-align:center; color:green;'>Database Connected.</h3>";
        $sql = "INSERT INTO `quiz` (`quiz_id`, `student_id`, `attempt_number`, `quiz_name`, `quiz_author_id`, `quiz_available`, `quiz_duration`, `date_of_attempt`, `total_score_available`, `total_score_gained`) 
        VALUES ('".$_REQUEST['id']."', '0', '0', '".$_REQUEST['name']."', '".$_COOKIE['id']."', '".$_REQUEST['available']."', '".$_REQUEST['duration']."', NULL, '".$_REQUEST['score']."', NULL);";
        
        $pdo->query($sql);

        // Create Quiz successful, Return to the Create Page.
        echo "<script>alert('Quiz Successfully Created, please select the Quiz Pool below to begin your edit on Questions.');location.href='create.php';</script>";

    }catch(PDOException $e){
        // echo "<h3 style='text-align:center; color:red;'>Database Disconnected.</h3>";
        echo "<script>alert('Can not connect to Data Base, please check your mysql or php configurations.');location.href='create.php';</script>";
    }




?>