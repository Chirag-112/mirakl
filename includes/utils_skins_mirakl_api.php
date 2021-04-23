<?php

if (!defined('ABSPATH')) {
    exit;
}

global $logging;
$logging = false;

// if(ENABLE_LOGS_SN){
//     $logging = true; 
// }

if (! function_exists('pr')) {
    function pr($arr,$die=true)
    {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';    
        
        if($die){
            die();       
        }
        
    }
    
}

if (! function_exists('get_all_active_sites')) {

    function get_all_active_sites()
    {

        $sites = get_sites(array('deleted'=>0,'public'=>1));   

        if(count($sites)){        
            $site_set = [];                     
            foreach ($sites as $key => $value) {

                $site_set[$key]['blog_id'] = $value->blog_id;
                $site_set[$key]['domain'] = $value->domain;
                $site_set[$key]['path'] = $value->path;                    
                $blog = get_blog_details($value->blog_id);                    
                $site_set[$key]['siteurl'] = $blog->siteurl;
                $site_set[$key]['blogname'] = $blog->blogname;

            }

            return $site_set;
        }

        return ;
    }
}