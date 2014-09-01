
    <h1>Люди</h1><hr>

    <?php
        $users = new User(Core::$db);
        $users->get_all();
    var_dump($users);
    ?>