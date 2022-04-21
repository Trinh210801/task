<?php

include('upload.html');

// nếu người dùng có chọn file để upload 
if (isset($_POST["uploadclick"]))
{
  // Kiểm tra có dữ liệu fileupload trong $_FILES không
  // Nếu không có thì dừng
    if (!isset($_FILES["fileupload"])) 
    {
      echo "File không đúng cấu trúc" ;
      die;
    }
  // Kiểm tra dữ liệu có bị lỗi không
    if ($_FILES["fileupload"]["error"] > 0)
      {
        echo "File upload bị lỗi";
        die;
      }

  // Đã có dữ liệu upload, thực hiện xử lý file upload

  //Thư mục bạn sẽ lưu file upload
    $target_dir    = "uploads/";
  //Vị trí file lưu tạm trong server (file sẽ lưu trong uploads, với tên giống tên ban đầu)
    $target_file   = $target_dir . basename($_FILES["fileupload"]["name"]);

    $allowUpload   = true;

  // Cỡ lớn nhất được upload (bytes)
    $maxfilesize   = 800000; 

  // Kiểm tra nếu file đã tồn tại thì không cho phép ghi đè
    if (file_exists($target_file)) 
    {
      echo "Tên file đã tồn tại, không được ghi đè";
      $allowUpload = false;
    }
  // Kiểm tra kích thước file upload cho vượt quá giới hạn cho phép
    if ($_FILES["fileupload"]["size"] > $maxfilesize)
    {
      echo "Không được upload file lớn hơn $maxfilesize (bytes).";
      $allowUpload = false;
    }
  
    if ($allowUpload) 
    {
      // Xử lý di chuyển file tạm ra thư mục cần lưu trữ, dùng hàm move_uploaded_file
      if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file))
      {
          echo "File uploaded <br>";
          echo "File lưu tại " . $target_file;

      }
        else
      {
          echo "Có lỗi xảy ra khi upload file.";
      }
    }
    }
  else
      {
        echo "Bạn chưa chọn file upload";
      }

?>