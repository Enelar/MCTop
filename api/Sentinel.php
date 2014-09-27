<?php

class Sentinel extends API
{
    function QueryServer( $addr, $port )
    {
      $socket = fsockopen($addr, $port, $errno, $errstr, 5);
      if (!$socket)
      {
          echo "$errstr ($errno)<br />\n";
          return;
      }

      fwrite($fp, "\xFE\x01\xFA");
      fwrite($fp, "\x00\x0B");
      $mcping = mb_convert_encoding("MC|PingHost", "UTF-16");
      fwrite($fp, $mcping);

      $res = "";
      while (!feof($fp))
        $res .= fgets($fp, 128);
      fclose($fp);

      $ret = json_decode($res, true);
      return $ret;
    }

}
