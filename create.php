<html>
    <head>
        <meta charset="utf-8">
        <title>Weicheng Quiz</title>
        <meta name="author" content="Weicheng Ao">
        <meta name="revised" content="Weicheng Ao, Canary Edition 11/30/2021">
    </head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />

    <body style="background-color: antiquewhite;">

            <div id='header_group' style="display:block; text-align: center;">
                <!-- <div style="display: inline-flex;"> -->
                <img src="./logo.png" id="logo" alt="Weicheng_Quiz_Welcome_Message" style=" text-align: left; border-radius:20px; display:inline-block; height:100px; width:auto;">
            </div>

            <p class="narrator" style="font-size: x-large; text-align: center;">Welcome to Weicheng Quiz Creater & Taker Lobby</p>
            <p class="narrator" style="font-size: x-large; text-align: center; " id="ymd"></p>
            <!-- <div style="text-align: center;"> -->
            <form action="reset.php" method="post" style="text-align:center; display:center;">
              <p class="narrator"><button type="submit" class="header_button" onclick="">Log Out</button></p>
            </form>
            <form action="index.php" method="post" style="text-align:center; display:center;">
              <p class="narrator"><button type="submit" class="header_button" onclick="">Go Back to Profile page</button></p>
            </form>

    <?php
        // Authentication of Users
        if(!isset($_COOKIE['id'])){
            echo "<script>alert('You have not login or disabled your cookies, please log in first.');location.href='index.php';</script>";
        }else{
            if($_COOKIE['staff'] != 1){
                // echo "<script>alert('You are not staff, this action is restricted.');location.href='index.php';</script>";
            }else{
                // Authentication Successful
                // New Quiz Meta Data Collection
                echo '
                <div id="writingArea" style="text-align:center; border-style:dashed; border-width:3px; border-radius:5px; padding:5px; margin:5px;">
                    <h1>New Quiz Meta Data Collection</h1>
                    <form action="quizUpload.php" method="post" style="display:center;">
                        <p>Quiz ID: (Number) <input name="id" type="number"></input></p>
                        <p>Quiz Name: <textarea name="name" style=""></textarea></p>
                        <p>Quiz Availability: (Put 1 for available, 0 or other for hide) <input name="available"></input></p>
                        <p>Total Score Available:  <input name="score"></input></p>
                        <p>Quiz Duration in Minutes: (Do not put anything other than numbers) <input name="duration"></input></p>
                        <p><button type="submit" class="header_button" onclick="">Create Now!</button></p>
                    </form>
                </div>
                ';
            }
            // Update the following quiz if user want
            // We fetch data from Data Base
            try{
                $user = "root";
                $password = "";

                $pdo = new pdo('mysql:host=localhost; dbname=23111cw2weicheng', $user, $password);
                $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                // echo "<h3 style='text-align:center; color:green;'>Database Connected.</h3>";
                $sql = "SELECT quiz.total_score_available, quiz.quiz_duration, quiz.quiz_id, quiz.quiz_name, staff.staff_name, quiz.quiz_available FROM quiz INNER JOIN staff ON quiz_author_id WHERE quiz.student_id = '0';";

                $stmt = $pdo->query($sql);
                // $rows = $stmt->fetchAll();
                $row_count = $stmt->rowCount();
                $rows = $stmt->fetchAll();
            
                echo '<form action="quizDelete.php" method="post" style="display:center;" id="delete"></form>';
                echo '<form action="history.php" method="post" style="display:center;" id="history"></form>';
                // Latest Created Quiz First
                for($i = $row_count-1; $i >= 0; $i--){
                    // Staff can see all quizzes, Students can only see available quizzes.
                    if($_COOKIE['staff'] === "1" or ($rows[$i]['quiz_available'] === "1" && $_COOKIE['staff'] === "0")){
                        echo '<form action="question.php" method="post" style="display:center;">';
                        echo '<div class="message" style="text-align:center; border-style:solid; border-width:3px; border-radius:5px; padding:5px; margin:5px;">';
                        if($rows[$i]['quiz_id'] != NULL && $rows[$i]['quiz_name'] != NULL && $rows[$i]['staff_name'] != NULL){
                            echo '<p>Quiz ID: <b><input type="hidden" name="quiz_id" value="'.$rows[$i]['quiz_id'].'">'.$rows[$i]['quiz_id'].'</input></b></p>';
                            echo '<p><b><input type="hidden" name="quiz_name" value="'.$rows[$i]['quiz_name'].'">'.$rows[$i]['quiz_name'].'</input></b></p>';
                            echo '<p>Creater / Last Modifier: <b><input type="hidden" name="staff_name" value="'.$rows[$i]['staff_name'].'">'.$rows[$i]['staff_name'].'</input></b></p>';
                            echo '<input type="hidden" name="quiz_available" value="'.$rows[$i]['quiz_available'].'"></input>';
                            echo '<input type="hidden" name="quiz_duration" value="'.$rows[$i]['quiz_duration'].'"></input>';
                            echo '<input type="hidden" name="quiz_total_score" value="'.$rows[$i]['total_score_available'].'"></input>';
                            if($_COOKIE['staff'] === "1"){
                                echo '<p><button type="submit" class="header_button" onclick="">Edit Now!</button></p>';

                                echo "<input type='hidden' name='quiz_id' value='".$rows[$i]['quiz_id']."' form='delete'></input>";
                                // echo "<input type='hidden' name='question_id' value='".$rows[$i]['question_id']."' form='delete'></input>";

                                echo '<p><button type="submit" class="header_button" onclick="" form="delete">Delete Quiz</button></p>';
                            }
                        }
                        echo '
                            <p><button type="submit" class="header_button" onclick="">Take it Now!</button></p>
                            <p><button type="submit" class="header_button" onclick="" form="history">Search Your Taken History of this Quiz</button></p>
                            </div>
                            </form>
                        ';
                    }
                }

            }catch(PDOException $e){
                // echo "<h3 style='text-align:center; color:red;'>Database Disconnected.</h3>";
                echo "<script>alert('Can not connect to Data Base, please check your mysql or php configurations.');</script>";
                echo "<h1>Data Base Offline...</h1>";
            }
        
            // print_r($rows);
        }
    ?>


    </body>

</html>

<script>

function fun(){
        var date = new Date()
        var y = date.getFullYear();
        var m = date.getMonth()+1;
        var d = date.getDate(); 
        var hh = date.getHours();
        var mm = date.getMinutes();
        var ss = date.getSeconds();
        if(hh <= 6 & hh >= 0){
            var notice = "Good Night, Have a deep rest."
        }else if(hh > 6 & hh < 11){
            var notice = "Now is morning, keep doing and smile..."
        }else if(hh >= 11  & hh <= 12){
            var notice = "We are currently at noon."
        }else if(hh > 12 & hh <= 18){
            var notice = "We are currently at afternoon, keep doing..."
        }else if(hh >= 19 & hh <= 22){
            var notice = "Evening Coming..."
        }else if(hh > 22 & hh <= 23){
            var notice = "Good Night, Have a deep rest."
        }else{
            var notice = "Have a nice day."
        }

        document.getElementById("ymd").innerHTML = +y+"-"+m+"-"+d+" "+hh+":"+mm+":"+ss+"  ---  "+notice+"";
        setTimeout("fun()",1000)
    }


    window.onload = function(){
        setTimeout("fun()",0)
    }
</script>


<style>
    .narrator{
        animation-name: narrator_enter; 
        animation-duration:5s;
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    }

    @keyframes narrator_enter {
        0%   {margin-top:-50px;}
        100% {margin-top:15px;}
    }

    #logo{
        text-align:left;
    }

    #header {
        
        /* display: inline-block; */
        border-radius: 5px;
        border-width: 5px;
        border: solid;
        border-color: skyblue;
        background-color: antiquewhite;
        text-align: center;
        display:inline-block;
        margin-left: 25%;
        /* margin-right: 50%; */
        
    }

    .header_button {
        margin: 20px, 20px, 20px, 20px;
        border-radius: 10px;
        /* text-align: right; */

        font-size: large;
    }

    .header_button:hover{
        background-color: rgb(36, 200, 221);
    }

    .header_button:active{
        background-color: sandybrown;
    }

    .good{
        text-align: center;    
    }

</style>
