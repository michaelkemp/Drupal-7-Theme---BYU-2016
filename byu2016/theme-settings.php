<?php

/**
 *
 *  Implements HOOK_form_system_theme_settings_alter(&$form, $form_state)
 *
 */
function byu2016_form_system_theme_settings_alter(&$form, $form_state) {

    unset($form['theme_settings']);
    
    $form['header'] = array(
        '#type' => 'fieldset',
        '#title' => 'Header Settings',
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
    );
        $form['header']['main_title'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Main Site Title'),
            '#default_value' => theme_get_setting('main_title'),
            '#description'   => t("The Main Title appears in the site header."),
        );
        $form['header']['subtitle'] = array(
            '#type' => 'fieldset',
            '#title' => 'Subtitle Settings',
            '#collapsible' => FALSE,
            '#collapsed' => FALSE,
        );
            $form['header']['subtitle']['sub_title_use'] = array(
                '#type'          => 'checkbox',
                '#title'         => t('Use Subtitle'),
                '#default_value' => theme_get_setting('sub_title_use'),
                '#description'   => t("Add Sub Title to the site header."),
            );
            $form['header']['subtitle']['sub_title_above'] = array(
                '#type'          => 'checkbox',
                '#title'         => t('Subtitle Above'),
                '#default_value' => theme_get_setting('sub_title_above'),
                '#description'   => t("Place the subtitle above the Main Title."),
            );
            $form['header']['subtitle']['sub_title_italic'] = array(
                '#type'          => 'checkbox',
                '#title'         => t('Subtitle Italic'),
                '#default_value' => theme_get_setting('sub_title_italic'),
                '#description'   => t("Italicize the subtitle."),
            );
            $form['header']['subtitle']['sub_title'] = array(
                '#type'          => 'textfield',
                '#title'         => t('Site Subtitle'),
                '#default_value' => theme_get_setting('sub_title'),
                '#description'   => t("The subtitle appears below (or above) the Main Title."),
            );



        $form['header']['login'] = array(
            '#type' => 'fieldset',
            '#title' => 'Login/Logout Settings',
            '#collapsible' => FALSE,
            '#collapsed' => FALSE,
        );
            $form['header']['login']['add_login'] = array(
                '#type'          => 'checkbox',
                '#title'         => t('Add Login/Logout'),
                '#default_value' => theme_get_setting('add_login'),
                '#description'   => t("Add Login/Logout to Header Menu."),
            );
            $form['header']['login']['login_text'] = array(
                '#type'          => 'textfield',
                '#title'         => t('Login Text'),
                '#default_value' => theme_get_setting('login_text'),
                '#description'   => t('Menu Text - (http://fontawesome.io/ icons can be added by using ::fa-bars:: instead of &lt;i class="fa fa-bars" aria-hidden="true">&lt;/i>)'),
            );
            $form['header']['login']['login_link'] = array(
                '#type'          => 'textfield',
                '#title'         => t('Login Link'),
                '#default_value' => theme_get_setting('login_link'),
                '#description'   => t("Relative URL to Login Page - eg. /user/login"),
            );
            $form['header']['login']['logout_text'] = array(
                '#type'          => 'textfield',
                '#title'         => t('Logout Text'),
                '#default_value' => theme_get_setting('logout_text'),
                '#description'   => t('Menu Text - (http://fontawesome.io/ icons can be added by using ::fa-bars:: instead of &lt;i class="fa fa-bars" aria-hidden="true">&lt;/i>)'),
            );
            $form['header']['login']['logout_link'] = array(
                '#type'          => 'textfield',
                '#title'         => t('Logout Link'),
                '#default_value' => theme_get_setting('logout_link'),
                '#description'   => t("Relative URL to Logout Page - eg. /user/logout"),
            );


            
        $form['header']['search'] = array(
            '#type' => 'fieldset',
            '#title' => 'Search Settings',
            '#collapsible' => FALSE,
            '#collapsed' => FALSE,
        );
            $form['header']['search']['search_use'] = array(
                '#type'          => 'checkbox',
                '#title'         => t('Include Search Form'),
                '#default_value' => theme_get_setting('search_use'),
                '#description'   => t("Add Search Form to Site Header."),
            );
            $form['header']['search']['search_url'] = array(
                '#type'          => 'textfield',
                '#title'         => t('Search Results URL'),
                '#default_value' => theme_get_setting('search_url'),
                '#description'   => t("URL that Search Results appear on - eg /search/node"),
            );


        $form['header']['menu_count'] = array(
            '#type' => 'select',
            '#title' => t('Menu Count'),
            '#description' => t('Maximum items in Main Menu before Dropdown'),
            '#default_value' => theme_get_setting('menu_count'),
            '#options' => array(
                4 => t('Four'),
                5 => t('Five'),
                6 => t('Six'),
                7 => t('Seven'),
                8 => t('Eight'),
            ),
            
        );


    $form['footer'] = array(
        '#type' => 'fieldset',
        '#title' => t('Footer Settings'),
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
    );
        $form['footer']['foot_region_cnt'] = array(
            '#type' => 'select',
            '#title' => t('Footer Regions'),
            '#description' => t('Number of regions (below) to include in the footer.'),
            '#options' => array(
                0 => t('None'),
                1 => t('One'),
                2 => t('Two'),
                3 => t('Three'),
                4 => t('Four'),
            ),
            '#default_value' => theme_get_setting('foot_region_cnt'),
        );
        
        $form['footer']['foot_area1'] = array(
            '#type' => 'fieldset',
            '#title' => t('Footer Column One'),
            '#collapsible' => FALSE,
            '#collapsed' => FALSE,
        );
            $form['footer']['foot_area1']['foot_area1_title'] = array(
                '#type'          => 'textfield',
                '#title'         => t('Title'),
                '#default_value' => theme_get_setting('foot_area1_title'),
                '#description'   => t("Title Text."),
            );
            $form['footer']['foot_area1']['foot_area1_body'] = array(
                '#title'            => t('Body'),
                '#description'      => t('Body HTML - (http://fontawesome.io/ icons can be added by using ::fa-bars:: instead of &lt;i class="fa fa-bars" aria-hidden="true">&lt;/i>).'),
                '#default_value'    => theme_get_setting('foot_area1_body'),
                '#type'             => 'textarea',
                '#format'           => 'filtered_html',
                '#pre_render'       => array('ckeditor_pre_render_text_format'),
                '#cols'             => 80,
                '#rows'             => 8,
                '#wysiwyg'          => TRUE,
            );       
        
        $form['footer']['foot_area2'] = array(
            '#type' => 'fieldset',
            '#title' => t('Footer Column Two'),
            '#collapsible' => FALSE,
            '#collapsed' => FALSE,
        );
            $form['footer']['foot_area2']['foot_area2_title'] = array(
                '#type'          => 'textfield',
                '#title'         => t('Title'),
                '#default_value' => theme_get_setting('foot_area2_title'),
                '#description'   => t("Title Text."),
            );
            $form['footer']['foot_area2']['foot_area2_body'] = array(
                '#title'            => t('Body'),
                '#description'      => t('Body HTML - (http://fontawesome.io/ icons can be added by using ::fa-bars:: instead of &lt;i class="fa fa-bars" aria-hidden="true">&lt;/i>).'),
                '#default_value'    => theme_get_setting('foot_area2_body'),
                '#type'             => 'textarea',
                '#format'           => 'filtered_html',
                '#pre_render'       => array('ckeditor_pre_render_text_format'),
                '#cols'             => 80,
                '#rows'             => 8,
                '#wysiwyg'          => TRUE,
            );     
        
        $form['footer']['foot_area3'] = array(
            '#type' => 'fieldset',
            '#title' => t('Footer Column Three'),
            '#collapsible' => FALSE,
            '#collapsed' => FALSE,
        );
            $form['footer']['foot_area3']['foot_area3_title'] = array(
                '#type'          => 'textfield',
                '#title'         => t('Title'),
                '#default_value' => theme_get_setting('foot_area3_title'),
                '#description'   => t("Title Text."),
            );
            $form['footer']['foot_area3']['foot_area3_body'] = array(
                '#title'            => t('Body'),
                '#description'      => t('Body HTML - (http://fontawesome.io/ icons can be added by using ::fa-bars:: instead of &lt;i class="fa fa-bars" aria-hidden="true">&lt;/i>).'),
                '#default_value'    => theme_get_setting('foot_area3_body'),
                '#type'             => 'textarea',
                '#format'           => 'filtered_html',
                '#pre_render'       => array('ckeditor_pre_render_text_format'),
                '#cols'             => 80,
                '#rows'             => 8,
                '#wysiwyg'          => TRUE,
            );      
        
        $form['footer']['foot_area4'] = array(
            '#type' => 'fieldset',
            '#title' => t('Footer Column Four'),
            '#collapsible' => FALSE,
            '#collapsed' => FALSE,
        );
            $form['footer']['foot_area4']['foot_area4_title'] = array(
                '#type'          => 'textfield',
                '#title'         => t('Title'),
                '#default_value' => theme_get_setting('foot_area4_title'),
                '#description'   => t("Title Text."),
            );
            $form['footer']['foot_area4']['foot_area4_body'] = array(
                '#title'            => t('Body'),
                '#description'      => t('Body HTML - (http://fontawesome.io/ icons can be added by using ::fa-bars:: instead of &lt;i class="fa fa-bars" aria-hidden="true">&lt;/i>).'),
                '#default_value'    => theme_get_setting('foot_area4_body'),
                '#type'             => 'textarea',
                '#format'           => 'filtered_html',
                '#pre_render'       => array('ckeditor_pre_render_text_format'),
                '#cols'             => 80,
                '#rows'             => 8,
                '#wysiwyg'          => TRUE,
            );       

        $form['footer']['sitemap'] = array(
            '#type' => 'fieldset',
            '#title' => t('Site Map Settings'),
            '#collapsible' => FALSE,
            '#collapsed' => FALSE,
        );
            $form['footer']['sitemap']['site_map_add'] = array(
                '#type'          => 'checkbox',
                '#title'         => t('Add Site Map Link.'),
                '#default_value' => theme_get_setting('site_map_add'),
                '#description'   => t("Add Site Map Link in Footer."),
            );
            $form['footer']['sitemap']['site_map_text'] = array(
                '#type'          => 'textfield',
                '#title'         => t('Site Map Text.'),
                '#default_value' => theme_get_setting('site_map_text'),
                '#description'   => t("Link Text."),
            );
            $form['footer']['sitemap']['site_map_url'] = array(
                '#type'          => 'textfield',
                '#title'         => t('Site Map URL.'),
                '#default_value' => theme_get_setting('site_map_url'),
                '#description'   => t("Link URL."),
            );


            
    $form['meta'] = array(
        '#type' => 'fieldset',
        '#title' => t('Icon, App, & META Settings'),
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
    );
        $form['meta']['block_robots'] = array(
            '#type'          => 'checkbox',
            '#title'         => t('Block Search Engine Crawlers'),
            '#default_value' => theme_get_setting('block_robots'),
            '#description'   => t("Adds 'noindex, nofollow' META Tag"),
        );
        $form['meta']['icon_directory'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Site FAV/Apple Icon Directory'),
            '#default_value' => theme_get_setting('icon_directory'),
            '#description'   => t("This directory should be created inside the sites directory in the theme folder. http://iconifier.net can be used to create needed icons."),
        );
        $form['meta']['facebook_app_id'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Facebook App ID'),
            '#default_value' => theme_get_setting('facebook_app_id'),
            '#description'   => t("Add this value if using a Facebook Comments Section."),
        );
        $form['meta']['site_description'] = array(
            '#type'          => 'textfield',
            '#title'         => t('Site Description'),
            '#default_value' => theme_get_setting('site_description'),
            '#description'   => t("Used in 'og:description' Meta Data"),
        );

    $form['page_settings'] = array(
        '#type' => 'fieldset',
        '#title' => t('Page Settings'),
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
    );
        $form['page_settings']['show_tabs'] = array(
            '#type'          => 'checkbox',
            '#title'         => t('Display View/Edit/Revision Tabs'),
            '#default_value' => theme_get_setting('show_tabs'),
            '#description'   => t("Puts Drupal View/Edit/Revision tabs the on content page."),
        );
        $form['page_settings']['responsive_images'] = array(
            '#type'          => 'checkbox',
            '#title'         => t('Bootstrap Responsive Images'),
            '#default_value' => theme_get_setting('responsive_images'),
            '#description'   => t("Adds the 'img-responsive' class to img tags"),
        );
        $form['page_settings']['byu_bootstrap_css'] = array(
            '#type'          => 'checkbox',
            '#title'         => t('BYU Bootstrap Theme'),
            '#default_value' => theme_get_setting('byu_bootstrap_css'),
            '#description'   => t("Use Bootstrap Theme with BYU Colors and Fonts by default."),
        );
        $form['page_settings']['full_font_package'] = array(
            '#type'          => 'checkbox',
            '#title'         => t('Full Font Package'),
            '#default_value' => theme_get_setting('full_font_package'),
            '#description'   => t("Include the Full Font Package (Gotham, Gotham Condensed, Sentinel, Vitesse, Whitney - 900KB) instead of the Light Font Package (Gotham, Vitesse - 320KB)"),
        );
        $form['page_settings']['page_title'] = array(
            '#type'          => 'checkbox',
            '#title'         => t('Render Page Title'),
            '#default_value' => theme_get_setting('page_title'),
            '#description'   => t("Include Page Title Rendering."),
        );
        $form['page_settings']['layout282'] = array(
            '#type'          => 'textfield',
            '#maxlength'     => 1024, 
            '#title'         => t('2-8-2 Layout - Pages'),
            '#default_value' => theme_get_setting('layout282'),
            '#description'   => t("Pages with 2 Column Sidebars and 8 Column Content. Comma separated, * as wildcard."),
        );
        $form['page_settings']['layout282ct'] = array(
            '#type'          => 'textfield',
            '#maxlength'     => 1024, 
            '#title'         => t('2-8-2 Layout - Content Types'),
            '#default_value' => theme_get_setting('layout282ct'),
            '#description'   => t("Content Types (machine name). Comma separated."),
        );
        $form['page_settings']['layout444'] = array(
            '#type'          => 'textfield',
            '#maxlength'     => 1024, 
            '#title'         => t('4-4-4 Layout - Pages'),
            '#default_value' => theme_get_setting('layout444'),
            '#description'   => t("Pages with 4 Column Sidebars and 4 Column Content. Comma separated, * as wildcard."),
        );
        $form['page_settings']['layout444ct'] = array(
            '#type'          => 'textfield',
            '#maxlength'     => 1024, 
            '#title'         => t('4-4-4 Layout - Content Types'),
            '#default_value' => theme_get_setting('layout444ct'),
            '#description'   => t("Content Types (machine name). Comma separated."),
        );


        $form['#validate'][] = 'byu2016_theme_settings_valitation';
        
}

function byu2016_theme_settings_valitation($form, &$form_state) {
    
    $footerHTML = array();
    $footerHTML['foot_area1_body'] = isset($form_state['values']['foot_area1_body']) ? check_markup($form_state['values']['foot_area1_body'],"filtered_html") : "";
    $footerHTML['foot_area2_body'] = isset($form_state['values']['foot_area2_body']) ? check_markup($form_state['values']['foot_area2_body'],"filtered_html") : "";
    $footerHTML['foot_area3_body'] = isset($form_state['values']['foot_area3_body']) ? check_markup($form_state['values']['foot_area3_body'],"filtered_html") : "";
    $footerHTML['foot_area4_body'] = isset($form_state['values']['foot_area4_body']) ? check_markup($form_state['values']['foot_area4_body'],"filtered_html") : "";

    foreach($footerHTML as $key => $value) {
        if (trim($value) != "") {
                $dom = new DomDocument();
                $dom->encoding = 'utf-8';
                $dom->strictErrorChecking = false;
                $dom->loadHTML(utf8_decode($value));
                foreach ($dom->getElementsByTagName('a') as $item) {
                    $href = trim($item->getAttribute('href'));
                    $titl = trim($item->getAttribute('title'));
                    $text = trim($item->nodeValue);
                    
                    $noTITL = ($titl == ""); // empty/missing title tag
                    $noTEXT = (preg_replace('/::([a-zA-Z0-9\-]*)::/','',$text) == ""); // Nothing but a font awesome icon
                    if ($noTITL && $noTEXT) {
                        switch($key) {
                            case 'foot_area1_body': form_set_error($key, t('Please include a title for your "Footer Column One" links eg &lt;a href="http://facebook.com/" title="Visit our Facebook">::fa-facebook-official::&lt;/a>')); break;
                            case 'foot_area2_body': form_set_error($key, t('Please include a title for your "Footer Column Two" links eg &lt;a href="http://facebook.com/" title="Visit our Facebook">::fa-facebook-official::&lt;/a>')); break;
                            case 'foot_area3_body': form_set_error($key, t('Please include a title for your "Footer Column Three" links eg &lt;a href="http://facebook.com/" title="Visit our Facebook">::fa-facebook-official::&lt;/a>')); break;
                            case 'foot_area4_body': form_set_error($key, t('Please include a title for your "Footer Column Four" links eg &lt;a href="http://facebook.com/" title="Visit our Facebook">::fa-facebook-official::&lt;/a>')); break;
                        }
                    } else {
                        if ($titl != "") {
                            $item->setAttribute('aria-label', $titl);
                            $html = $dom->saveHTML();
                            if ($html !== false) { $form_state['values'][$key] = $html; }
                        }
                    }
                }
        }
    }
    
}

