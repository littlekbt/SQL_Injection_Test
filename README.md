# SQL_Injection_Test


### 1, EC2ログイン
お好きなソフトでログインしてください。

### 2, 各ミドルウェアインストール
```
sudo yum update -y
```

**Apacheインストール**
```
sudo yum -y install httpd
```

**PHPインストール**
```
sudo yum install -y php php-devel php-mysql php-gd php-mbstring
```

**MySQL インストール**
```
sudo yum localinstall https://dev.mysql.com/get/mysql80-community-release-el7-1.noarch.rpm -y
sudo yum-config-manager --disable mysql80-community
sudo yum-config-manager --enable mysql57-community
sudo yum install mysql-community-server -y
```

### 3, ファイルを移動
/var/www/html/
に、以下のファイルを設置してください。
EC2へのアップロードはお好きな方法でお願いします。

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
  # ログイン成功したらこちら
  echo "login success";
}else{
　# ログイン失敗したら最初のページに戻る
  $url = '/';
  header('Location: ' . $url, true, 301);
}
mysqli_close($conn);
exit;
?>
```

### 4, MySQL設定
**起動**
```
sudo systemctl start mysqld.service
```
**password設定**
```
// このコマンドで、初期設定されたパスワードを探します。
sudo cat /var/log/mysqld.log | grep password


// パスワードをrootに変更します。
// 最初のコマンドで取得したパスワードを使ってログイン
mysql -u root -p
SET GLOBAL validate_password_length=0;
SET GLOBAL validate_password_policy=LOW;
// パスワードをrootに変更
set password for root@localhost=password('root');
```

**初期データ投入**
```
// MySQLログイン
mysql -u root -p
```
DB作成 & 使用DB変更
```
create database sqli_test;
use sqli_test;
 ```
テーブル作成
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
レコード作成
```
INSERT INTO `users` VALUES (1,'test','test_user','test_pass','2019-12-04 01:44:47','2019-12-04 01:44:47');
```

### 5, Apache 起動
```
sudo httpd
```

### 6, ページにアクセス
EC2のグローバルIPにアクセスしてみてください。

