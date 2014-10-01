<?php

class UploadImage extends api
{
    private $base_prefix = "./../img/";

    public function upload_by_name( $name )
    {
        global $_FILES;
        if (!$_FILES[$name])
            return false;
        $file = $_FILES[$name];
        if($file['error'])
            return false;

        if (false === $ext = $this->check_extension($file))
            return false;
        $gd = $this->create_gd($ext, $file['tmp_name']);

        if (!$gd)
            return false;

        $tran = db::Begin();
        $name = $this->alloc_image_name($ext);

        $fileloc = $this->base_prefix.$name.".".$ext;
        $save_res = $this->SaveTo($gd, $ext, $fileloc);
        $res = $tran->Finish($save_res);

        @imagedestroy($gd);

        if ($res)
            return $name;
        return NULL;
    }

    private function check_extension( $file )
    {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $ext = array_search
        (
            $finfo->file($file['tmp_name']),
            [
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
            ]
        );

        return $ext;
    }

    private function create_gd( $ext, $filename )
    {
        if ($ext == 'jpg')
            return @imagecreatefromjpeg($filename);
        if ($ext == 'png')
            return @imagecreatefrompng($filename);
        return false;
    }

    private function SaveTo( $gd, $ext, $filename )
    {
        if ($ext == 'jpg')
            return imagejpeg($gd, $filename);
        if ($ext == 'png')
            return imagepng($gd, $filename);
        return false;
    }

    private function alloc_image_name( $ext )
    {
        $res = Core::get_db()->Query("
            INSERT INTO main.images(author, ext)
                VALUES ($1, $2)
                RETURNING name", [LoadModule('api', 'Users')->uid(), $ext], true);
        return $res['name'];
    }

    public function location_by_name( $name )
    {
        $res = $this->info($name);
        return $this->base_prefix.$res['name'].".".$res['ext'];
    }

    public function info( $name )
    {
        return Core::get_db()->Query("SELECT * FROM main.images WHERE name=$1", [$name], true);
    }
}