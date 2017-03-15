<?php get_header(); ?>

<main>

  <div class="row content-top">

      <!-- start W@SCS general info (CMU logo, W@SCS, mission) -->
      <div class="col s12 l8">
        <div class="wscs-info">
          <img class="cmu-logo" src="<?php echo get_template_directory_uri() . '/img/cmu_wordmark.png';?>">
        </div>
        <h1 class="wscs-info">WOMEN<b>@SCS</b></h1> 
        <p class="wscs-info hide-on-small-screens"> The Women@SCS mission is to create, encourage, and support academic, social, and professional opportunities for women in computer science and to promote the breadth of the field and its diverse community. </p>
      </div>
      <!-- end W@SCS general info (CMU logo, W@SCS, mission) -->

      <div class="col s12 section-divider less-margin"><hr></div>

      <!-- start upcoming events info -->
      <div class="col s12 l4 hide-on-small-screens" id="dates">
        <div class="label"> <h2>Upcoming <br> Events</h2> </div>
        <!-- Event 1 / 3 -->
        <div class="event">
          <div class="info">Mon, Feb 8</div>
          <div class="name"><b>Faculty Student Dinner</b></div>
          <div class="info">Cool Restaurant</div>
        </div>
        <hr>
        <!-- Event 2 / 3 -->
        <div class="event">
          <div class="info">Wed, Mar 9</div>
          <div class="name"><b>AirBnb Dinner</b></div>
          <div class="info">Another Cool Place</div>
        </div>
        <hr>
        <!-- Event 3 / 3 -->
        <div class="event">
          <div class="info">Thurs, Dec 11</div>
          <div class="name"><b>Women@SCS Meeting</b></div>
          <div class="info">GHC 4412</div>
        </div>
      </div>
      <!-- end upcoming events info -->

    </div>


  <div class="col s12 section-divider"></div>
  <div class="wscs-page-content">
    <?php $first = true; ?>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      
      <div class="page-title "><b><?php the_title() ?></b></div>
      <p class="description"><?php the_content() ?></p>
      
    <?php endwhile; else : ?>

      <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>

    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>

