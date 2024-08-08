<?php
/**
 * Template Functions
 *
 * This file provides template specific custom functions that are
 * not provided by the DokuWiki core.
 * It is common practice to start each function with an underscore
 * to make sure it won't interfere with future core functions.
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();

/**
 * Create link/button to discussion page and back
 *
 * @author Anika Henke <anika@selfthinker.org>
 */
function _tpl_discussion($discussionPage, $title, $backTitle, $link=0, $wrapper=0, $return=0) {
    global $ID;
    $output = '';

    $discussPage    = str_replace('@ID@', $ID, $discussionPage);
    $discussPageRaw = str_replace('@ID@', '', $discussionPage);
    $isDiscussPage  = strpos($ID, $discussPageRaw) !== false;
    $backID         = ':'.str_replace($discussPageRaw, '', $ID);

    if ($wrapper) $output .= "<$wrapper>";

    if ($isDiscussPage) {
        if ($link) {
            ob_start();
            tpl_pagelink($backID, $backTitle);
            $output .= ob_get_contents();
            ob_end_clean();
        } else {
            $output .= html_btn('back2article', $backID, '', array(), 'get', 0, $backTitle);
        }
    } else {
        if ($link) {
            ob_start();
            tpl_pagelink($discussPage, $title);
            $output .= ob_get_contents();
            ob_end_clean();
        } else {
            $output .= html_btn('discussion', $discussPage, '', array(), 'get', 0, $title);
        }
    }

    if ($wrapper) $output .= "</$wrapper>";
    if ($return) return $output;
    echo $output;
}

/**
 * Create link/button to user page
 *
 * @author Anika Henke <anika@selfthinker.org>
 */
function _tpl_userpage($userPage, $title, $link=0, $wrapper=0, $return=0) {
    if (empty($_SERVER['REMOTE_USER'])) return;

    global $conf;
    $output = '';
    $userPage = str_replace('@USER@', $_SERVER['REMOTE_USER'], $userPage);

    if ($wrapper) $output .= "<$wrapper>";

    if ($link) {
        ob_start();
        tpl_pagelink($userPage, $title);
        $output .= ob_get_contents();
        ob_end_clean();
    } else {
        $output .= html_btn('userpage', $userPage, '', array(), 'get', 0, $title);
    }

    if ($wrapper) $output .= "</$wrapper>";
    if ($return) return $output;
    echo $output;
}

/**
 * Wrapper around custom template actions
 *
 * @author Anika Henke <anika@selfthinker.org>
 */
function _tpl_action($type, $link=0, $wrapper=0, $return=0) {
    switch ($type) {
        case 'discussion':
            if (tpl_getConf('discussionPage')) {
                $output = _tpl_discussion(tpl_getConf('discussionPage'), tpl_getLang('discussion'), tpl_getLang('back_to_article'), $link, $wrapper, 1);
                if ($return) return $output;
                echo $output;
            }
            break;
        case 'userpage':
            if (tpl_getConf('userPage')) {
                $output = _tpl_userpage(tpl_getConf('userPage'), tpl_getLang('userpage'), $link, $wrapper, 1);
                if ($return) return $output;
                echo $output;
            }
            break;
    }
}

/**
 * copied to core (available since Detritus)
 */
if (!function_exists('tpl_toolsevent')) {
    function tpl_toolsevent($tooltoolssname, $items, $view='main') {
        $data = array(
            'view'  => $view,
            'items' => $items
        );

        $hook = 'TEMPLATE_'.strtoupper($tooltoolssname).'_DISPLAY';
        $evt = new Doku_Event($hook, $data);
        if($evt->advise_before()){
            foreach($evt->data['items'] as $k => $html) echo $html;
        }
        $evt->advise_after();
    }
}

/**
 * copied from core (available since Binky)
 */
if (!function_exists('tpl_classes')) {
    function tpl_classes() {
        global $ACT, $conf, $ID, $INFO;
        $classes = array(
            'dokuwiki',
            'mode_'.$ACT,
            'tpl_'.$conf['template'],
            !empty($_SERVER['REMOTE_USER']) ? 'loggedIn' : '',
            $INFO['exists'] ? '' : 'notFound',
            ($ID == $conf['start']) ? 'home' : '',
        );
        return join(' ', $classes);
    }
}


function conf_ischosen($confname,$choice){
    global $conf;
    $val=$conf[$confname];
    if(empty($val)) return false;
    if(!is_array($val)) $val=explode(',',$val);
    return in_array($choice,$val);
}
function tplconf_ischosen($confname,$choice){
    $val=tpl_getConf($confname);
    if(empty($val)) return false;
    if(!is_array($val)) $val=explode(',',$val);
    return in_array($choice,$val);
}
#section: navbar,sidebar,contenttop,footer.
function tpl_showsection($section,$tools=null){
    global $conf;
    global $lang;
    global $ID;
    global $INFO;
    if(!isset($tools)) $tools=tpl_getConf($section);
    if(empty($tools)) return;
    if(!is_array($tools)) $tools=explode(',',$tools);
    $inicons=false;

    //Ideally all of these wrappers should have been the same, except with class="$section" and the css should have taken care of the rest. But I did not want to mess with the css too much.
    $icons_start='';
    $icons_end='';
    $items_start='';
    $items_end='';
    if($section=='navbar'){
        $items_start="<li class='nav-item nav-link'>";
        $items_end="</li>\n"; }
    else{
        $icons_start="<div class='argon-doku-page-menu'>\n";
        $icons_end="</div>\n";
    }
    if($section=='sidebar'){
        $items_start="<div class='ct-toc-item active dokuwiki__pagetools'>\n{TITLE}<ul class='nav ct-sidenav'>\n";
        $items_end="</ul></div>\n";
    }

    foreach($tools as $tool){
        if(strtolower($tool)=='hr'){ echo "<HR>\n"; continue; }
        if(($tool=='usertools'||$tool=='usericons') && !$INFO['userinfo'] && !tpl_getConf('exposeusertools') ) continue;
        if($tool=='searchform' && !actionOK('search')) continue;

        if($section=='sidebar'&&$tool=='sidebarpage'){
            $items_start="<div id='dokuwiki__aside' class='ct-toc-item active'><div class='leftsidebar'>\n";
            if(tpl_getConf($tool.'_showtitle')){ $items_start.="<a class='ct-toc-link'>".$lang['sidebar']."</a>\n"; }
            $items_end=" </div>\n</div>\n";
        }
        elseif(str_starts_with($tool,'PAGE:')){
            $items_start="<div id='dokuwiki__aside'><div class='leftsidebar'>\n";
            $items_end=" </div></div>\n";
        }
        elseif(str_ends_with($tool,'html')){
            $items_start='';
            $items_end='';
        }

        $isicons=str_ends_with($tool,'icons');
        if($isicons){ $tool=str_replace('icons','',$tool); }
        if(strpos($items_start,'{TITLE}')!==false){
            $items_start=str_replace('{TITLE}',tpl_getConf($tool.'_showtitle')?" <a class='ct-toc-link'>".($lang[$tool.'_tools'])."</a>\n":'',$items_start);
        }

        //-----------------------------------------------
        if($isicons&&!$inicons){
            echo $icons_start;
            $inicons=true;
        }
        elseif(!$isicons&&$inicons){
            echo $icons_end;
            echo $items_start;
            $inicons=false;
        }
        elseif(!$isicons&&!$inicons){
            echo $items_start;
        }

        if($tool=='searchform'){
            echo "<div class='search-form'>";
            tpl_searchform();
            echo "</div>";
        }
        elseif($tool=='userinfo'){
            if (!empty($_SERVER['REMOTE_USER'])) {
                tpl_userinfo();
            }
        }
        elseif(str_ends_with($tool,'.html')){
            tpl_includeFile($tool);
        }
        elseif($tool=='sidebarpage'||str_starts_with($tool,'PAGE:')){
            if($tool=='sidebarpage') $page=$conf['sidebar'];
            else $page=substr($tool,5);
            $findnearest=!str_starts_with($page,':')&&tpl_getConf('findnearestpage');
			if($findnearest){
				if(($page2 = page_findnearest($page2))) $page=$page2;
			}
            tpl_include_page($page, 1, 0);
        }
        elseif($tool=='msgarea'){
            html_msgarea();
        }
        elseif($tool=='footerhtml'){
            tpl_includeFile('footer.html');
        }
        elseif($tool=='pageinfo'){
            tpl_pageinfo(); # 'Last modified' etc
        }
        elseif($tool=='licenseinfo') {
            tpl_license('0'); # content license, parameters: img=*badge|button|0, imgonly=*0|1, return=*0|1
        }
        elseif($tool=='breadcrumbs'){
            if($conf['breadcurmbs']||$conf['youarehere']){
                echo "<nav aria-label='breadcrumb' role='navigation'>\n";
                if ($conf['breadcrumbs']){
                    echo "<div class='breadcrumbs'>";
                    tpl_breadcrumbs();
                    echo "</div>\n";
                }
                if ($conf['youarehere']) {
                    echo "<div class='breadcrumbs'>";
                    tpl_youarehere();
                    echo "</div>\n";
                }
                echo "</nav>";
            }
        }
        elseif($tool=='page'||$tool=='site'||$tool=='user'||$tool=='pagetools'||$tool=='sitetools'||$tool=='usertools'){
            //create $menu_items dynamically based on the $tool
            $class='\\dokuwiki\\Menu\\'.ucfirst(str_replace('tools','',$tool)).'Menu';
            $menu_items = (new $class())->getItems();

            foreach($menu_items as $item) {
                //if location is contenttop, don't bother shwowing "go to top" item.
                if($section=='contenttop'&&$item->getType()=='top') continue;
                $accesskey = $item->getAccesskey();
                $akey = $accesskey?'accesskey="'.$accesskey.'" ':'';
                if($isicons)
                    echo '<li class="'.$item->getType().'">'
                    .'<a class="'.($section=='navbar'?'nav-link ':'page-menu__link ').$item->getLinkAttributes('')['class'].'" href="'.$item->getLink().'" title="'.$item->getTitle().'" '.$akey.'>'
                    .'<i'.($section=='navbar'?' class="argon-doku-navbar-icon" aria-hidden="true"':'').'>'.inlineSVG($item->getSvg()).'</i>'
                    . '<span class="a11y">'.$item->getLabel().'</span>'
                    . "</a></li>\n";
                else
                    echo '<li class="'.$item->getType().'">'
                    .'<a class="'.$item->getLinkAttributes('')['class'].'" href="'.$item->getLink().'" title="'.$item->getTitle().'" '.$akey.'>'
                    . $item->getLabel()
                    . "</a></li>\n";
            }
        }
        else{ echo "Invalid toolname: ".hsc($tool); }
       
        if(!$isicons&&!$inicons){
            echo $items_end;
        }
    }
    if($inicons) echo $icons_end;
}
function tpl_showlogo(){
    $logoSize = array();
    $logo = tpl_getMediaFile(array(':wiki:logo.png', ':logo.png', 'images/logo.png', ':wiki:dokuwiki-128.png'), false, $logoSize);
    tpl_link(
        wl(),
        '<img src="'.$logo.'" height="30px" alt="" />',
        'accesskey="h" title="[H]"'
    );
}

function tpl_showtools(){    return; }
function tpl_showpagetools(){    return; }
function tpl_showsearchform(){ return; }