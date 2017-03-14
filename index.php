<?php get_header(); ?>

<main>

	<div class="row content-top">

      <!-- start W@SCS general info (CMU logo, W@SCS, mission) -->
      <div class="col s12 l8">
        <div class="wscs-info">
          <img class="cmu-logo" src="<?php echo get_template_directory_uri() . '/img/cmu_wordmark.png';?>">
        </div>
        <h1 class="wscs-info">WOMEN<b>@SCS</b></h1> 
        <p class="wscs-info"> The Women@SCS mission is to create, encourage, and support academic, social, and professional opportunities for women in computer science and to promote the breadth of the field and its diverse community. </p>
      </div>
      <!-- end W@SCS general info (CMU logo, W@SCS, mission) -->

      <div class="col s12 section-divider"><hr></div>

      <!-- start upcoming events info -->
      <div class="col s12 l4" id="dates">
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

	<?php $first = true; ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php if ( $first ): ?>
			<div class="row news-section">
		    	<div class="label"> <h2>News</h2> </div>
		      	<div class="col s12 post">
			        <!-- TODO: deal with how much content is outputted here, and making sure it's centered; problem is need vertical-align: top to keep news div in line with image div -->
			        <div class="image feature"></div>
		        	<div class="news feature">
		          		<div class="content feature">
							<h3><?php the_title() ?></h3>
							<h4>by women@scs</h4>
							<p class="description"><?php the_content() ?></p>
		          			<div class="button">Read Full Story</div>
		         		</div>
		        	</div>
		      	</div>
		    </div>
		    <!-- TODO: hacky way of starting next row -->
		    <div class="row news-section">
			<?php $first = false; ?>
	    <?php else: ?>
		    <div class="col s12 l4 post">
		    	<div class="image"></div>
		        <div class="news">
		        	<div class="content">
		            	<h5><?php the_title() ?></h5>
		            	<h6>by women@scs</h6>
		          	</div>
		        </div>
		      </div>
	    <?php endif; ?>
	<?php endwhile; else : ?>

		<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>

	<?php endif; ?>
	<!-- TODO: hacky way of ending row -->
</div>
</main>

<?php get_footer(); ?>

