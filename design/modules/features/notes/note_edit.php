
    <?php
        $note = new Notes('get_one:note_by_id:'.$_GET['id'].':from_user:'.Core::get_current_user_profile()->id);
        $note = $note->storage;
        $id = 'user:'.Core::get_current_user_profile()->id.':notes:'.$_GET['id'];
    ?>

    <h1>Изменения содержания страницы</h1> <hr>
    <a class="btn btn-danger" onclick="note_delete('<?php echo $_GET['id'];?>', '<?php echo Core::get_current_user_profile()->id?>')">Удалить</a> <hr>

    <form method="POST" id="formx" action="javascript:void(null);" onsubmit="edit_note('<?php echo $id?>')">

        <div class="form-group">
            <input name="name" class="form-control" value="<?php echo $note['name']?>">
        </div>

        <textarea class="form-control" rows="10" name="content"><?php echo $note['content']?></textarea>
        <br>
        <input class="btn btn-success" type="submit" value="Переписать"/>
    </form>