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

            <p class="narrator" style="font-size: x-large; text-align: center;">You are in: Quiz --> Question Creater Page/ Taken Page</p>
            <p class="narrator" style="font-size: x-large; text-align: center; " id="ymd"></p>
            <form action="reset.php" method="post" style="text-align:center; display:center;">
              <p class="narrator"><button type="submit" class="header_button" onclick="">Log Out</button></p>
            </form>

            <form action="create.php" method="post" style="text-align:center; display:center;">
              <p class="narrator"><button type="submit" class="header_button" onclick="">Go Back to Quiz page</button></p>
            </form>

    <?php
        // print_r($_REQUEST['staff_name']);
        // Authentication of Staff users only
        if(!isset($_COOKIE['staff'])){
            echo "<script>alert('You have not login or disabled your cookies, please log in first.');location.href='index.php';</script>";
        }else{
                // Authentication Successful
                // New Question Meta Data Collection
                if(!isset($_REQUEST['quiz_id'])){}
                else{
                    setcookie("quiz_id", NULL);
                    setcookie("quiz_id", $_REQUEST['quiz_id'], time()+3600);
                }

                if($_COOKIE['staff'] === "1"){
                    if(!isset($_REQUEST['quiz_id'])){
                        echo '
                        <div id="writingArea" style="text-align:center; border-style:dashed; border-width:3px; border-radius:5px; padding:5px; margin:5px;">
                            <h1>New Question Registration</h1>';
                        echo '<div id="writingArea" style="text-align:center; border-style:solid; border-color:purple ;border-width:3px; border-radius:5px; padding:5px; margin:5px;">
                        <form action="questionUpload.php" method="post" style="display:center;">';
                        echo "<h2>You are now editing Quiz <mark># <input type='hidden' name='quiz_id' value='".$_COOKIE['quiz_id']."'>".$_COOKIE['quiz_id']."</input></mark>.</h2>";
                        echo '<p>Quiz Name: <input name="quiz_name" style="" value="'.$_COOKIE['quiz_name'].'"></input></p>';
                        echo '<p>Quiz Availability: (Put 1 for available, 0 or other for hide) <input name="quiz_available" value="'.$_COOKIE['quiz_available'].'"></input></p>';
                        echo '<p>Total Score Available:  <input name="quiz_total_score" value="'.$_COOKIE['quiz_total_score'].'"></input></p>';
                        echo '<p>Quiz Duration in Minutes: (Do not put anything other than numbers) <input name="quiz_duration" value="'.$_COOKIE['quiz_duration'].'"></input></p>';
                        echo '</div>';               
                    }
                    else{
                        echo '
                        <div id="writingArea" style="text-align:center; border-style:dashed; border-width:3px; border-radius:5px; padding:5px; margin:5px;">
                            <h1>New Question Registration</h1>';
                        echo '<div id="writingArea" style="text-align:center; border-style:solid; border-color:purple ;border-width:3px; border-radius:5px; padding:5px; margin:5px;">
                        <form action="questionUpload.php" method="post" style="display:center;">';
                        echo "<h2>You are now editing Quiz <mark># <input type='hidden' name='quiz_id' value='".$_REQUEST['quiz_id']."'>".$_REQUEST['quiz_id']."</input></mark>.</h2>";
                        echo '<p>Quiz Name: <input name="quiz_name" style="" value="'.$_REQUEST['quiz_name'].'"></input></p>';
                        echo '<p>Quiz Availability: (Put 1 for available, 0 or other for hide) <input name="quiz_available" value="'.$_REQUEST['quiz_available'].'"></input></p>';
                        echo '<p>Total Score Available:  <input name="quiz_total_score" value="'.$_REQUEST['quiz_total_score'].'"></input></p>';
                        echo '<p>Quiz Duration in Minutes: (Do not put anything other than numbers) <input name="quiz_duration" value="'.$_REQUEST['quiz_duration'].'"></input></p>';
                        echo '</div>';
                    }

                    echo '<h3>If you want to <mark>only</mark> edit Quiz Meta-Data Above, Please leave the first blank "Question ID" empty below.</h3>';

                    echo '<div id="writingArea" style="text-align:center; border-style:solid; border-color:purple ;border-width:3px; border-radius:5px; padding:5px; margin:5px;">';
                    echo '<p>Question ID: <input type="number" name="question_id" style="" ></input></p>';
                    echo '<p>Question Desciption: <input name="question_description" style="" ></input></p>';
                    echo '<p>Question Score Available: <input type="number" name="question_total_score" style="" ></input></p>';
                    echo '<p>Correct Answer ID: <input type="number" name="correct_answer_id" style="" placeholder="0" value="0"></input></p>';
                    echo '<p>Correct Answer Text/Description: <input name="correct_answer" style="" placeholder=""></input></p>';

                    echo '</div>';

                    echo '<p><button type="submit" class="header_button" onclick="">Update this Quiz Info OR Add this Question Meta Data Now!</button></p>';
                    echo '</form></div>';
                }
            

            // Update the following question and take quiz if user want
            // We fetch data from Data Base
            try{
                $user = "root";
                $password = "";

                $pdo = new pdo('mysql:host=localhost; dbname=23111cw2weicheng', $user, $password);
                $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                if(!isset($_REQUEST['quiz_id'])){
                    $sql = "SELECT * FROM `question` WHERE `question`.`quiz_id` = '".$_COOKIE['quiz_id']."'";
                }else{
                    $sql = "SELECT * FROM `question` WHERE `question`.`quiz_id` = '".$_REQUEST['quiz_id']."'";
                }
                $stmt = $pdo->query($sql);
                $row_count = $stmt->rowCount();
                $rows = $stmt->fetchAll();

                if(!isset($_REQUEST['quiz_id'])){
                    echo '<div class="message" style="text-align:center; border-style:solid; border-width:3px; border-radius:5px; padding:5px; margin:5px;">';
                    echo '<h2>'.$_COOKIE['quiz_name'].'</h2>';
                    echo '<h3>Duration: '.$_COOKIE['quiz_duration'].' Minutes</h3>';
                    echo '<h3>Total Score Available: '.$_COOKIE['quiz_total_score'].'</h3>';
                    echo '</div>';
                }else{
                    echo '<div class="message" style="text-align:center; border-style:solid; border-width:3px; border-radius:5px; padding:5px; margin:5px;">';
                    echo '<h2>'.$_REQUEST['quiz_name'].'</h2>';
                    echo '<h3>Duration: '.$_REQUEST['quiz_duration'].' Minutes</h3>';
                    echo '<h3>Total Score Available: '.$_REQUEST['quiz_total_score'].'</h3>';
                    echo '</div>';
                }
                // First Created Question First

                // Forms
                echo '<form action="option.php" method="post" style="display:center;" id="inner"></form>';
                echo '<form action="handin.php" method="post" style="display:center;" id="outer"></form>';
                echo '<form action="questionDelete.php" method="post" style="display:center;" id="delete"></form>';

                echo '<input name="count" type="hidden" value="'.$row_count.'" form="outer"></input>';

                for($i = 0; $i < $row_count; $i++){

                    echo '<div class="message" style="text-align:center; border-style:solid; border-width:3px; border-radius:5px; padding:5px; margin:5px;">';
                    if($rows[$i]['question_id'] != NULL && $rows[$i]['question_description'] != NULL && $rows[$i]['attempt_number'] != NULL){
                        echo '<p>Question ID: <b><input type="hidden" name="question_id" value="'.$rows[$i]['question_id'].'" form="inner">'.$rows[$i]['question_id'].'</input></b></p>';
                        echo '<p>Question Description: <b><input form="inner" type="hidden" name="question_description" value="'.$rows[$i]['question_description'].'">'.$rows[$i]['question_description'].'</input></b></p>';
                        echo '<input form="inner" type="hidden" name="attempt_number" value="0"></input>';

                        echo '<input type="hidden" name="question_id" value="'.$rows[$i]['question_id'].'" form="inner"></input>';
                        echo '<input type="hidden" name="question_score_available" value="'.$rows[$i]['question_score_available'].'" form="inner"></input>';
                        echo '<input type="hidden" name="correct_answer_id" value="'.$rows[$i]['correct_answer_id'].'" form="inner"></input>';
                        echo '<input type="hidden" name="correct_answer" value="'.$rows[$i]['correct_answer'].'" form="inner"></input>';

                        if(!isset($_REQUEST['quiz_id'])){
                            echo '<input type="hidden" name="quiz_id_'.$i.'" value="'.$_COOKIE['quiz_id'].'" form="outer"></input>';
                            echo '<input type="hidden" name="quiz_name_'.$i.'" value="'.$_COOKIE['quiz_name'].'" form="outer"></input>';

                            echo '<input type="hidden" name="quiz_total_score" value="'.$_COOKIE['quiz_total_score'].'" form="outer"></input>';

                            echo '<input type="hidden" name="quiz_id" value="'.$_COOKIE['quiz_id'].'" form="inner"></input>';
                            echo '<input type="hidden" name="quiz_name" value="'.$_COOKIE['quiz_name'].'" form="inner"></input>';
                            echo '<input type="hidden" name="quiz_total_score" value="'.$_COOKIE['quiz_total_score'].'" form="inner"></input>';
                            echo '<input type="hidden" name="quiz_duration" value="'.$_COOKIE['quiz_duration'].'" form="inner"></input>';
                        }else{
                            echo '<input type="hidden" name="quiz_id_'.$i.'" value="'.$_REQUEST['quiz_id'].'" form="outer"></input>';
                            echo '<input type="hidden" name="quiz_name_'.$i.'" value="'.$_REQUEST['quiz_name'].'" form="outer"></input>';

                            echo '<input type="hidden" name="quiz_id" value="'.$_REQUEST['quiz_id'].'" form="inner"></input>';
                            echo '<input type="hidden" name="quiz_name" value="'.$_REQUEST['quiz_name'].'" form="inner"></input>';

                            echo '<input type="hidden" name="quiz_total_score" value="'.$_REQUEST['quiz_total_score'].'" form="outer"></input>';
                            
                            echo '<input type="hidden" name="quiz_total_score" value="'.$_REQUEST['quiz_total_score'].'" form="inner"></input>';
                            echo '<input type="hidden" name="quiz_duration" value="'.$_REQUEST['quiz_duration'].'" form="inner"></input>';
                        }


                        // Options Fetch
                        $pdo1 = new pdo('mysql:host=localhost; dbname=23111cw2weicheng', $user, $password);
                        $pdo1 -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                        if(!isset($_REQUEST['quiz_id'])){
                            $sql1 = "SELECT * FROM `option` WHERE `quiz_id` = '".$_COOKIE['quiz_id']."' AND `question_id` = '".$rows[$i]['question_id']."' AND `attempt_number` = '0'";
                        }else{
                            $sql1 = "SELECT * FROM `option` WHERE `quiz_id` = '".$_REQUEST['quiz_id']."' AND `question_id` = '".$rows[$i]['question_id']."' AND `attempt_number` = '0'";
                        }
                        $stmt1 = $pdo1->query($sql1);
                        $row_count1 = $stmt1->rowCount();
                        $rows1 = $stmt1->fetchAll();

                        for($j = 0; $j < $row_count1; $j++){
                            echo "<p><mark>".$rows1[$j]['option_id'].". ".$rows1[$j]['option_description']."</mark></p>";
                        }


                        if($_COOKIE['staff'] === "1"){
                            echo '<p><button type="submit" class="header_button" onclick="" form="inner">Edit Now!</button></p>';


                            if(isset($_REQUEST['quiz_id'])){
                                echo "<input type='hidden' name='quiz_id' value='".$_REQUEST['quiz_id']."' form='delete'></input>";
                                echo "<input type='hidden' name='question_id' value='".$rows[$i]['question_id']."' form='delete'></input>";
                            }else{
                                echo "<input type='hidden' name='quiz_id' value='".$_COOKIE['quiz_id']."' form='delete'></input>";
                                echo "<input type='hidden' name='question_id' value='".$rows[$i]['question_id']."' form='delete'></input>";
                            }
                            echo '<p><button type="submit" class="header_button" onclick="" form="delete">Delete Question</button></p>';
                            // echo '</form>';
                        }
                    }

                    echo '<input type="hidden" form="outer" name="correct_answer_id_'.$i.'" value="'.$rows[$i]['correct_answer_id'].'"></input>';
                    echo '<input type="hidden" form="outer" name="correct_answer_'.$i.'" value="'.$rows[$i]['correct_answer'].'"></input>';
                    echo '<input type="hidden" form="outer" name="question_score_available_'.$i.'" value="'.$rows[$i]['question_score_available'].'"></input>';

                    echo '<p>Your Answer: (Enter Choice Number if it is a multiple choice, Short Answer otherwise.) <input name="option_selected_'.$i.'" form="outer"></input></p>';
                    echo '</div>';
                }

                
                // echo '</form>';
                echo '<div style="text-align:center;">';
                echo '
                <p><button type="submit" style="text-align:center" class="header_button" onclick="" form="outer">Submit Your Work</button></p>';
                echo '</div>';
                
                // echo "</form>";

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