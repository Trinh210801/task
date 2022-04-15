<?php
//Khai báo sử dụng session
session_start();
 
//Khai báo utf-8 để hiển thị được tiếng việt
header('Content-Type: text/html; charset=UTF-8');
 
//Xử lý đăng nhập
if (isset($_POST['dangnhap'])) 
{
    //Kết nối tới database
    $conn = mysqli_connect('localhost', 'root','', 'data') or die ('Lỗi kết nối'); mysqli_set_charset($conn, "utf8");
     
    //Lấy dữ liệu nhập vào
    $username = addslashes($_POST['username']);
    $password = addslashes($_POST['password']);
     
    //Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
    if (!$username || !$password) {
        echo "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }
     
    // mã hóa pasword
    $password = md5($password);
     
    //Kiểm tra tên đăng nhập có tồn tại không
    $query = mysqli_query($connect, "
        SELECT username,password FROM information_user WHERE username='$username'
        ");
    if (mysqli_num_rows($query) == 0) {
        echo "Tên đăng nhập này không tồn tại! <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }
     
    //Lấy mật khẩu trong database ra
    $row = mysqli_fetch_array($query);
     
    //So sánh 2 mật khẩu có trùng khớp hay không
    if ($password != $row['password']) {
        echo "Mật khẩu không đúng! <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }
     
    //Lưu tên đăng nhập
    $_SESSION['username'] = $username;
    echo "Xin chào " . $username . ". Bạn đã đăng nhập thành công. <a href='/'>Về trang chủ</a>";
    die();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <form action='login.php' method='POST'>
        <label> Username : </label>
                    <input type="text" name="username" size="50" />
                    <br></br>
                    <label> Password : </label>
                    <input type="text" name="password" size="50" />
                    <br></br>
        <input type='submit' name="dangnhap" value='Đăng nhập' />
        <a href='register.php' title='Đăng ký'>Đăng ký</a>
        </form>
    </body>
</html>
