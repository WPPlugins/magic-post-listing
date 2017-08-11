<?php
/** no direct access **/
defined('_WBMPLEXEC_') or die();
?>
<p>
    <label for="<?php echo $this->get_field_id('layout_mode'); ?>"><?php echo __('Mode', 'wbmpl'); ?></label>
    <select id="<?php echo $this->get_field_id('layout_mode'); ?>" name="<?php echo $this->get_field_name('layout_mode'); ?>" class="widefat">
        <option value="slide" <?php echo ((isset($instance['layout_mode']) and $instance['layout_mode'] == 'slide') ? 'selected="selected"' : ''); ?>><?php echo __('Slide', 'wbmpl'); ?></option>
        <option value="fade" <?php echo ((isset($instance['layout_mode']) and $instance['layout_mode'] == 'fade') ? 'selected="selected"' : ''); ?>><?php echo __('Fade', 'wbmpl'); ?></option>
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id('layout_speed'); ?>"><?php echo __('Speed', 'wbmpl'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('layout_speed'); ?>" name="<?php echo $this->get_field_name('layout_speed'); ?>" value="<?php echo (isset($instance['layout_speed']) ? $instance['layout_speed'] : 400); ?>" type="text" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('layout_pause'); ?>"><?php echo __('Pause', 'wbmpl'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('layout_pause'); ?>" name="<?php echo $this->get_field_name('layout_pause'); ?>" value="<?php echo (isset($instance['layout_pause']) ? $instance['layout_pause'] : 2000); ?>" type="text" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('layout_item'); ?>"><?php echo __('Items', 'wbmpl'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('layout_item'); ?>" name="<?php echo $this->get_field_name('layout_item'); ?>" value="<?php echo (isset($instance['layout_item']) ? $instance['layout_item'] : 3); ?>" type="text" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('layout_slide_move'); ?>"><?php echo __('Slide Move', 'wbmpl'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('layout_slide_move'); ?>" name="<?php echo $this->get_field_name('layout_slide_move'); ?>" value="<?php echo (isset($instance['layout_slide_move']) ? $instance['layout_slide_move'] : 1); ?>" type="text" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('layout_pager'); ?>"><?php echo __('Pager', 'wbmpl'); ?></label>
    <select id="<?php echo $this->get_field_id('layout_pager'); ?>" name="<?php echo $this->get_field_name('layout_pager'); ?>" class="widefat">
        <option value="1" <?php echo ((isset($instance['layout_pager']) and $instance['layout_pager'] == '1') ? 'selected="selected"' : ''); ?>><?php echo __('Yes', 'wbmpl'); ?></option>
        <option value="0" <?php echo ((isset($instance['layout_pager']) and $instance['layout_pager'] == '0') ? 'selected="selected"' : ''); ?>><?php echo __('No', 'wbmpl'); ?></option>
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id('layout_controls'); ?>"><?php echo __('Controls', 'wbmpl'); ?></label>
    <select id="<?php echo $this->get_field_id('layout_controls'); ?>" name="<?php echo $this->get_field_name('layout_controls'); ?>" class="widefat">
        <option value="1" <?php echo ((isset($instance['layout_controls']) and $instance['layout_controls'] == '1') ? 'selected="selected"' : ''); ?>><?php echo __('Yes', 'wbmpl'); ?></option>
        <option value="0" <?php echo ((isset($instance['layout_controls']) and $instance['layout_controls'] == '0') ? 'selected="selected"' : ''); ?>><?php echo __('No', 'wbmpl'); ?></option>
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id('layout_auto'); ?>"><?php echo __('Auto Play', 'wbmpl'); ?></label>
    <select id="<?php echo $this->get_field_id('layout_auto'); ?>" name="<?php echo $this->get_field_name('layout_auto'); ?>" class="widefat">
        <option value="1" <?php echo ((isset($instance['layout_auto']) and $instance['layout_auto'] == '1') ? 'selected="selected"' : ''); ?>><?php echo __('Yes', 'wbmpl'); ?></option>
        <option value="0" <?php echo ((isset($instance['layout_auto']) and $instance['layout_auto'] == '0') ? 'selected="selected"' : ''); ?>><?php echo __('No', 'wbmpl'); ?></option>
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id('layout_loop'); ?>"><?php echo __('Loop', 'wbmpl'); ?></label>
    <select id="<?php echo $this->get_field_id('layout_loop'); ?>" name="<?php echo $this->get_field_name('layout_loop'); ?>" class="widefat">
        <option value="0" <?php echo ((isset($instance['layout_loop']) and $instance['layout_loop'] == '0') ? 'selected="selected"' : ''); ?>><?php echo __('No', 'wbmpl'); ?></option>
        <option value="1" <?php echo ((isset($instance['layout_loop']) and $instance['layout_loop'] == '1') ? 'selected="selected"' : ''); ?>><?php echo __('Yes', 'wbmpl'); ?></option>
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id('layout_vertical'); ?>"><?php echo __('Vertical', 'wbmpl'); ?></label>
    <select id="<?php echo $this->get_field_id('layout_vertical'); ?>" name="<?php echo $this->get_field_name('layout_vertical'); ?>" class="widefat">
        <option value="0" <?php echo ((isset($instance['layout_vertical']) and $instance['layout_vertical'] == '0') ? 'selected="selected"' : ''); ?>><?php echo __('No', 'wbmpl'); ?></option>
        <option value="1" <?php echo ((isset($instance['layout_vertical']) and $instance['layout_vertical'] == '1') ? 'selected="selected"' : ''); ?>><?php echo __('Yes', 'wbmpl'); ?></option>
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id('layout_vertical_height'); ?>"><?php echo __('Vertical Height', 'wbmpl'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('layout_vertical_height'); ?>" name="<?php echo $this->get_field_name('layout_vertical_height'); ?>" value="<?php echo (isset($instance['layout_vertical_height']) ? $instance['layout_vertical_height'] : 200); ?>" type="text" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('layout_rtl'); ?>"><?php echo __('RTL', 'wbmpl'); ?></label>
    <select id="<?php echo $this->get_field_id('layout_rtl'); ?>" name="<?php echo $this->get_field_name('layout_rtl'); ?>" class="widefat">
        <option value="0" <?php echo ((isset($instance['layout_rtl']) and $instance['layout_rtl'] == '0') ? 'selected="selected"' : ''); ?>><?php echo __('No', 'wbmpl'); ?></option>
        <option value="1" <?php echo ((isset($instance['layout_rtl']) and $instance['layout_rtl'] == '1') ? 'selected="selected"' : ''); ?>><?php echo __('Yes', 'wbmpl'); ?></option>
    </select>
</p>