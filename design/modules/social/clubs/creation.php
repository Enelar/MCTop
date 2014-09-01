
    <h1>Создание клуба</h1><hr>

    <form method="POST" id="formx" action="javascript:void(null);" onsubmit="club_create()">

        <div class="form-group">
            <input name="name" class="form-control" placeholder="Название">
        </div>

        <textarea class="form-control" rows="3" name="description" placeholder="Описание"></textarea>
        <hr>

        <h3>Приватность</h3>
        <div class="radio">
            <label>
                <input type="radio" name="access_privacy" value="private_club" checked>
                Приватный клуб (не виден в списке клубов)
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="access_privacy" value="public_closed_club">
                Публичный <b>закрытый</b> клуб
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="access_privacy" value="public_club">
                Публичный клуб
            </label>
        </div>
        <hr>

        <input class="btn btn-success" type="submit" value="Зарегистрировать клуб"/>
    </form>