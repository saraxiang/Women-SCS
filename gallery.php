<?php /* Template Name: Photo Gallery */ ?>
<head><title>Women@SCS Photos</title></head>
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
        <p class="wscs-info hide-on-small-screens"> The Women@SCS mission is to create, encourage, and support academic, social, and professional opportunities for women in computer science and to promote the breadth of the field and its diverse community. </p>
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
              $date = date_create($dateString);
              $formattedDate = date_format($date,"m/d/y");
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
  <div class="wscs-page-content">
    <?php $first = true; ?>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      
      <div class="page-title "><b><?php the_title() ?> Photo Gallery</b></div>
      <?php the_content() ?>
      
    <?php endwhile; else : ?>

      <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>

    <?php endif; ?>
  </div>


</main>

<?php get_footer(); ?>

