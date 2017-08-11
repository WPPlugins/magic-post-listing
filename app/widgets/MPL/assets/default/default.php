<?php
/** no direct access **/
defined('_WBMPLEXEC_') or die();

// Pagination Type
$pagination = (isset($instance['layout_pagination']) and trim($instance['layout_pagination'])) ? $instance['layout_pagination'] : WBMPL_PG_NO;

// Grid Size
$grid_size = (isset($instance['layout_grid_size']) and trim($instance['layout_grid_size'])) ? $instance['layout_grid_size'] : 2;

// Responsive cares for Grid
if((isset($instance['layout_display']) and $instance['layout_display'] == '2'))
{
    // Generating javascript code of the widget
    $javascript = '<script type="text/javascript">
    jQuery(document).ready(function()
    {
        var windowSize = jQuery(window).width();
        if(windowSize <= 800 && windowSize > 480)
        {
            jQuery("#'.$this->posts->get_container_id($this->widget_id).' ul").removeClass("wbmpl_grid'.$grid_size.'");
            jQuery("#'.$this->posts->get_container_id($this->widget_id).' ul").addClass("wbmpl_grid2");
        }
        else if(windowSize <= 480)
        {
            jQuery("#'.$this->posts->get_container_id($this->widget_id).' ul").removeClass("wbmpl_grid'.$grid_size.'");
            jQuery("#'.$this->posts->get_container_id($this->widget_id).' ul").addClass("wbmpl_grid1");
        }
    });
    
    jQuery(window).resize(function()
    {
        var windowSize = jQuery(window).width();
        if(windowSize > 800)
        {
            jQuery("#'.$this->posts->get_container_id($this->widget_id).' ul").removeClass("wbmpl_grid2");
            jQuery("#'.$this->posts->get_container_id($this->widget_id).' ul").removeClass("wbmpl_grid1");
            jQuery("#'.$this->posts->get_container_id($this->widget_id).' ul").addClass("wbmpl_grid'.$grid_size.'");
        }
        else if(windowSize <= 800 && windowSize > 480)
        {
            jQuery("#'.$this->posts->get_container_id($this->widget_id).' ul").removeClass("wbmpl_grid'.$grid_size.'");
            jQuery("#'.$this->posts->get_container_id($this->widget_id).' ul").removeClass("wbmpl_grid1");
            jQuery("#'.$this->posts->get_container_id($this->widget_id).' ul").addClass("wbmpl_grid2");
        }
        else if(windowSize <= 480)
        {
            jQuery("#'.$this->posts->get_container_id($this->widget_id).' ul").removeClass("wbmpl_grid2");
            jQuery("#'.$this->posts->get_container_id($this->widget_id).' ul").addClass("wbmpl_grid1");
        }
    });
    </script>';

    // Include javascript code into the footer
    $this->factory->params('footer', $javascript);
}

if($pagination == WBMPL_PG_LOAD_MORE and $this->main->getPRO())
{
    // Generating javascript code of the widget
    $javascript = '<script type="text/javascript">
    var wbmpl_page'.$this->widget_id.' = '.$mplpage.';
    jQuery(document).ready(function()
    {
        jQuery("#'.$this->posts->get_container_id($this->widget_id).' .wbmpl_pagination button").on("click", function()
        {
            wbmpl_paginate'.$this->widget_id.'()
        });
    });

    function wbmpl_paginate'.$this->widget_id.'()
    {
        wbmpl_page'.$this->widget_id.'++;
        if(wbmpl_page'.$this->widget_id.' > '.$total_pages.') return false;

        // Add loading Class
        jQuery("#'.$this->posts->get_container_id($this->widget_id).' .wbmpl_pagination").addClass("wbmpl-pagination-loading");

        jQuery.ajax(
        {
            url: "'.admin_url('admin-ajax.php').'",
            data: "action=wbmpl_load_items_default&'.http_build_query(array('instance'=>$instance)).'&mplpage="+wbmpl_page'.$this->widget_id.'+"&widget_id='.$this->widget_id.'",
            dataType: "json",
            type: "post",
            success: function(response)
            {
                // Append Items
                jQuery("#'.$this->posts->get_container_id($this->widget_id).' ul").append(response.html);
                
                // Remove loading Class
                jQuery("#'.$this->posts->get_container_id($this->widget_id).' .wbmpl_pagination").removeClass("wbmpl-pagination-loading");

                if(wbmpl_page'.$this->widget_id.' == '.$total_pages.')
                {
                    jQuery("#'.$this->posts->get_container_id($this->widget_id).' .wbmpl_pagination").hide();
                }
            },
            error: function()
            {
            }
        });
    }
    </script>';

    // Include javascript code into the footer
    $this->factory->params('footer', $javascript);
}