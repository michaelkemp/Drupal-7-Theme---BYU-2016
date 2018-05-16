<?php

require_once(dirname(__FILE__) . '/vendor/phpSyllable/classes/autoloader.php');

/**
 *
 *  Implements HOOK_html_head_alter(&$head_elements)
 *
 */
function byu2016_html_head_alter(&$head_elements) {
	// don't announce to the world that this is drupal 7
	unset($head_elements['system_meta_generator']);
}
    
/**
 *
 *  Implements HOOK_js_alter(&$javascript)
 *
 */
function byu2016_js_alter(&$javascript) {
     global $base_url;
    // Swap out jQuery - bootstrap needs at least v1.9.1
    // ========================== JQUERY FALLBACK ==========================
    $local = $base_url . "/" .  drupal_get_path('theme', 'byu2016') . '/vendor/jquery-1.12.4/jquery.min.js';
    $cdn = "//code.jquery.com/jquery-1.12.4.min.js";
    if (byu2016CDNFallback($cdn)) { $jquery = $cdn; } else { $jquery = $local; }
    
    $javascript['misc/jquery.js']['data'] = $jquery;
    $javascript['misc/jquery.js']['version'] = '1.12.4';
    $javascript['misc/jquery.js']['group']  = JS_LIBRARY;
    $javascript['misc/jquery.js']['weight'] = -20;
}
    
/**
 *
 *  Implements HOOK_preprocess_image(&$variables)
 *
 */
function byu2016_preprocess_image(&$variables) {
    if (theme_get_setting('responsive_images') == 1) {
        $variables['attributes']['class'][] = 'img-responsive';
    }
}

/**
 *
 *  Implements HOOK_preprocess_page(&$variables)
 *
 */
function byu2016_preprocess_page(&$variables) {
    global $user;
    global $base_url;
    
    $myVars = byu2016GetVars($variables);
    
    // ================== Add Soft-Hyphens to Title and Subtitle ==================
    $syllable = new Syllable('en-us');
    $syllable->setHyphen(new Syllable_Hyphen_Soft);
    $myVars["siteTTL"] = $syllable->hyphenateText($myVars["siteTTL"]);
    $myVars["siteSUB"] = $syllable->hyphenateText($myVars["siteSUB"]);
    // ================== Add Soft-Hyphens to Title and Subtitle ==================
    
    $byuMark = $base_url . "/" . drupal_get_path('theme', 'byu2016') . "/images/byu.svg";
    $url = $myVars["homeURL"];
    $title = "<div class='site-name'>" .$myVars["siteTTL"]. "</div>";
    $class = ($myVars["subtITA"]) ? "sub-title-italic" : "sub-title";
    $class.= ($myVars["subtABV"]) ? " sub-title-above" : " sub-title-below";
    $subTl = "<div class='" .$class. "'>" .$myVars["siteSUB"]. "</div>";
    
    if ($myVars["subtUSE"]) {
        if ($myVars["subtABV"]) {
            $siteTitle = $subTl . $title;
        } else {
            $siteTitle = $title . $subTl;
        }
    } else {
        $siteTitle = $title;
    }
    
    $printTitle = $myVars["prntTTL"];
    
    $html = "";
    $html.= "<a href='${url}' title='BYU ${printTitle}' class='header-title-link'>";
    $html.= "<div class='logo-container'><img class='site-logo' alt='BYU' src='${byuMark}'></div>";
    $html.= "<div class='title-container title-container-flex'>${siteTitle}</div>";
    $html.= "</a>";
    
    $variables["theme_url"] = $base_url . "/" . drupal_get_path('theme', 'byu2016');
    $variables["site_logo"] = $html;
    $variables["main-menu-markup"] = byu2016BootstrapMenu('main-menu',1,true);
    $variables["main-menu-markup-flat"] = byu2016BootstrapMenu('main-menu',1,false);
    $variables["user-menu-markup"] = byu2016BootstrapMenu('user-menu',2,true);
    $variables["user-menu-markup-flat"] = byu2016BootstrapMenu('user-menu',2,false);

    $variables["add-login"] = "";
    if (theme_get_setting('add_login') == 1) {
        if ($user->uid > 0) {
            $url = theme_get_setting('logout_link');
            $titl = theme_get_setting('logout_text');
            $titl = preg_replace('/::([a-zA-Z0-9\-]*)::/','<i class="fa ${1}" aria-hidden="true"></i>',$titl);
            $variables["add-login"] = "<li class='menu-parent'><a href='${url}'>${titl}</a></li>";
        } else {
            $url = theme_get_setting('login_link');
            $titl =  theme_get_setting('login_text');
            $titl = preg_replace('/::([a-zA-Z0-9\-]*)::/','<i class="fa ${1}" aria-hidden="true"></i>',$titl);
            $variables["add-login"] = "<li class='menu-parent'><a href='${url}'>${titl}</a></li>";
        }
    }
    
    $variables["content-url-class"] = $myVars["typClss"] . " " . $myVars["urlClss"];
    $variables["sidebar-columns"] = isset($myVars["sideBAR"]) ? intval($myVars["sideBAR"]) : 3;
    
}

/**
 *
 *  Implements HOOK_preprocess_html(&$variables)
 *
 */
function byu2016_preprocess_html(&$variables) {
    
    $myVars = byu2016GetVars($variables);
    
    $metaSTR ="\n";

    if (theme_get_setting('block_robots') == 1) {
        $metaSTR.="\n    <!-- ROBOT META TAG -->";
        $metaSTR.="\n        <meta name='robots' content='noindex,nofollow'>";
        $metaSTR.="\n    <!-- END ROBOT META TAG -->";
        $metaSTR.="\n\n";
    }

    $metaSTR.="\n    <!-- FACEBOOK META TAGS -->";
    $metaSTR.="\n        <meta property='fb:app_id' content='${myVars['appIdnt']}' />";
    $metaSTR.="\n        <meta property='og:site_name' content='${myVars['siteNam']}' />";
    $metaSTR.="\n        <meta property='og:description' content='${myVars['siteDsc']}' />";
    $metaSTR.="\n        <meta property='og:title' content='${myVars['pageTtl']}' />";
    $metaSTR.="\n        <meta property='og:type' content='university' />";
    $metaSTR.="\n        <meta property='og:url' content='${myVars['pageURL']}' />";
    $metaSTR.="\n        <meta property='og:image' content='${myVars['fullDir']}/social.png' />";
    $metaSTR.="\n    <!-- END FACEBOOK META TAGS -->";
    $metaSTR.="\n\n";

    $metaSTR.="\n    <!-- FAV and APPLE ICON TAGS -->";
    $metaSTR.="\n        <meta name='msapplication-config' content='none' />";
    $metaSTR.="\n        <link rel='shortcut icon' href='${myVars['fullDir']}/favicon.ico' type='image/x-icon' />";
    $metaSTR.="\n        <link rel='apple-touch-icon' href='${myVars['fullDir']}/apple-touch-icon.png' />";
    $metaSTR.="\n        <link rel='apple-touch-icon' sizes='57x57' href='${myVars['fullDir']}/apple-touch-icon-57x57.png' />";
    $metaSTR.="\n        <link rel='apple-touch-icon' sizes='72x72' href='${myVars['fullDir']}/apple-touch-icon-72x72.png' />";
    $metaSTR.="\n        <link rel='apple-touch-icon' sizes='76x76' href='${myVars['fullDir']}/apple-touch-icon-76x76.png' />";
    $metaSTR.="\n        <link rel='apple-touch-icon' sizes='114x114' href='${myVars['fullDir']}/apple-touch-icon-114x114.png' />";
    $metaSTR.="\n        <link rel='apple-touch-icon' sizes='120x120' href='${myVars['fullDir']}/apple-touch-icon-120x120.png' />";
    $metaSTR.="\n        <link rel='apple-touch-icon' sizes='144x144' href='${myVars['fullDir']}/apple-touch-icon-144x144.png' />";
    $metaSTR.="\n        <link rel='apple-touch-icon' sizes='152x152' href='${myVars['fullDir']}/apple-touch-icon-152x152.png' />";
    $metaSTR.="\n        <link rel='apple-touch-icon' sizes='180x180' href='${myVars['fullDir']}/apple-touch-icon-180x180.png' />";
    $metaSTR.="\n    <!-- END FAV and APPLE ICON TAGS -->";
    $metaSTR.="\n\n";


    $variables['meta_tags'] = $metaSTR;
    $variables['facebook_id'] = trim($myVars['appIdnt']);

    if (theme_get_setting('full_font_package') == 1) {
        // ========================== WEBFONTS FULL CSS FALLBACK ==========================
        $local = drupal_get_path('theme', 'byu2016') . '/vendor/cloud.typography.com/css/fonts.css';
        $cdn = "//cloud.typography.com/75214/6517752/css/fonts.css";
        if (byu2016CDNFallback($cdn)) { drupal_add_css($cdn, array('type' => 'external')); } else { drupal_add_css($local, array('type' => 'file')); }
        //byu2016CDNDownload($cdn);
    } else {    
        // ========================== WEBFONTS LIGHT CSS FALLBACK ==========================
        $local = drupal_get_path('theme', 'byu2016') . '/vendor/cloud.typography.com/css/light-fonts.css';
        $cdn = "//cloud.typography.com/75214/7683772/css/fonts.css";
        if (byu2016CDNFallback($cdn)) { drupal_add_css($cdn, array('type' => 'external')); } else { drupal_add_css($local, array('type' => 'file')); }
        //byu2016CDNDownload($cdn);
    }
    
    // ========================== BOOTSTRAP CSS FALLBACK ==========================
    $local = drupal_get_path('theme', 'byu2016') . '/vendor/bootstrap-3.3.7-dist/css/bootstrap.min.css';
    $cdn = "//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css";
    if (byu2016CDNFallback($cdn)) { drupal_add_css($cdn, array('type' => 'external')); } else { drupal_add_css($local, array('type' => 'file')); }
    //byu2016CDNDownload($cdn);

    // ========================== BYU - BOOTSTRAP CSS ==========================
    if (theme_get_setting('byu_bootstrap_css') == 1) {
        $local = drupal_get_path('theme', 'byu2016') . '/vendor/bootstrap-3.3.7-dist/byu-css/byu-theme.min.css';
        drupal_add_css($local, array('type' => 'file'));
    } else {
        // ========================== BOOTSTRAP-THEME CSS FALLBACK ==========================
        $local = drupal_get_path('theme', 'byu2016') . '/vendor/bootstrap-3.3.7-dist/css/bootstrap-theme.min.css';
        $cdn = "//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css";
        if (byu2016CDNFallback($cdn)) { drupal_add_css($cdn, array('type' => 'external')); } else { drupal_add_css($local, array('type' => 'file')); }
        //byu2016CDNDownload($cdn);
    }

    // ========================== FONTAWESOME CSS FALLBACK ==========================
    $local = drupal_get_path('theme', 'byu2016') . '/vendor/font-awesome-4.7.0/css/font-awesome.min.css';
    $cdn = "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css";
    if (byu2016CDNFallback($cdn)) { drupal_add_css($cdn, array('type' => 'external')); } else { drupal_add_css($local, array('type' => 'file')); }
    //byu2016CDNDownload($cdn);
    
    // ========================== BOOTSTRAP JS FALLBACK ==========================
    $local = drupal_get_path('theme', 'byu2016') . '/vendor/bootstrap-3.3.7-dist/js/bootstrap.min.js';
    $cdn = "//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js";
    if (byu2016CDNFallback($cdn)) { drupal_add_js($cdn, array('type' => 'external')); } else { drupal_add_js($local, array('type' => 'file')); }
    //byu2016CDNDownload($cdn);
    

}

/**
 *
 *  Implements HOOK_form_alter(&$form, &$form_state, $form_id)
 *
 */
function byu2016_form_alter(&$form, &$form_state, $form_id) {
    
    if ($form_id == 'search_block_form') {
        
        // =================== GET QUERY STRING ===================
        $searchURL = trim(theme_get_setting('search_url'),"/\\") . "/";
        $val = '';
        if ((isset($_GET["q"])) && (strpos($_GET["q"],$searchURL) !== false)) {
            $val = str_replace($searchURL,"",$_GET["q"]);
        } 
        
        $formClass = "byu2016-search-form";
        $textClass = "byu2016-search-text";
        $bttnClass = "byu2016-search-button";

        $form['#attributes']['class'][] = $formClass;
        $form['#attributes']['onsubmit'] = "if(this.search_block_form.value==''){ return false; }";
        $form['#attributes']['role'] = "search";
        
        $form['search_block_form']['#size'] = 20;
        $form['search_block_form']['#default_value'] = t($val);
        
        $form['search_block_form']['#theme_wrappers'] = array();
        $form['search_block_form']['#prefix'] = '<div class="' .$textClass. '">';
        $form['search_block_form']['#attributes']['title'] = "";
        $form['search_block_form']['#attributes']['aria-label'] = "Search Box";
        $form['search_block_form']['#attributes']['placeholder'] = "Search";
        $form['search_block_form']['#suffix'] = '</div>';
 
        $form['actions']['submit']['#attributes']['style'] = 'display:none;';
        $form['actions']['#theme_wrappers'] = array();
        $form['actions']['button']['#prefix'] = '<div class="' .$bttnClass. '"><button aria-label="Submit Search" type="submit" class="button-small">';
        $form['actions']['button']['#markup'] = '<i class="fa fa-search" aria-hidden="true"></i>';
        $form['actions']['button']['#suffix'] = '</button></div>';
 
    }

}

/**
 *
 *  Implements HOOK_form($variables)
 *
 */
function byu2016_form($variables) {
  
    $element = $variables['element'];
    if (isset($element['#action'])) {
        $element['#attributes']['action'] = drupal_strip_dangerous_protocols($element['#action']);
    }
    element_set_attributes($element, array('method', 'id'));
    if (empty($element['#attributes']['accept-charset'])) {
        $element['#attributes']['accept-charset'] = "UTF-8";
    }
  
    // ========= PRINT FROM WITHOUT EXTRA DIVs =========
    return '<form' . drupal_attributes($element['#attributes']) . '>' . $element['#children'] . '</form>';
}

/**
 *
 *  Implements HOOK_apachesolr_search_noresults() 
 *  from apachesolr - change No-Results Output
 */
function byu2016_apachesolr_search_noresults() {

$noRes=<<<NORES
        <div class='search-results-container'>
            <ul class='search-noresults'>
                <li>Check if your spelling is correct, or try removing filters.</li>
                <li>Remove quotes around phrases to match each word individually: <em>"blue drop"</em> will match less than <em>blue drop</em>.</li>
                <li>You can require or exclude terms using + and -: <em>big +blue drop</em> will require a match on <em>blue</em> while <em>big blue -drop</em> will exclude results that contain <em>drop</em>.</li>
            </ul>
        </div>    
NORES;
    
  return t($noRes);
  
}


/**
 *
 *  Return an Array of site specific variables
 *
 */
function byu2016GetVars($variables) {
    $vars = array();
    
    // FULL URL PATH
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $pageURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $pageURI = trim(strtok($_SERVER["REQUEST_URI"],"?"),"/");
    $domain = $protocol . $_SERVER['SERVER_NAME'];
    if (($_SERVER['SERVER_PORT'] != 80) && ($_SERVER['SERVER_PORT'] != 443)) { $domain.= ":". $_SERVER['SERVER_PORT']; }
    $pathToTheme = $domain . base_path() . path_to_theme();
    $rootToTheme = DRUPAL_ROOT. '/' .path_to_theme();
    
    $siteName = variable_get('site_name');
    $siteSlog = variable_get('site_slogan');

    $siteTitle = trim(theme_get_setting('main_title'));
    $siteSbTtl = trim(theme_get_setting('sub_title'));
    $siteSTUse = (theme_get_setting('sub_title_use') == 1) ? true: false;
    $siteSTAbv = (theme_get_setting('sub_title_above') == 1) ? true: false;
    $siteSTIta = (theme_get_setting('sub_title_italic') == 1) ? true: false;
    $siteIcons = trim(theme_get_setting('icon_directory'));
    $siteAppId = trim(theme_get_setting('facebook_app_id'));

    $app_id = $siteAppId;
    $rootDir = "${rootToTheme}/sites/${siteIcons}";
    if (file_exists($rootDir)) {
        $fullDir = "${pathToTheme}/sites/${siteIcons}";
    } else {
        $fullDir = "${pathToTheme}/sites/default";
    }
    
    $pageTtl = isset($variables['head_title']) ? $variables['head_title'] : $siteName;
    
    $siteDesc = (trim(theme_get_setting('site_description')) != "") ? theme_get_setting('site_description') : $pageTtl;

    $vars["siteDsc"] = $siteDesc;

    $vars["prntTTL"] = $siteSTUse ? $siteTitle . " - " . $siteSbTtl : $siteTitle;
    
    $vars["siteNam"] = $siteName;
    $vars["siteSlo"] = $siteSlog;

    $vars["siteTTL"] = $siteTitle;
    $vars["siteSUB"] = $siteSbTtl;
    $vars["subtUSE"] = $siteSTUse;
    $vars["subtABV"] = $siteSTAbv;
    $vars["subtITA"] = $siteSTIta;
    
    $vars["rootDir"] = $rootDir;
    $vars["fullDir"] = $fullDir;
    
    $vars["appIdnt"] = $siteAppId;
    $vars["pageURL"] = $pageURL;
    $vars["pageTtl"] = $pageTtl;
    $vars["homeURL"] = $domain . base_path();

    if(trim(theme_get_setting('site_home')) != "") {
        $vars["homeURL"] = trim(theme_get_setting('site_home'));
    }

    $vars["urlClss"] = "url-" . trim(preg_replace('/\-+/','-',preg_replace('/[^a-z0-9]/','-',strtolower($pageURI))),"-");
    if ( arg(0) == 'node' && is_numeric(arg(1)) ) {
        $contentType = db_query("SELECT type FROM {node} WHERE nid = :nid", array(':nid' => arg(1)))->fetchField();
        $vars["typClss"] = "node-" . arg(1) . " type-" . trim(preg_replace('/\-+/','-',preg_replace('/[^a-z0-9]/','-',strtolower($contentType))),"-");
    } else {
        $vars["typClss"] = "type-not-node";
        $contentType = "";
    }
    
    $vars["sideBAR"] = 3;
	
	if (byu2016PageMatch(theme_get_setting('layout282'))) 				 { $vars["sideBAR"] = 2; }
    if (byu2016PageMatch(theme_get_setting('layout444'))) 				 { $vars["sideBAR"] = 4; }
    if (byu2016TypeMatch(theme_get_setting('layout282ct'),$contentType)) { $vars["sideBAR"] = 2; }
    if (byu2016TypeMatch(theme_get_setting('layout444ct'),$contentType)) { $vars["sideBAR"] = 4; }
    
    return $vars;
    
}

/**
 *
 *  Create BOOTSTRAP Friendly UL from items in the Menu
 *
 */
function byu2016BootstrapMenu($menuName, $depth=1, $dropdown=true) {
    
    $branches = menu_tree_all_data($menuName);
    byu2016StripHidden($branches);
    $branchCnt = count($branches);
    if (($branchCnt == 0) && (theme_get_setting('add_login') != 1)) {
        return "";
    }
    
    // FIND ACTIVE MENU or CHILD ELEMENT
    if ($menuName == "main-menu") {
        $thisURL = (trim(strtolower($_SERVER["REQUEST_URI"])) == "/") ? url(variable_get('site_frontpage')) : trim(strtolower($_SERVER["REQUEST_URI"]));
        foreach($branches as $bkey => $branch) {
            $link = isset($branch["link"]["link_path"]) ? $branch["link"]["link_path"] : "";
            if ($thisURL == trim(strtolower(url($link)))) {
                $branches[$bkey]["active"] = true;
            } else {
                $branches[$bkey]["active"] = false;
            }
            $leaves = isset($branch["below"]) ? $branch["below"] : array();
            foreach($leaves as $lkey => $leaf) {
                $link = isset($leaf["link"]["link_path"]) ? $leaf["link"]["link_path"] : ""; 
                if ($thisURL == trim(strtolower(url($link)))) {
                    $branches[$bkey]["below"][$lkey]["active"] = true;
                    $branches[$bkey]["active"] = true; // MARK PARENT AS ACTIVE
                } else {
                    $branches[$bkey]["below"][$lkey]["active"] = false;
                }
            }
        }
    }
    
    $b4Over = (theme_get_setting('menu_count')) ? intval(theme_get_setting('menu_count')) : 6;
    
    $list = "";
    $overflow = "";
    
    $cnt = 0;
    foreach($branches as $branch) {
        $titl = isset($branch["link"]["title"]) ? $branch["link"]["title"] : "";
        $titl = preg_replace('/::([a-zA-Z0-9\-]*)::/','<i class="fa ${1}" aria-hidden="true"></i>',$titl);
        $link = isset($branch["link"]["link_path"]) ? $branch["link"]["link_path"] : ""; 
        $url = url($link);
        $active = "";
        if (isset($branch["active"])) {  $active = $branch["active"] ? "active" : "";  }
        
        if ($depth == 1) {
                ++$cnt;
                if (($cnt>=$b4Over) && ($branchCnt > $b4Over) && ($dropdown)) {
                    if ($link=="") {
                        $overflow.="<li class='menu-child ${menuName}'>${titl}</li>";
                    } else {
                        $overflow.="<li class='menu-child ${menuName} ${active}'><a href='${url}'>${titl}</a></li>";
                    }
                } else {
                    if ($link=="") {
                        $list.="<li class='menu-parent ${menuName}'>${titl}</li>";
                    } else {
                        $list.="<li class='menu-parent ${menuName} ${active}'><a href='${url}'>${titl}</a></li>";
                    }
                }
        } else {
                $leaves = isset($branch["below"]) ? $branch["below"] : array();
                byu2016StripHidden($leaves);
                $leafCnt = count($leaves);
                
                if ($leafCnt > 0) {
                    if ($dropdown) {
                            $list.="<li class='dropdown menu-parent ${menuName}'>";
                            $list.="<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>${titl} <span class='caret'></span></a>";
                            $list.="<ul class='dropdown-menu dropdown-menu-right'>";
                            foreach($leaves as $leaf) {
                                $titl = isset($leaf["link"]["title"]) ? $leaf["link"]["title"] : "";
                                $titl = preg_replace('/::([a-zA-Z0-9\-]*)::/','<i class="fa ${1}" aria-hidden="true"></i>',$titl);
                                $link = isset($leaf["link"]["link_path"]) ? $leaf["link"]["link_path"] : ""; 
                                $url = url($link);
                                
                                if ($link=="") {
                                    $list.="<li class='menu-child ${menuName}'>${titl}</li>";
                                } else {
                                    $list.="<li class='menu-child ${menuName} ${active}'><a href='${url}'>${titl}</a></li>";
                                }
                            }
                            $list.="</ul>";
                            $list.="</li>";
                    } else {
                            $list.="<li class='menu-parent ${menuName}'><p>${titl} <span class='caret'></span></p></li>";
                            foreach($leaves as $leaf) {
                                $titl = isset($leaf["link"]["title"]) ? $leaf["link"]["title"] : "";
                                $titl = preg_replace('/::([a-zA-Z0-9\-]*)::/','<i class="fa ${1}" aria-hidden="true"></i>',$titl);
                                $link = isset($leaf["link"]["link_path"]) ? $leaf["link"]["link_path"] : ""; 
                                $url = url($link);
                                if ($link=="") {
                                    $list.="<li class='menu-child ${menuName}'>${titl}</li>";
                                } else {
                                    $list.="<li class='menu-child ${menuName} ${active}'><a href='${url}'>${titl}</a></li>";
                                }
                            }
                    }
                } else {
                    if ($link=="") {
                        $list.="<li class='menu-parent ${menuName}'>${titl}</li>";
                    } else {
                        $list.="<li class='menu-parent ${menuName} ${active}'><a href='${url}'>${titl}</a></li>";
                    }
                    
                }
        }
    }
    
    if (($cnt>=$b4Over) && ($branchCnt > $b4Over) && ($dropdown)) {
        $list.="<li class='dropdown main-menu-overflow ${menuName}'>";
        $list.="<a class='dropdown-toggle' data-toggle='dropdown' href='#'>More <span class='caret'></span></a>";
        $list.="<ul class='dropdown-menu dropdown-menu-right'>";
        $list.=$overflow;
        $list.="</ul>";
        $list.="</li>";
    }
    
    return $list;
    
}

/**
 *
 *  Remove Menu Items, not marked as *Enabled*, from the list 
 *
 */
function byu2016StripHidden(&$menu) {
    foreach($menu as $key=>$value) {
        $hidden = isset($value["link"]["hidden"]) ? $value["link"]["hidden"] : 0;
        if ($hidden) {
            unset($menu[$key]);
        }
    }
}

/**
 *
 *  PAGE MATCH 
 *
 */
function byu2016PageMatch($patternList) {

	$pagePath = current_path();
	$pageAlias = drupal_get_path_alias($pagePath);
	$pageFront = variable_get('site_frontpage', 'node');
	
	$patternList = strtolower($patternList); // Lowercast Patterns
	$patternList = preg_replace("/\s+/","",$patternList); // remove whitespace from Patterns
	$patternList = str_replace("<front>",$pageFront,$patternList); // replace <front> with actual URL
    $patternList = str_replace(",",PHP_EOL,$patternList); // replace commas with EOL
	
	if (drupal_match_path($pagePath, $patternList) || drupal_match_path($pageAlias, $patternList)) {
		return true;
    }
	return false;
	
}

/**
 *
 *  TYPE MATCH 
 *
 */
function byu2016TypeMatch($patternList,$type) {
	
	$type = strtolower($type); // Lowercast ContentType
	$type = preg_replace("/\s+/","",$type); // remove whitespace from ContentType

	$patternList = strtolower($patternList); // Lowercast Patterns
	$patternList = preg_replace("/\s+/","",$patternList); // remove whitespace from Patterns

    if ($patternList !== "") {
        $cTypes = explode(",",trim($patternList));
        foreach($cTypes as $ct) {
            if ( ($type !== "") && ($type === $ct) ) {
                return true;
            }
        }
    }
	return false;
	
}

/**
 *
 *  CDN Download 
 *
 */
function byu2016CDNDownload($url) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https:" : "http:";
    $fullURL= $protocol.$url;
    $ch = @curl_init($fullURL); 
    
    @curl_setopt($ch, CURLOPT_REFERER        ,"http://home.byu.edu/home/"); 
    @curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,true);    
    @curl_setopt($ch, CURLOPT_RETURNTRANSFER ,true);
    $data = @curl_exec($ch);
    $error = @curl_error($ch);
    $code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
    @curl_close($ch);

    if($code == 200) {
        $filename = drupal_get_path('theme', 'byu2016') . '/cdn/' . trim(str_replace("/","-",$url),"- ");
        @file_put_contents($filename,$data);
    } else {
        $filename = drupal_get_path('theme', 'byu2016') . '/cdn/log.txt';
        @file_put_contents($filename, $code ."--". $error ."\n\n" ,FILE_APPEND);
    }

}


/**
 *
 *  CDN Availability Check 
 *
 */
function byu2016CDNFallback($url) {

    if (theme_get_setting('use_local_libs') == 1) {
        return false;
    }

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https:" : "http:";
    $fullURL= $protocol.$url;
    
    if (strpos(strtolower($_SERVER['SERVER_NAME']), "byu.edu") === false) {
        return false; // FALLBACK if on development (non byu) domain
    }
    
    if (!function_exists('curl_version')) {
        return false; // FALLBACK if no CURL to check CDNs
    }
    
    $ch = @curl_init($fullURL);    
    if ($ch === false) {
        return false;
    }
    @curl_setopt($ch, CURLOPT_HEADER         ,true);
    @curl_setopt($ch, CURLOPT_NOBODY         ,true);
    @curl_setopt($ch, CURLOPT_RETURNTRANSFER ,true);
    @curl_exec($ch);
    if(@curl_errno($ch)) { 
        @curl_close($ch);
        return false;
    }    
    
    $code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
    @curl_close($ch);
    
    if ($code == 200) {
        return true;
    } else {
        return false;
    }
}
