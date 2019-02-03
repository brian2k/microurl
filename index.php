<?php

require 'config.php';
require 'crypto_token.php';

$conn = new mysqli($servername, $username, $password, $dbname);
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$pure_url = explode('?', $actual_link);

$maxi_url = filter_input(INPUT_POST, 'url');
$micro_url = filteR_input(INPUT_GET,'u');

// GENERATE RANDOM NUMBER FOR BACKGROUND-IMAGE
$count_files = count(scandir('bg')) - 3;
$rand_image = rand(0,$count_files);

// REDIRECT TO URL IF THERE IS A VALUE IN 'U'
if($micro_url  && substr($actual_link, -1) != '-'){
//    $micro_url = substr_replace($micro_url ,"",-1);

    // LOOK IF THERE IS ANY URL WITH THAT TOKEN
    $result = $conn->query("SELECT id, micro_url, maxi_url, count FROM microURL WHERE micro_url LIKE '" . $micro_url . "'");
    $row = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        
        // FIRST ADD A CLICK TO THE COUNTER BY UPDrATING THE ROW
        $conn->query("UPDATE microURL SET count = '" . ++$row['count']. "' WHERE id = '" . $row['id'] . "'");
        // REDIRECT TO URL
        $redirect_url = $row['maxi_url'];
        header("Location: " . $redirect_url);
        
        $conn->close();    
    }
    else{
        echo "url not found!";
    }
} else {
    

// START HEADER TO GET THE MESSAGES INSIDE THE BODY PART TO STYLE WITH CSS
?>

<html>
<head>
    <title>microURL - Open Source</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <meta name="viewport" content="user-scalable=no" />
</head>
<body style="background: url(bg/bg_<?php echo $rand_image ?>.jpg) no-repeat center center fixed;   background-size: cover;">
    <div class="wrapper">
        <div class="welcome"><span>URL micromizer</span></div>
        <div class="form">
            <form action="index.php" method="post">
                <input type="text" class="url" name="url" value="<?php echo $maxi_url  ?>" placeholder="Paste your URL here">
                <span class="hidden-xs">
                    <button type="submit" name="submit">micromize me</button>
                </span>
        <!--        <input type="checkbox" name="expire" value="1" checked>
                <label for="expire">expire after 30 days</label>-->

                <div class="visible-xs">
                    <button type="submit" name="submit">micromize me</button>
                </div>

            </form>     
        </div>
        <div class="messages">
            
            
<?php
            // FIRST GET RID OF THE LAST CHARACTER
            $micro_url = substr_replace($micro_url ,"",-1);

            // LOOK IF THERE IS ANY URL WITH THAT TOKEN
            $result = $conn->query("SELECT id, micro_url, maxi_url, count, date FROM microURL WHERE micro_url LIKE '" . $micro_url . "'");
            $row = $result->fetch_assoc();

            if ($result->num_rows > 0) {
                
                
            echo "<span class='stats'><p class='caption'>statistics:</p>" 
                . date("d.m.Y H:i:s",strtotime($row['date']));
            
                echo "<p class='subs'>your URL from:</p><p class='maxi_url'>" . $row['maxi_url'] . "</p>";
            
                echo "<p class='subs'>shortcode:</p><a href='" . $pure_url[0] . "?u=" . $row['micro_url'] . "'>" . $pure_url[0] . "?u=" . $row['micro_url'] . "</a>";

                if(!(int) $row['count']){
                    echo "<p class='subs'>Sorry! No clicks yet..</p></span>";
                }
                else{
                    echo "<p class='subs'>" . (int) $row['count'] .  " clicks</p></span>";
                }
            }        
        }

            if($_POST)
            {


                // GENERATE MICROURL

                if (filter_var($_POST['url'], FILTER_VALIDATE_URL)) {

                    // VARIABLES        
                    $maxi_url = $_POST['url'];                


                    // CONNECT TO DATABASE        
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    } 
                    else{        
                        $micro_url = getToken(6);   // CREATE UNIQUE MICRO-URL
//                        $expire = $_POST['expire'];
                        //  INSERT INTO TABLE
            //            $sql = "INSERT INTO microURL (maxi_url, micro_url, exp) VALUES ('" . $maxi_url . "', '" . $micro_url . "', '" . $expire ."')";
                        $sql = "INSERT INTO microURL (maxi_url, micro_url) VALUES ('" . $maxi_url . "', '" . $micro_url . "')";

                        if ($conn->query($sql) === TRUE) {
                            echo "<span>your URL:&nbsp;<a href='" . $pure_url[0] . "?u=" . $micro_url . "' class'micro_url'>" . $pure_url[0] . "?u=" . $micro_url . "</a></span>";
                        } else {
                            echo "error: " . $conn->error;
                        }

                        $conn->close();
                    }
                }
                else{
                    echo "no valid url";
                }

            }
            ?>

        </div>    
    </div>
</body>
</html>
