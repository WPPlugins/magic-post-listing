<?php
/** no direct access **/
defined('_WBMPLEXEC_') or die();
?>
<?php foreach($rendered as $post): ?>
<li id="wbmpl_list_container<?php echo $this->widget_id; ?>_<?php echo $post['ID']; ?>" class="wbmpl_list_container">
    <?php if($instance['thumb_show']): ?>
    <div class="wbmpl_list_thumbnail" id="wbmpl_list_thumbnail<?php echo $this->widget_id; ?>_<?php echo $post['ID']; ?>">
        <?php echo $this->posts->render_thumbnail($post['rendered']['thumbnail'], $instance, $post); ?>
    </div>
    <?php endif; ?>
    <div class="wbmpl_list_right" id="wbmpl_list_right<?php echo $this->widget_id; ?>_<?php echo $post['ID']; ?>">

        <?php if($instance['display_show_title']): ?>
        <div class="wbmpl_list_title" id="wbmpl_list_title<?php echo $this->widget_id; ?>_<?php echo $post['ID']; ?>">
            <?php echo $this->posts->render_title($post['post_title'], $instance, $post); ?>
        </div>
        <?php endif; ?>

        <?php if($instance['display_show_content']): ?>
        <div class="wbmpl_list_content" id="wbmpl_list_content<?php echo $this->widget_id; ?>_<?php echo $post['ID']; ?>">
            <?php echo $this->posts->render_content($post['post_content'], $instance, $post); ?>
        </div>
        <?php endif; ?>

    </div>
    <div class="wbmpl_list_details" id="wbmpl_list_details<?php echo $this->widget_id; ?>_<?php echo $post['ID']; ?>">
        <?php if($instance['display_show_author']): ?>
        <div class="wbmpl_list_author" id="wbmpl_list_author<?php echo $this->widget_id; ?>_<?php echo $post['ID']; ?>">
            <?php echo $this->posts->render_author($post['post_author'], $instance); ?>
        </div>
        <?php endif; ?>

        <?php if($instance['display_show_date']): ?>
        <div class="wbmpl_list_date" id="wbmpl_list_date<?php echo $this->widget_id; ?>_<?php echo $post['ID']; ?>">
            <?php echo $this->posts->render_date($post['ID'], $instance); ?>
        </div>
        <?php endif; ?>

        <?php if($instance['display_show_category'] and $instance['post_type'] == 'post'): ?>
        <div class="wbmpl_list_categories" id="wbmpl_list_categories<?php echo $this->widget_id; ?>_<?php echo $post['ID']; ?>">
            <?php echo $this->posts->render_categories($post['ID'], $instance); ?>
        </div>
        <?php endif; ?>

        <?php if($instance['display_show_tags'] and $instance['post_type'] == 'post'): ?>
        <div class="wbmpl_list_tags" id="wbmpl_list_tags<?php echo $this->widget_id; ?>_<?php echo $post['ID']; ?>">
            <?php echo $this->posts->render_tags($post['ID'], $instance); ?>
        </div>
        <?php endif; ?>
    </div>
</li>
<?php endforeach; ?>