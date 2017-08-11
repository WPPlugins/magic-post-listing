<?php
/** no direct access **/
defined('_WBMPLEXEC_') or die();

$widget_layouts = $this->layouts();
?>
<script type="text/javascript">
jQuery(document).ready(function()
{
    if(wbmpl_current_tab_widget) wbmpl_slide_tabs(wbmpl_current_tab_widget, true, '<?php echo $this->number; ?>');
    jQuery('#<?php echo $this->get_field_id('widget_main_color'); ?>').wpColorPicker();
});
</script>
<div class="wbmpl_widget_form_container" id="wbmpl_widget_form_container<?php echo $this->number; ?>">
	<h4 class="wbmpl_widget_tab_header" onclick="wbmpl_slide_tabs('basic', false, '<?php echo $this->number; ?>');"><i class="fa fa-home"></i><?php echo __('Basic Options', 'wbmpl'); ?></h4>
    <div class="wbmpl_widget_tab_container wbmpl_widget_tab_basic">
        <fieldset class="wbmpl_field_wrapper">
            <legend><?php echo __('Widget Title', 'wbmpl'); ?></legend>
            <p>
                <select id="<?php echo $this->get_field_id('show_widget_title'); ?>" name="<?php echo $this->get_field_name('show_widget_title'); ?>" class="widefat" onchange="wbmpl_toggle('<?php echo $this->get_field_id('wbmpl_title_options_container'); ?>');">
                    <option value="1" <?php if('1' == $instance['show_widget_title']) echo 'selected="selected"'; ?>><?php echo __('Yes', 'wbmpl'); ?></option>
                    <option value="0" <?php if('0' == $instance['show_widget_title']) echo 'selected="selected"'; ?>><?php echo __('No', 'wbmpl'); ?></option>
                </select>
            </p>
            <div class="wbmpl_title_options_container" id="<?php echo $this->get_field_id('wbmpl_title_options_container'); ?>" <?php if($instance['show_widget_title'] == 0) echo 'style="display: none;"'; ?>>
                <p>
                    <label for="<?php echo $this->get_field_id('widget_title'); ?>"><?php echo __('Widget Title', 'wbmpl'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" value="<?php echo $instance['widget_title']; ?>" type="text" />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('widget_title_url'); ?>"><?php echo __('URL', 'wbmpl'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('widget_title_url'); ?>" name="<?php echo $this->get_field_name('widget_title_url'); ?>" value="<?php echo $instance['widget_title_url']; ?>" type="text" />
                </p>
            </div>
        </fieldset>
        <p>
            <label for="<?php echo $this->get_field_id('widget_css_classes'); ?>"><?php echo __('Additional CSS classes', 'wbmpl'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('widget_css_classes'); ?>" name="<?php echo $this->get_field_name('widget_css_classes'); ?>" value="<?php echo $instance['widget_css_classes']; ?>" type="text" />
        </p>
        <p class="wbmpl-no-margin-bottom">
            <label for="<?php echo $this->get_field_id('widget_main_color'); ?>"><?php echo __('Main Color', 'wbmpl'); ?></label> 
            <input id="<?php echo $this->get_field_id('widget_main_color'); ?>" name="<?php echo $this->get_field_name('widget_main_color'); ?>" type="text" value="<?php echo $instance['widget_main_color']; ?>" class="wbmpl-color-field" data-default-color="#345d81" />
        </p>
        <p class="wbmpl-no-margin-top">
            <input type="checkbox" id="<?php echo $this->get_field_id('widget_main_color_ignore'); ?>" name="<?php echo $this->get_field_name('widget_main_color_ignore'); ?>" <?php if(isset($instance['widget_main_color_ignore']) and $instance['widget_main_color_ignore']) echo 'checked="checked"'; ?> />
            <label for="<?php echo $this->get_field_id('widget_main_color_ignore'); ?>" style="display: inline;"><?php echo __("Don't apply this color.", 'wbmpl'); ?></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('widget_url_target'); ?>"><?php echo __('Links Target', 'wbmpl'); ?></label>
            <select id="<?php echo $this->get_field_id('widget_url_target'); ?>" name="<?php echo $this->get_field_name('widget_url_target'); ?>" class="widefat">
                <option value="_self" <?php echo ($instance['widget_url_target'] == '_self' ? 'selected="selected"' : ''); ?>><?php echo __('Current Window', 'wbmpl'); ?></option>
                <option value="_blank" <?php echo ($instance['widget_url_target'] == '_blank' ? 'selected="selected"' : ''); ?>><?php echo __('New Window', 'wbmpl'); ?></option>
            </select>
        </p>
    </div>
    <h4 class="wbmpl_widget_tab_header" onclick="wbmpl_slide_tabs('post', false, '<?php echo $this->number; ?>');"><i class="fa fa-filter"></i><?php echo __('Filter Options', 'wbmpl'); ?></h4>
    <div class="wbmpl_widget_tab_container wbmpl_widget_tab_post" style="display: none;">
    	<p>
            <label for="<?php echo $this->get_field_id('post_authors'); ?>"><?php echo __('Author', 'wbmpl'); ?></label>
            <?php
				$args = array('who'=>'authors');
            	$wp_authors = $this->main->get_authors($args);
				$current_authors = explode(',', $instance['post_authors']);
			?>
            <select name="<?php echo $this->get_field_name('post_authors'); ?>" id="<?php echo $this->get_field_id('post_authors'); ?>" class="widefat">
            	<option value="">---</option>
                <?php foreach($wp_authors as $wp_author): ?>
                <option value="<?php echo $wp_author->data->ID; ?>" <?php if(in_array($wp_author->data->ID, $current_authors)) echo 'selected="selected"' ?>><?php echo $wp_author->data->user_login; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <fieldset class="wbmpl_field_wrapper">
            <legend><?php echo __('Post Type', 'wbmpl'); ?></legend>
            <p>
                <select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>" class="widefat" onchange="wbmpl_change_post_type_status(this.value);">
                    <option value="post" <?php if($instance['post_type'] == 'post') echo 'selected="selected"'; ?>><?php echo __('Post', 'wbmpl'); ?></option>
                    <option value="page" <?php if($instance['post_type'] == 'page') echo 'selected="selected"'; ?>><?php echo __('Page', 'wbmpl'); ?></option>
                    <?php foreach($post_types as $post_type): $PTO = get_post_type_object($post_type); ?>
                    <option value="<?php echo $post_type; ?>" <?php if($instance['post_type'] == $post_type) echo 'selected="selected"'; ?>><?php echo __($PTO->labels->singular_name, 'wbmpl'); ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <div class="wbmpl_post_type_options_container wbmpl_post_type_page_options_container" <?php if($instance['post_type'] != 'page') echo 'style="display: none;"'; ?>>
                <p>
                    <label for="<?php echo $this->get_field_id('parent_page'); ?>"><?php echo __('Parent Page', 'wbmpl'); ?></label>
                    <?php echo $this->pages_selectbox(array('name'=>$this->get_field_name('parent_page'), 'id'=>$this->get_field_id('parent_page'), 'selected'=>$instance['parent_page']), array('class'=>'widefat')); ?>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('include_page_ids'); ?>"><?php echo __('Include page IDs', 'wbmpl'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('include_page_ids'); ?>" name="<?php echo $this->get_field_name('include_page_ids'); ?>" value="<?php echo $instance['include_page_ids']; ?>" type="text" />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('exclude_page_ids'); ?>"><?php echo __('Exclude page IDs', 'wbmpl'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('exclude_page_ids'); ?>" name="<?php echo $this->get_field_name('exclude_page_ids'); ?>" value="<?php echo $instance['exclude_page_ids']; ?>" type="text" />
                </p>
            </div>
            <div class="wbmpl_post_type_options_container wbmpl_post_type_post_options_container" <?php if($instance['post_type'] != 'post') echo 'style="display: none;"'; ?>>
                <p>
                    <label for="<?php echo $this->get_field_id('post_categories'); ?>"><?php echo __('Post Category', 'wbmpl'); ?></label> 
                    <?php echo $this->categories_selectbox(array('name'=>$this->get_field_name('post_categories'), 'id'=>$this->get_field_id('post_categories'), 'selected'=>$instance['post_categories']), array('class'=>'widefat')); ?>
                </p>
                <p>
                    <input id="<?php echo $this->get_field_id('include_current_category'); ?>" name="<?php echo $this->get_field_name('include_current_category'); ?>" <?php if(isset($instance['include_current_category']) and $instance['include_current_category']) echo 'checked="checked"'; ?> type="checkbox" />
                    <label for="<?php echo $this->get_field_id('include_current_category'); ?>" style="display: inline;"><?php echo __('Include current category', 'wbmpl'); ?></label>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('post_tags'); ?>"><?php echo __('Post Tags', 'wbmpl'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('post_tags'); ?>" name="<?php echo $this->get_field_name('post_tags'); ?>" value="<?php echo $instance['post_tags']; ?>" type="text" />
                </p>
                <p>
                    <input id="<?php echo $this->get_field_id('include_current_tag'); ?>" name="<?php echo $this->get_field_name('include_current_tag'); ?>" <?php if(isset($instance['include_current_tag']) and $instance['include_current_tag']) echo 'checked="checked"'; ?> type="checkbox" />
                    <label for="<?php echo $this->get_field_id('include_current_tag'); ?>" style="display: inline;"><?php echo __('Include current tag', 'wbmpl'); ?></label>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('include_post_ids'); ?>"><?php echo __('Include post IDs', 'wbmpl'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('include_post_ids'); ?>" name="<?php echo $this->get_field_name('include_post_ids'); ?>" value="<?php echo $instance['include_post_ids']; ?>" type="text" />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('exclude_post_ids'); ?>"><?php echo __('Exclude post IDs', 'wbmpl'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('exclude_post_ids'); ?>" name="<?php echo $this->get_field_name('exclude_post_ids'); ?>" value="<?php echo $instance['exclude_post_ids']; ?>" type="text" />
                </p>
            </div>
            <?php foreach($post_types as $post_type): $taxonomies = get_object_taxonomies($post_type, 'objects'); ?>
            <div class="wbmpl_post_type_options_container wbmpl_post_type_<?php echo $post_type; ?>_options_container" <?php if($instance['post_type'] != $post_type) echo 'style="display: none;"'; ?>>
                <?php foreach($taxonomies as $taxkey=>$taxonomy): $terms = get_terms(array($taxkey), array('orderby'=>'count', 'hide_empty'=>0)); ?>
                <p>
                    <label for="<?php echo $this->get_field_id('cpost_'.$post_type.'_'.$taxkey); ?>"><?php echo __($taxonomy->label, 'wbmpl'); ?></label>
                    <select id="<?php echo $this->get_field_id('cpost_'.$post_type.'_'.$taxkey); ?>" name="<?php echo $this->get_field_name('cpost_'.$post_type.'_terms_'.$taxkey); ?>" class="widefat">
                        <option value="">---</option>
                        <?php foreach($terms as $term): ?>
                        <option value="<?php echo $term->term_id; ?>" <?php echo ((isset($instance['cpost_'.$post_type.'_terms_'.$taxkey]) and $instance['cpost_'.$post_type.'_terms_'.$taxkey] == $term->term_id) ? 'selected="selected"' : ''); ?>><?php echo __($term->name, 'wbmpl'); ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <?php endforeach; ?>
                <p>
                    <label for="<?php echo $this->get_field_id('cpost_'.$post_type.'_include_post_ids'); ?>"><?php echo __('Include post IDs', 'wbmpl'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('cpost_'.$post_type.'_include_post_ids'); ?>" name="<?php echo $this->get_field_name('cpost_'.$post_type.'_include_post_ids'); ?>" value="<?php echo (isset($instance['cpost_'.$post_type.'_include_post_ids']) ? $instance['cpost_'.$post_type.'_include_post_ids'] : ''); ?>" type="text" />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('cpost_'.$post_type.'_exclude_post_ids'); ?>"><?php echo __('Exclude post IDs', 'wbmpl'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('cpost_'.$post_type.'_exclude_post_ids'); ?>" name="<?php echo $this->get_field_name('cpost_'.$post_type.'_exclude_post_ids'); ?>" value="<?php echo (isset($instance['cpost_'.$post_type.'_exclude_post_ids']) ? $instance['cpost_'.$post_type.'_exclude_post_ids'] : ''); ?>" type="text" />
                </p>
            </div>
            <?php endforeach; ?>
            <p>
                <input id="<?php echo $this->get_field_id('exclude_current_post'); ?>" name="<?php echo $this->get_field_name('exclude_current_post'); ?>" <?php if($instance['exclude_current_post']) echo 'checked="checked"'; ?> type="checkbox" />
                <label for="<?php echo $this->get_field_id('exclude_current_post'); ?>" style="display: inline;"><?php echo __('Exclude current post/page', 'wbmpl'); ?></label>
            </p>
        </fieldset>
        <p>
        	<label for="<?php echo $this->get_field_id('listing_orderby'); ?>"><?php echo __('Order by', 'wbmpl'); ?></label>
            <select id="<?php echo $this->get_field_id('listing_orderby'); ?>" name="<?php echo $this->get_field_name('listing_orderby'); ?>" class="widefat">
                <option value="post_date" <?php if($instance['listing_orderby'] == 'post_date') echo 'selected="selected"'; ?>><?php echo __('Post date', 'wbmpl'); ?></option>
                <option value="post_modified" <?php if($instance['listing_orderby'] == 'post_modified') echo 'selected="selected"'; ?>><?php echo __('Post modified date', 'wbmpl'); ?></option>
                <option value="comment_count" <?php if($instance['listing_orderby'] == 'comment_count') echo 'selected="selected"'; ?>><?php echo __('Comment count', 'wbmpl'); ?></option>
                <option value="post_title" <?php if($instance['listing_orderby'] == 'post_title') echo 'selected="selected"'; ?>><?php echo __('Post title', 'wbmpl'); ?></option>
            </select>
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id('listing_order'); ?>"><?php echo __('Order', 'wbmpl'); ?></label>
            <select id="<?php echo $this->get_field_id('listing_order'); ?>" name="<?php echo $this->get_field_name('listing_order'); ?>" class="widefat">
                <option value="ASC" <?php if($instance['listing_order'] == 'ASC') echo 'selected="selected"'; ?>><?php echo __('Ascending', 'wbmpl'); ?></option>
                <option value="DESC" <?php if($instance['listing_order'] == 'DESC') echo 'selected="selected"'; ?>><?php echo __('Descending', 'wbmpl'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('listing_size'); ?>"><?php echo __('Max number of posts/pages', 'wbmpl'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('listing_size'); ?>" name="<?php echo $this->get_field_name('listing_size'); ?>" value="<?php echo $instance['listing_size']; ?>" type="text" />
        </p>
	</div>
    <h4 class="wbmpl_widget_tab_header" onclick="wbmpl_slide_tabs('thumbnail', false, '<?php echo $this->number; ?>');"><i class="fa fa-picture-o"></i><?php echo __('Thumbnail Options', 'wbmpl'); ?></h4>
    <div class="wbmpl_widget_tab_container wbmpl_widget_tab_thumbnail" style="display: none;">
    	<fieldset class="wbmpl_field_wrapper">
            <legend><?php echo __('Thumbnails', 'wbmpl'); ?></legend>
            <p>
                <select id="<?php echo $this->get_field_id('thumb_show'); ?>" name="<?php echo $this->get_field_name('thumb_show'); ?>" class="widefat" onchange="wbmpl_toggle('<?php echo $this->get_field_id('wbmpl_show_thumbnails_options_container'); ?>')">
                    <option value="1" <?php if($instance['thumb_show'] == '1') echo 'selected="selected"'; ?>><?php echo __('Yes', 'wbmpl'); ?></option>
                    <option value="0" <?php if($instance['thumb_show'] == '0') echo 'selected="selected"'; ?>><?php echo __('No', 'wbmpl'); ?></option>
                </select>
            </p>
            <div class="wbmpl_show_thumbnails_options_container" id="<?php echo $this->get_field_id('wbmpl_show_thumbnails_options_container'); ?>" <?php if($instance['thumb_show'] == '0') echo 'style="display: none;"'; ?>>
                <p>
                    <label for="<?php echo $this->get_field_id('thumb_width'); ?>" class="short"><?php echo __('Width (px)', 'wbmpl'); ?></label>
                    <input id="<?php echo $this->get_field_id('thumb_width'); ?>" name="<?php echo $this->get_field_name('thumb_width'); ?>" value="<?php echo $instance['thumb_width']; ?>" type="text" class="widefat" />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('thumb_height'); ?>" class="short"><?php echo __('Height (px)', 'wbmpl'); ?></label>
                    <input id="<?php echo $this->get_field_id('thumb_height'); ?>" name="<?php echo $this->get_field_name('thumb_height'); ?>" value="<?php echo $instance['thumb_height']; ?>" type="text" class="widefat" />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('thumb_link'); ?>"><?php echo __('Link thumbnails to post', 'wbmpl'); ?></label>
                    <select id="<?php echo $this->get_field_id('thumb_link'); ?>" name="<?php echo $this->get_field_name('thumb_link'); ?>" class="widefat">
                        <option value="1" <?php if($instance['thumb_link'] == '1') echo 'selected="selected"'; ?>><?php echo __('Yes', 'wbmpl'); ?></option>
                        <option value="0" <?php if($instance['thumb_link'] == '0') echo 'selected="selected"'; ?>><?php echo __('No', 'wbmpl'); ?></option>
                    </select>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('thumb_skip'); ?>"><?php echo __('Skip no images posts', 'wbmpl'); ?></label>
                    <select id="<?php echo $this->get_field_id('thumb_skip'); ?>" name="<?php echo $this->get_field_name('thumb_skip'); ?>" class="widefat">
                        <option value="0" <?php if($instance['thumb_skip'] == '0') echo 'selected="selected"'; ?>><?php echo __('No', 'wbmpl'); ?></option>
                        <option value="1" <?php if($instance['thumb_skip'] == '1') echo 'selected="selected"'; ?>><?php echo __('Yes', 'wbmpl'); ?></option>
                    </select>
                </p>
            </div>
        </fieldset>
    </div>
    <h4 class="wbmpl_widget_tab_header" onclick="wbmpl_slide_tabs('display', false, '<?php echo $this->number; ?>');"><i class="fa fa-eye"></i><?php echo __('Display Options', 'wbmpl'); ?></h4>
    <div class="wbmpl_widget_tab_container wbmpl_widget_tab_display" style="display: none;">
    	<fieldset class="wbmpl_field_wrapper">
            <legend><?php echo __('Post Title', 'wbmpl'); ?></legend>
            <p>
                <select id="<?php echo $this->get_field_id('display_show_title'); ?>" name="<?php echo $this->get_field_name('display_show_title'); ?>" class="widefat" onchange="wbmpl_change_display_show_status(this.value, 'title');">
                    <option value="1" <?php if($instance['display_show_title'] == '1') echo 'selected="selected"'; ?>><?php echo __('Yes', 'wbmpl'); ?></option>
                    <option value="0" <?php if($instance['display_show_title'] == '0') echo 'selected="selected"'; ?>><?php echo __('No', 'wbmpl'); ?></option>
                </select>
            </p>
            <div class="wbmpl_show_display_title_options_container" <?php if($instance['display_show_title'] == '0') echo 'style="display: none;"'; ?>>
                <p>
                    <input id="<?php echo $this->get_field_id('display_link_title'); ?>" name="<?php echo $this->get_field_name('display_link_title'); ?>" <?php if($instance['display_link_title']) echo 'checked="checked"'; ?> type="checkbox" />
                    <label for="<?php echo $this->get_field_id('display_link_title'); ?>" style="display: inline;"><?php echo __('Link title', 'wbmpl'); ?></label>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('display_cut_title_size'); ?>"><?php echo __('Cut title after', 'wbmpl'); ?></label>
                    <input class="wbmpl_short" id="<?php echo $this->get_field_id('display_cut_title_size'); ?>" name="<?php echo $this->get_field_name('display_cut_title_size'); ?>" value="<?php echo $instance['display_cut_title_size']; ?>" type="text" />
                    <select id="<?php echo $this->get_field_id('display_cut_title_mode'); ?>" name="<?php echo $this->get_field_name('display_cut_title_mode'); ?>">
                        <option value="0" <?php if($instance['display_cut_title_mode'] == '0') echo 'selected="selected"'; ?>><?php echo __('No cut', 'wbmpl'); ?></option>
                        <option value="1" <?php if($instance['display_cut_title_mode'] == '1') echo 'selected="selected"'; ?>><?php echo __('Characters', 'wbmpl'); ?></option>
                        <option value="2" <?php if($instance['display_cut_title_mode'] == '2') echo 'selected="selected"'; ?>><?php echo __('Words', 'wbmpl'); ?></option>
                    </select>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('display_title_html_tag'); ?>"><?php echo __('Title HTML Tag', 'wbmpl'); ?></label>
                    <select id="<?php echo $this->get_field_id('display_title_html_tag'); ?>" name="<?php echo $this->get_field_name('display_title_html_tag'); ?>" class="widefat">
                        <option value="" <?php if($instance['display_title_html_tag'] == '') echo 'selected="selected"'; ?>>-----</option>
                        <option value="h2" <?php if($instance['display_title_html_tag'] == 'h2') echo 'selected="selected"'; ?>><?php echo __('Heading2', 'wbmpl'); ?></option>
                        <option value="h3" <?php if($instance['display_title_html_tag'] == 'h3') echo 'selected="selected"'; ?>><?php echo __('Heading3', 'wbmpl'); ?></option>
                        <option value="h4" <?php if($instance['display_title_html_tag'] == 'h4') echo 'selected="selected"'; ?>><?php echo __('Heading4', 'wbmpl'); ?></option>
                        <option value="h5" <?php if($instance['display_title_html_tag'] == 'h5') echo 'selected="selected"'; ?>><?php echo __('Heading5', 'wbmpl'); ?></option>
                        <option value="h6" <?php if($instance['display_title_html_tag'] == 'h6') echo 'selected="selected"'; ?>><?php echo __('Heading6', 'wbmpl'); ?></option>
                        <option value="strong" <?php if($instance['display_title_html_tag'] == 'strong') echo 'selected="selected"'; ?>><?php echo __('Bold', 'wbmpl'); ?></option>
                    </select>
                </p>
            </div>
        </fieldset>
        <fieldset class="wbmpl_field_wrapper">
            <legend><?php echo __('Post Content', 'wbmpl'); ?></legend>
            <p>
                <select id="<?php echo $this->get_field_id('display_show_content'); ?>" name="<?php echo $this->get_field_name('display_show_content'); ?>" class="widefat" onchange="wbmpl_change_display_show_status(this.value, 'content');">
                    <option value="1" <?php if($instance['display_show_content'] == '1') echo 'selected="selected"'; ?>><?php echo __('Yes', 'wbmpl'); ?></option>
                    <option value="0" <?php if($instance['display_show_content'] == '0') echo 'selected="selected"'; ?>><?php echo __('No', 'wbmpl'); ?></option>
                </select>
            </p>
            <div class="wbmpl_show_display_content_options_container" <?php if($instance['display_show_content'] == '0') echo 'style="display: none;"'; ?>>
                <p>
                    <input id="<?php echo $this->get_field_id('display_link_content'); ?>" name="<?php echo $this->get_field_name('display_link_content'); ?>" <?php if($instance['display_link_content']) echo 'checked="checked"'; ?> type="checkbox" />
                    <label for="<?php echo $this->get_field_id('display_link_content'); ?>" style="display: inline;"><?php echo __('Link content', 'wbmpl'); ?></label>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('display_cut_content_size'); ?>"><?php echo __('Cut content after', 'wbmpl'); ?></label>
                    <input class="wbmpl_short" id="<?php echo $this->get_field_id('display_cut_content_size'); ?>" name="<?php echo $this->get_field_name('display_cut_content_size'); ?>" value="<?php echo $instance['display_cut_content_size']; ?>" type="text" />
                    <select id="<?php echo $this->get_field_id('display_cut_content_mode'); ?>" name="<?php echo $this->get_field_name('display_cut_content_mode'); ?>">
                        <option value="0" <?php if($instance['display_cut_content_mode'] == '0') echo 'selected="selected"'; ?>><?php echo __('No cut', 'wbmpl'); ?></option>
                        <option value="1" <?php if($instance['display_cut_content_mode'] == '1') echo 'selected="selected"'; ?>><?php echo __('Characters', 'wbmpl'); ?></option>
                        <option value="2" <?php if($instance['display_cut_content_mode'] == '2') echo 'selected="selected"'; ?>><?php echo __('Words', 'wbmpl'); ?></option>
                    </select>
                </p>
            </div>
        </fieldset>
        <fieldset class="wbmpl_field_wrapper">
            <legend><?php echo __('Post Author', 'wbmpl'); ?></legend>
            <p>
                <select id="<?php echo $this->get_field_id('display_show_author'); ?>" name="<?php echo $this->get_field_name('display_show_author'); ?>" class="widefat" onchange="wbmpl_change_display_show_status(this.value, 'author');">
                    <option value="1" <?php if($instance['display_show_author'] == '1') echo 'selected="selected"'; ?>><?php echo __('Yes', 'wbmpl'); ?></option>
                    <option value="0" <?php if($instance['display_show_author'] == '0') echo 'selected="selected"'; ?>><?php echo __('No', 'wbmpl'); ?></option>
                </select>
            </p>
            <div class="wbmpl_show_display_author_options_container" <?php if($instance['display_show_author'] == '0') echo 'style="display: none;"'; ?>>
                <p>
                    <input id="<?php echo $this->get_field_id('display_link_author'); ?>" name="<?php echo $this->get_field_name('display_link_author'); ?>" <?php if($instance['display_link_author']) echo 'checked="checked"'; ?> type="checkbox" />
                    <label for="<?php echo $this->get_field_id('display_link_author'); ?>" style="display: inline;"><?php echo __('Link author', 'wbmpl'); ?></label>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('display_author_label'); ?>"><?php echo __('Author label', 'wbmpl'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('display_author_label'); ?>" name="<?php echo $this->get_field_name('display_author_label'); ?>" value="<?php echo $instance['display_author_label']; ?>" type="text" />
                </p>
            </div>
        </fieldset>
        <fieldset class="wbmpl_field_wrapper">
            <legend><?php echo __('Post Date', 'wbmpl'); ?></legend>
            <p>
                <select id="<?php echo $this->get_field_id('display_show_date'); ?>" name="<?php echo $this->get_field_name('display_show_date'); ?>" class="widefat" onchange="wbmpl_change_display_show_status(this.value, 'date');">
                    <option value="1" <?php if($instance['display_show_date'] == '1') echo 'selected="selected"'; ?>><?php echo __('Yes', 'wbmpl'); ?></option>
                    <option value="0" <?php if($instance['display_show_date'] == '0') echo 'selected="selected"'; ?>><?php echo __('No', 'wbmpl'); ?></option>
                </select>
            </p>
            <div class="wbmpl_show_display_date_options_container" <?php if($instance['display_show_date'] == '0') echo 'style="display: none;"'; ?>>
                <p>
                    <label for="<?php echo $this->get_field_id('display_date_format'); ?>"><?php echo __('Date format', 'wbmpl'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('display_date_format'); ?>" name="<?php echo $this->get_field_name('display_date_format'); ?>" value="<?php echo $instance['display_date_format']; ?>" type="text" />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('display_date_label'); ?>"><?php echo __('Date label', 'wbmpl'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('display_date_label'); ?>" name="<?php echo $this->get_field_name('display_date_label'); ?>" value="<?php echo $instance['display_date_label']; ?>" type="text" />
                </p>
            </div>
        </fieldset>
        <div class="wbmpl_show_display_category_tags_options_container" <?php if($instance['post_type'] != 'post') echo 'style="display: none;"'; ?>>
            <fieldset class="wbmpl_field_wrapper">
                <legend><?php echo __('Post Categories', 'wbmpl'); ?></legend>
                <p>
                    <select id="<?php echo $this->get_field_id('display_show_category'); ?>" name="<?php echo $this->get_field_name('display_show_category'); ?>" class="widefat" onchange="wbmpl_change_display_show_status(this.value, 'category');">
                        <option value="1" <?php if($instance['display_show_category'] == '1') echo 'selected="selected"'; ?>><?php echo __('Yes', 'wbmpl'); ?></option>
                        <option value="0" <?php if($instance['display_show_category'] == '0') echo 'selected="selected"'; ?>><?php echo __('No', 'wbmpl'); ?></option>
                    </select>
                </p>
                <div class="wbmpl_show_display_category_options_container" <?php if($instance['display_show_category'] == '0') echo 'style="display: none;"'; ?>>
                    <p>
                        <input id="<?php echo $this->get_field_id('display_category_link'); ?>" name="<?php echo $this->get_field_name('display_category_link'); ?>" <?php if($instance['display_category_link']) echo 'checked="checked"'; ?> type="checkbox" />
                        <label for="<?php echo $this->get_field_id('display_category_link'); ?>" style="display: inline;"><?php echo __('Link Categories', 'wbmpl'); ?></label>
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('display_category_label'); ?>"><?php echo __('Categories label', 'wbmpl'); ?></label>
                        <input class="widefat" id="<?php echo $this->get_field_id('display_category_label'); ?>" name="<?php echo $this->get_field_name('display_category_label'); ?>" value="<?php echo $instance['display_category_label']; ?>" type="text" />
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('display_category_separator'); ?>"><?php echo __('Categories separator', 'wbmpl'); ?></label>
                        <input class="widefat" id="<?php echo $this->get_field_id('display_category_separator'); ?>" name="<?php echo $this->get_field_name('display_category_separator'); ?>" value="<?php echo $instance['display_category_separator']; ?>" type="text" />
                    </p>
                </div>
            </fieldset>
            <fieldset class="wbmpl_field_wrapper">
                <legend><?php echo __('Post Tags', 'wbmpl'); ?></legend>
                <p>
                    <select id="<?php echo $this->get_field_id('display_show_tags'); ?>" name="<?php echo $this->get_field_name('display_show_tags'); ?>" class="widefat" onchange="wbmpl_change_display_show_status(this.value, 'tags');">
                        <option value="1" <?php if($instance['display_show_tags'] == '1') echo 'selected="selected"'; ?>><?php echo __('Yes', 'wbmpl'); ?></option>
                        <option value="0" <?php if($instance['display_show_tags'] == '0') echo 'selected="selected"'; ?>><?php echo __('No', 'wbmpl'); ?></option>
                    </select>
                </p>
                <div class="wbmpl_show_display_tags_options_container" <?php if($instance['display_show_tags'] == '0') echo 'style="display: none;"'; ?>>
                    <p>
                        <input id="<?php echo $this->get_field_id('display_tags_link'); ?>" name="<?php echo $this->get_field_name('display_tags_link'); ?>" <?php if($instance['display_tags_link']) echo 'checked="checked"'; ?> type="checkbox" />
                        <label for="<?php echo $this->get_field_id('display_tags_link'); ?>" style="display: inline;"><?php echo __('Link Tag', 'wbmpl'); ?></label>
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('display_tags_label'); ?>"><?php echo __('Tags label', 'wbmpl'); ?></label>
                        <input class="widefat" id="<?php echo $this->get_field_id('display_tags_label'); ?>" name="<?php echo $this->get_field_name('display_tags_label'); ?>" value="<?php echo $instance['display_tags_label']; ?>" type="text" />
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('display_tags_separator'); ?>"><?php echo __('Tags separator', 'wbmpl'); ?></label>
                        <input class="widefat" id="<?php echo $this->get_field_id('display_tags_separator'); ?>" name="<?php echo $this->get_field_name('display_tags_separator'); ?>" value="<?php echo $instance['display_tags_separator']; ?>" type="text" />
                    </p>
                </div>
            </fieldset>
        </div>
        <fieldset class="wbmpl_field_wrapper">
            <legend><?php echo __('String Break', 'wbmpl'); ?></legend>
            <p>
                <select id="<?php echo $this->get_field_id('display_show_string_break'); ?>" name="<?php echo $this->get_field_name('display_show_string_break'); ?>" class="widefat" onchange="wbmpl_change_display_show_status(this.value, 'string_break');">
                    <option value="1" <?php if($instance['display_show_string_break'] == '1') echo 'selected="selected"'; ?>><?php echo __('Yes', 'wbmpl'); ?></option>
                    <option value="0" <?php if($instance['display_show_string_break'] == '0') echo 'selected="selected"'; ?>><?php echo __('No', 'wbmpl'); ?></option>
                </select>
            </p>
            <div class="wbmpl_show_display_string_break_options_container" <?php if($instance['display_show_string_break'] == '0') echo 'style="display: none;"'; ?>>
                <p>
                    <label for="<?php echo $this->get_field_id('display_string_break_str'); ?>"><?php echo __('String Break', 'wbmpl'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('display_string_break_str'); ?>" name="<?php echo $this->get_field_name('display_string_break_str'); ?>" value="<?php echo $instance['display_string_break_str']; ?>" type="text" />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('display_string_break_img'); ?>"><?php echo __('String Break Image', 'wbmpl'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('display_string_break_img'); ?>" name="<?php echo $this->get_field_name('display_string_break_img'); ?>" value="<?php echo $instance['display_string_break_img']; ?>" type="text" />
                </p>
                <p>
                    <input id="<?php echo $this->get_field_id('display_link_string_break'); ?>" name="<?php echo $this->get_field_name('display_link_string_break'); ?>" <?php if($instance['display_link_string_break']) echo 'checked="checked"'; ?> type="checkbox" />
                    <label class="widefat" for="<?php echo $this->get_field_id('display_link_string_break'); ?>" style="display: inline;"><?php echo __('Link String Break', 'wbmpl'); ?></label>
                </p>
            </div>
        </fieldset>
    </div>
    <h4 class="wbmpl_widget_tab_header" onclick="wbmpl_slide_tabs('advanced', false, '<?php echo $this->number; ?>');"><i class="fa fa-gear"></i><?php echo __('Advanced Options', 'wbmpl'); ?></h4>
    <div class="wbmpl_widget_tab_container wbmpl_widget_tab_advanced" style="display: none;">
    	<p>
        	<label for="<?php echo $this->get_field_id('allowed_html_tags'); ?>"><?php echo __('Allowed HTML tags for content', 'wbmpl'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('allowed_html_tags'); ?>" name="<?php echo $this->get_field_name('allowed_html_tags'); ?>" value="<?php echo $instance['allowed_html_tags']; ?>" type="text" />
        </p>
    	<p>
        	<label for="<?php echo $this->get_field_id('no_post_default_text'); ?>"><?php echo __('No post default text', 'wbmpl'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('no_post_default_text'); ?>" name="<?php echo $this->get_field_name('no_post_default_text'); ?>" value="<?php echo $instance['no_post_default_text']; ?>" type="text" />
        </p>
    </div>
    <h4 class="wbmpl_widget_tab_header" onclick="wbmpl_slide_tabs('layout', false, '<?php echo $this->number; ?>');"><i class="fa fa-desktop"></i><?php echo __('Layout Options', 'wbmpl'); ?></h4>
    <div class="wbmpl_widget_tab_container wbmpl_widget_tab_layout" style="display: none;">
        <?php if(!$this->main->getPRO()) echo $this->main->pro_messages('more_layouts'); ?>
        <fieldset class="wbmpl_field_wrapper">
            <legend><?php echo __('Widget Layout', 'wbmpl'); ?></legend>
            <p>
                <select id="<?php echo $this->get_field_id('display_layout'); ?>" name="<?php echo $this->get_field_name('display_layout'); ?>" class="widefat" onchange="wbmpl_load_widget_form('<?php echo $this->id_base; ?>', <?php echo $this->number; ?>, this.value, '<?php echo $this->get_field_id('display_layout_container'); ?>');">
                    <?php foreach($widget_layouts as $widget_layout): ?>
                    <option value="<?php echo $widget_layout; ?>" <?php if($widget_layout == $instance['display_layout']) echo 'selected="selected"'; ?>><?php echo ucfirst(str_replace('_', ' ', str_replace('.php', '', $widget_layout))); ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <div id="<?php echo $this->get_field_id('display_layout_container'); ?>">
                <?php
                if(isset($instance['display_layout']) and $instance['display_layout'])
                {
                    $layout_path = $this->main->import($this->formspath.'.'.str_replace('.php', '', $instance['display_layout']), true, true);
                    include $layout_path;
                }
                ?>
            </div>
        </fieldset>
    </div>
    <h4 class="wbmpl_widget_tab_header" onclick="wbmpl_slide_tabs('code', false, '<?php echo $this->number; ?>');"><i class="fa fa-code"></i><?php echo __('Shortcode and PHP code', 'wbmpl'); ?></h4>
    <div class="wbmpl_widget_tab_container wbmpl_widget_tab_code" style="display: none;">
        <?php if($this->main->getPRO()): ?>
        <p class="wbmpl_notice_message"><?php echo __('Save to see updated Shortcode and PHP code.', 'wbmpl'); ?></p>
        <p>
            <label for="<?php echo $this->get_field_id('shortcode'); ?>"><?php echo __('Shortcode', 'wbmpl'); ?></label>
            <textarea class="widefat wbmpl_shortcode" id="<?php echo $this->get_field_id('shortcode'); ?>" name="<?php echo $this->get_field_name('shortcode'); ?>"><?php echo isset($instance['shortcode']) ? $instance['shortcode'] : ''; ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('phpcode'); ?>"><?php echo __('PHP code', 'wbmpl'); ?></label>
            <textarea class="widefat wbmpl_phpcode" id="<?php echo $this->get_field_id('phpcode'); ?>" name="<?php echo $this->get_field_name('phpcode'); ?>"><?php echo isset($instance['phpcode']) ? $instance['phpcode'] : ''; ?></textarea>
        </p>
        <?php else: echo $this->main->pro_messages('upgrade'); ?>
        <?php endif; ?>
    </div>
</div>