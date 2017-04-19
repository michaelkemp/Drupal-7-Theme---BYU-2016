<div id="page">

    <header role="banner" id="header" class="header byu2016-top-header">
    <!--- ========================================================== BEGIN DESKTOP ========================================================== --->
        <nav role="navigation" class="navbar byu2016-header-desktop">
            <div class="container byu2016-header-desktop-container">
            
                <!-- ================= BYU LOGO + SITE TITLE ================= -->
                <div class="byu2016-header-desktop-site">
                    <?php print $variables['site_logo']; ?>
                </div> 
                
                <div class="byu2016-header-desktop-menu-search">
     
                    <!-- ================= DESKTOP USER MENU ================= -->
                    <?php if (trim($variables["user-menu-markup"] . $variables["add-login"]) != ""): ?>
                        <ul class="nav navbar-nav byu2016-header-desktop-menu">
                            <?php print $variables["user-menu-markup"]; ?>
                            <?php print $variables["add-login"]; ?>
                        </ul>
                    <?php endif; ?>
                    
                    <!-- ================= DESKTOP SEARCH FORM ================= -->
                    <?php if (theme_get_setting('search_use') == 1): ?>
                        <div class="byu2016-header-desktop-search">
                            <?php $search = drupal_get_form('search_block_form'); print render($search); ?>
                        </div>
                    <?php endif; ?>
                    
                </div>
                
            </div>
        </nav>

        <?php if (trim($variables["main-menu-markup"]) != ""): ?>
            <nav role="navigation" class="navbar byu2016-main-menu-desktop">
                <div class="container byu2016-main-menu-desktop-container">
                    <!-- ================= DESKTOP MAIN MENU ================= -->
                    <ul class="nav navbar-nav byu2016-main-menu-desktop-menu">
                        <?php print $variables["main-menu-markup"]; ?>
                    </ul>
                </div>
            </nav>
        <?php endif; ?>
    <!--- ========================================================== END DESKTOP ========================================================== --->


    <!--- ========================================================== BEGIN MOBILE ========================================================== --->
        <nav role="navigation" class="navbar byu2016-header-mobile">
            <div class="container byu2016-header-mobile-container">
                <!-- ================= BYU LOGO + SITE TITLE ================= -->
                <div class="byu2016-header-mobile-site">
                    <?php print $variables['site_logo']; ?>
                </div> 
                <?php if (trim($variables["main-menu-markup"] . $variables["user-menu-markup"] . $variables["add-login"]) != ""): ?>
                    <div class="byu2016-header-mobile-menu-button">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#byu2016-mobile-menu-collapse" aria-expanded="false" aria-label="Main Menu">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </nav>
        
        <?php if (trim($variables["main-menu-markup-flat"] . $variables["user-menu-markup-flat"] . $variables["add-login"]) != ""): ?>
            <nav role="navigation" class="navbar byu2016-combined-menu-mobile">
                <div class="container byu2016-header-mobile-menu">
                    <div class="collapse navbar-collapse" id="byu2016-mobile-menu-collapse">
                        <ul class="nav navbar-nav byu2016-header-mobile-combined-menu">
                            <?php 
                                if (trim($variables["add-login"]) != "") {
                                    print $variables["add-login"];
                                }
                            ?>
                            <?php 
                                if (trim($variables["main-menu-markup-flat"]) != "") {
                                    print $variables["main-menu-markup-flat"];
                                }
                            ?>
                            <?php
                                if (trim($variables["user-menu-markup-flat"]) != "") {
                                    print $variables["user-menu-markup-flat"];
                                }
                            ?>
                        </ul>
                    </div>        
                </div>
            </nav>
        <?php endif; ?>

        <?php if (theme_get_setting('search_use') == 1): ?>
            <nav role="navigation" class="navbar byu2016-search-mobile">
                <!-- ================= MOBILE SEARCH FORM ================= -->
                <div class="byu2016-header-mobile-search">
                    <?php $search = drupal_get_form('search_block_form'); print render($search); ?>
                </div>
            </nav>
        <?php endif; ?>    
    <!--- ========================================================== END MOBILE ========================================================== --->
    </header>

    
    <main role="main">
        <a name="main-content" aria-label="Main Content"></a>
        <div id="flex-body" class="<?php print $variables["content-url-class"]; ?>">
            <?php if ($page['hero']): ?>    
                <div id="hero"><?php print render($page['hero']); ?></div>
            <?php endif; ?>
            
            <?php if ($page['fullwidth']): ?>    
                <div id="fullwidth"><?php print render($page['fullwidth']); ?></div>
            <?php endif; ?>

            <!--- ======== DRUPAL HELP and MESSAGES ======== --->
            <?php if ($page['help']): ?>    
                <div id="help" class="container"><?php print render($page['help']); ?></div>
            <?php endif; ?>
            <?php if (!empty($messages) && user_is_logged_in()) : ?>
                <div id="messages" class="container"><?php print $messages; ?></div>
            <?php endif; ?>
            <!--- ======== DRUPAL HELP and MESSAGES ======== --->
            
            <?php
                if ($page['ten-column']) {
                    print "<div id='ten-col-container' class='container'>";
                    print "    <div id='ten-col-columm' class='col-md-10 col-md-push-1'>";
                    print "        <div id='ten-col-content'>" .render($page['ten-column']). "</div>";            
                    print "    </div>";
                    print "    <div id='one-col-columm-lhs' class='col-md-1 col-md-pull-1'></div>";
                    print "    <div id='one-col-columm-rhs' class='col-md-1'></div>";
                    print "</div>";
                }
            ?>
            
            <div id="page-content" class="container">

                <div class="row">
                <?php
                    $push = "";
                    $sbWide = intval($variables["sidebar-columns"]);
                    $conWide = 12;
                    if ($page['lhs']) { $conWide-= $sbWide; $push = "col-md-push-${sbWide}"; }
                    if ($page['rhs']) { $conWide-= $sbWide; }
                
                    print "<div id='page-content-columm' class='col-md-${conWide} ${push}'>";
                    
                        if ($page['content-head']) {
                            print "<div id='content-head' class='content-head'>" .render($page['content-head']). "</div>";
                        }
                        
                        print "<div id='content'>";
                            if ((theme_get_setting('page_title') == 1) && ($title)) { print "<h1 class='page-title title' id='page-title'>" .$title. "</h1>"; }
                            if ($page['content']) { print render($page['content']); } 
                        print "</div>";
                        
                        if ($page['content-foot']) {
                            print "<div id='content-foot' class='content-foot'>" .render($page['content-foot']). "</div>";
                        }
                        
                    print "</div>";
                    
                    // SIDEBAR
                    if ($page['lhs']) {
                        print "<div id='lhs' class='sidebar-left col-md-${sbWide} col-md-pull-${conWide}'>" .render($page['lhs']). "</div>";
                    }
                    
                    // SIDEBAR
                    if ($page['rhs']) {
                        print "<div id='rhs' class='sidebar-right col-md-${sbWide}'>" .render($page['rhs']). "</div>";
                    }
                    
                ?>
                </div>
            </div>
            
            <?php
                if ($page['eight-column']) {
                    print "<div id='eight-col-container' class='container'>";
                    print "    <div id='eight-col-columm' class='col-md-8 col-md-push-2'>";
                    print "        <div id='eight-col-content'>" .render($page['eight-column']). "</div>";            
                    print "    </div>";
                    print "    <div id='two-col-columm-lhs' class='col-md-2 col-md-pull-2'></div>";
                    print "    <div id='two-col-columm-rhs' class='col-md-2'></div>";
                    print "</div>";
                }
            ?>
            
        </div>
    </main>
    
    <footer role="contentinfo" id="footer" class="footer">
        <?php if ($page['footer']): ?>    
            <div id="footer" class="container"><?php print render($page['footer']); ?></div>
        <?php endif; ?>
        <div class='byu2016-footer-div'>
            <?php if (intval(theme_get_setting('foot_region_cnt')) > 0): ?> 
                <div class='byu2016-footer-div-site-wrapper container'>
                    <div class='byu2016-footer-div-site'>
                        <?php
                            $region1 = "";
                            if (theme_get_setting('foot_area1_title')) { $region1.=  "<h2>" .theme_get_setting('foot_area1_title'). "</h2>"; }
                            if (theme_get_setting('foot_area1_body'))  { $region1.=  preg_replace('/::([a-zA-Z0-9\-]*)::/','<i class="fa ${1}" aria-hidden="true"></i>',theme_get_setting('foot_area1_body')); } 
                            $region2 = "";
                            if (theme_get_setting('foot_area2_title')) { $region2.=  "<h2>" .theme_get_setting('foot_area2_title'). "</h2>"; }
                            if (theme_get_setting('foot_area2_body'))  { $region2.=  preg_replace('/::([a-zA-Z0-9\-]*)::/','<i class="fa ${1}" aria-hidden="true"></i>',theme_get_setting('foot_area2_body')); } 
                            $region3 = "";
                            if (theme_get_setting('foot_area3_title')) { $region3.=  "<h2>" .theme_get_setting('foot_area3_title'). "</h2>"; }
                            if (theme_get_setting('foot_area3_body'))  { $region3.=  preg_replace('/::([a-zA-Z0-9\-]*)::/','<i class="fa ${1}" aria-hidden="true"></i>',theme_get_setting('foot_area3_body')); } 
                            $region4 = "";
                            if (theme_get_setting('foot_area4_title')) { $region4.=  "<h2>" .theme_get_setting('foot_area4_title'). "</h2>"; }
                            if (theme_get_setting('foot_area4_body'))  { $region4.=  preg_replace('/::([a-zA-Z0-9\-]*)::/','<i class="fa ${1}" aria-hidden="true"></i>',theme_get_setting('foot_area4_body')); } 
                            
                            $footCnt = (theme_get_setting('foot_region_cnt')) ? theme_get_setting('foot_region_cnt') : 4;
                            switch ($footCnt) {
                                case 4:
                                    print "<div class='byu2016-footer-site-block col-md-3 col-sm-6 col-xs-12'>" . $region1 . "</div>";
                                    print "<div class='byu2016-footer-site-block col-md-3 col-sm-6 col-xs-12'>" . $region2 . "</div>";
                                    print "<div class='byu2016-footer-site-block col-md-3 col-sm-6 col-xs-12'>" . $region3 . "</div>";
                                    print "<div class='byu2016-footer-site-block col-md-3 col-sm-6 col-xs-12'>" . $region4 . "</div>";
                                    break;
                                case 3:
                                    print "<div class='byu2016-footer-site-block col-md-4 col-sm-4 col-xs-12'>" . $region1 . "</div>";
                                    print "<div class='byu2016-footer-site-block col-md-4 col-sm-4 col-xs-12'>" . $region2 . "</div>";
                                    print "<div class='byu2016-footer-site-block col-md-4 col-sm-4 col-xs-12'>" . $region3 . "</div>";
                                    break;
                                case 2:
                                    print "<div class='byu2016-footer-site-block col-md-6 col-sm-6 col-xs-12'>" . $region1 . "</div>";
                                    print "<div class='byu2016-footer-site-block col-md-6 col-sm-6 col-xs-12'>" . $region2 . "</div>";
                                    break;
                                case 1:
                                    print "<div class='byu2016-footer-site-block col-md-12 col-sm-12 col-xs-12'>" . $region1 . "</div>";
                                    break;
                                default:
                                    print "<div class='byu2016-footer-site-block col-md-3 col-sm-6 col-xs-12'>" . $region1 . "</div>";
                                    print "<div class='byu2016-footer-site-block col-md-3 col-sm-6 col-xs-12'>" . $region2 . "</div>";
                                    print "<div class='byu2016-footer-site-block col-md-3 col-sm-6 col-xs-12'>" . $region3 . "</div>";
                                    print "<div class='byu2016-footer-site-block col-md-3 col-sm-6 col-xs-12'>" . $region4 . "</div>";
                                    break;
                            }
                        ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class='byu2016-footer-div-byu'>
                <div class='byu2016-footer-byu-logo'>
                    <a href='http://byu.edu/'><img src='/<?php print $directory ?>/images/footer-wordmark-inline.svg' alt='Brigham Young University'></img></a>
                </div>
                <div class='byu2016-footer-byu-logo-stacked'>
                    <a href='http://byu.edu/'><img src='/<?php print $directory ?>/images/footer-wordmark-stacked.svg' alt='Brigham Young University'></img></a>
                </div>
                <div class='byu2016-footer-byu-copyright'>
                    <?php 
                        if (theme_get_setting('site_map_add') == 1) {
                            $smText = theme_get_setting('site_map_text');
                            $smURL = theme_get_setting('site_map_url');
                            print "<span id='byu2016-footer-tagline'><a href='${smURL}'>${smText}</a></span>&nbsp;&nbsp;|&nbsp;";
                        }
                    ?> 
                    <span id='byu2016-footer-copyright'>&copy; <?php echo date("Y") ?>, All Rights Reserved&nbsp;&nbsp;| &nbsp;Provo,&nbsp;UT&nbsp;84602,&nbsp;USA&nbsp;&nbsp;|&nbsp;&nbsp;1&#8209;801&#8209;422&#8209;4636</span>
                </div>
            </div>
        </div>
    </footer>    
    
    <?php if ($page['bottom']): ?>    
        <div id="bottom" class="container"><?php print render($page['bottom']); ?></div>
    <?php endif; ?>

</div>
