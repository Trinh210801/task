<?php
header('Content-Type: text/html; charset=utf-8');
// Kết nối cơ sở dữ liệu
$conn = mysqli_connect('localhost', 'root','', 'data') or die ('Lỗi kết nối'); mysqli_set_charset($conn, "utf8");

// Dùng isset để kiểm tra Form
if(!isset($_POST['dangky']))
    {
    die('');
    }
// lấy dữ liệu từ file register
$username = addslashes($_POST['username']);
$password = addslashes($_POST['password']);
$email = addslashes($_POST['email']);
$phone = addslashes($_POST['phone']);

// kiểm tra người dùng nhập đủ thông tin ch 
if (!$username || !$password || !$email || !$phone)
    {
        echo "Vui lòng nhập đầy đủ thông tin. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }

// mã hóa mật khẩu 
 $password = md5($password);

// kiểm tra tên đăng nhập đã có người dùng chưa 
if (mysqli_num_rows(mysqli_query($conn,"
    SELECT username FROM user WHERE username='$username'")) > 0)
    {
    echo "Tên đăng nhập đã có người dùng! <a href='javascript: history.go(-1)'>Trở lại</a>";
    exit;
    }

// kiểm tra định dạng email
// $email = "asd/sdff@asdf.com"; 
// $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
// $email = (preg_match($regex, $email))? $email:"invalid email";
if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        echo "Email này không hợp lệ! <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }

// kiểm tra email ddã có người dùng chưa 
if (mysqli_num_rows(mysqli_query($conn,"
    SELECT email FROM user WHERE email='$email'")) > 0)
    {
        echo "Email đã có người dùng! <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }

// kiểm tra định dạng sdt
if (!preg_match("/(84|0[3|5|7|8|9])+([0-9]{8})\b/", $phone))
    {
        echo "Số điện thoại không hợp lệ! <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }

// lưu thông tin thành viên 
$addmember = mysqli_query($conn,"
    select into user (username,password,email,phone)
    values ('$username','$password','$email','$phone')
    ");

// 
if ($addmember)
    echo "Đăng ký thành công!. <a href='/'>Về trang chủ</a>";
else
    echo "Đăng kí không thành công!. <a href='register.php'>Thử lại</a>";

?>