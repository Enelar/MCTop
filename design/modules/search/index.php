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
        <input type="submit" class="btn btn-default" value="Поиск">
    </form>

    <div id="results">

    </div>