<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self';object-src 'none'; style-src 'self'; script-src 'self'; img-src 'self'; base-uri 'none';">
    <title>Alex Blog</title>
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
        </div>
    </nav>
    <br>

    <br>
    <form action="<?=PUBLIC_ROOT?>admin/change_password/<?=$datas['id']?>" method="POST">
        <label for="password1">New password</label> <br>
        <input type="password" name="password1"> <br>

        <label for="password2">Confirm new password</label> <br>
        <input type="password" name="password2"> <br>

        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">

        <input type="submit" name="change" value="Change">
    </form>
</body>
</html>