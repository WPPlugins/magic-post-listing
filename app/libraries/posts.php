<?php
/** no direct access **/
defined('_WBMPLEXEC_') or die();

/**
 * Webilia MPL post class.
 * @author Webilia <info@webilia.com>
 */
class WBMPL_posts extends WBMPL_base
{
    /**
     * Constructor method
     * @author Webilia <info@webilia.com>
     */
    public function __construct()
    {
        // MPL Posts library
        $this->posts = $this;
        
        // MPL Main library
        $this->main = $this->getMain();
        
        // MPL DB library
        $this->db = $this->getDB();
        
        // MPL File library
        $this->file = $this->getFile();
        
        // MPL Folder library
        $this->folder = $this->getFolder();
        
        // MPL Factory library
        $this->factory = $this->getFactory();
    }
    
    /**
     * Get post/page query
     * @author Webilia <info@webilia.com>
     * @param array $params
     * @return string
     */
	public function get_query($params)
	{
        // Search only on published posts
		$condition1 = "`post_status`='publish'";
        $condition2 = "";
        $join = "";
		
		// Include post type to query
		if(trim($params['post_type']) != '') $condition1 .= " AND `post_type`='".$params['post_type']."'";
		
		// Include post authors to query
		if(trim($params['post_authors']) != '') $condition1 .= " AND `post_author` IN (".$params['post_authors'].")";
        
        // Exclude current post from query
		if(trim($params['exclude_current_post']) and is_singular())
        {
            $current_post_id = get_queried_object_id();
            if($current_post_id) $condition1 .= " AND `ID` NOT IN (".$current_post_id.")";
        }
		
		// Include post queries
		if($params['post_type'] == 'post')
		{
            // Include current Category
            if(is_category() and isset($params['include_current_category']) and $params['include_current_category'])
            {
                $category = get_category(get_query_var('cat'));
                $condition1 .= " AND `ID` IN (SELECT `object_id` FROM `#__term_relationships` WHERE `term_taxonomy_id` IN (".$this->get_taxonomy_ids($category->cat_ID)."))";
            }
            elseif(trim($params['post_categories']) != '' and trim($params['post_categories']) != '-1')
            {
                $condition1 .= " AND `ID` IN (SELECT `object_id` FROM `#__term_relationships` WHERE `term_taxonomy_id` IN (".$this->get_taxonomy_ids($params['post_categories'])."))";
            }
            
            // Include current Tag
            if(is_tag() and isset($params['include_current_tag']) and $params['include_current_tag'])
            {
                $queried_object = get_queried_object();
                $condition1 .= " AND `ID` IN (SELECT `object_id` FROM `#__term_relationships` WHERE `term_taxonomy_id` IN (".$this->get_taxonomy_ids($queried_object->term_id)."))";
            }
            elseif(trim($params['post_tags']) != '')
            {
                $condition1 .= " AND `ID` IN (SELECT `object_id` FROM `#__term_relationships` WHERE `term_taxonomy_id` IN (".$this->get_taxonomy_ids_by_names($params['post_tags'])."))";
            }
			
            // Include posts
			if(trim($params['include_post_ids']) != '') $condition2 .= " OR `ID` IN (".$params['include_post_ids'].")";
            
            // Exclude posts
			if(trim($params['exclude_post_ids']) != '') $condition1 .= " AND `ID` NOT IN (".$params['exclude_post_ids'].")";
		}
		// include page queries
		elseif($params['post_type'] == 'page')
		{
            // Include post parent
			$condition1 .= " AND `post_parent`='".$params['parent_page']."'";
            
            // Include pages
			if(trim($params['include_page_ids']) != '') $condition2 .= " OR `ID` IN (".$params['include_page_ids'].")";
            
			// Exclude pages
            if(trim($params['exclude_page_ids']) != '') $condition1 .= " AND `ID` NOT IN (".$params['exclude_page_ids'].")";
		}
        // include custom post type queries
        else
        {
            $post_type = $params['post_type'];
            foreach($params as $key=>$value)
            {
                if(is_string($value) and (trim($value) == '' or trim($value == '-1'))) continue;
                if(strpos($key, 'cpost_'.$post_type.'_terms_') === false) continue;
                
                $condition1 .= " AND `ID` IN (SELECT `object_id` FROM `#__term_relationships` WHERE `term_taxonomy_id` IN (".$this->get_taxonomy_ids($value)."))";
            }
			
            // Include Posts
			if(isset($params['cpost_'.$post_type.'_include_post_ids']) and trim($params['cpost_'.$post_type.'_include_post_ids']) != '') $condition2 .= " OR `ID` IN (".$params['cpost_'.$post_type.'_include_post_ids'].")";
            
            // Exclude Posts
			if(isset($params['cpost_'.$post_type.'_exclude_post_ids']) and trim($params['cpost_'.$post_type.'_exclude_post_ids']) != '') $condition1 .= " AND `ID` NOT IN (".$params['cpost_'.$post_type.'_exclude_post_ids'].")";
        }
		
        // Skip post if no image found
        if(isset($params['thumb_skip']) and $params['thumb_skip'])
        {
            $condition1 .= " AND `#__postmeta`.meta_key='_thumbnail_id'";
            $join .= "LEFT JOIN `#__postmeta` ON `#__posts`.ID=`#__postmeta`.post_id";
        }
            
        $condition2 = trim($condition2, 'OR ');
        
		// Order and Size
		$order_limit = " ORDER BY `".($params['listing_orderby'] ? $params['listing_orderby'] : 'post_date')."` ".($params['listing_order'] ? $params['listing_order'] : 'DESC')." LIMIT ".(isset($params['listing_offset']) ? $params['listing_offset'].', ' : '').($params['listing_size'] ? $params['listing_size'] : 10);
        
        // Return the query
        return "SELECT * FROM `#__posts` ".(trim($join) ? $join : '')." WHERE (".$condition1.") ".(trim($condition2) != '' ? " OR (".$condition2.")" : '').$order_limit;
	}
	
    /**
     * Get taxonomy IDs by term IDs
     * @author Webilia <info@webilia.com>
     * @param string $term_ids
     * @return string
     */
	public function get_taxonomy_ids($term_ids)
	{
		$query = "SELECT `term_taxonomy_id` FROM `#__term_taxonomy` WHERE `term_id` IN (".$term_ids.")";
		$taxonomy_ids = $this->db->select($query, 'loadAssocList');
		
		$taxonomy_str = '';
		foreach($taxonomy_ids as $taxonomy_id)
		{
			$taxonomy_str .= $taxonomy_id['term_taxonomy_id'].",";
		}
		
		return trim($taxonomy_str, ', ');
	}
	
    /**
     * Get WordPress terms IDs by term names
     * @author Webilia <info@webilia.com>
     * @param string $names
     * @return string
     */
	public function get_term_ids($names)
	{
		$query = "SELECT `term_id` FROM `#__terms` WHERE `name` IN (".$names.")";
		$term_ids = $this->db->select($query, 'loadAssocList');
		
		$term_str = '';
		foreach($term_ids as $term_id)
		{
			$term_str .= $term_id['term_id'].",";
		}
		
		return trim($term_str, ', ');
	}
	
    /**
     * Get taxonomy IDs by taxonomy names
     * @author Webilia <info@webilia.com>
     * @param string $names
     * @return array
     */
	public function get_taxonomy_ids_by_names($names)
	{
		$ex = explode(',', $names);
		
		$names_str = '';
		foreach($ex as $key=>$value)
		{
			$value = trim($value, "' ");
			$names_str .= "'".$value."',";
		}
		
		return $this->get_taxonomy_ids($this->get_term_ids(trim($names_str, ', ')));
	}
	
    /**
     * Get WordPress categories
     * @author Webilia <info@webilia.com>
     * @param int $post_id
     * @return array
     */
	public function get_categories($post_id)
	{
        // Get the categories
		$post_categories = wp_get_post_categories($post_id);
		$cats = array();
		
        // Render the categories
		foreach($post_categories as $c)
		{
          	$cat = get_category($c);
			$cats[] = array('id'=>$c, 'name'=>$cat->name, 'slug'=>$cat->slug, 'link'=>get_category_link($c));
		}
		
		return $cats;
	}
	
    /**
     * Get WordPress post tags
     * @author Webilia <info@webilia.com>
     * @param int $post_id
     * @return array
     */
	public function get_tags($post_id)
	{
        // Get the tags
		$post_tags = wp_get_post_tags($post_id);
        $tags = array();
		
        // Render tags
		foreach($post_tags as $tag)
		{
			$tags[] = array('id'=>$tag->term_id, 'name'=>$tag->name, 'slug'=>$tag->slug, 'link'=>get_tag_link($tag->term_id));
		}
		
		return $tags;
	}
	
    /**
     * Get post/page thumbnail
     * @author Webilia <info@webilia.com>
     * @param int $post_id
     * @param array $size
     * @return string
     */
	public function get_thumbnail($post_id, $size = array(100, 100))
	{
		return get_the_post_thumbnail($post_id, $size);
	}
    
    /**
     * Add HTML tag to a element
     * @author Webilia <info@webilia.com>
     * @param string $content
     * @param string $tag
     * @return string
     */
    public function add_html_tag($content, $tag = '')
	{
        if(!trim($tag)) return $content;
		
        return '<'.$tag.'>'.$content.'</'.$tag.'>';
	}
	
    /**
     * Returns post URL
     * @author Webilia <info@webilia.com>
     * @param int $post_id
     * @return string
     */
	public function get_post_url($post_id)
	{
		return get_permalink($post_id);
	}
    
    /**
     * Render WordPress posts/pages
     * @author Webilia <info@webilia.com>
     * @param array $posts
     * @param array $instance
     * @return array
     */
	public function render($posts, $instance = array())
	{
		$rendered = array();
        
        // Render posts
		foreach($posts as $post)
		{
			$post_id = $post->ID;
            
            // Get post thumbnails
            $thumbnail = $this->get_thumbnail($post_id, array($instance['thumb_width'], $instance['thumb_height']));
            
            $rendered[$post_id] = (array) $post;
            
            // Set post thumbnail
			$rendered[$post_id]['rendered']['thumbnail'] = $thumbnail;
            
            // Get post link
			$rendered[$post_id]['rendered']['link'] = $this->get_post_url($post_id);
		}
        
		return $rendered;
	}
	
    /**
     * Get default options of MPL widget
     * @author Webilia <info@webilia.com>
     * @return array
     */
	public function get_default_args()
	{
		return array(
			  'show_widget_title'=>'1', 'widget_title'=>'Related Posts', 'widget_title_url'=>'', 'widget_url_target'=>'_self', 'widget_css_classes'=>'', 'widget_main_color'=>'#345d81',
              'widget_main_color_ignore'=>0, 'post_type'=>'post','post_authors'=>'', 'listing_orderby'=>'post_date', 'listing_order'=>'DESC', 'listing_size'=>'10', 'include_page_ids'=>'',
              'parent_page'=>'0', 'exclude_page_ids'=>'', 'post_categories'=>'-1', 'include_current_category'=>'0', 'post_tags'=>'', 'include_current_tag'=>'0', 'include_post_ids'=>'', 'exclude_post_ids'=>'', 'cpost'=>array(), 'exclude_current_post'=>'1',
			  'thumb_show'=>'1', 'thumb_width'=>'100', 'thumb_height'=>'100', 'thumb_link'=>'1', 'thumb_skip'=>'0',
			  'display_show_title'=>'1', 'display_link_title'=>'0', 'display_cut_title_size'=>'100', 'display_cut_title_mode'=>'1', 'display_title_html_tag'=>'',
			  'display_show_content'=>'1', 'display_link_content'=>'0', 'display_cut_content_size'=>'300', 'display_cut_content_mode'=>'1',
			  'display_show_author'=>'1', 'display_link_author'=>'0', 'display_author_label'=>'',
			  'display_show_date'=>'0', 'display_date_format'=>'Default', 'display_date_label'=>'',
			  'display_show_category'=>'0', 'display_category_link'=>'0', 'display_category_label'=>'', 'display_category_separator'=>'',
			  'display_show_tags'=>'0', 'display_tags_link'=>'0', 'display_tags_label'=>'', 'display_tags_separator'=>'',
			  'display_show_string_break'=>'1', 'display_string_break_str'=>'...', 'display_string_break_img'=>'', 'display_link_string_break'=>'1',
			  'allowed_html_tags'=>'', 'no_post_default_text'=>'No posts!', 'display_layout'=>'default.php'
		);
	}
	
    /**
     * Generate shortcodes and PHP codes
     * @author Webilia <info@webilia.com>
     * @param array $instance
     * @return array
     */
	public function generate_codes($instance)
	{
		$shortcode = '';
		$phpcode = '';
        
        // Get default arguments
		$defaults = $this->get_default_args();
		
		foreach($instance as $key=>$value)
		{
            // Skip the options that are equals to default option
			if(in_array($key, array('shortcode', 'phpcode')) or (isset($defaults[$key]) and $defaults[$key] == $value) or (trim($value) == '')) continue;
            
            // Add to shortcodes
            $shortcode .= ' '.$key.'="'.$value.'"';
            
            // Add to PHP codes
            $phpcode .= "'".$key."'=>'".$value."', ";
		}
		
        // Generate shortcodes
		$shortcode = '[WBMPL'.(trim($shortcode) ? ' '.trim($shortcode) : '').']';
        
		$php_str  = '<?php'.PHP_EOL;
		$php_str .= '$params = array('.trim($phpcode, ", ").');'.PHP_EOL;
        $php_str .= '$WBMPL_pro = WBMPL::getInstance("app.libraries.pro");'.PHP_EOL;
		$php_str .= 'echo $WBMPL_pro->mpl($params);'.PHP_EOL;
		$php_str .= '?>';
        
        // Generate PHP code
		$phpcode = $php_str;
		
		return array('shortcode'=>$shortcode, 'phpcode'=>$phpcode);
	}
	
    /**
     * Render post title
     * @author Webilia <info@webilia.com>
     * @param string $title
     * @param array $instance
     * @param array $post
     * @return string
     */
	public function render_title($title, $instance, $post)
	{
		// Get default options if the instance didn't set
		if(!$instance) $instance = $this->get_default_args();
		if(!$instance['display_show_title']) return '';
		
		$title = strip_tags($title, $instance['allowed_html_tags']);
		$need_to_cut = false;
		
        $cutted = $title;
        
        // Cut the title based on character
		if($instance['display_cut_title_mode'] == 1) $cutted = substr($title, 0, $instance['display_cut_title_size']);
        // Cut the title based on words
		elseif($instance['display_cut_title_mode'] == 2)
        {
            $ex = explode(' ', $title);
            $ex = array_slice($ex, 0, $instance['display_cut_title_size']);
            $cutted = implode(' ', $ex);
        }
        
        // Post title cutted
		if($title != $cutted)
		{
			$title = $cutted;
			$need_to_cut = true;
		}
        
        // Add break string if enabled
		$break_str = '';
		if($instance['display_show_string_break']) $break_str = trim($instance['display_string_break_img']) != '' ? '<img src="'.$instance['display_string_break_img'].'" class="wbpml_list_break_image" />' : $instance['display_string_break_str'];
		
        // Add links to the post titles
		if($instance['display_link_title'])
		{
            // Title is cutted
			if($need_to_cut)
			{
                // Add link to the string break
				if($instance['display_link_string_break']) $title = '<a href="'.$post['rendered']['link'].'" target="'.$instance['widget_url_target'].'" class="wbpml_list_title_link">'.$this->add_html_tag($title." ".$break_str, $instance['display_title_html_tag']).'</a>';
				else $title = '<a href="'.$post['rendered']['link'].'" target="'.$instance['widget_url_target'].'" class="wbpml_list_title_link">'.$this->add_html_tag($title, $instance['display_title_html_tag']).'</a> '.$break_str;
			}
			else $title = '<a href="'.$post['rendered']['link'].'" target="'.$instance['widget_url_target'].'" class="wbpml_list_title_link">'.$this->add_html_tag($title, $instance['display_title_html_tag']).'</a>';
		}
        // No need to add links to the post titles
		else
		{
            // Title is cutted
			if($need_to_cut)
			{
                // Add link to the string break
				if($instance['display_link_string_break']) $title = $this->add_html_tag($title, $instance['display_title_html_tag']).' <a href="'.$post['rendered']['link'].'" target="'.$instance['widget_url_target'].'" class="wbpml_list_string_break_link">'.$break_str.'</a>';
				else $title = $this->add_html_tag($title." ".$break_str, $instance['display_title_html_tag']);
			}
		}
        
		return $this->close_html_tags($title);
	}
	
    /**
     * Render post date
     * @author Webilia <info@webilia.com>
     * @param int $post_id
     * @param array $instance
     * @return string
     */
    public function render_date($post_id, $instance, $icon = true)
    {
        // Get date format
        if(strtolower($instance['display_date_format']) == 'default') $format = get_option('date_format');
        else $format = $instance['display_date_format'];
        
        // Get post date
		$date = get_the_date($format, $post_id);
        
        // Add label if enabled
        if(trim($instance['display_date_label'])) $date = __($instance['display_date_label'], 'wbmpl').' '.$date;
        
        // Add fa icon
        if($icon) $date = '<i class="fa fa-clock-o"></i>'.$date;
        
        return $date;
    }
    
    /**
     * Render post field
     * @author Webilia <info@webilia.com>
     * @param int $post_id
     * @param string $key
     * @param boolean $single
     * @return mixed
     */
    public function render_field($post_id, $key, $single = false)
    {
		return get_post_meta($post_id, $key, $single);
    }
    
    /**
     * Render post author
     * @author Webilia <info@webilia.com>
     * @param int $author_id
     * @param array $instance
     * @return string
     */
    public function render_author($author_id, $instance, $icon = true)
    {
        // Get post author link
        $link = get_author_posts_url($author_id);
        
        // Get display name of author
        $display_name = get_the_author_meta('display_name', $author_id);
        if(trim($display_name)) $display_name = get_the_author_meta('nickname', $author_id);
        
        $author = '';
        
        // Add author link if enabled
        if($instance['display_link_author']) $author = '<a href="'.$link.'" target="'.$instance['widget_url_target'].'">'.$display_name.'</a>';
        else $author = $display_name;
        
        // Add author label if enabled
        if(trim($instance['display_author_label'])) $author = __($instance['display_author_label'], 'wbmpl').' '.$author;
        
        // Add fa icon
        if($icon) $author = '<i class="fa fa-user"></i>'.$author;
        
        return $author;
    }
    
    /**
     * Render post categories
     * @author Webilia <info@webilia.com>
     * @param int $post_id
     * @param array $instance
     * @return string
     */
    public function render_categories($post_id, $instance, $icon = true)
    {
        // Get post categories
        $categories = $this->get_categories($post_id);
        
        $str = '';
        if(!count($categories)) return $str;
        
        // Get category separator
        $separator = trim($instance['display_category_separator']) ? $instance['display_category_separator'] : ', ';
        foreach($categories as $category)
        {
            // Category name
            $category_name = __($category['name'], 'wbmpl');
            
            // Add category link
            if($instance['display_category_link']) $category_name = '<a href="'.$category['link'].'" target="'.$instance['widget_url_target'].'">'.$category_name.'</a>';
            
            $str .= $category_name.$separator;
        }
        
        // Add category label if enabled
        if(trim($instance['display_category_label'])) $str = __($instance['display_category_label'], 'wbmpl').$str;
        
        // Add fa icon
        if($icon) $str = '<i class="fa fa-list"></i>'.$str;
        
        return trim($str, $separator);
    }
    
    /**
     * Render post tags
     * @author Webilia <info@webilia.com>
     * @param int $post_id
     * @param array $instance
     * @return string
     */
    public function render_tags($post_id, $instance, $icon = true)
    {
        // Get post tags
        $tags = $this->get_tags($post_id);
        
        $str = '';
        if(!count($tags)) return $str;
        
        // Get tags separator
        $separator = trim($instance['display_tags_separator']) ? $instance['display_tags_separator'] : ', ';
        foreach($tags as $tag)
        {
            // Tag name
            $tag_name = __($tag['name'], 'wbmpl');
            
            // Add tags link
            if($instance['display_tags_link']) $tag_name = '<a href="'.$tag['link'].'" target="'.$instance['widget_url_target'].'">'.$tag_name.'</a>';
            
            $str .= $tag_name.$separator;
        }
        
        // Add tags label if enabled
        if(trim($instance['display_tags_label'])) $str = __($instance['display_tags_label'], 'wbmpl').$str;
        
        // Add fa icon
        if($icon) $str = '<i class="fa fa-tags"></i>'.$str;
        
        return trim($str, $separator);
    }
    
    /**
     * Render thumbnail of post
     * @author Webilia <info@webilia.com>
     * @param string $thumbnail
     * @param array $instance
     * @param array $post
     * @return string
     */
	public function render_thumbnail($thumbnail, $instance, $post)
	{
		// Get default options
		if(!$instance) $instance = $this->get_default_args();
		if(!$instance['thumb_show'] or !trim($thumbnail)) return '';
		
        // Add post link to the thumbnail
		if($instance['thumb_link']) $thumbnail = '<a href="'.$post['rendered']['link'].'" target="'.$instance['widget_url_target'].'" class="wbpml_list_thumbnail_link">'.$thumbnail.'</a>';
		
		return $thumbnail;
	}
	
    /**
     * Render Post Content
     * @author Webilia <info@webilia.com>
     * @param string $content
     * @param array $instance
     * @param array $post
     * @return string
     */
	public function render_content($content, $instance, $post)
	{
		// Get default options
		if(!$instance) $instance = $this->get_default_args();
		if(!$instance['display_show_content']) return '';
		
        // Strip tags
		$content = strip_tags($content, $instance['allowed_html_tags']);
        
        // Strip shortcodes
        $content = strip_shortcodes($content);
		$need_to_cut = false;
		
        $cutted = $content;
        
        // Cut the content based on character
		if($instance['display_cut_content_mode'] == 1) $cutted = substr($content, 0, $instance['display_cut_content_size']);
        // Cut the content based on words
		elseif($instance['display_cut_content_mode'] == 2)
        {
            $ex = explode(' ', $content);
            $ex = array_slice($ex, 0, $instance['display_cut_content_size']);
            $cutted = implode(' ', $ex);
        }
        
		// Content is cutted
		if($content != $cutted)
		{
			$content = $cutted;
			$need_to_cut = true;
		}
		
        // Break string is enabled
		$break_str = '';
		if($instance['display_show_string_break']) $break_str = trim($instance['display_string_break_img']) != '' ? '<img src="'.$instance['display_string_break_img'].'" class="wbpml_list_break_image" />' : $instance['display_string_break_str'];
		
        // Add post link to the title
		if($instance['display_link_content'])
		{
			if($need_to_cut)
			{
                // Add link to break string
				if($instance['display_link_string_break']) $content = '<a href="'.$post['rendered']['link'].'" target="'.$instance['widget_url_target'].'" class="wbpml_list_content_link">'.$content." ".$break_str.'</a>';
				else $content = '<a href="'.$post['rendered']['link'].'" target="'.$instance['widget_url_target'].'" class="wbpml_list_content_link">'.$content.'</a> '.$break_str;
			}
			else $content = '<a href="'.$post['rendered']['link'].'" target="'.$instance['widget_url_target'].'" class="wbpml_list_content_link">'.$content.'</a>';
		}
		else
		{
			if($need_to_cut)
			{
                // Add link to break string
				if($instance['display_link_string_break']) $content = $content.' <a href="'.$post['rendered']['link'].'" target="'.$instance['widget_url_target'].'" class="wbpml_list_string_break_link">'.$break_str.'</a>';
				else $content = $content." ".$break_str;
			}
		}
		
		return $this->close_html_tags($content);
	}
    
    /**
     * Returns public WordPress post types
     * @author Webilia <info@webilia.com>
     * @return array
     */
    public function get_post_types()
    {
        return get_post_types(array('public'=>true, '_builtin'=>false));
    }
    
    /**
     * Close unclosed HTML tags
     * @author Webilia <info@webilia.com>
     * @param string $html
     * @return string
     */
    public function close_html_tags($html)
	{
        if(trim($html) == '') return $html;
        
        // Convert encoding to UTF-8
        if(function_exists('mb_convert_encoding')) $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        
        // There is no HTML tag on the text
        if(strip_tags($html) == $html) return $html;
        
		@$doc = new DOMDocument();
		@$doc->loadHTML($html);
        
        // Create valid HTML
		@$str = $doc->saveHTML();
        
        // Return only needed section
		$ex1 = explode('<body>', $str);
		$ex2 = explode('</body>', $ex1[1]);
        
		return $ex2[0];
	}
    
    /**
     * Renders widget title
     * @author Webilia <info@webilia.com>
     * @param string $title
     * @param array $instance
     * @return null|string
     */
	public function render_widget_title($title, $instance)
	{
		// If title is hidden
		if(!$instance['show_widget_title']) return NULL;
        
        // Add link to widget title
		if($instance['widget_title_url']) $title = '<a href="'.$instance['widget_title_url'].'" target="'.$instance['widget_url_target'].'" class="wbpml_widget_title_link">'.$title.'</a>';
		
		return $title;
	}
    
    /**
     * Generates container ID and classes
     * @author Webilia <info@webilia.com>
     * @param int $widget_id
     * @param array $instance
     * @return string
     */
    public function generate_container_classes($widget_id, $instance)
    {
        // Get layout name
        $layout_name = str_replace('-', '_', str_replace('.php', '', $instance['display_layout']));
        
        // Return unique ID and widget classes
        return ($widget_id ? 'id="'.$this->get_container_id($widget_id).'" ' : '').'class="wbmpl_main_container wbmpl_main_container_'.$layout_name.(trim($instance['widget_css_classes']) != '' ? ' '.$instance['widget_css_classes'] : '').'"';
    }
    
    /**
     * Generates dynamic styles and set it to be printed in website footer
     * @author Webilia <info@webilia.com>
     * @param array $instance
     * @param int $widget_id
     * @return void
     */
    public function generate_dynamic_styles($instance, $widget_id)
    {
        // ignore applying main color is enabled
        if(isset($instance['widget_main_color_ignore']) and $instance['widget_main_color_ignore']) return;
        
        // Generate dynamic style based on the main color
        $css = '<style type="text/css">
        #'.$this->posts->get_container_id($widget_id).' .wbmpl_list_title,
        #'.$this->posts->get_container_id($widget_id).' .wbmpl_list_title a,
        #'.$this->posts->get_container_id($widget_id).' .wbmpl_list_author a,
        #'.$this->posts->get_container_id($widget_id).' .wbmpl_list_categories a,
        #'.$this->posts->get_container_id($widget_id).' .wbmpl_list_tags a
        {color: '.$instance['widget_main_color'].'}
        </style>';
        
        $this->factory->params('footer', $css);
    }
    
    /**
     * Returns container ID
     * @author Webilia <info@webilia.com>
     * @param int $widget_id
     * @return string
     */
    public function get_container_id($widget_id)
    {
        return 'wbmpl_main_container'.$widget_id;
    }
    
    /**
     * Returns total posts of a query
     * @author Webilia <info@webilia.com>
     * @param string $query
     * @return int
     */
    public function get_total_posts($query)
    {
        $query = substr($query, 0, strpos($query, 'LIMIT'));
        $query = str_replace('SELECT *', 'SELECT COUNT(*) AS count', $query);
        
        return $this->db->select($query, 'loadResult');
    }
}