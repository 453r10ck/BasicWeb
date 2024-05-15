<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Post</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Lato", sans-serif;
            background: #f2f2f2;
        }

        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1000;
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
        }

        .logo a {
            text-decoration: none;
            font-size: 1.5rem;
            color: #333;
        }

        .nav-menu {
            display: flex;
            list-style: none;
        }

        .nav-item {
            margin-left: 20px;
        }

        .nav-link {
            text-decoration: none;
            color: #333;
            font-size: 1rem;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: #007bff;
        }

        .menu-toggle {
            display: none;
            flex-direction: column;
            gap: 4px;
            cursor: pointer;
        }

        .bar {
            width: 25px;
            height: 2px;
            background-color: #333;
        }

        .nav-menu.active {
            display: flex;
        }

        header {
        width: 90%;
        max-width: 1240px;
        margin: 0 auto;
        }
        .band {
            width: 90%;
            max-width: 1240px;
            margin: 0 auto;
            
            display: grid;
            
            grid-template-columns: 1fr;
            grid-template-rows: auto;
            grid-gap: 20px;
            
            @media (min-width: 30em) {
                grid-template-columns: 1fr 1fr;
            }
            
            @media (min-width: 60em) {
                grid-template-columns: repeat(4, 1fr);
            }
        }
        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
            border-radius: 10px;
        }

    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">
                <a href="<?=PUBLIC_ROOT?>">Alex Blog</a>
            </div>
            <ul class="nav-menu" id="nav-menu">
                <li class="nav-item"><a href="<?=PUBLIC_ROOT?>" class="nav-link">Home</a></li>
                <?php if(!isset($_SESSION['user_id'])): ?> 
                    <li class="nav-item"><a href="<?=PUBLIC_ROOT?>login" class="nav-link">Login</a></li>
                <?php else: ?>
                    <?php if ($_SESSION['role'] == 1): ?>
                        <li class="nav-item"><a href="<?=PUBLIC_ROOT?>admin" class="nav-link">Admin panel</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a href="<?=PUBLIC_ROOT?>post/create" class="nav-link">Create post</a></li>
                    <li class="nav-item"><a href="<?=PUBLIC_ROOT?>user/profile/<?=$_SESSION['user_id']?>" class="nav-link"><strong><?=$_SESSION['username']?></strong></a></li>
                    <li class="nav-item"><a href="<?=PUBLIC_ROOT?>user/logout" class="nav-link">Logout</a></li>
                <?php endif; ?>
            </ul>
            <div class="menu-toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>

    <div class="w3-content" style="max-width:2000px;margin-top:46px">
        <!-- The Band Section -->
        <div class="w3-container w3-content w3-center w3-padding-64" style="max-width:800px" id="band">
            <h2 class="w3-wide"><?=htmlspecialchars($datas['title'])?></h2>
            <p class="w3-opacity"><i><?=htmlspecialchars($datas['created_at'])?></i></p>
            <br>
            <img src="/images/post/<?=$datas['image']?>" alt="">
            <br>
            <p class="w3-justify"><?=nl2br(htmlspecialchars($datas['content']))?></p>
        </div>

        <!-- End Page Content -->
        <?php if ($datas['isAuthor'] === true): ?>
            <button style="position: absolute;left: 470px"><a href="<?=PUBLIC_ROOT?>post/edit/<?=$datas['id']?>">Edit</a></button>
            <button style="position: absolute;left: 510px"><a href="<?=PUBLIC_ROOT?>post/delete/<?=$datas['id']?>">Delete</a></button>
        <?php endif; ?>
    </div>
</div>
</body>
</html>