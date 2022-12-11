<?php
    include("config.php");
    $full_url = mysqli_real_escape_string($conn, $_POST['full_url']);
    //check if url is valid and not empty
    if(!empty($full_url) && filter_var($full_url, FILTER_VALIDATE_URL)) {
        //generate 5 random characters
        $ran_url = substr(md5(microtime()), rand(0,26), 5);
        //check if short url already exists
        $sql = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = {$ran_url}");
        if(mysqli_num_rows($sql) > 0) {
            //if exists, generate new random characters
            echo "URL already exists. Please try again.";
            $ran_url = substr(md5(microtime()), rand(0,26), 5);
        }else{
            //if not exists, insert into database
            $sql2 = mysqli_query($conn, "INSERT INTO url (shorten_url, full_url, clicks) VALUES ('{$ran_url}', '{$full_url}', '0')");
            if($sql2) {
                echo "URL successfully shortened. Your short URL is: <a href='http://localhost/url-shortener/{$ran_url}'>http://localhost/url-shortener/{$ran_url}</a>";
            }else{
                echo "Something went wrong. Please try again.";
            }
        }
    } else {
        echo "$full_url is not a valid URL";
        exit();
    }
?>