<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bootstrap Example</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>

        <div class="container">

            <?php
            error_reporting(E_ALL);
            ini_set('display_errors', TRUE);
            ini_set('display_startup_errors', TRUE);



            if (isset($_POST['join'])) {
                session_start();
                require './db/users.php';
                $objUser = new users();
                $objUser->setName($_POST['username']);
                $objUser->setEmail($_POST['email']);
                $objUser->setLoginStatus(1);
                $objUser->setLastLogin(date('Y-m-d h:i:s'));

                $userData = $objUser->getUserByEmail();

                if (is_array($userData) && count($userData) > 0) {
                    $objUser->setId($userData['id']);
                    if ($objUser->updateLoginstatus()) {
                        echo "user login..";
                        $_SESSION['user'] = $userData;
                        header("location: chatroom.php");
                    } else {
                        echo "failed to login..";
                    }
                } else {

                    if ($objUser->save()) {
                        $lastId = $objUser->getDbConn()->lastInsertId();
                        $objUser->setId($lastId);
                        $_SESSION['user'] = (array) $objUser;
                        header("location: chatroom.php");
                        echo 'Regiterd ' . $lastId;
                    } else {
                        echo 'fail';
                    }
                }
                
                
            }
            ?>


            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Username:</label>
                    <input type="text" name="username" class="form-control" id="name">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" class="form-control" id="email">
                </div>

                <button type="submit" name="join" class="btn btn-default">Submit</button>
            </form>


        </div>

    </body>
</html>
