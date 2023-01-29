<?php

    session_start();

   // php_errormsg;

   if (isset($_POST['upload'])) {
       if (isset($_SESSION['upload_count'])) {
           $php_errormsg = 'Вы уже загрузили фото';
       } else {
           try {
               if (($_FILES['photo']['type'] === 'image/jpg' || $_FILES['photo']['type'] === 'image/png')
                   && $_FILES['photo']['size'] < 2005000) {
                   if (! file_exists('storage')) {
                       mkdir('images');
                   }

                   $fileAddress = './images' . $_FILES['photo']['name'];
                   move_uploaded_file($_FILES['photo']['tmp_name'], $fileAddress);
                   $_SESSION['upload_count'] = 1;
                   header('Location: ' . $fileAddress);
                   exit;

               } else {

                   $php_errormsg = 'Допускается загрузка только JPG/PNG файлов размером не более 2Mb';
               }
           } catch (Exception $exception) {
               echo $exception->getMessage();
           }
       }
   }

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание нового поста - Telegraph</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <?php
    if (isset($php_errormsg)){
        echo "<div class='alert alert-danger' role='alert'>{$php_errormsg}</div>";
    }
    ?>
    <form method="POST" action="send_photo.php" enctype="multipart/form-data">
        <div class="mb-4">
            <input type="hidden" name="upload" value="load" class="form-control" required>
        </div>
        <div class="mb-4">
            <label for="formFile" class="form-label">Выберете изображение
                <input type="file" name="photo" id="formFile" class="form-control">
            </label>
        </div>
        <div class="mb-4">
            <button type="submit" class="btn btn-primary">Отправить</button>
        </div>
    </form>
</div>
</body>
</html>
