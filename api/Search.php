<?php

function array_php2pg($array, $data_type = 'character varying')
{
    $array = (array) $array; // Type cast to array.
    $result = [];

    foreach ($array as $entry)
    { // Iterate through array.
        if (is_array($entry)) // Supports nested arrays.
        {
            $result[] = array_php2pg($entry, $data_type);
            continue;
        }

        $entry = str_replace('"', '\\"', $entry); // Escape double-quotes.
        $entry = pg_escape_string($entry); // Escape everything else.

        if (is_numeric($entry))
            $result[] = $entry;
        else
            $result[] = '"' . $entry . '"';
    }

    $ret = '{' . implode(',', $result) . '}';

    if ($data_type !== null)
        $ret .= '::' . $data_type . '[]'; // format
    return $ret;
}

class Search extends api
{

    protected function reserve()
    {
        return [
            "design" => "rating/search/index",
            "script" => ["libs/chosen.jquery", "libs/jquery.tagsinput"],
            "data" => [
                "server_versions" => Core::get_db()->Query('select * from main.servers_versions')
            ],
        ];
    }

    protected function get_results($tags_string, $version = 0)
    {

        $tags = explode(',', $tags_string);
        foreach ($tags as &$tag)
            if (strlen($tag))
                $tag = "%$tag%";

        $pg = array_php2pg($tags, null);

        if($version == 0)
        {
            $query = 'select * from main.servers where tags like all ($1::varchar[]) order by votes desc';
            $servers = Core::get_db()->Query($query,[$pg]);
        }
        else
        {
            $query = 'select * from main.servers where version_id = $2 and tags like all ($1::varchar[]) order by votes desc';
            $servers = Core::get_db()->Query($query,[$pg, $version]);
        }

        return
        [
            "data" => ["search" => $servers],
            "result" => "search_out",
            "design" => "rating/search/server_result",
        ];
    }
}