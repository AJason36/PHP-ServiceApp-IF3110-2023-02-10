<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" sizes="180x180" href="<?= BASE_URL ?>/icon/favicon-110.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL ?>/icon/favicon-32.png">
    <!-- Global CSS -->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/styles/template/globals.css">
    <!-- Navbar CSS -->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/styles/template/navbar.css">
    <!-- Page-specific CSS -->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/styles/admin/list.css">
    <title>Delete User : <? echo $this->data['username'];?></title>
</head>

<body>
    <!-- Navigation bar -->
    <?php include(dirname(__DIR__) . '../../components/Navbar.php') ?>
    <div class="wrapper-small">
        <div class="pad-40">
            <h1>Delete User Page</h1>
            <div class="centered">
                <form  
                    class="center-contents"
                    action="/user/delete/<? echo $this->data['username']?>" method="POST" enctype="multipart/form-data"
                >
                    <p class="form-label">Username : <?
                        echo $this->data['username'];
                    ?></p>

                    <p class="form-label">Role : <?
                        echo $this->data['role'];
                    ?></p>


                    <input type="submit" class="button green-button" value="Delete">

                </form>
            </div>
        </div>
    </div>
</body>

</html>