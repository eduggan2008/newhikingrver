<?php 
declare(strict_types = 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $description ?>">
    		
    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@300;400;500;600;700;800&family=Merriweather:wght@300;400;700;900&display=swap" rel="stylesheet">

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"> -->

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Fotorama from CDNJS, 19 KB -->
    <!-- <link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script> -->

    <!-- jQuery 1.8 or later, 33 KB -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Fotorama from CDNJS, 19 KB -->
        <link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
    

    <!-- Tiny MCE text editor for forms text areas -->
    <script src="https://cdn.tiny.cloud/1/libvcds9rw3ldflt31alukkzs2ua9o05u4ywdbavlxd3k2z8/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css" type="text/css">

    <title><?= $title ?></title>

</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">

        <div class="container-fluid">

        <a class="navbar-brand" href="index.php">Hiking RVer</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                
                <ul class="nav navbar-nav me-auto mb-2 mb-lg-0"><i class="hide"></i>   
    
                    <?php if ($session_id == 0) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>

                    <?php } else { ?>
                        <li class="nav-item"> 
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>

                        <?php if ($session_role == 'Admin') { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="admin/profile.php?id=<?= $session_id ?>"><?= $session_first_name ?></a>
                            </li>
                        <?php } elseif ($session_role == 'Member') { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="member/profile.php?id=<?= $session_id ?>"><?= $session_first_name ?></a>
                            </li>
                        <?php } ?>

                        <?php if ($session_role == 'Admin') { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="admin/index.php?id=<?= $session_id ?>">Admin</a>
                            </li>
                        <?php } ?>
                        
                    <?php } ?>
            
                
                </ul>
                
                    <ul class="nav navbar-nav me-auto mb-2 mb-lg-0"><i class="hide"></i>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                            <?php foreach ($navigation as $link) { ?>
                                <li class="nav-item">
                                    <a href="category.php?id=<?= $link['id'] ?>" class="nav-link">
                                        <?= ($section == $link['id']) ? "" : '' ?>
                                        <?= $link['name'] ?>
                                    </a>
                                </li>
                            <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link" href="search.php">
                                <span class="icon-search"></span><span class="search-text">Search</span>
                            </a>
                        </li>
                    </ul>
            
            </div>
        </div>
    </nav>  

    <br><br><br><br>

          

