<?php

class Image extends api
{
    protected function is_image_owner($name)
    {
      return $this->info($name)->author == LoadModule('api', 'Users')->uid;
    }

    public function location( $name )
    {
        $res = $this->info($name);
        $base_prefix = Core::get_settings()->application['image_prefix'];
        return $base_prefix.$res['name'].".".$res['ext'];
    }

    public function info( $name )
    {
        return Core::get_db()->Query("SELECT * FROM main.images WHERE name=$1", [$name], true);
    }

    protected function show( $name )
    { 
        // I know this is crap. idc.      
        $loc = $this->location($name);
        
        if ($this->info($name)['ext'] == 'jpg')
            header('Content-type: image/jpeg');
        else
          header('Content-type: image/png');

        echo file_get_contents($loc);
        die();
    }
}