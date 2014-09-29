<script src="/js/chosen.jquery.js"></script>
<link type="text/css" rel="stylesheet" href="/css/chosen.css"/>

<script src="/js/jquery.tagsinput.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.tagsinput.css" />
<script>
    $('#tags').tagsInput(
        {
            'defaultText':'+',
            'width':'40%'
        }
    );
</script>


<h1><span class="<?php echo Core::get_settings()->modules['search']->icon?>"></span> Поиск</h1><hr>

    <form method="POST" id="formx" action="javascript:void(null);" onsubmit="servers_search()">
        <div class="form-group">
            <label>Теги</label>
            <input name="tags" class="form-control" id="tags" value="" />
            <!--<input name="strictly_search" class="form-control" value="yes" />-->
        </div>


        <div class="form-group">
            <p><label>Версия игры</label></p>
            <select id="version_id" name="version_id" data-placeholder="Версия игры..." class="chosen-select" style="width:350px;" tabindex="2">
                <option value=""></option>
                <?php
                $servers_versions = Core::$db->Query('select * from main.servers_versions');
                foreach ($servers_versions as $version)
                {
                    if($server->version_id == $version['id'])
                        echo '<option selected value="'.$version['id'].'">'.$version['name'].'</option>';
                    else
                        echo '<option value="'.$version['id'].'">'.$version['name'].'</option>';
                }
                ?>
            </select>
        </div>

        <input type="submit" class="btn btn-default" value="Поиск">
    </form>

    <div id="results">

    </div>

<script type="text/javascript">
    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Упс, ничего не найдено'},
        '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>