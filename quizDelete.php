<?php
    $dsn="mysql:host=localhost";
    $user="root";
    $password='';
    $pdo=new PDO($dsn,$user,$password);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    try{
        $pdo = new pdo('mysql:host=localhost; dbname=23111cw2weicheng', $user, $password);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sql = "
        DELETE FROM `option` WHERE `quiz_id` = '".$_REQUEST['quiz_id']."' AND `question_id` LIKE '_' AND `attempt_number` LIKE '_';
        DELETE FROM `question` WHERE `question`.`quiz_id` = '".$_REQUEST['quiz_id']."' AND `question`.`question_id` LIKE '_' AND `question`.`attempt_number` LIKE '_';
        DELETE FROM `quiz` WHERE `quiz`.`quiz_id` = '".$_REQUEST['quiz_id']."' AND `quiz`.`student_id` LIKE '_' AND `quiz`.`attempt_number` LIKE '_';";
        // Delete that Quiz
        $pdo->query($sql);

        // Deletion successful, Return.
        echo "<script>alert('Quiz Deleted Completely.');location.href='create.php';</script>";

    }catch(PDOException $e){
        echo "<script>alert('Can not connect to Data Base, please check your mysql or php configurations.');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
    }
    //DELETE FROM `quiz` WHERE `quiz`.`quiz_id` = 1 AND `quiz`.`student_id` LIKE '_' AND `quiz`.`attempt_number` LIKE '_'

?>