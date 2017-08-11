<?php
/** no direct access **/
defined('_WBMPLEXEC_') or die();

// Get layout path
$render_path = $this->main->import('app.widgets.MPL.tmpl.render.'.$layout_name, true, true);

ob_start();
include $render_path;
$items_html = ob_get_clean();

if(isset($instance['mpl_return_items']) and trim($instance['mpl_return_items']))
{
    echo json_encode(array('html'=>$items_html, 'raw'=>$rendered));
    return;
}

// Pagination Type
$pagination = (isset($instance['layout_pagination']) and trim($instance['layout_pagination'])) ? $instance['layout_pagination'] : WBMPL_PG_NO;
?>
<div <?php echo $this->posts->generate_container_classes($this->widget_id, $instance); ?>>
    <?php if(trim($widget_title) != '') echo '<div class="wbmpl_main_title">'.$before_title.$widget_title.$after_title.'</div>'; ?>
    <?php if(count($rendered)): ?>
    <ul class="<?php echo ((isset($instance['layout_display']) and $instance['layout_display'] == '2') ? 'wbmpl_grid wbmpl_grid'.$instance['layout_grid_size'] : 'wbmpl_list'); ?>">
        <?php echo $items_html; ?>
    </ul>
    <?php if($pagination == WBMPL_PG_LOAD_MORE and $mplpage < $total_pages and $this->main->getPRO()): ?>
    <div class="wbmpl_pagination">
        <button><i class="fa fa-plus"></i><?php echo __('Load More', 'wbmpl'); ?></button>
        <i class="fa fa-spinner fa-spin fa-5x fa-fw"></i>
    </div>
    <?php endif; ?>
    <?php else: ?>
    <div class="wbmpl_no_posts"><?php echo $instance['no_post_default_text']; ?></div>
    <?php endif; ?>
</div>