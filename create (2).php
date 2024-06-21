<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>scp foundations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body class="container">
      <?php
      
            include "connection.php";
            
            if(isset($_POST['submit']))
            {
                // write a prepared statement to insert data
                $insert = $connection->prepare("insert into scp(item, class, containment, image, description) values(?,?,?,?,?)");
                $insert->bind_param("ssss", $_POST['item'], $_POST['class'], $_POST['containment'], $_POST['image'],  $_POST['description']);
                
                if($insert->execute())
                {
                    echo "
                        <div class='alert alert-success p-3 m-3'>Record successfully created</div>
                    ";
                }
                else
                {
                    echo "
                    <div class='alert alert-danger p-3 m-3'>Error: {$insert->error}</div>
                    ";
                }
            }
      
      ?>
    <h1>Create a new record.</h1>
    <p><a href="index.php" class="btn btn-dark">Back to index page.</a></p>
    <div class="p-3 bg-light border shadow">
        <form method="post" action="create.php" class="form-group">
            <label>item:</label>
            <br>
            <input type="text" name="item" placeholder="item..." class="form-control" required>
            <br><br>
            <label>Enter class:</label>
            <br>
            <input type="text" name="class" placeholder="class..." class="form-control">
            <br><br>
            <label>Enter Containment:</label>
            <br>
            <textarea name="containment" class="form-control">Enter content:</textarea>
            <br><br>
            <label>Enter image:</label>
            <br>
            <input type="text" name="image" placeholder="images/nameofimage.png..." class="form-control">
            <br><br>
            <label>Enter description:</label>
            <br>
            <textarea name="description" class="form-control">Enter description:</textarea>
            <br><br>