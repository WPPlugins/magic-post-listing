var wbmpl_current_tab_widget = 'basic';

function wbmpl_slide_tabs(tab_id, force, widget_id)
{
    if(!force) force = false;
    if(!widget_id) widget_id = 0;
    
    if(widget_id)
    {
        jQuery('#wbmpl_widget_form_container'+widget_id+' .wbmpl_widget_tab_container').slideUp(200);
        jQuery('#wbmpl_widget_form_container'+widget_id+' .wbmpl_widget_tab_'+tab_id).slideDown(200);
    }
    else
    {
        jQuery('.wbmpl_widget_tab_container').slideUp(200);
        jQuery('.wbmpl_widget_tab_'+tab_id).slideDown(200);
    }

    wbmpl_current_tab_widget = tab_id;
}

function wbmpl_change_post_type_status(status)
{
    jQuery('.wbmpl_post_type_options_container').slideUp(200);
    
    if(status == 'post')
    {
        jQuery('.wbmpl_post_type_post_options_container').slideDown(200);
        jQuery('.wbmpl_show_display_category_tags_options_container').slideDown(200);
    }
    else if(status == 'page')
    {
        jQuery('.wbmpl_post_type_page_options_container').slideDown(200);
        jQuery('.wbmpl_show_display_category_tags_options_container').slideUp(200);
    }
    else
    {
        jQuery('.wbmpl_show_display_category_tags_options_container').slideUp(200);
        jQuery('.wbmpl_post_type_'+status+'_options_container').slideDown(200);
    }
}

function wbmpl_toggle(html_id)
{
    jQuery('#'+html_id).toggle();
}

function wbmpl_change_display_show_status(status, type)
{
    if(!type) type = 'title';

    if(status == 0) jQuery('.wbmpl_show_display_'+type+'_options_container').slideUp(200);
    else if(status == 1) jQuery('.wbmpl_show_display_'+type+'_options_container').slideDown(200);
}

function wbmpl_load_widget_form(id, number, layout, container)
{
    jQuery.ajax(
    {
        type: "POST",
        url: ajaxurl,
        data: "id_base="+id+"&number="+number+"&action=wbmpl_widget_layout_form&layout="+layout,
        success: function(data)
        {
            jQuery("#"+container).html(data);
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            alert('ERROR');
        }
    });
}

jQuery(document).ready(function()
{
    jQuery('#wbmpl_close_upgrade_notice').on('click', function()
    {
        jQuery('#wbmpl_upgrade_notice').css('display', 'none');
        
        var data = {action: 'wbmpl_hide_upgrade_notice'};

        jQuery.post(ajaxurl, data, function(response)
        {
        });
    });
});