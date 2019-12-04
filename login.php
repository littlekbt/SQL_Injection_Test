<?php

$conn=mysqli_connect('127.0.0.1:3307','root','');
mysqli_select_db($conn,'sqli_test');

$userid = $_POST['userid'];
$password = $_POST['password'];

$sql="SELECT user_id,password FROM users WHERE user_id='$userid' AND password='$password';";
$result=mysqli_query($conn,$sql);

if(mysqli_num_rows($result)!=0){
  echo "login success";
}else{
  $url = 'http://localhost';
  header('Location: ' . $url, true, 301);
}
mysqli_close($conn);
exit;
?>
