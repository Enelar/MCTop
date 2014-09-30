<?php
class Search extends API
{
    static function results()
    {
        //todo make api results [json only]


        if(isset($_POST['tags']))
        {
            $tags_string = $_POST['tags'];
            $tags = explode(',', $tags_string);
            $test = '';
            foreach ($tags as $tag)
            {
                $test .= '"%'.$tag.'%", ';
            }
            $test = substr($test, 0, strlen($test)-2);

            //if($_POST['strictly_search'] == 'no')
                if(isset($_POST['version_id']) and strlen($_POST['version_id'])>0)
                    $query = 'select * from main.servers where version_id = $1 and tags like any (\'{'.$test.'}\') order by votes desc';
                else
                    $query = 'select * from main.servers where tags like any (\'{'.$test.'}\') order by votes desc';
            //else
            //    $query = 'select * from main.servers where tags like all (\'{'.$test.'}\')';
            if(isset($_POST['version_id']) and strlen($_POST['version_id'])>0)
                $servers =  Core::$db->Query($query, [$_POST['version_id']]);
            else
                $servers =  Core::$db->Query($query, []);
            foreach ($servers as $server)
            {
                $server = new Object($server);
                require (ROOT_DIR.'/design/modules/search/_result.php');
            }

            if(sizeof($_POST)>0)
                Core::log_post_request();
            die();
      }
    }
}