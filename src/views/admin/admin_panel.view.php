<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self';object-src 'none'; style-src 'self'; script-src 'self'; img-src 'self'; base-uri 'none';">
    <title>Admin Panel</title>
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
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* CSS */
        .button {
        appearance: button;
        background-color: #000;
        background-image: none;
        border: 1px solid #000;
        border-radius: 4px;
        box-shadow: #fff 4px 4px 0 0,#000 4px 4px 0 1px;
        box-sizing: border-box;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        font-family: ITCAvantGardeStd-Bk,Arial,sans-serif;
        font-size: 14px;
        font-weight: 400;
        line-height: 20px;
        margin: 0 5px 10px 0;
        overflow: visible;
        padding: 12px 40px;
        text-align: center;
        text-transform: none;
        touch-action: manipulation;
        user-select: none;
        -webkit-user-select: none;
        vertical-align: middle;
        white-space: nowrap;
        }

        .button:focus {
        text-decoration: none;
        }

        .button:hover {
        text-decoration: none;
        }

        .button:active {
        box-shadow: rgba(0, 0, 0, .125) 0 3px 5px inset;
        outline: 0;
        }

        .button:not([disabled]):active {
        box-shadow: #fff 2px 2px 0 0, #000 2px 2px 0 1px;
        transform: translate(2px, 2px);
        }

        @media (min-width: 768px) {
        .button-50 {
            padding: 12px 50px;
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

    <div class="container">
        <!-- Search post -->
        <form class="app-content-actions" action="<?=PUBLIC_ROOT?>admin/search" method="POST">
            <input class="search-bar" name="searchUser" placeholder="Search user" type="text">
        </form>
        <br>
        
        <h2>User</h2>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($datas[1] as $user): ?>
                    <tr>
                        <td><?=htmlspecialchars($user['username'])?></td>
                        <td><?=$user['email']?></td>
                        <td><?=$user['phone']?></td>
                        <?php if ($user['role'] == 1): ?>
                            <td><strong>Admin</strong></td>
                        <?php else: ?>
                            <td>Author</td>
                        <?php endif; ?>
                        <td><a href="<?=PUBLIC_ROOT?>admin/edit_user/<?=$user['id']?>">Edit</a> | 
                        <a href="<?=PUBLIC_ROOT?>user/delete/<?=$user['id']?>">Delete</a> | 
                        <a href="<?=PUBLIC_ROOT?>admin/change_password/<?=$user['id']?>">Change password</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <br>
        <form class="app-content-actions" method="POST" action="<?=PUBLIC_ROOT?>admin/search">
            <input class="search-bar" name="searchPost" placeholder="Search post" type="text">
        </form> <br>
        <h2>Post</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datas[0] as $post): ?>
                    <tr>
                        <td><?=htmlspecialchars($post['title'])?></td>
                        <td><?=htmlspecialchars($post['author'])?></td>
                        <?php if ($post['published'] == 1): ?>
                            <td>Public</td>
                        <?php else: ?>
                            <td>Private</td>
                        <?php endif; ?>
                        <td><a href="<?=PUBLIC_ROOT?>post/edit/<?=$post['id']?>">Edit</a> | 
                        <a href="<?=PUBLIC_ROOT?>post/delete/<?=$post['id']?>">Delete</a> |
                        <a href="<?=PUBLIC_ROOT?>post/detail/<?=$post['id']?>">Detail</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
                
        <br>
        <button class="button"><a style="color: #ffffff" href="<?=PUBLIC_ROOT?>post/create">Add post</a></button>
        <button class="button"><a style="color: #ffffff" href="<?=PUBLIC_ROOT?>admin/addUser">Add user</a></button>
    </div>
</body>
</html>