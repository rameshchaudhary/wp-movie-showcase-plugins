<?php
/************************shortcode to display property listing****************************/

add_shortcode('offshore_property', function($attr){
    $loop=new WP_Query(
        array(
            'post_type' => 'ob_property',
            'orderby'  => 'date',
            'posts_per_page' => $attr['list']
        )

    );

    if($loop->have_posts()){

        while($loop->have_posts()){
            $loop->the_post();
            $meta=get_post_meta(get_the_id(),'');
            $output.='
                <div>
					'.get_the_term_list(get_the_id(), 'additional_features', '<div class="entry-meta"><span class="tag-links">', ', ', '</span></div>' ).'
                    '.get_the_post_thumbnail().' <br/>
					'.get_the_term_list(get_the_id(), 'property_type', '<div class="entry-meta"><span class="cat-links">', ', ', '</span></div>' ).'
                    <a href="' .get_permalink(). '"><h1>'.
						get_the_title().
                    '</h1></a><br/><div>'.
					get_the_term_list(get_the_id(), 'location', '<div class="entry-meta"><span>Location: ', ', ', '</span></div>' ).
					get_the_excerpt('>> Read More').'<br/>'.
					'Price: $'.$meta[ob_price][0].'<br/>'.
					'Bathroom: '.$meta[ob_bathrooms][0].'<br/>'.
					'Bedroom: '.$meta[ob_bedrooms][0].'<br/>'.
 				'</div><br/><hr/><br/>
            ';
        }
    }
    return $output;
});


/************************shortcode to display property details****************************/

add_shortcode('offshore_property_details', function(){

    $postid=get_the_id();
	$custom_fields = get_post_custom($postid);
    $custom_field_keys = get_post_custom_keys();
    foreach ( $custom_field_keys as $key => $value ) {
        $valuet = trim($value);
        if ( '_' == $valuet{0} )
            continue;
        $my_custom_field = $custom_fields[$valuet];
        switch($valuet)
		{
			case("ob_price"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_price = $value;
			}
			break;
			case("ob_lat"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_lat = $value;
        	}
			break;
			case("ob_long"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_long = $value;
        	}
			break;
			case("ob_rent_sale"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_rent_sale = $value;
        	}
			break;
			case("ob_floor"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_floor = $value;
        	}
			break;
			case("ob_material"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_material = $value;
        	}
			break;
			case("ob_bedrooms"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_bedrooms = $value;
        	}
			break;
			case("ob_bathrooms"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_bathrooms = $value;
        	}
			break;
			case("ob_plot_size"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_plot_size = $value;
        	}
			break;
			case("ob_living_area"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_living_area = $value;
        	}
			break;
			case("ob_terrace"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_terrace = $value;
        	}
			break;
			case("ob_parking"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_parking = $value;
        	}
			break;
			case("ob_built_in_year"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_built_in_year = $value;
			}
			break;
			case("ob_expire"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_expire = $value;
        	}
			break;
			case("ob_condition_essential_repair_done"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_condition_essential_repair_done = $value;
        	}
			break;
			case("ob_condition_foundation"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_condition_foundation = $value;
        	}
			break;
			case("ob_condition_framework"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_condition_framework = $value;
        	}
			break;
			case("ob_condition_need_complete_renewal"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_condition_need_complete_renewal = $value;
        	}
			break;
			case("ob_condition_need_decoration"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_condition_need_decoration = $value;
        	}
			break;
			case("ob_condition_new_building"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_condition_new_building = $value;
        	}
			break;
			case("ob_condition_newly_decorated"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_condition_newly_decorated = $value;
        	}
			break;
			case("ob_condition_ready"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_condition_ready = $value;
        	}
			break;
			case("ob_condition_renovated"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_condition_renovated = $value;
        	}
			break;
			case("ob_condition_under_construction"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_condition_under_construction = $value;
        	}
			break;
			case("ob_condition_new_building"):
			foreach ( $my_custom_field as $key => $value ) {
				$ob_condition_new_building = $value;
        	}
			break;
		}

    }

	if(isset($ob_price) && $ob_price != NULL)
	{
		echo '<div class="sth">Price: '.$ob_price.'</div>';
	}
	if(isset($ob_rent_sale) && $ob_rent_sale != NULL)
	{
		echo '<div class="sth">For: '.$ob_rent_sale.'</div>';
	}
	echo get_the_term_list(get_the_id(), 'location', '<div class="sss"><span class="ssss">', ', ', '</span></div>');
	if(isset($ob_lat) && $ob_lat != NULL && isset($ob_long) &&$ob_long != NULL)
	{
		?>
        <iframe style="width:100%; height:350px;" src="https://maps.google.com/maps?q=<?php echo $ob_lat.",".$ob_long; ?>&z=15&amp;output=embed"></iframe>
        <?php
	}
	//taxonomies
	/*
	echo "ADDITIONAL FEATURES:";
	wp_tag_cloud( array( 'taxonomy' => 'additional_features') );
	echo "<br/>";
	echo "PROPERTY TYPE: ";
	wp_tag_cloud( array( 'taxonomy' => 'property_type') );
	echo "<br/>";
	echo "LOCATION: ";
	wp_tag_cloud( array( 'taxonomy' => 'location') );
	echo "<br/>";
	*/
	?>
    <div>
    <?php
	echo get_the_term_list(get_the_id(), 'additional_features', '<div class="entry-meta"><span class="tag-links">', ', ', '</span></div>' );
	echo get_the_term_list(get_the_id(), 'property_type', '<div class="sss><span class="ssss">', ', ', '</span></div>');
	?>
`	</div>
	<!--- for the attached property images -->
	<?php $attachments = new Attachments( 'attachments' ); /* pass the instance name */ ?>
	<?php if( $attachments->exist() ) : ?>
	  <h3>Attachments</h3>
	  <p>Total Attachments: <?php echo $attachments->total(); ?></p>
	  <ul>
		<?php while( $attachments->get() ) : ?>
		  <li>
			ID: <?php echo $attachments->id(); ?><br />
			Type: <?php echo $attachments->type(); ?><br />
			Subtype: <?php echo $attachments->subtype(); ?><br />
			URL: <?php echo $attachments->url(); ?><br />
			Image: <?php echo $attachments->image( 'thumbnail' ); ?><br />
			Source: <?php echo $attachments->src( 'full' ); ?><br />
			Size: <?php echo $attachments->filesize(); ?><br />
			Title Field: <?php echo $attachments->field( 'title' ); ?><br />
			Caption Field: <?php echo $attachments->field( 'caption' ); ?>
		  </li>
		<?php endwhile; ?>
	  </ul>
	<?php endif; ?>
	<!--- /for the attached property images -->
<?php
});


/************************shortcode to search property****************************/

add_shortcode('offshore_property_search', function(){
//fetching taxonomies
//fetching property_type
$categories1 = get_categories('taxonomy=property_type');

$select1 = "<select name='ptype' id='ptype'>";
$select1.= "<option value='0'>Property Type</option>";

foreach($categories1 as $category1){
	if($category1->count > 0){
		$select1.= "<option value='".$category1->slug."'>".$category1->name."</option>";
	}
}
$select1.= "</select>";
//fetching location
$categories2 = get_categories('taxonomy=location');

$select2 = "<select name='plocation' id='plocation'>";
$select2.= "<option value='0'>Location</option>";

foreach($categories2 as $category2){
	if($category2->count > 0){
		$select2.= "<option value='".$category2->slug."'>".$category2->name."</option>";
	}
}
$select2.= "</select>";

//fetching additional features
$categories3 = get_categories('taxonomy=additional_features');

$select3 = "";

foreach($categories3 as $category3){
	if($category3->count > 0){
		$select3.= "<input type='checkbox' name='add_feature[]' value='".$category3->slug."'/>  ".$category3->name."&nbsp;&nbsp;&nbsp;&nbsp;";
	}
}
////fetching taxonomies end '.get_template_directory_uri().'/search   		<input type="text" name="list_id"><br/>'

?>
<section class="container">

	<div class="row">

		<div class="col-lg-12">

		

			<div class="offshore_estatesearch box-shadow">

				<div class="offshore_forms_wrapper">


<?php
//fetching the ob options for units
$op = get_option('ob_properties_settings'); 
//fetching taxonomies
//fetching property_type
$categories1 = get_categories('taxonomy=property_type');

$select1 = "<select name='ptype' id='ptype' data-placeholder='Select a Property Type' class='chosen-select-nosearch  form-control'>";
$select1.= "<option></option>";

foreach($categories1 as $category1){
	if($category1->count > 0){
		$select1.= "<option value='".$category1->slug."'>".$category1->name."</option>";
	}
}
$select1.= "</select>";
//fetching location
$categories2 = get_categories('taxonomy=location');

$select2 = "<select name='plocation' id='plocation' data-placeholder='Select a Location' multiple='multiple' class='chosen-select-no-results form-control'>";
$select2.= "<option value='0'></option>";

foreach($categories2 as $category2){
	if($category2->count > 0){
		$select2.= "<option value='".$category2->slug."'>".$category2->name."</option>";
	}
}
$select2.= "</select>";

//fetching additional features
$categories3 = get_categories('taxonomy=additional_features');

$select3 = "<select name='add_feature[]' id='add_feature' data-placeholder='Select Additional Features' multiple='multiple' class='chosen-select-no-results form-control'>";
$select3.= "<option value='0'></option>";
foreach($categories3 as $category3){
	if($category3->count > 0){
		$select3.= "<option value='".$category3->slug."'>".$category3->name."</option>";
	}
}
$select3.= "</select>";
?>
				

					<!-- Start Search Form -->
					<form action="<?php echo home_url(); ?>" name="properties" method="post">

						<div class="offshore_searchform_row">

							<!-- Search Form - First Row -->

							<div class="offshore_propertytype pull-left rightmargin">

								<p>Property Type</p>

								<?php echo $select1; ?>			
							
                            </div>



							<div class="offshore_propertylocation pull-left rightmargin">

								<p>Property Location:</p>

								<?php echo $select2; ?>
                                	
							</div>

							

							<div class="offshore_pricerange form-inline pull-left">

								<p>Price Range in
								<?php
								if(!empty($op['ob_currency']))
								{
									if($op['ob_currency'] == "Dollar")
										echo "Dollar(&#36;)"; 
									if($op['ob_currency'] == "Pound")
										echo "Pound(&pound;)"; 
									if($op['ob_currency'] == "Yen")
										echo "Yen(&yen;)"; 
									if($op['ob_currency'] == "Euro")
										echo "Euro(&euro;)"; 

								}
								else
									echo "Dollar($)"; 
								?>
                                </p>

								<div class="form-group rightmargin">

									<input type="text" placeholder="Min" class="form-control" name="price_min">

								</div>

								<div class="form-group">

									<input type="text" placeholder="Max" class="form-control" name="price_max">

								</div>

							</div>					

							<!-- //Search Form - First Row -->

						</div><!-- .offshore_searchform_row-->



						<div class="offshore_searchform_row">

							<!-- Search Form - Second Row -->

							<div class="offshore_transactiontype pull-left rightmargin">

								<p>Transaction Type:</p>

								<select data-placeholder="For Sale or Rent" multiple class="chosen-select-no-results form-control" name="status">

									<option value="0"></option>

									<option>For Rent</option>

									<option>For Sale</option>

								</select>

							</div>

							

							<div class="offshore_rooms pull-left rightmargin">

								<p style="width:150px; float:left;">Bedrooms</p>
								<p style="width:130px; float:left;">Bathrooms</p>
								<div class="form-inline">

									<div class="form-group rightmargin">

                                        <select data-placeholder="Bedrooms" name="bedrooms" id="bedrooms" class="form-control" style="width:133px;">
                                            <option value="0"></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>

									</div>

									<div class="form-group">

                                        <select data-placeholder="Bathrooms" name="bathrooms" id="bathrooms" class="form-control" style="width:133px;">
                                            <option value="0"></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>

									</div>

								</div>					

							</div>

							

							<div class="offshore_psize pull-left">

								<p>Size/Area  
								<?php
								if(!empty($op['ob_area']))
								{
									if($op['ob_area'] == "sq_meter")
										echo "( m&sup2; )"; 

									if($op['ob_area'] == "sq_kilometer")
										echo "( km&sup2; )"; 

									if($op['ob_area'] == "sq_feet")
										echo "( ft&sup2;) "; 

									if($op['ob_area'] == "sq_yard")
										echo "( yd&sup2; )"; 

									if($op['ob_area'] == "sq_mile")
										echo "( mi&sup2; )"; 
								}
								else
									echo "( m&sup2; )"; 
								?>
                                </p>

								<div class="form-inline pull-left">

									<div class="form-group rightmargin">

										<input type="text" placeholder="Min" class="form-control" name="area_min">

									</div>

									<div class="form-group">

										<input type="text" placeholder="Max" class="form-control" name="area_max">

									</div>

								</div>

							</div>



							<button class="btn btn-primary pull-left" type="submit" name="submit"><i class="glyphicon glyphicon-search"></i> Search</button>

							

							<!-- //Search Form - Second Row -->

						</div>

						



							<div class="offshore_searchform_row additional_features">

								<div class="offshore_pcondition pull-left rightmargin">

									<p>Condition</p>

									<select data-placeholder="Condition of Property" multiple class="chosen-select-no-results form-control" name="condition[]">

										<option value="0"></option>

										<option value="ob_condition_essential_repair_done">Essential Repair Done</option>

										<option value="ob_condition_foundation">Foundation</option>

										<option value="ob_condition_framework">Framework</option>

										<option value="ob_condition_need_complete_renewal">Need Complete Renewal</option>

										<option value="ob_condition_need_decoration">Needs Decoration</option>

										<option value="ob_condition_new_building">New Building</option>

										<option value="ob_condition_newly_decorated">Newly Decorated</option>

										<option value="ob_condition_ready">Ready</option>

										<option value="ob_condition_renovated">Renovated</option>

										<option value="ob_condition_under_construction">Under Construction</option>

									</select>

								</div>	



								<div class="offshore_pmaterial pull-left rightmargin">

									<p>House Material</p>

									<select data-placeholder="House Material" multiple class="chosen-select-no-results form-control" name="material[]">

										<option value="0"></option>

										<option value="Brick">Brick</option>

										<option value="Log">Log</option>

										<option value="Log Stone">Log Stone</option>

										<option value="Monolith">Monolith</option>

										<option value="Panel">Panel</option>

										<option value="Stone">Stone</option>

										<option value="Wooden">Wooden</option>

									</select>

								</div>



								<div class="offshore_pfeatures pull-left">

									<p>Additional Features:</p>

									<?php echo $select3; ?>

								</div>

							</div>



						<div class="clearfix"></div>

					<?php //do_shortcode('[offshore_property_search]'); ?>
					<!-- End Search Form -->

					

				

					<div class="additional_features offshore_wpsearch">

					<div class="offshore_searchbykey fadein">
						<fieldset>

							<input type="text" placeholder="Search by keyword or Property ID" class="form-control pull-left" name="search_word">

							<button class="btn btn-primary pull-right" type="submit" name="submit"><i class="glyphicon glyphicon-search"></i> Search</button>

						</fieldset>
					</div>
					</form>

					<?php //do_shortcode('[offshore_property_search]'); ?>

					</div>

				

				</div>

				<p class="text-right">

					<span class="trigger_moreoptions"><i class="fa fa-chevron-circle-down"></i> <span class="advancedform">Advanced Search</span></span>

					<span class="trigger_lessoptions"><i class="fa fa-chevron-circle-up"></i> <span class="advancedform">Basic Search</span></span>

				</p>

			</div>

			

		</div>

	</div>

</section>
<?php
	if(isset($_GET['submit']))
	{
		$args = array();
		$args['post_type'] = "ob_property";

		//getting form data
		if(!empty($_GET['search_word']))
		{
			$args['s'] = $_GET['search_word'];
		}
		if(isset($_GET['ptype']) && $_GET['ptype'] != '0')
		{
			$args['property_type'] = $_GET['ptype'];
		}
		if(isset($_GET['plocation']) && $_GET['plocation'] != '0')
		{
			$args['location'] = $_GET['plocation'];
		}
		if(isset($_GET['order_by']) && $_GET['order_by'] != '0')
		{
			if($_GET['order_by'] == 'date' || $_GET['order_by'] == 'title')
			{
				$args['orderby'] = $_GET['order_by'];
			}
			if($_GET['order_by'] == 'price')
			{
				$args['meta_key'] = "ob_price";
				$args['orderby'] = "meta_value_num";
			}
		}
		else
		{
			$args['orderby'] = "title";
		}
		if(isset($_GET['order_in']) && $_GET['order_in'] != '0')
		{
			$args['order'] = $_GET['order_in'];
		}
		else
		{
			$args['order'] = "ASC";
		}
		if(isset($_GET['price_min']) || isset($_GET['price_max']) || isset($_GET['status']) || isset($_GET['bedrooms']) || isset($_GET['bathrooms']))
		{
			$args['meta_query']['relation'] = "AND";
			//checking price range
			if(isset($_GET['price_min']) || isset($_GET['price_max']))
			{
				if(empty($_GET['price_min']))
					$price_min = 10;
				else
					$price_min = $_GET['price_min'];
				if(empty($_GET['price_max']))
					$price_max = 99999999999999;
				else
					$price_max = $_GET['price_max'];
					
				$args['meta_query'][] = array(
                    'key' => 'ob_price',
                    'value' => array($price_min, $price_max),
                    'compare' => 'BETWEEN',
                    'type' => 'numeric'
					);
			}
			if(isset($_GET['status']) && $_GET['status'] != "0")
			{
				$args['meta_query'][] = array(
                    'key' => 'ob_rent_sale',
                    'value' => $_GET['status'],
                    'compare' => '='
					);
			}
			if(isset($_GET['bedrooms']) && $_GET['bedrooms'] != "0")
			{
				$args['meta_query'][] = array(
                    'key' => 'ob_bedrooms',
                    'value' => $_GET['bedrooms'],
                    'compare' => '='
					);
			}
			if(isset($_GET['bathrooms']) && $_GET['bathrooms'] != "0")
			{
				$args['meta_query'][] = array(
                    'key' => 'ob_bathrooms',
                    'value' => $_GET['bathrooms'],
                    'compare' => '='
					);
			}
			
		}
		if(isset($_GET['add_feature']))
		{
			$add_feature = $_GET['add_feature'];
			$args['tax_query']['relation'] = 'AND';
			$args['tax_query'][] =	array(
				'taxonomy' => 'additional_features',
				'field' => 'slug',
				'terms' => array(),
				'operator' => 'AND'
			);
				
			foreach($add_feature as $feature)
			{
				$args['tax_query'][0]['terms'][] = $feature;
			}
		}
		//echo '<pre>', print_r($args,true), '</pre>';
		$loop2 = new WP_Query( $args );
	
		if($loop2->have_posts()){
	
			while($loop2->have_posts()){
				$loop2->the_post();
				$meta2=get_post_meta(get_the_id(),'');
				$output2.='
					<div>
						'.get_the_term_list(get_the_id(), 'additional_features', '<div class="entry-meta"><span class="tag-links">', ', ', '</span></div>' ).'
						'.get_the_post_thumbnail().' <br/>
						'.get_the_term_list(get_the_id(), 'property_type', '<div class="entry-meta"><span class="cat-links">', ', ', '</span></div>' ).'
						<a href="' .get_permalink(). '"><h1>'.
							get_the_title().
						'</h1></a><br/><div>'.
						get_the_term_list(get_the_id(), 'location', '<div class="entry-meta"><span>Location: ', ', ', '</span></div>' ).
						get_the_excerpt('>> Read More').'<br/>'.
						'Price: $'.$meta2[ob_price][0].'<br/>'.
						'Bathroom: '.$meta2[ob_bathrooms][0].'<br/>'.
						'Bedroom: '.$meta2[ob_bedrooms][0].'<br/>'.
					'</div><br/><hr/><br/>
				';
			}
			return $output2;
		}
		else
			return "NO RESULT FOR YOUR SEARCH";

	}
});

/************************shortcode to display properties in a map****************************/

add_shortcode('offshore_property_map', function($attr){
?>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyD6ASoG5706WgEDAIK1-YerHrqZL_4n1MM&sensor=false"></script>
<script>
var myCenter=new google.maps.LatLng(0,0);

function initialize()
{
var mapProp = {
  center:myCenter,
  zoom:1,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
var lastOpen = null;
<?php
    $loop4=new WP_Query(
        array(
            'post_type' => 'ob_property',
			
        )

    );
	$count = 1;
    if($loop4->have_posts()){
        while($loop4->have_posts()){
            $loop4->the_post();
            $meta4=get_post_meta(get_the_id(),'');
			if(!empty($meta4[ob_lat][0]) && !empty($meta4[ob_long][0]))
			{
?>

				var myCenter<?php echo $count; ?>=new google.maps.LatLng(<?php echo $meta4[ob_lat][0].",".$meta4[ob_long][0]; ?>);
				var marker<?php echo $count; ?>=new google.maps.Marker({
				  position:myCenter<?php echo $count; ?>,
				  //icon:'<?php //get_the_post_thumbnail(); ?>'
				  });
				marker<?php echo $count; ?>.setMap(map);
				
				var infowindow<?php echo $count; ?> = new google.maps.InfoWindow({
					content: '<div style="width:200px; height:200px;"><?php echo get_the_post_thumbnail(get_the_id(), array(200,150)); ?><br/><?php echo get_the_title()."  $".$meta4[ob_price][0];  ?></div>'
				});
				
				google.maps.event.addListener(marker<?php echo $count; ?>,'mouseover',function() {
					if (lastOpen!=null)
						lastOpen.close();
					infowindow<?php echo $count; ?>.open(map, marker<?php echo $count; ?>);
					lastOpen = infowindow<?php echo $count; ?>;
				});				  

<?php
			}
	$count++;
		}
	}
	
?>
}
google.maps.event.addDomListener(window, 'load', initialize);

</script>
    <!-- /the mapping script google -->
<div id="googleMap" style="width:100%;height:500px; "></div>

<?php
});
?>


<?php
add_shortcode('offshore_property_search_form', function($attr){

//fetching the ob options for units

$op = get_option('ob_properties_settings'); 



//fetching taxonomies

//fetching property_type

$categories1 = get_categories('taxonomy=property_type');



$propertytpe_placeholder = __( 'Select a Property Type', 'offshore' );

$select1 = "<select name='ptype' id='ptype' data-placeholder='$propertytpe_placeholder' class='chosen-select-nosearch form-control'>";

$select1.= "<option></option>";



foreach($categories1 as $category1){

	if($category1->count > 0){

		$select1.= "<option value='".$category1->slug."'>".$category1->name."</option>";

	}

}

$select1.= "</select>";



//fetching location

$categories2 = get_categories('taxonomy=location');



$location_placeholder = __( 'Select a location', 'offshore' );

$select2 = "<select name='plocation' id='plocation' data-placeholder='$location_placeholder' multiple='multiple' class='chosen-select-no-results form-control'>";

$select2.= "<option value='0'></option>";



foreach($categories2 as $category2){

	if($category2->count > 0){

		$select2.= "<option value='".$category2->slug."'>".$category2->name."</option>";

	}

}

$select2.= "</select>";



//fetching additional features

$categories3 = get_categories('taxonomy=additional_features');



$features_placeholder = __( 'Select Additional Features', 'offshore' );

$select3 = "<select name='add_feature[]' id='add_feature' data-placeholder='$features_placeholder' multiple='multiple' class='chosen-select-no-results form-control'>";

$select3.= "<option value='0'></option>";

foreach($categories3 as $category3){

	if($category3->count > 0){

		$select3.= "<option value='".$category3->slug."'>".$category3->name."</option>";

	}

}

$select3.= "</select>";

?>

				



					<!-- Start Search Form -->

					<form id="ob_search" action="?page_id=196" name="properties" method="POST">



						<div class="offshore_searchform_row">



							<!-- Search Form - First Row -->



							<div class="offshore_propertytype pull-left rightmargin">



								<p>Property Type</p>



								<?php echo $select1; ?>			

							

                            </div>







							<div class="offshore_propertylocation pull-left rightmargin">



								<p>Property Location:</p>



								<?php echo $select2; ?>

                                	

							</div>



							



							<div class="offshore_pricerange form-inline pull-left">



								<p>Price Range in

								<?php

								if(!empty($op['ob_currency']))

								{

									if($op['ob_currency'] == "Dollar")

										echo "Dollar(&#36;)"; 

									if($op['ob_currency'] == "Pound")

										echo "Pound(&pound;)"; 

									if($op['ob_currency'] == "Yen")

										echo "Yen(&yen;)"; 

									if($op['ob_currency'] == "Euro")

										echo "Euro(&euro;)"; 



								}

								else

									echo "Dollar($)"; 

								?>

                                </p>



								<div class="form-group rightmargin">



									<input type="text" placeholder="Min" class="form-control" name="price_min">



								</div>



								<div class="form-group">



									<input type="text" placeholder="Max" class="form-control" name="price_max">



								</div>



							</div>					



							<!-- //Search Form - First Row -->



						</div><!-- .offshore_searchform_row-->







						<div class="offshore_searchform_row">



							<!-- Search Form - Second Row -->



							<div class="offshore_transactiontype pull-left rightmargin">



								<p>Transaction Type:</p>



								<select data-placeholder="For Sale or Rent" multiple class="chosen-select-no-results form-control" name="status">



									<option value="0"></option>



									<option>For Rent</option>



									<option>For Sale</option>



								</select>



							</div>

							

							<div class="offshore_rooms pull-left rightmargin">

								<p>Rooms:</p>

								<?php /* Mehmet, changed the form below from selectbox to multiselect */ ?>

								<select data-placeholder="Number of Rooms" multiple class="chosen-select-no-results form-control" name="bedrooms">

									<option value="0"></option>

									<option value="1">1</option>

									<option value="2">2</option>

									<option value="3">3</option>

									<option value="4">4</option>

									<option value="5">5</option>

									<option value="6">6</option>

									<option value="7">7</option>

									<option value="8">8</option>

									<option value="9">9</option>

									<option value="10">10</option>

								</select>

								<?php /* //Mehmet */ ?>

							</div>	



							<div class="offshore_bathrooms pull-left rightmargin">

								<p>Bathrooms:</p>

								<?php /* Mehmet, changed the form below from select to input field */ ?>

								<input type="text" placeholder="Number of Baths" class="form-control" name="bathrooms">

								<?php /* //Mehmet */ ?>

							</div>								



							

							



							<div class="offshore_psize pull-left">



								<p>Size/Area  

								<?php

								if(!empty($op['ob_area']))

								{

									if($op['ob_area'] == "sq_meter")

										echo "( m&sup2; )"; 



									if($op['ob_area'] == "sq_kilometer")

										echo "( km&sup2; )"; 



									if($op['ob_area'] == "sq_feet")

										echo "( ft&sup2;) "; 



									if($op['ob_area'] == "sq_yard")

										echo "( yd&sup2; )"; 



									if($op['ob_area'] == "sq_mile")

										echo "( mi&sup2; )"; 

								}

								else

									echo "( m&sup2; )"; 

								?>

                                </p>



								<div class="form-inline pull-left">



									<div class="form-group rightmargin">



										<input type="text" placeholder="Min" class="form-control" name="area_min">



									</div>



									<div class="form-group">



										<input type="text" placeholder="Max" class="form-control" name="area_max">



									</div>



								</div>



							</div>







							<button class="btn btn-primary pull-left" type="submit" name="submit"><i class="glyphicon glyphicon-search"></i> Search</button>



							



							<!-- //Search Form - Second Row -->



						</div>



						







							<div class="offshore_searchform_row additional_features">



								<div class="offshore_pcondition pull-left rightmargin">



									<p>Condition</p>



									<select data-placeholder="Condition of Property" multiple class="chosen-select-no-results form-control" name="condition[]">



										<option value="0"></option>



										<option value="ob_condition_essential_repair_done">Essential Repair Done</option>



										<option value="ob_condition_foundation">Foundation</option>



										<option value="ob_condition_framework">Framework</option>



										<option value="ob_condition_need_complete_renewal">Need Complete Renewal</option>



										<option value="ob_condition_need_decoration">Needs Decoration</option>



										<option value="ob_condition_new_building">New Building</option>



										<option value="ob_condition_newly_decorated">Newly Decorated</option>



										<option value="ob_condition_ready">Ready</option>



										<option value="ob_condition_renovated">Renovated</option>



										<option value="ob_condition_under_construction">Under Construction</option>



									</select>



								</div>	







								<div class="offshore_pmaterial pull-left rightmargin">



									<p>House Material</p>



									<select data-placeholder="House Material" multiple class="chosen-select-no-results form-control" name="material[]">



										<option value="0"></option>



										<option value="Brick">Brick</option>



										<option value="Log">Log</option>



										<option value="Log Stone">Log Stone</option>



										<option value="Monolith">Monolith</option>



										<option value="Panel">Panel</option>



										<option value="Stone">Stone</option>



										<option value="Wooden">Wooden</option>



									</select>



								</div>







								<div class="offshore_pfeatures pull-left">



									<p>Additional Features:</p>



									<?php echo $select3; ?>



								</div>



							</div>







						<div class="clearfix"></div>

  <script type="text/javascript">



    var config = {



      '.chosen-select'           : {},



      '.chosen-select-deselect'  : {allow_single_deselect:true},



      '.chosen-select-no-single' : {disable_search_threshold:10},



      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},



      '.chosen-select-width'     : {width:"95%"}



    }



    for (var selector in config) {



      $(selector).chosen(config[selector]);



	  $(".chosen-select-nosearch").chosen({disable_search_threshold: 10});



    }



  </script>

					<!-- End Search Form -->

<?php
});
?>
