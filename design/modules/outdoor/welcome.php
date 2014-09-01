<h1>Добро пожаловать на Vay!</h1><hr>

<div class="welcome_slogan">
    <h3>
        <?php

        $button_text = [];
        $button_text[] = 'Хочу еще!';
        $button_text[] = 'Попытать счастье!';
        $button_text[] = 'Новая фраза!';
        $button_text[] = 'Скажи еще!';
        $button_text[] = 'Генератор настроения';
        $current_text = $button_text[rand(0, sizeof($button_text)-1)];

        $phrases = [];
        $phrases[] = 'Vay - Интернет в одном флаконе';
        $phrases[] = 'Vay - Вместо тысячи слов';
        $phrases[] = 'Найди себя. В Vay';
        $phrases[] = 'Мы будем вместе. Vay';
        $phrases[] = 'Vay. Мы вам рады :)';
        $phrases[] = 'Vay - это просто';
        $phrases[] = 'Vay. Из Ростова Великого';
        $phrases[] = 'Vay - для взрослых и детей';
        $phrases[] = 'Vay - читается как "вэй"';
        $phrases[] = 'Vay - с турецкого: "Вот это да!"';
        $phrases[] = 'Vay! Вы вернулись!';
        $phrases[] = 'Vay - за Мир во всем Мире!';
        $phrases[] = 'Vay. Мы ♥ любим ♥ своё сообщество';
        $phrases[] = 'Vay. Все лучшее - людям';
        $phrases[] = 'Vay - подойдет каждому';
        $phrases[] = 'Vay, как круто!';
        $phrases[] = 'Vay. У нас есть книги и музыка';
        $phrases[] = 'Vay - у нас есть все. Ну, почти, но своё';
        $phrases[] = 'Vay - мы не конкуренты, работайте с нами';
        $phrases[] = 'Vay. Сейчас '.date('h:i', time()).'. У нас на сервере точно';
        $phrases[] = 'Vay - может даже хватить кнопки "'.$current_text.'" :)';
        $phrases[] = 'Vay. Мы желаем тебе Счастья :)';
        $phrases[] = 'Vay. Бросай курить и будет жизнь веселей';
        $phrases[] = 'Юзай Vay, Люби друзей';
        $phrases[] = 'Vay - Проще некуда';
        $phrases[] = 'Vay. Написан прямыми руками. На чем?<br><br> <a href="https://github.com/IlyaVorozhbit/X">На X Engine</a>';
        $phrases[] = 'Vay - Генератор настроения';
        $phrases[] = 'Vay - Генератор идей';
        $phrases[] = 'Vay - this is My way';
        $phrases[] = 'Vay. Мы можем помочь, мы умеем';
        $phrases[] = 'Vay. Мы умеем делать сайты';
        $phrases[] = 'Vay. В каждую семью';
        $phrases[] = 'Vay. 3 буквы, но какие!';
        $phrases[] = 'Vay. 3 буквы на все флаги стран Мира';
        $phrases[] = 'Vay. Oops, sorry!';
        $phrases[] = 'Vay. Мы ненавидим людей, которые не умеют работать, но получают деньги со своих пользователей.<br><br> Список таких людей:<br> VK.com<br>МТС<br>Microsoft';

        //Vay - вы здесь уже 2 минуты, проходите же

            echo $phrases[rand(0, sizeof($phrases)-1)];
        ?>
    </h3>

    <hr>

    <a class="btn btn-success" onclick="display_page('main','welcome')"><?php echo $current_text;?></a>
</div>