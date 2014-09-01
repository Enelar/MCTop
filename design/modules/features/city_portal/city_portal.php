
    <?php

        $id = 1;
        $_GET['id'] = 1;
        $city = new Cities('get_one:city_by_id:'.$_GET['id'].':from_user:'.Core::get_current_user_profile()->id);
        $city = $city->storage;

    ?>

    <h1><span class="glyphicon glyphicon-th-large"></span> Городской портал</h1> <hr>

    <div class="city_portal">

        <div class="name">
            Ростов

            <?php echo $city->name;?>
        </div>

        <hr>

        <div class="menu">


            <table>

                <tr>
                    <td>
                        <span class="glyphicon glyphicon-usd"></span> <a onclick="display_page_with_id('features','city_portal_shop','test')"> Магазины</a>
                    </td>
                    <td>
                        <span class="glyphicon glyphicon-copyright-mark"></span> Организации
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-log-in"></span> Мероприятия
                    </td>
                    <td>
                        <span class="glyphicon glyphicon-phone-alt"></span> Такси
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="glyphicon glyphicon-heart-empty"></span> Развлечения
                    </td>
                    <td>
                        <span class="glyphicon glyphicon-tower"></span> Гостиницы
                    </td>
                </tr>

            </table>

        </div>



    </div>