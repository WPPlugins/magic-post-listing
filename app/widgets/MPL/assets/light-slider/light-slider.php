<?php
/** no direct access **/
defined('_WBMPLEXEC_') or die();

// Include light-slider CSS file
wp_enqueue_style('mpl-light-slider-css', $this->main->URL('WBMPL').'app/widgets/MPL/assets/light-slider/css/light-slider.css');

// Include owl JavaScript file
wp_enqueue_script('mpl-light-slider-js', $this->main->URL('WBMPL').'app/widgets/MPL/assets/light-slider/js/jquery.light-slider.min.js');

// Slider ttem count
$item = isset($instance['layout_item']) ? $instance['layout_item'] : 3;

// How many items move on each slide
$slide_move = isset($instance['layout_slide_move']) ? $instance['layout_slide_move'] : 1;

// Generating javascript code of the widget
$javascript = '<script type="text/javascript">
jQuery(document).ready(function()
{
    jQuery("#'.$this->posts->get_container_id($this->widget_id).' ul").lightSlider(
    {
        item: '.$item.',
        slideMove: '.$slide_move.',
        mode: "'.(isset($instance['layout_mode']) ? $instance['layout_mode'] : 'slide').'",
        vertical: '.((isset($instance['layout_vertical']) and $instance['layout_vertical']) ? 'true' : 'false').',
        verticalHeight: '.(isset($instance['layout_vertical_height']) ? $instance['layout_vertical_height'] : 200).',
        pager: '.((isset($instance['layout_pager']) and $instance['layout_pager']) ? 'true' : 'false').',
        controls: '.((isset($instance['layout_controls']) and $instance['layout_controls']) ? 'true' : 'false').',
        loop: '.((isset($instance['layout_loop']) and $instance['layout_loop']) ? 'true' : 'false').',
        auto: '.((isset($instance['layout_auto']) and $instance['layout_auto']) ? 'true' : 'false').',
        rtl: '.((isset($instance['layout_rtl']) and $instance['layout_rtl']) ? 'true' : 'false').',
        speed: '.(isset($instance['layout_speed']) ? $instance['layout_speed'] : 400).',
        pause: '.(isset($instance['layout_pause']) ? $instance['layout_pause'] : 2000).',
        responsive: [
            {
                breakpoint: 800,
                settings: {
                    item: '.min(array($item, 3)).',
                    slideMove: '.min(array($slide_move, 1)).'
                }
            },
            {
                breakpoint: 480,
                settings: {
                    item: '.min(array($item, 1)).',
                    slideMove: '.min(array($slide_move, 1)).'
                }
            }
        ]
    });
});
</script>';

// Include javascript code into the footer
$this->factory->params('footer', $javascript);