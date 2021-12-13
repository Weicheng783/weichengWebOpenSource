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
            <div style="display: inline-flex;">
            <img src="./logo.png" id="logo" alt="Weicheng_Quiz_Welcome_Message" style=" text-align: left; border-radius:20px; display:inline-block; height:100px; width:auto;">
            </div>

            <p class="narrator" style="font-size: x-large; text-align: center;">Welcome to Weicheng Quiz Time</p>
            <p class="narrator" style="font-size: x-large; text-align: center; " id="ymd"></p>
            <div style="text-align: center;">

            <form action="index.php" method="post" style="text-align:center; display:center;">
              <p class="narrator"><button type="submit" class="header_button" onclick="">Refresh this page</button></p>
            </form>

            <!-- <button type="button" class="header_button" onclick="location.href='/phpmyadmin'">Php My Admin</button> -->
            <!-- </div> -->
                <!-- <form action="login.php" method="post" style="display:center;"> -->
                    <!-- <input type="hidden" name="res1" id="res1_id"/> -->
                    <!-- <input type="hidden" name="res2" id="res2_id"/> -->
                    <!-- <input type="input" name="flag" id="flagg_id"/> -->
                    <!-- <button type="submit" class="header_button" onclick="new_task()">New Task</button> -->
                    <!-- <button type="submit" class="header_button" onclick="">Post Now!</button> -->
                <!-- </form>
           </div> -->

            <!-- <div id="writingArea" style="text-align:center; border-style:solid; border-width:3px; border-radius:5px; padding:5px; margin:5px;">
                <form action="uploadtoDB.php" method="post" style="display:center;">
                    <p>Editor: <input name="editor"></input></p>
                    <p>Message: <textarea name="message" style="font-style:italic;"></textarea></p>
                    <p>Photos Address: <input name="photos"></input></p>
                    <p>Comments: <textarea name="comments"></textarea></p>
                    <p><button type="submit" class="header_button" onclick="upLoadtofileSystem();">Post Now!</button></p>
                </form>
            </div> -->

            <?php
                // TODO: We can also use session_start(); and $_SESSION['xxx'] to store values.
                if(!isset($_COOKIE['id'])){
                    echo '<div id="writingArea" style="text-align:center; border-style:dashed; border-width:3px; border-radius:5px; padding:5px; margin:5px;">';
                    echo "<p><strong>Please Login or Register to continue...</strong></p>";
                    echo "<p><strong>![Note]! We will use cookies to store your data for an hour for each login, only proceed and enable it if you agree with this.</strong></p>";
                    echo "<p>Submit the following form will automatically detect if you are registered. If you are unregistered then you will get registered.</p>";
                    echo '<form action="login.php" method="post" style="display:center;">
                            <p>User ID (Student/Staff ID): <input type="number" name="id"></input></p>
                            <p>User Name: <textarea name="name" style="font-style:bold;"></textarea></p>
                            <p>Staff (Put Y, y, yes, T, t, true or 1 if you are staff, put nothing or anything else if you are student): <input name="staff"></input></p>
                            <p>Password: <input type="password" name="password"></input></p>
                            <button type="submit" class="header_button" onclick="">Login / Registration</button>
                          </form>';
                    echo '</div>';
                }else{
                    echo '<div id="writingArea" style="text-align:center; border-style:dashed; border-width:3px; border-radius:5px; padding:5px; margin:5px;">';
                    echo "<p>You are logined as <strong>".$_COOKIE['name']."</strong>. Nice to see you.</p>";
                    if($_COOKIE['staff'] == 1){
                        $membership = "Staff";
                    }else{
                        $membership = "Student";
                    }
                    echo "<p>Your membership is classified as: <strong>".$membership."</strong></p>";
                    echo "<p>To do a quiz, please use the solid box below to navigate one.</p>";
                    // $_COOKIE = null;

                    // if($_COOKIE['staff'] == 1){
                    echo '<form action="create.php" method="post" style="display:center;">';
                    echo '<p><button type="submit" class="header_button" onclick="">Create New Quiz / Update Available Quiz / Take Quiz</button></p>';
                    echo '</form>';
                    // }

                    echo '<form action="reset.php" method="post" style="display:center;">';
                    echo '<p><button type="submit" class="header_button" onclick="">Log Out</button></p>';
                    echo '</form>';
                    echo '</div>';

                    echo '';
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
