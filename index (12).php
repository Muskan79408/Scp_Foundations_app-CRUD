<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCP Foundations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 20px;
            font-family: Comic, cursive;
        }
        .navbar {
            background-color: #800080;
        }
        .navbar-brand {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .navbar-nav .nav-link {
            font-size: 1.1rem;
        }
        .container {
            max-width: 800px;
        }
        .scp-details {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        .btn {
            margin-right: 5px;
            border-radius: 10px;
            background color: #253342;
        }
    </style>
</head>
<body>
    <?php include "connection.php"; ?>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <style>
                .container{
                    background color: #CBD6E2;
                }
            </style>
            <a class="navbar-brand" href="#">SCP Foundations</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <!-- using php loop through database and retrieve item values -->
                    <?php foreach($Result as $link): ?>
                    <li>
                        <a href="index.php?link='<?php echo $link['item']; ?>'" class="nav-link text-light"><?php echo $link['item']; ?></a>
                    </li>
                    <?php endforeach; ?>
                    <li class="nav-item active">
                        <a href="create.php" class="nav-link text-light">Create New SCP Record</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mt-4">SCP Foundations Details</h1>
                <?php
                // Display SCP record based on link clicked from the menu above
                // Enable error reporting
                error_reporting(E_ALL);
                // Display errors
                ini_set('display_errors', 1);

                if(isset($_GET['link'])) {
                    // remove single quotes from returned get value
                    // value to trim, character to trim out
                    $item = trim($_GET['link'], "'");
                    // prepared statement
                    $statement = $connection->prepare("select * from scp_foundations_app where item = ?");
                    if(!$statement) {
                        echo "<p>Error in preparing sql statement</p>";
                        exit;
                    }
                    // bind parameters takes 2 arguments the type of data and the var to bind to.
                    $statement->bind_param("s", $item);

                    if($statement->execute()) {
                        $get_result = $statement->get_result();
                        // check if record has been retrieved
                        if($get_result->num_rows > 0) {
                            $array = array_map('htmlspecialchars', $get_result->fetch_assoc());
                            $update = "update.php?update=" . $array['id'];
                            $delete = "index.php?delete=" . $array['id'];
                            echo "
                                <h2 class='display-2'>{$array['item']}</h2>
                                <h3 class='display-3'>{$array['class']}</h3>";

                            if(!empty($array['image'])) {
                                echo "
                                <p class='text-center'><img src='{$array['image']}' alt='{$array['item']}' class='img-fluid'></p>
                                ";
                            }

                            echo "
                                <h3>Containment</h3>
                                <p>{$array['containment']}</p>
                                <h3>Description</h3>
                                <p>{$array['description']}</p>
                                <p><a href='{$update}' class='btn btn-dark'>Update Record</a> &nbsp;
                                <a href='{$delete}' class='btn btn-danger'>Delete Record</a>
                                <p>";
                        } else {
                            echo "<p>No record found for model: {$array['model']}</p>";
                        }
                    } else {
                        echo "<p>Error executing statement.</p>";
                    }
                } else {
                    // this will display the first time a user visits the site
                    echo "
                        <h3 class='display-3'>Please use the menu to navigate this web application.</h3>
                    ";
                }

                // Delete functionality
                if(isset($_GET['delete'])) {
                    $deleteID = $_GET['delete'];
                    $delete_query = $connection->prepare("delete from kenworth where id = ?");
                    $delete_query->bind_param("i", $deleteID);

                    if($delete_query->execute()) {
                        echo "<div class='alert alert-danger'>Recorded Deleted...</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error: {$delete_query->error}</div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
