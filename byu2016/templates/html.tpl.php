<!DOCTYPE html>
<html>
<head>
    <?php print $head; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="theme-color" content="#002e5d">
    <?php print $variables['meta_tags']; ?>
    <title><?php print $head_title; ?></title>
    <?php print $styles; ?>
    <?php print $scripts; ?>
    
    <?php 
        // ============================ INCLUDE FACEBOOK SCRIPT ============================
        if ($variables['facebook_id'] != "") { 
            print '<script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/en_US/all.js#xfbml=1"; fjs.parentNode.insertBefore(js, fjs); }(document, "script", "facebook-jssdk")); </script>';
        } 
    ?>    
    
</head>
<body>
    <div id="skip-to-main-content"><a href="#main-content">Skip to Main Content</a></div>
    <?php print $page_top; ?>
    <?php print $page; ?>
    <?php print $page_bottom; ?>
</body>
</html>
