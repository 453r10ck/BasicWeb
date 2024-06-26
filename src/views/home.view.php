<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

        .card {
        background: white;
        text-decoration: none;
        color: #444;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        min-height: 100%;
        
        position: relative;
        top: 0;
        transition: all .1s ease-in;
            
        &:hover {
            top: -2px;
            box-shadow: 0 4px 5px rgba(0,0,0,0.2);
        }
        
        article {
            padding: 20px;
            flex: 1;
            
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        h1 {
            font-size: 20px;
            margin: 0;
            color: #333;
        }
        
        p {
            flex: 1;
            line-height: 1.4;
        }
        
        span {
            font-size: 12px;
            font-weight: bold;
            color: #999;
            text-transform: uppercase;
            letter-spacing: .05em;
            margin: 2em 0 0 0;
        }
        
        .thumb {
            padding-bottom: 60%;
            background-size: cover;
            background-position: center center;
        }
        }

        .item-1 {
        @media (min-width: 60em) {
            grid-column: 1 / span 2;
            
            h1 {
            font-size: 24px;
            }
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
                        <li class="nav-item"><a href="admin" class="nav-link">Admin panel</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a href="<?=PUBLIC_ROOT?>post/create" class="nav-link">Create post</a></li>
                    <li class="nav-item"><a href="<?=PUBLIC_ROOT?>user/profile/<?=$_SESSION['user_id']?>" class="nav-link"><strong><?=$_SESSION['username']?></strong></a></li>
                    <li class="nav-item"><a href="<?=PUBLIC_ROOT?>user/logout" class="nav-link">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <br>

    <!-- Search box -->
    <form action="<?=PUBLIC_ROOT?>home/search" method="POST" style="position: absolute; left: 235px">
        <input type="text" name="search" placeholder="search">
    </form>
    <br>

    <br>
    <header>
        <h1>All Articles</h1>
    </header> <br>
    <div class="band">
        <?php foreach($datas as $post): ?>
            <div class="item">
                <a href="<?=PUBLIC_ROOT?>post/detail/<?=$post['id']?>" class="card">
                <div class="thumb" style="background-image: url('<?=PUBLIC_ROOT?>images/post/<?=$post['image']?>')"></div>
                <article>
                    <h1><?=htmlspecialchars($post['title'])?></h1>    
                    <span><?=htmlspecialchars($post['author'])?></span>
                    <?php if ($post['published'] == 1): ?>
                        <span>Public</span>
                    <?php else: ?>
                        <span>Private</span>
                    <?php endif; ?>
                </article>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>