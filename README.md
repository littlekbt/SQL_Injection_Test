# SQL_Injection_Test


### 1, EC2$B%m%0%$%s(B
$B$*9%$-$J%=%U%H$G%m%0%$%s$7$F$/$@$5$$!#(B

### 2, $B3F%_%I%k%&%'%"%$%s%9%H!<%k(B
```
sudo yum update -y
```

**Apache$B%$%s%9%H!<%k(B**
```
sudo yum -y install httpd
```

**PHP$B%$%s%9%H!<%k(B**
```
sudo yum install -y php php-devel php-mysql php-gd php-mbstring
```

**MySQL $B%$%s%9%H!<%k(B**
```
sudo yum localinstall https://dev.mysql.com/get/mysql80-community-release-el7-1.noarch.rpm -y
sudo yum-config-manager --disable mysql80-community
sudo yum-config-manager --enable mysql57-community
sudo yum install mysql-community-server -y
```

### 3, $B%U%!%$%k$r0\F0(B
/var/www/html/
$B$K!"0J2<$N%U%!%$%k$r@_CV$7$F$/$@$5$$!#(B
EC2$B$X$N%"%C%W%m!<%I$O$*9%$-$JJ}K!$G$*4j$$$7$^$9!#(B

index.html
```html
<html>
  <body>
    <form action=login.php method="POST">
      <div>
        <label>id</label>
        <input type="text" name="userid">
      </div>
      <div>
        <label>password</label>
        <input type="password" name="password">
      </div>
      <input type="submit" value="submit">
    </form>
  </body>
</html>
```

login.php
```php
<?php
$conn=mysqli_connect('127.0.0.1:3306','root','root');
mysqli_select_db($conn,'sqli_test');
$userid = $_POST['userid'];
$password = $_POST['password'];

$sql="SELECT user_id,password FROM users WHERE user_id='$userid' AND password='$password';";
$result=mysqli_query($conn,$sql);

if(mysqli_num_rows($result)!=0){
  # $B%m%0%$%s@.8y$7$?$i$3$A$i(B
  echo "login success";
}else{
$B!!(B# $B%m%0%$%s<:GT$7$?$i:G=i$N%Z!<%8$KLa$k(B
  $url = '/';
  header('Location: ' . $url, true, 301);
}
mysqli_close($conn);
exit;
?>
```

### 4, MySQL$B@_Dj(B
**$B5/F0(B**
```
sudo systemctl start mysqld.service
```
**password$B@_Dj(B**
```
// $B$3$N%3%^%s%I$G!"=i4|@_Dj$5$l$?%Q%9%o!<%I$rC5$7$^$9!#(B
sudo cat /var/log/mysqld.log | grep password


// $B%Q%9%o!<%I$r(Broot$B$KJQ99$7$^$9!#(B
// $B:G=i$N%3%^%s%I$G<hF@$7$?%Q%9%o!<%I$r;H$C$F%m%0%$%s(B
mysql -u root -p
SET GLOBAL validate_password_length=0;
SET GLOBAL validate_password_policy=LOW;
// $B%Q%9%o!<%I$r(Broot$B$KJQ99(B
set password for root@localhost=password('root');
```

**$B=i4|%G!<%?EjF~(B**
```
// MySQL$B%m%0%$%s(B
mysql -u root -p
```
DB$B:n@.(B & $B;HMQ(BDB$BJQ99(B
```
create database sqli_test;
use sqli_test;
 ```
$B%F!<%V%k:n@.(B
 ```
CREATE TABLE `users` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` varchar(50) NOT NULL,
`name` varchar(50) NOT NULL,
`password` varchar(50) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
```
$B%l%3!<%I:n@.(B
```
INSERT INTO `users` VALUES (1,'test','test_user','test_pass','2019-12-04 01:44:47','2019-12-04 01:44:47');
```

### 5, Apache $B5/F0(B
```
sudo httpd
```

### 6, $B%Z!<%8$K%"%/%;%9(B
EC2$B$N%0%m!<%P%k(BIP$B$K%"%/%;%9$7$F$_$F$/$@$5$$!#(B

