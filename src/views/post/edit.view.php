<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit post</title>
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
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
                    <li class="nav-item"><a href="<?=PUBLIC_ROOT?>user/profile" class="nav-link"><strong><?=$_SESSION['username']?></strong></a></li>
                <?php endif; ?>
            </ul>
            <div class="menu-toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Form -->
        <form action="<?=PUBLIC_ROOT?>post/edit/<?=$datas['id']?>" method="POST">
            <label for="title">Title</label> <br>
            <input type="text" name="title" id="title" value="<?=$datas['title']?>"> <br>

            <label for="content">Content</label> <br>
            <textarea name="content" id="content" cols="155" rows="30"><?=$datas['content']?></textarea> <br>

            <label for="public"></label>
            <select name="published">
                <option value="1">Public</option>
                <option value="0">Private</option>
            </select>
            <br>

            Change cover image
            <input type="file" name="imageToEdit"><br>

            <input type="submit" name="submit" value="Edit">
        </form>
    </div>
</body>
</html>