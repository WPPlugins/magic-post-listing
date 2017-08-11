=== Magic Post Listing ===
Contributors: webilia
Donate link: http://webilia.com/api/mpl/redirect.php?action=upgrade
Tags: post, widget, content slider, slider, wp slider, carousel, page slider, page, page carousel, horizontal carousel, light slider, post carousel, recent posts, latest posts, post list
Requires at least: 3.0.1
Tested up to: 4.5
Stable tag: 2.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Best plugin for creating content sliders and image sliders. MPL supports multiple layouts with advanced options and custom post types.

== Description ==

Using Magic Post Listing (MPL) you can simply create content sliders for your website. MPL has some advanced options for filtering posts or pages.
Magic Post Listing has ability to show thumbnails of posts/pages so you can simply create advanced image sliders and link the images to post/page URLs.

> <strong>MPL PRO released!</strong><br />
> We're glad to announce, the premium version of MPL finally released with plenty advanced options. Please check [MPL PRO demo website](http://webilia.com/api/mpl/redirect.php?action=demo) and [MPL PRO product page](http://webilia.com/api/mpl/redirect.php?action=upgrade).

> <strong>MPL PRO Features</strong><br />
- Filter Layout<br />
- Animate Layout<br />
- Caption Layout<br />
- Ticker Layout<br />
- Masonry Layout<br />
- Shortcode support and automatic shortcode generator<br />
- PHP code support and automatic PHP code generator<br />

**Post Types**

MPL completely supports custom post types. Therefor using MPL and its different layouts you can simply show your custom post types. Even you can filter them by custom taxonomy options.

**MPL Layouts**

Magic Post Listing has a great feature for specifying layout of slider. Using layout feature of MPL you can show filtered posts/pages using a specific style. Currently MPL has 2 layouts, default and light-slider.

*   Default layout shows filtered posts/pages using a simple structure. This layout is useful for using as recent posts widget or using in a theme with customized style. It has list/grid option as well.
*   Light-slider layout shows filtered posts/pages in a slider using a jQuery plugin. There are some useful options for this layout in MPL so you can configure it in a way that you like easily.
*   Filter layout shows all of filtered posts/pages at once. Your website visitor can see post categories/tags above of the posts and filter them based on a certain tag/category. This layout included in MPL PRO.
*   Animate layout shows one of filtered posts/pages at once and navigate to next post using a nice animation. This layout included in MPL PRO.
*   Caption layout shows all of filtered posts/pages at once. By hovering mouse on each post, post title and/or post content will show using a caption style. This layout is part of MPL PRO.
*   Ticker layout shows all filtered posts/pages using a breaking news style one by one. This layout is included in MPL PRO as well.
*   Masonry layout shows all filtered posts/pages using a masonry style. This layout supports pagination as well.

**Developers**

Developers can simply create a new layout for MPL. What you should do it to check current light-slider as a sample. Therefor if you created an interesting layout for MPL we will be happy to add your layout in MPL core with your name.

== Installation ==

1. Install as regular WordPress plugin.
1. Find "Magic Post Listing" on installed plugins menu and activate it.
After activating the plugin, You can see Magic Post Listing widget in your widgets menu.

== Frequently Asked Questions ==

= How to create a new layout? =
It's easy for developers. Just check one of current layouts structure such as light-slider.
Layout main file should be placed in this path: /path/to/plugin/app/widgets/MPL/tmpl/your-layout.php
Layout form file (if any) should be placed in this path: /path/to/plugin/app/widgets/MPL/forms/your-layout.php
And layout assets directory (if any) should be placed in this path: /path/to/plugin/app/widgets/MPL/assets/your-layout/

= Can I have multiple instance of this widget on one page? =
Yes of course, MPL supports multiple instance widgets.

== Screenshots ==

1. Basic Options.
2. Filter Options.
3. Thumbnail Options.
4. Display Options.
5. Layout Options.
6. Widget Output (Slider)
7. Widget Output (Simple)

== Changelog ==

= 2.5 =
* Added Filter layout to MPL PRO.
* Fixed some reported issues.

= 2.2 =
* Fixed an issue in light-slider layout.
* Fixed a language issue.

= 2.1 =
* Added Masonry layout to MPL PRO.
* Added pagination option to default, caption and masonry layouts.
* Tweak design of MPL widget form and some MPL layouts.
* Fixed some minor issues.

= 2.0 =
* Released [MPL PRO](http://webilia.com/api/mpl/redirect.php?action=upgrade).
* Fixed some style issues.

= 1.8 =
* Added some styles for default layout.
* Added comments to the codes.
* Fixed cut title and cut content issue.
* Fixed theme override issue.

= 1.7 =
* Added current category filter for category archive pages.
* Added current tag filter for category archive pages.

= 1.6 =
* Fixed content cut issue.
* Fixed some design issues in MPL layouts.
* Fixed some PHP notices.

= 1.5 =
* Added title HTML tag selection feature.
* Added ability to skip posts that don't have images.
* Added responsive display and grid size for default layout.

= 1.4 =
* Fixed an ID conflict.
* Added render_field function for showing custom field data on any layout.
* Updated language files.

= 1.3 =
* Added current post exclusion feature.

= 1.2 =
* Fixed a UTF-8 encoding issue.
* Fixed a responsive issue.

= 1.1 =
* Added full taxonomy support for custom post types.
* Fixed a responsive issue on light-slider layout.
* Fixed some issues for theme compatibility.

= 1.0 =
* Added filter options.
* Added thumbnail support.
* Added main color option.
* Added light-slider layout with its options.
* Added advanced options.

== Upgrade Notice ==

There is no upgrade notices for now.