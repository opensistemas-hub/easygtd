<?php
class MimeContent {

  public static function mime_content_type($file){
    ob_start();
    system('/usr/bin/file -i -b ' . realpath($file));
    $type = ob_get_clean();
    $parts = explode(';', $type);
    return trim($parts[0]);
  }

}

