

    <h1>Создание новой страницы</h1><hr>

    <form method="POST" id="formx" action="javascript:void(null);" onsubmit="create_new_note()">

        <div class="form-group">
            <input name="name" class="form-control" placeholder="Название">
        </div>

        <textarea class="form-control" rows="20" name="content"></textarea>
        <br>
        <input class="btn btn-success" type="submit" value="Добавить страницу"/>
    </form>