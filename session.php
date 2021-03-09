<?php

session_set_cookie_params(60*60, "/");
session_start();

if(@!isset($_COOKIE['PHPSESSID'])){
    header("Location: login.php?expired=true");
    #not logged in. return to login form
}
