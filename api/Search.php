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
                $query = 'select * from main.servers where tags like any (\'{'.$test.'}\') order by votes desc';
            //else
            //    $query = 'select * from main.servers where tags like all (\'{'.$test.'}\')';

            $servers =  Core::$db->Query($query, []);
            foreach ($servers as $server)
            {
                $server = new Object($server);
                require (ROOT_DIR.'/design/modules/search/_result.php');
            }
            die();
      }
    }
}