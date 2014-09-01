
    <?php
        $notes = new Notes('get_all:notes_from_user:'.Core::get_current_user_profile()->id);
    ?>

    <h1> <span class="glyphicon glyphicon-book"></span> Ежедневник</h1>
    <hr>

    <div class="notes">

        <a class="btn btn-primary" onclick="display_page('features','notes/new_book')">Новая книга</a>
        <a class="btn btn-success" onclick="display_page('features','notes/note_create_new')">Новая страница</a>
        <hr>

        <?php if(empty($notes)):?>
            У тебя еще нет заметок. <hr>
            <a class="btn btn-success" href="">Создать</a>
        <?php endif;?>

        <?php
            if(!empty($notes))
                foreach($notes->storage as $redis_key => $note)
                {
                    if(sizeof($note)>0)
                        require('note.php');
                }
        ?>

    </div>