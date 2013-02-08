<?php
#Modified to fit easygtd
#modified image_tag('/sf/sf_admin/images/first.png' for image_tag('icons/first.png' 
function pager_navigation($pager, $uri)
{
  $navigation = '';
 
  if ($pager->haveToPaginate())
  {  
    $uri .= (preg_match('/\?/', $uri) ? '&' : '?').'page=';
 
    // First and previous page
    if ($pager->getPage() != 1)
    {
      $navigation .= link_to(image_tag('icons/first.png', array('alt' => 'First')), $uri.'1');
      $navigation .= link_to(image_tag('icons/previous.png', array('alt' => 'Previous')), $uri.$pager->getPreviousPage()).' ';
    }
 
    // Pages one by one
    $links = array();
    foreach ($pager->getLinks() as $page)
    {
      $links[] = link_to_unless($page == $pager->getPage(), $page, $uri.$page);
    }
    $navigation .= join('  ', $links);
 
    // Next and last page
    if ($pager->getPage() != $pager->getLastPage())
    {
      $navigation .= ' '.link_to(image_tag('icons/next.png', array('alt' => 'Siguiente')), $uri.$pager->getNextPage());
      $navigation .= link_to(image_tag('icons/last.png', array('alt' => '&Uacute;ltimo')), $uri.$pager->getLastPage());
    }
 
  }
 
  return $navigation;
}


function pager_navigation_ajax($pager, $uri, $update ,$callback)
{
  $navigation = '';

  if ($pager->haveToPaginate())
  {  
    $uri .= (preg_match('/\?/', $uri) ? '&' : '?').'page=';
 
    // First and previous page
    if ($pager->getPage() != 1)
    {
      $navigation .= '<a href="'.'#'.$update.'" id="link_first">'.image_tag('/sf/sf_admin/images/first.png', 'align=absmiddle').'</a>';
      $navigation .= '<script type="text/javascript">
                         jq("#link_first").click(function(){
                                                           '.$callback.'(1);
                                                           });
                      </script>';
      $navigation .= '<a href="'.'#'.$update.'" id="link_previous">'.image_tag('/sf/sf_admin/images/previous.png', 'align=absmiddle').'</a>';
      $navigation .= '<script type="text/javascript">
                         jq("#link_previous").click(function(){
                                                           '.$callback.'('.$pager->getPreviousPage().');
                                                           });
                      </script>';
    }
 
    // Pages one by one
    $links = array();
    foreach ($pager->getLinks() as $page)
    {
      $links[] = '<a id="link_'.$update.'_'.$page.'" href="'.'#'.$update.'">'.$page.'</a>'.'
                         <script type="text/javascript">
                           jq("#link_'.$update.'_'.$page.'").click(function(){
                                                           '.$callback.'('.$page.');
                                                           });
                         </script>';
      
  
    }
    $navigation .= join('  ', $links);
 
    // Next and last page
    if ($pager->getPage() != $pager->getLastPage())
    {
      $navigation .= '<a href="'.'#'.$update.'" id="link_next">'.image_tag('/sf/sf_admin/images/next.png', 'align=absmiddle').'</a>';
      $navigation .= '<script type="text/javascript">
                         jq("#link_next").click(function(){
                                                           '.$callback.'('.$pager->getNextPage().');
                                                           });
                      </script>';
      $navigation .= '<a href="'.'#'.$update.'" id="link_last">'.image_tag('/sf/sf_admin/images/last.png', 'align=absmiddle').'</a>';
      $navigation .= '<script type="text/javascript">
                         jq("#link_last").click(function(){
                                                           '.$callback.'('.$pager->getLastPage().');
                                                           });
                      </script>';
    }
 
  }
 
  return $navigation;
}


