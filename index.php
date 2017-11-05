<?php get_header();
    date_default_timezone_set('EST');
    $currentTime = date('c');
    // 3 query parameters set:
    // maxResults = 3
    // timeMin = currentTime
    // key = API key (obtain from console.developers.google.com - navigate to correct project > create credentials > API key)
    $calendarEventsRequest = wp_remote_get( 'https://www.googleapis.com/calendar/v3/calendars/xiangyiqisara@gmail.com/events?key=AIzaSyDDIMbO-_T-5cklnZU1-nnZAavWox67-ds&maxResults=3&timeMin=' . $currentTime);
    if ( is_array( $calendarEventsRequest ) ) {
      $calendarEvents = $calendarEventsRequest['body']; // use the content
    } else {
            $response = "ERROR";
    }
?>

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
            <?php
	        	$json = json_decode($calendarEvents, true);
	        	// var_dump($json["items"]);
	        	foreach ($json["items"] as $event) {
	        		$dateString = $event["start"]["date"] ? $event["start"]["date"] : $event["start"]["dateTime"];
	        		echo
	        			'<div class="event">
	        				<div class="info">' . $dateString . '</div>
	        				<div class="name"><b>' . $event["summary"] . '</b></div>
	        				<div class="info">' . $event["location"] . '</div>
	        			</div>';
	        	}
	        ?>
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
                    <?php
                      echo sprintf(
                        '<a class="button" href="%s" rel="bookmark">
                           Read Full Story
                         </a>', esc_url(get_permalink())); ?>
		         		</div>
		        	</div>
		      	</div>
		    </div>
		    <!-- TODO: hacky way of starting next row -->
		    <div class="row news-section">
			<?php $first = false; ?>
	    <?php else: ?>
		    <div class="col s12 l4 post">
          <?php
              echo sprintf(
                '<a class="post-link" href="%s">
                  <div class="image"></div>
                  <div class="news">
                    <div class="content">
                        <h5>%s</h5>
                        <h6>by women@scs</h6>
                      </div>
                  </div>
                </a>', esc_url(get_permalink()), the_title('','',false)); ?>
		    </div>
	    <?php endif; ?>
	<?php endwhile; else : ?>

		<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>

	<?php endif; ?>
	<!-- TODO: hacky way of ending row -->
</div>
</main>

<?php get_footer(); ?>
