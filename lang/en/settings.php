<?php
/**
 * English language file for config
 *
 */

$lang['discussionPage']   = 'Discussion page (leave empty to disable discussions)';
$lang['userPage']         = 'User page (leave empty to disable user pages)';

$lang['navbar'] = 'What to show in navbar (type CSV if you want to control the order.)';
$lang['sidebar'] = 'What to show in sidebar (type CSV if you want to control the order. Use "PAGE:" prefix to show wiki pages. Use "hr" to add a horizontal rule.)';
$lang['contenttop'] ='Which icons to show at the top of the page content (type CSV if you want to control the order.)';
$lang['footer'] = 'What to show in the footer (type CSV if you want to control the order.';

$lang['pagetools_showtitle']='Show the page tools title in the sidebar';
$lang['sitetools_showtitle']='Show the site tools title in the sidebar';
$lang['usertools_showtitle']='Show the user tools title in the sidebar';
$lang['sidebarpage_showtitle']='Show the sidebar page title in the sidebar';


$lang['findnearestpage']='For sidebarpage and PAGE: entries, whether to find the nearest page or treat the item as is. This setting does not apply to pages with ":" prefix, which are considered absolute paths. For PAGE: prefixed entries, use an extra colon, e.g., PAGE::mysidebar to selectively disable this feature for that entry.';
$lang['navbar_showlogo']='Show the website logo on the top right corner.';
$lang['navbar_titleasbutton']='Show the website title as a button';
$lang['showsidebar']='Show the sidebar';
$lang['exposeusertools']='Show user tools (i.e., Login link) even when no user is logged in';
$lang['handlenotitle']='Handle the notitle REQUEST parameter to remove the first heading from page content (only works if there is no content before the first heading.)';
$lang['handleprintview']='Handle the printview REQUEST parameter to show only the main page content.';
$lang['handleprintview_alterlinks']='In printview, alter all the links to also have the printview parameter (This is a hack and may not work in all cases.)';
$lang['handlebasetarget']='Handle the basetarget REQUEST parameter to inject target=.... attribute into links in the page. This is useful when the page is included in an iframe and you want all the links to open e.g. in the parent window.';
