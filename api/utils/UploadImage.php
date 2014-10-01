<?php

class UploadImage extends API
{
    private $base_prefix = "./../img/";

    public function UploadByName( $name )
    {
        global $_FILES;
        if (!$_FILES[$name])
            return false;
        $file = $_FILES[$name];
        if($file['error'])
            return false;

        if (false === $ext = $this->CheckExtension($file))
            return false;
        $gd = $this->CreateGD($ext, $file['tmp_name']);

        if (!$gd)
            return false;

        $tran = db::Begin();
        $name = $this->AllocImageName($ext);

        $fileloc = $this->base_prefix.$name.".".$ext;
        $save_res = $this->SaveTo($gd, $ext, $fileloc);
        $res = $tran->Finish($save_res);

        @imagedestroy($gd);

        if ($res)
            return $name;
        return NULL;
    }

    private function CheckExtension( $file )
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

    private function CreateGD( $ext, $filename )
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

    private function AllocImageName( $ext )
    {
        // Get random image name stored in ta
        // $res = db::Query("INSERT INTO kickstart.images(author, ext) VALUES ($1, $2) RETURNING name", [C::Users()->uid(), $ext], true);
        // return $res['name'];
    }

    public function LocationByName( $name )
    {
        $res = $this->info($name);
        return $this->base_prefix.$res['name'].".".$res['ext'];
    }

    public function info( $name )
    {
        // Get image row by name
        // return db::Query("SELECT * FROM kickstart.images WHERE name=$1", [$name], true);
    }
}