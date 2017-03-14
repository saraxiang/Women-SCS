<!doctype html>
  <head>
    <meta charset="utf-8"/>
    <!-- Using the meta viewport value width=device-width instructs the page to match the screen's width in device-independent pixels. This allows the page to reflow content to match different screen sizes, whether rendered on a small mobile phone or a large desktop monitor. 
    tldr:
    Use the meta viewport tag to control the width and scaling of the browser's viewport.
    Include width=device-width to match the screen's width in device-independent pixels.
    Include initial-scale=1 to establish a 1:1 relationship between CSS pixels and device-independent pixels.-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Women@SCS</title>
    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>
    <div class="row">
      <div class="col s12 padding-top"></div>
    </div>


    <!-- start nav bar -->
      <!-- z-depth-0 removes the shadow effect that is the default for materialize css nav bars -->
      <nav id="main-nav" class="z-depth-0">
        <div class="nav-wrapper">
          <a href="#" data-activates="mobile-nav" class="button-collapse"><i class="material-icons">menu</i></a> <!-- hamburger icon :D - only visible on mobile -->
          <?php
            $defaults = array(
              'menu_class'=>'right hide-on-med-and-down',
              'container'=> false,
              'theme_location' => 'primary-menu',
              'walker' => new wscs_materializecss_walker(),
            ); 
            //details: https://developer.wordpress.org/reference/functions/wp_nav_menu/
            //container boolean determines whether wrapped in auto-generated div
            //theme_location links to menu (from functions.php array)
            //menu-class adds classes to ul (that wraps the nav)

            wp_nav_menu($defaults);
         ?>
         <?php
            $defaults = array(
              'menu_class'=>'side-nav',
              'menu_id' => 'mobile-nav',
              'container'=> false,
              'theme_location' => 'primary-menu',
            ); 
            wp_nav_menu($defaults);
         ?>
        </div>
      </nav>
    <!-- end nav bar -->      