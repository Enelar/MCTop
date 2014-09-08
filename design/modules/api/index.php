<?php
    //todo найти подходящее место для этой функции
    function show_api_url($module, $action)
    {
        return 'http://'.$_SERVER['HTTP_HOST'].'/api.php?module='.$module.'&action='.$action;
    }
?>

<h1>
    <span class="<?php echo Core::get_settings()->modules['api']->icon?>"></span>
    <?php echo Core::get_settings()->application['site_name'];?>.API
</h1>

<div class="well">

    <h3>Получение информации о проекте</h3>
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        URL
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?php echo show_api_url('projects_api', 'get&id=1')?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"">
                        Пример ответа
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <div id="function_1_result">
<pre>
<?php $project = new Projects_api(); echo (Core::json_encode_cyr($project->get(1)));?>
</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <h3>Получение информации о проектах пользователя</h3>
    <div class="panel-group" id="accordion_2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion_2" href="#2_collapseOne">
                        URL
                    </a>
                </h4>
            </div>
            <div id="2_collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?php echo show_api_url('users', 'get_user_projects&id=1')?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion_2" href="#2_collapseTwo"">
                    Пример ответа
                    </a>
                </h4>
            </div>
            <div id="2_collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <div id="function_1_result">
<pre>
<?php $user = new Users(); echo (Core::json_encode_cyr($user->get_user_projects(1)));?>
</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>