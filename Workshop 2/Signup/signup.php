<?php
require('functions.php');

if($_POST && $_REQUEST['firstName']) {
  //get each field and insert to the database
  $user['firstName'] = $_REQUEST['firstName'];
  $user['lastName'] = $_REQUEST['lastName'];
  $user['email'] = $_REQUEST['email'];
  $user['province_id'] = $_REQUEST['province'];
  $user['password'] = $_REQUEST['password'];
  if (saveUser($user)) {
    header("/Signup/index.php");
  }

}