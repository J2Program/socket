<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bootstrap Example</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script -->
    </head>
    <body>

        <?php
        session_start();

        require './db/users.php';

        $objUser = new users();
        $users = $objUser->getAllUsers();




        foreach ($users as $row => $value) {
            echo $value['name'] . ' | ' . $value['login_status'] . '</br>';
            echo '';
        }
        ?>

        <script>

            $(document).ready(function () {

                var conn = new WebSocket('ws://localhost:8085');
                conn.onopen = function (e) {
                    console.log("Connection established!");
                };

                conn.onmessage = function (e) {
                    console.log(e.data);
                    var newData = JSON.parse(e.data);
                    console.log(newData);

                    document.title = newData.dt;
                };

                function subscribe(channel) {
                    conn.send(JSON.stringify({command: "subscribe", channel: channel}));
                }

                $('#send').click(function () {
                    var msg = 'Panni';
                    var data = {userId: 7, msg: msg}

                    conn.send(JSON.stringify(data));
                });

            });



        </script>

        <button id="send">Send</button>

    </body>
</html>


