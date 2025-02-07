<?php
/*
 * configuration metadata
 *
 */

$meta['discussionPage']   = array('string');
$meta['userPage']         = array('string');

$meta['navbar'] = ['multicheckbox','_choices'=>['pageicons','siteicons','usericons','searchform']];
$meta['sidebar'] = ['multicheckbox','_choices'=>['pageicons','siteicons','usericons','searchform','pagetools','sitetools','usertools','sidebarheader.html','sidebarpage','sidebarfooter.html']];
$meta['contenttop'] = ['multicheckbox','_choices'=>['msgarea','header.html','breadcrumbs','pageicons','siteicons','usericons']];
$meta['footer'] = ['multicheckbox','_choices'=>['pageicons','siteicons','usericons','pageinfo','licenseinfo','breadcrumbs','searchform','msgarea','footer.html']];

$meta['findnearestpage']=['onoff'];
$meta['pagetools_showtitle']=['onoff'];
$meta['sitetools_showtitle']=['onoff'];
$meta['usertools_showtitle']=['onoff'];
$meta['sidebarpage_showtitle']=['onoff'];


$meta['navbar_showlogo']=['onoff'];
$meta['navbar_titleasbutton']=['onoff'];
$meta['showsidebar']=['onoff'];
$meta['exposeusertools']=['onoff'];
$meta['handlenotitle']=['onoff'];
$meta['handleprintview']=['onoff'];
$meta['handleprintview_alterlinks']=['onoff'];
$meta['handlebasetarget']=['onoff'];
