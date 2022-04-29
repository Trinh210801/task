<?php

include('upload.html');
 //Thư mục bạn sẽ lưu file upload
 $uploaddir    = "uploads/";
 //Vị trí file lưu tạm trong server (file sẽ lưu trong uploads, với tên giống tên ban đầu)
 $uploadfile   = $uploaddir. basename($_FILES["fileupload"]["name"]);
 $allowUpload   = true;
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

  // Kiểm tra file php
//   $blacklist = array(".php", ".phtml");
//   foreach ($blacklist as $item) {
//   if(preg_match("/$item\$/i", $_FILES["fileupload"]["name"])) {
//       echo "Không upload file PHP";
//       $allowUpload = false ;
//   }
// }

  // Kiểm tra file ảnh 
  // $fileType = $_FILES["fileupload"]["tmp_name"];
  // $allowedfileExtensions = array("image/jpg","image/jpeg","image/png","image/gif");
  // if (in_array($fileType,$allowedfileExtensions)){
  //   echo "Đây là file ảnh";
  //   $allowUpload = true;
  // }
  // else {
  //   echo "Chỉ upload file ảnh";
  //   $allowUpload = false ;
  // }

  //kiểm tra file ảnh 
  //lấy phần mở rộng file image (jpg, png ,..)
  
    // kiểm tra kiểu file
    $file_ext = explode(".",($_FILES["fileupload"]["name"]));
    $file_actualext = strtolower(end($file_ext));
    $allowed = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($file_actualext, $allowed))
      {
        echo "Chỉ được upload các định dạng JPG, PNG, JPEG, GIF <br>";
        $allowUpload = false;
      }
    

  // Đã có dữ liệu upload, thực hiện xử lý file upload

  // Kiểm tra nếu file đã tồn tại thì không cho phép ghi đè
    if (file_exists($uploadfile)) 
    {
      echo "<b>Tên file đã tồn tại, không được ghi đè</b>";
      $allowUpload = false;
      exit ;
    }

     // Kiểm tra kích thước file upload cho vượt quá giới hạn cho phép
     
   // Cỡ lớn nhất được upload (bytes)
    $maxfilesize   = 1000; 
    if ($_FILES["fileupload"]["size"] > $maxfilesize)
    {
      echo "Không được upload ảnh lớn hơn $maxfilesize (bytes).";
      $allowUpload = false;
    }


    if ($allowUpload) 
    {
      
         // Xử lý di chuyển file tạm ra thư mục cần lưu trữ, dùng hàm move_uploaded_file
      if(move_uploaded_file($_FILES["fileupload"]["tmp_name"], $uploadfile))
      {
          echo "File uploaded <br>";
          echo "File lưu tại " . $uploadfile;

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