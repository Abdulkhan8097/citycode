<?php
global $title;
global $metaTags;
/** function for include title of the page
 *
 */
if ( ! function_exists('include_title'))
{
   function include_title()
    {
        global $title;
       echo "<title>".$title."</title>";

    }
}

/**
 *  function foer set page title at run time
 */
if ( ! function_exists('set_title'))
{
   function set_title($titlevalue)
    {
        global $title; $title = $titlevalue;
    }
}


/**
 * function get meta tag into header
 */
if ( ! function_exists('include_metas'))
{
   function include_metas()
    {
       global $metaTags;
       if(is_array($metaTags)){
       foreach($metaTags as $key=>$value)
       {
            echo "<meta name='".$key."' content='".$value."'>";
       }
       }

    }
}

/**
 * function for set meta tag for SEO at any place
 */
if ( ! function_exists('set_metas'))
{
   function set_metas($arrmeta)
    {
        global $metaTags;

        foreach($arrmeta as $key=>$value)
       {
            $metaTags[$key] = $value;
       }
    }
}