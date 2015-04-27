
<?php
/*
  Template Name: Explore
 */
?>

<?php get_header(); ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBkuBixKRRJDNY01bNrOoLRW44rdwfsBR8&sensor=false"></script>
<style type="text/css">
    span.full.room-span { margin-left:1px; }
    .room-span {font-size:65%; }
    .room-span label {margin-right:2px; }
</style>

<section id="content" role="main">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <section class="entry-content">
                    <div id="venue-filter">
                        <?php
                        $maxGuestRooms = 0;
                        $minGuestRooms = 0;
                        $minRoomSize = 5000;
                        $maxRoomSize = 0;

                        $regions = (isset($_GET['regions']) && !empty($_GET['regions'])) ? explode(',', urldecode($_GET['regions'])) : array();
                        $amenities = (isset($_GET['amenities']) && !empty($_GET['amenities'])) ? explode(',', urldecode($_GET['amenities'])) : array();
                        $accolades = (isset($_GET['accolades']) && !empty($_GET['accolades'])) ? explode(',', urldecode($_GET['accolades'])) : array();
                        $guestRoomsNeeded = isset($_GET['guest-rooms']) ? $_GET['guest-rooms'] : $maxGuestRooms;
                        $roomSizeNeeded = isset($_GET['room-size']) ? $_GET['room-size'] : $minRoomSize;

                        $args = array('post_type' => 'venues', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC');
                        $venues = get_posts($args);

                        $random_venue = $venues[array_rand($venues)];

                        if ($guestRoomsNeeded == '74') {
                            $minGuestRooms = 0;
                        } else if ($guestRoomsNeeded == '149') {
                            $minGuestRooms = 75;
                        } else if ($guestRoomsNeeded == '224') {
                            $minGuestRooms = 150;
                        } else if ($guestRoomsNeeded == '10000') {
                            $minGuestRooms = 225;
                        } else {
                            $minGuestRooms = 0;
                        }


                        if ($roomSizeNeeded == '5000') {
                            $minRoomSize = 0;
                        } else if ($roomSizeNeeded == '10000') {
                            $minRoomSize = 5000;
                        } else if ($roomSizeNeeded == '25000') {
                            $minRoomSize = 10000;
                        } else if ($roomSizeNeeded == '25001') {
                            $minRoomSize = 25000;
                        } else {
                            $minRoomSize = 0;
                        }
                        ?>

                        <script type="text/javascript">
                            var guestRooms = <?= $guestRoomsNeeded ?>;
                            var roomSize = <?= '' ?>;
                            var maxGuestRooms = <?= $maxGuestRooms ?>;
                            var minGuestRooms = <?= $minGuestRooms ?>;
                            var minRoomSize = <?= $minRoomSize ?>;
                            var maxRoomSize = <?= $maxRoomSize ?>;
                        </script>

                        <form id="venue-filter-form" method="GET" name="venue-filter-form">
                            <div id="amaze">
                                <a href="<?= get_permalink($random_venue->ID) ?>">Recommend an<br />amazing resort for me</a>
                            </div>
                            <div id="region">
                                <label class="filter-title">Where do you want to go?</label>

                                <span class="half">
                                    <input type="checkbox" id="nw" value="northwest" class="region-checkbox" <?php if (in_array('northwest', $regions)) echo 'checked="checked"'; ?>/>
                                    <label for="nw"><span></span>Northwest</label>
                                </span>

                                <span class="half">
                                    <input type="checkbox" id="ne" value="northeast" class="region-checkbox" <?php if (in_array('northeast', $regions)) echo 'checked="checked"'; ?>/>
                                    <label for="ne"><span></span>Northeast</label>
                                </span>

                                <span class="half">
                                    <input type="checkbox" id="sw" value="southwest" class="region-checkbox" <?php if (in_array('southwest', $regions)) echo 'checked="checked"'; ?>/>
                                    <label for="sw"><span></span>Southwest</label>
                                </span>

                                <span class="half">
                                    <input type="checkbox" id="se" value="southeast" class="region-checkbox" <?php if (in_array('southeast', $regions)) echo 'checked="checked"'; ?>/>
                                    <label for="se"><span></span>Southeast</label>
                                </span>


                                <br class="clear"/>
                            </div>
                            <div id="guest-rooms">
                                <label class="filter-title">
                                    Number of peak night rooms?
                                    <!--<input type="text" id="guest-rooms-label" />-->
                                </label>

                                <span class="full room-span custom-radio" id="custom-radio">
                                    <div id="guest-rooms-slider"></div>
                                    <div>
                                        <input type="radio" name="guest-rooms" id="btn-0" class="room-selector radio" value="0" <?php
                                        if ($_GET['guest-rooms'] == '0' || $_GET['guest-rooms'] == '') {
                                            echo 'checked';
                                        }
                                        ?>>
                                        <label for="btn-0">Any</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="guest-rooms" id="btn-0-74" class="room-selector radio" value="74" <?php
                                        if ($_GET['guest-rooms'] == '74') {
                                            echo 'checked';
                                        }
                                        ?>>
                                        <label for="btn-0-74">0-74</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="guest-rooms" id="btn-75-149" class="room-selector radio" value="149" <?php
                                        if ($_GET['guest-rooms'] == '149') {
                                            echo 'checked';
                                        }
                                        ?>>
                                        <label for="btn-75-149">75-149</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="guest-rooms" id="btn-150-224" class="room-selector radio" value="224" <?php
                                        if ($_GET['guest-rooms'] == '224') {
                                            echo 'checked';
                                        }
                                        ?>>
                                        <label for="btn-150-224">150-224</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="guest-rooms" id="btn-225-plus" class="room-selector radio" value="10000" <?php
                                        if ($_GET['guest-rooms'] == '10000') {
                                            echo 'checked';
                                        }
                                        ?>>
                                        <label for="btn-225-plus">225+</label>
                                    </div>
                                    <br class="clear" />
                                </span>
                            </div>
                            <div id="meeting-room-size">
                                <label class="filter-title">
                                    Total meeting space required?
                                </label>
                                <span class="full room-span custom-radio" id="custom-room-size">
                                    <div>
                                        <input type="radio" name="room-size" id="btn-0-5K" class="room-selector radio" value="5000" <?php
                                        if ($_GET['room-size'] == '5000' || $_GET['room-size'] == '') {
                                            echo 'checked';
                                        }
                                        ?>>
                                        <label for="btn-0-5K">0-5K</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="room-size" id="btn-5K-10K" class="room-selector radio" value="10000" <?php
                                        if ($_GET['room-size'] == '10000') {
                                            echo 'checked';
                                        }
                                        ?>>
                                        <label for="btn-5K-10K">5K-10K</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="room-size" id="btn-10K-25K" class="room-selector radio" value="25000" <?php
                                        if ($_GET['room-size'] == '25000') {
                                            echo 'checked';
                                        }
                                        ?>>
                                        <label for="btn-10K-25K">10K-25K</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="room-size" id="btn-25K-plus" class="room-selector radio" value="25001" <?php
                                        if ($_GET['room-size'] == '25001') {
                                            echo 'checked';
                                        }
                                        ?>>
                                        <label for="btn-25K-plus">25K+</label>
                                    </div>
                                    <br class="clear" />
                                </span>
                            </div>

                            <div id="amenities">
                                <label class="filter-title">Property Type</label>
                                <?php
                                $args = array(
                                    'posts_per_page' => -1,
                                    'post_type' => 'amenities',
                                    'post_status' => 'publish',
                                    'orderby' => 'menu_order',
                                    'order' => 'ASC');

                                $allAmenities = get_posts($args);
                                $allAmenitiesIds = array();

                                foreach ($allAmenities as $amenity) {
                                    if (in_array(sanitize_title($amenity->post_title), $amenities))
                                        array_push($allAmenitiesIds, $amenity->ID);
                                    ?>
                                    <span class="half">
                                        <input type="checkbox" class="amenity-checkbox" id="amenity-<?= sanitize_title($amenity->post_title) ?>" value="<?= sanitize_title($amenity->post_title) ?>" <?php if (in_array(sanitize_title($amenity->post_title), $amenities)) echo 'checked="checked"'; ?> />
                                        <label for="amenity-<?= sanitize_title($amenity->post_title) ?>"><span></span><?= $amenity->post_title ?></label>
                                    </span>
                                    <?php
                                }
                                ?>
                                <br class="clear" />
                            </div>

                            <div id="accolades">
                                <label class="filter-title">Accolades</label>
                                <?php
                                $args = array(
                                    'posts_per_page' => -1,
                                    'post_type' => 'accolades',
                                    'post_status' => 'publish',
                                    'orderby' => 'menu_order',
                                    'order' => 'ASC');

                                $allAccolades = get_posts($args);
                                $allAccoladesIds = array();

                                foreach ($allAccolades as $accolade) {
                                    if (in_array(sanitize_title($accolade->post_title), $accolades))
                                        array_push($allAccoladesIds, $accolade->ID);
                                    ?>
                                    <span class="full">
                                        <input type="checkbox" class="accolades-checkbox" id="accolades-<?= sanitize_title($accolade->post_title) ?>" value="<?= sanitize_title($accolade->post_title) ?>" <?php if (in_array(sanitize_title($accolade->post_title), $accolades)) echo 'checked="checked"'; ?> />
                                        <label for="accolades-<?= sanitize_title($accolade->post_title) ?>"><span></span><?= $accolade->post_title ?></label>
                                    </span>
                                    <?php
                                }
                                ?>
                                <br class="clear" />
                            </div>


                            <input type="hidden" id="amenities-combined" name="amenities" value="<?php echo implode(',', $amenities); ?>" />
                            <input type="hidden" id="accolades-combined" name="accolades" />
                            <input type="hidden" id="regions-combined" name="regions" value="<?php echo implode(',', $regions); ?>"/>
                            <input type="submit" value="Show Destinations" />
                        </form>
                    </div>
                    <?php
                    $filteredVenues = array();
                    foreach ($venues as $venue) {
                        $values = get_post_custom($venue->ID);
                        $venueGuestRooms = $values['guest-rooms'][0];
                        $venueMeetingRoomSize = $values['venue-size'][0];
                        $amenitiesArr = explode(',', $values['amenities-string'][0]);
                        $accoladesArr = explode(',', $values['accolades-string'][0]);
                        $regionsArr = explode(',', $values['regions-string'][0]);



                        $regionsMatched = false;

                        if (!empty($regions)) {
                            foreach ($regionsArr as $regionName)
                                if (in_array($regionName, $regions))
                                    $regionsMatched = true;
                        }
                        else {
                            $regionsMatched = true;
                        }



                        $amenitiyMatches = 0;

                        foreach ($amenitiesArr as $amenityId) {
                            if (in_array($amenityId, $allAmenitiesIds))
                                $amenitiyMatches++;
                        }

                        $amenitiesMatched = count($amenities) <= $amenitiyMatches;



                        $accoladesMatches = 0;

                        foreach ($accoladesArr as $accoladeId) {
                            if (in_array($accoladeId, $allAccoladesIds))
                                $accoladesMatches++;
                        }

                        $accoladesMatched = count($accolades) <= $accoladesMatches;

                        $guestRoomsMatch = false;

                        if ($guestRoomsNeeded > 0 && $guestRoomsNeeded < 10000) {

                            if (($venueGuestRooms > $minGuestRooms && $venueGuestRooms < $guestRoomsNeeded)) {
                                $guestRoomsMatch = true;
                            }
                        } else if ($guestRoomsNeeded == 10000) {
                            if (($venueGuestRooms > $minGuestRooms)) {
                                $guestRoomsMatch = true;
                            }
                        } else if ($guestRoomsNeeded == 0) {
                            if (($venueGuestRooms > $guestRoomsNeeded)) {
                                $guestRoomsMatch = true;
                            }
                        }

                        $venueMeetingRoomSizeMatch = false;
                        if ($roomSizeNeeded >= 5000 && $roomSizeNeeded < 25001) {

                            if (($venueMeetingRoomSize > $minRoomSize && $venueMeetingRoomSize < $roomSizeNeeded))
                                $venueMeetingRoomSizeMatch = true;
                        } else if ($roomSizeNeeded >= 25001) {
                            if ($venueMeetingRoomSize > $roomSizeNeeded)
                                $venueMeetingRoomSizeMatch = true;
                        }


                        if ($guestRoomsMatch && $venueMeetingRoomSizeMatch && $amenitiesMatched && $regionsMatched && $accoladesMatched)
                            array_push($filteredVenues, $venue);
                    }
                    ?>
                    <div id="venue-list">
                        <div class="inside">
                            <div class="utility-bar">
                                <strong><?= count($filteredVenues) ?> Destinations Found</strong>
                                <a href="#" class="map-btn">Show Map</a>
                            </div>
                            <div id="map"></div>
                            <?php
                            if (!empty($filteredVenues)) {
                                $perPage = 10;
                                $currentPage = isset($_GET['pg']) ? $_GET['pg'] : 1;
                                $totalPages = ceil(count($filteredVenues) / $perPage);
                                $showingCount = 0;
                                $count = 0;
                                $mapVenues = array();
                                ?>
                                <ul class="results">
                                    <?php
                                    foreach ($filteredVenues as $venue) {

                                        if ($count < ($currentPage - 1) * $perPage) {
                                            $count++;
                                            continue;
                                        } else {
                                            $count++;
                                        }
                                        if ($showingCount >= $perPage)
                                            break;

                                        $values = get_post_custom($venue->ID);
                                        $address = $values['venue-address'][0];
                                        $city = $values['venue-city'][0];
                                        $state = $values['venue-state'][0];
                                        $zip = $values['venue-zip'][0];
                                        $director = $values['venue-director'][0];
                                        $phone = $values['venue-phone'][0];
                                        $email = $values['venue-email'][0];
                                        $website = $values['venue-website'][0];
                                        $venueGuestRooms = $values['guest-rooms'][0];
                                        $venueMeetingRoomSize = $values['venue-size'][0];
                                        $airportName = $values['airport-name'][0];
                                        $airportDistance = $values['airport-distance'][0];
                                        $airportTime = $values['airport-time'][0];
                                        $venueGuestRooms = $values['guest-rooms'][0];
                                        $venueMeetingRooms = $values['venue-rooms'][0];
                                        $venueMeetingRoomSize = $values['venue-size'][0];
                                        $lat = $values['location-lat'][0];
                                        $lng = $values['location-lng'][0];

                                        $mapVenue = array('title' => $venue->post_title,
                                            'location' => $city . ', ' . $state,
                                            'guestRooms' => $venueGuestRooms,
                                            'meetingRooms' => $venueMeetingRooms,
                                            'meetingRoomSize' => $venueMeetingRoomSize,
                                            'airportName' => $airportName,
                                            'airportDistance' => $airportDistance,
                                            'airportTime' => $airportTime,
                                            'lat' => $lat,
                                            'lng' => $lng,
                                            'link' => get_post_permalink($venue->ID),
                                            'img' => get_the_post_thumbnail($venue->ID, 'spotlightsmall')
                                        );
                                        array_push($mapVenues, $mapVenue);
                                        ?>
                                        <li>
                                            <a href="<?= get_post_permalink($venue->ID) ?>"><?= get_the_post_thumbnail($venue->ID, 'venueslisting') ?></a>
                                            <h3><a href="<?= get_post_permalink($venue->ID) ?>"><?= $venue->post_title ?></a></h3>
                                            <em><?= $city ?>, <?= $state ?></em>
                                            <p>
                                                <strong>Guest Rooms</strong>
                                                <br />
                                                <?= $venueGuestRooms ?> guest rooms
                                            </p>
                                            <p>
                                                <strong>Meeting Rooms</strong>
                                                <br />
                                                <?= $venueMeetingRooms ?> meeting rooms
                                                <br />
                                                <?= $venueMeetingRoomSize ?> square feet
                                            </p>
                                            <p>
                                                <strong>Closest Airport</strong><br />
                                                <?= $airportName ?><br />
                                                <?= $airportDistance ?> Miles<br />
                                                <?= $airportTime ?> Minutes
                                            </p>
                                            <a href="<?= get_post_permalink($venue->ID) ?>" class="view-btn">View Details</a>
                                            <br class="clear" />
                                        </li>
                                        <?php
                                        $showingCount++;
                                    }
                                    ?>
                                </ul>
                                <?php
                                $addArgs = array('guest-rooms' => $guestRoomsNeeded,
                                    'room-size' => $roomSizeNeeded,
                                    'amenities' => implode(',', $amenities),
                                    'regions' => implode(',', $regions));

                                $args = array(
                                    'base' => '%_%',
                                    'format' => '?pg=%#%',
                                    'total' => $totalPages,
                                    'current' => $currentPage,
                                    'show_all' => false,
                                    'end_size' => 5,
                                    'mid_size' => 5,
                                    'prev_next' => true,
                                    'prev_text' => '',
                                    'next_text' => '',
                                    'type' => 'list',
                                    'add_args' => $addArgs
                                );
                                ?>
                                <div class="paging">
                                    <?= paginate_links($args) ?>
                                </div>
                                <?php
                            }
                            else {
                                echo '<p class="no-results">Sorry, there are no results that match your filter settings.<br />Try making your search less specific for more results.</p>';
                            }
                            ?>

                            <script type="text/javascript">
                                var mapVenues = <?php echo json_encode((isset($mapVenues) ? $mapVenues : array())); ?>;
                            </script>
                        </div>
                    </div>
                    <br class="clear" />
                </section>
            </article>
            <?php
        endwhile;
    endif;
    ?>

</section>

<?php get_footer(); ?>

