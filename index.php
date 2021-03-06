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
	        	
            usort($json["items"], function($a, $b) { //Sort the array using a user defined function
              $dateStringA = $a["start"]["date"] ? $a["start"]["date"] : $a["start"]["dateTime"];
              $dateStringB = $b["start"]["date"] ? $b["start"]["date"] : $b["start"]["dateTime"];
              $currSeconds = strtotime(time());
              return strtotime($dateStringA) - $currSeconds < strtotime($dateStringB) - $currSeconds ? -1 : 1; //Compare the scores
            });

            // var_dump($json["items"]);
            foreach ($json["items"] as $event) {
	        		$dateString = $event["start"]["date"] ? $event["start"]["date"] : $event["start"]["dateTime"];
	        		$date = date_create($dateString);
	        		$formattedDate = date_format($date,"l, M j");
	        		echo
	        			'<div class="event">
	        				<div class="info">' . $formattedDate . '</div>
	        				<div class="name"><b>' . $event["summary"] . '</b></div>
	        				<div class="info">' . $event["location"] . '</div>
	        			</div>';
	        	}
	        ?>
      </div>
      <!-- end upcoming events info -->

    </div>


	<div class="col s12 section-divider"></div>

  <?php
    $postctr = 0;
    global $more;
  ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php if ( $postctr === 0 ): ?>
			<div class="row news-section">
		    	<div class="label"> <h2>News</h2> </div>
		      	<div class="col s12 post">
			        <!-- TODO: deal with how much content is outputted here, and making sure it's centered; problem is need vertical-align: top to keep news div in line with image div -->
			        <!--div class="image feature"></div-->
              <?php
                if ( has_post_thumbnail() ) {
                  the_post_thumbnail(
                    'post-thumbnail', ['class' => 'image feature', 'title' => 'Feature Post Thumbnail']);
                }
                else {
                    echo '<img class="image feature" src="' . get_bloginfo( 'stylesheet_directory' )
                        . '/img/feature.jpeg" />';
                }
              ?>
		        	<div class="news feature">
                <div class="content feature">
                  <h3><?php the_title() ?></h3>
                  <h4>by women@scs</h4>
                  <p class="description">
                    <?php
                      $more = 0;
                      the_content();
                    ?>
                  </p>
		         		</div>
		        	</div>
		      	</div>
		    </div>
		    <!-- TODO: hacky way of starting next row -->
		    <div class="row news-section">
			<?php $postctr = $postctr + 1; ?>
	    <?php elseif ($postctr < 4): ?>
		    <div class="col s12 l4 post">
          <?php
              echo sprintf(
                '<a class="post-link" href="%s">', esc_url(get_permalink()));
              if ( has_post_thumbnail() ) {
                  the_post_thumbnail();
              }
              else {
                  echo '<img class="image" src="' . get_bloginfo( 'stylesheet_directory' )
                      . '/img/feature.jpeg" />';
              }
              echo sprintf(
                '<div class="news">
                    <div class="content">
                        <h5>%s</h5>
                        <h6>by women@scs</h6>
                      </div>
                  </div>
                  </a>', the_title('','',false));
              $postctr = $postctr + 1;
           ?>
		    </div>
	    <?php endif; ?>
	<?php endwhile; else : ?>

		<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>

	<?php endif; ?>
	<!-- TODO: hacky way of ending row -->
</div>
</main>

<?php get_footer(); ?>
