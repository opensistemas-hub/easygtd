
<?php
#example is the file example of stuff import file

if (!isset($example)) {

if(!isset($lang)) {

    include_once(sfConfig::get('sf_app_module_dir').'/home/content_static/'.$view.'.html');

} else {
  
    include_once(sfConfig::get('sf_app_module_dir').'/home/content_static/'.$view.'-'.$lang.'.html');
}

} else {

  include_once(sfConfig::get('sf_app_module_dir').'/home/content_static/example.txt');

}
