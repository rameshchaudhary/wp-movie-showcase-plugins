<?php
/*
Plugin Name: Offshore Bees Movie Database
Plugin URI: www.offshorebees.com
Description: Movie Database plugin
Author: Offshore Bees
Author URI: www.offshorebees.com
Version: 0.1
*/
?>
<?php
	class ob_Post_Type 
{ 

	public function __construct()
	{
		$this->register_post_type();
		$this->metaboxes();
	}
	
	public function register_post_type()
	{
		$args = array(
			'labels' => array(
				'name' => 'Movies',
				'singular_name' => 'Movie',
				'add_new' => 'Add new Movie',
				'add_new_item' => 'Add new Movie',
				'edit_item' => 'Edit Movie',
				'new_item' => 'Add new Movie',
				'view_item' => 'View Movie',
				'search_items' => 'Search Movies',
				'not_found' => 'No Movies Found',
				'not_found_in_trash' => 'No Movies found in Trash'
			),
			'query_var' => 'Movies',
			'rewrite' => array(
				'slug' => 'movies/'
				),
			/*'capability_type' => 'attachment',*/	
			'public' => true,
			//'menu_position' => 5, 
			'supports' => array('title', 'thumbnail'),
			'has_archive' => true,
			'menu_icon' => plugins_url( 'ob_movie.png' , __FILE__ )
		);
		register_post_type('ob_movie', $args);
	}
	

	public function metaboxes()
	{
		add_action( 'add_meta_boxes', 'offshore_meta_box_add' );
		function offshore_meta_box_add()
		{
			//css id, title, cb function, page, priority, cb function arguments
			add_meta_box( '', 'Movie Custom Fields', 'offshore_meta_box', 'ob_movie', 'normal', 'high' );
		}

		/* Create Post and Page Custom Fields */
		function offshore_meta_box( $post )
		{
			$values = get_post_custom( $post->ID );
			$idMovie = isset( $values['idMovie'] ) ? esc_attr( $values['idMovie'][0] ) : '';
			$trailer = isset( $values['trailer'] ) ? esc_attr( $values['trailer'][0] ) : '';
			$overview = isset( $values['overview'] ) ? esc_attr( $values['overview'][0] ) : ''; 
			$genres = isset( $values['genres'] ) ? esc_attr( $values['genres'][0] ) : ''; 
			$poster_path = isset( $values['poster_path'] ) ? esc_attr( $values['poster_path'][0] ) : ''; 
			$backdrop_path = isset( $values['backdrop_path'] ) ? esc_attr( $values['backdrop_path'][0] ) : ''; 
			$backdrops_path = isset( $values['backdrops_path'] ) ? esc_attr( $values['backdrops_path'][0] ) : ''; 
			$imdb_rating = isset( $values['imdb_rating'] ) ? esc_attr( $values['imdb_rating'][0] ) : ''; 
			$imdb_link = isset( $values['imdb_link'] ) ? esc_attr( $values['imdb_link'][0] ) : ''; 
			$cast = isset( $values['cast'] ) ? esc_attr( $values['cast'][0] ) : ''; 
			$bilgi_ulke = isset( $values['bilgi_ulke'] ) ? esc_attr( $values['bilgi_ulke'][0] ) : ''; 
			$bilgi_sure = isset( $values['bilgi_sure'] ) ? esc_attr( $values['bilgi_sure'][0] ) : ''; 
			$bilgi_vizyon = isset( $values['bilgi_vizyon'] ) ? esc_attr( $values['bilgi_vizyon'][0] ) : ''; 
			$bilgi_butce = isset( $values['bilgi_butce'] ) ? esc_attr( $values['bilgi_butce'][0] ) : ''; 
			$bilgi_hasilat = isset( $values['bilgi_hasilat'] ) ? esc_attr( $values['bilgi_hasilat'][0] ) : ''; 
			wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
			
			//trying out cast array
			$caststrip = stripslashes($cast);
			$cast_detail_array=json_decode($caststrip, 1);
			//var_dump($cast_detail_array);
			//var_dump($cast);
			//echo json_last_error();		
			?>
			<p class="gab_caption">The Movie Database ID</p>
			<div class="gab_fieldrow">
				<div class="gab_fieldname"><label for="idMovie"><?php _e('The ID of movie form tmdb.org','offshore'); ?></label></div>
				<div class="gab_fieldinput">
					<input type="text" class="gab_textfield" name="idMovie" class="regular-text" id="idMovie" value="<?php echo $idMovie; ?>" />
					<input type="button" value="Load Details" class="button search_button" id="search_button" />
					
					<div id="searchresults">Loading Details for movie id: <span class="word"></span></div>

					<div id="results" class="update">
					</div>
					
				</div>
				<div class="clear"></div>
			</div>	

			<p class="gab_caption">The Movie Trailer</p>
			<div class="gab_fieldrow">
				<div class="gab_fieldname"><label for="trailer"><?php _e('Enter a Youtube URL here','offshore'); ?></label></div>
				<div class="gab_fieldinput"><input type="text" class="gab_textfield" name="trailer" class="regular-text" id="trailer" value="<?php if($trailer !== '') { echo $trailer; } ?>" /><label class="not_available" style="color:#F30;"  id="trailer_label"></label></div>
				<div class="clear"></div>
			</div>			
			
			<p class="gab_caption">Plot Summary</p>
			<div class="gab_fieldrow">
				<div class="gab_fieldname"><label for="overview"><?php _e('The short summary of movie','offshore'); ?></label></div>
				<div class="gab_fieldinput"><textarea class="gab_textfield" name="overview" class="regular-text" id="overview"><?php if($overview !== '') { echo $overview; } else { echo $movieInfo[overview]; } ?></textarea><label class="not_available" style="color:#F30;" id="overview_label"></label></div>
				<div class="clear"></div>
			</div>	
			
			<p class="gab_caption">Movie Cast</p>
			<div class="gab_fieldrow">
				<div class="gab_fieldname"><label for="cast"><?php _e('The cast of movie','offshore'); ?></label></div>
				<div class="gab_fieldinput"><textarea class="gab_textfield" name="cast" class="regular-text" id="cast"><?php if($cast !== '') { echo $cast; } else { @print implode(" \n", $echo_cast); } ?></textarea><label class="not_available" style="color:#F30;"  id="cast_label"></label></div>
				<div class="clear"></div>
			</div>			
			
			<p class="gab_caption">Genres</p>
			<div class="gab_fieldrow">
				<div class="gab_fieldname"><label for="genres"><?php _e('The movie genres','offshore'); ?></label></div>
				<div class="gab_fieldinput"><input type="text" class="gab_textfield" name="genres" class="regular-text" id="genres" value="<?php if($genres !== '') { echo $genres; } else { @print implode(', ', $echo_genres);  } ?>" /><label class="not_available" style="color:#F30;"  id="genres_label"></label></div>
				<div class="clear"></div>
			</div>			
			
			<p class="gab_caption">Poster Path</p>
			<div class="gab_fieldrow">
				<div class="gab_fieldname"><label for="poster_path"><?php _e('Poster URL','offshore'); ?></label></div>
				<div class="gab_fieldinput"><input type="text" class="gab_textfield" name="poster_path" class="regular-text" id="poster_path" value="<?php if($poster_path !== '') { echo $poster_path; } else { echo $tmdb_posterpath; } ?>" /><label class="not_available" style="color:#F30;"  id="poster_path_label"></label></div>
				<div class="clear"></div>
			</div>	

			<p class="gab_caption">Backdrop Path</p>
			<div class="gab_fieldrow">
				<div class="gab_fieldname"><label for="backdrop_path"><?php _e('Backdrop URL','offshore'); ?></label></div>
				<div class="gab_fieldinput"><input type="text" class="gab_textfield" name="backdrop_path" class="regular-text" id="backdrop_path" value="<?php if($backdrop_path !== '') { echo $backdrop_path; } else { echo $tmdb_backdroppath; } ?>" /><label class="not_available" style="color:#F30;"  id="backdrop_path_label"></label></div>
				<div class="clear"></div>
			</div>			
			
			<p class="gab_caption">Backdrops</p>
			<div class="gab_fieldrow">
				<div class="gab_fieldname"><label for="backdrops_path"><?php _e('Backdrop URL','offshore'); ?></label></div>
				<div class="gab_fieldinput"><textarea class="gab_textfield" name="backdrops_path" class="regular-text" id="backdrops_path"><?php if($backdrops_path !== '') { echo $backdrops_path; } else { echo $tmdb_backdroppath; } ?></textarea><label class="not_available" style="color:#F30;"  id="backdrops_path_label"></label></div>
				<div class="clear"></div>
			</div>			
			
			<p class="gab_caption">IMDB Rating</p>
			<div class="gab_fieldrow">
				<div class="gab_fieldname"><label for="imdb_rating"><?php _e('The IMDB rating of movie','offshore'); ?></label></div>
				<div class="gab_fieldinput"><input type="text" class="gab_textfield" name="imdb_rating" class="regular-text" id="imdb_rating" value="<?php if($imdb_rating !== '') { echo $imdb_rating; }  ?>" /><label class="not_available" style="color:#F30;"  id="imdb_rating_label"></label></div>
				<div class="clear"></div>
			</div>		

			<p class="gab_caption">IMDB Link</p>
			<div class="gab_fieldrow">
				<div class="gab_fieldname"><label for="imdb_link"><?php _e('The IMDB link of movie','offshore'); ?></label></div>
				<div class="gab_fieldinput"><input type="text" class="gab_textfield" name="imdb_link" class="regular-text" id="imdb_link" value="<?php if($imdb_link !== '') { echo $imdb_link; } ?>" /><label class="not_available" style="color:#F30;"  id="imdb_link_label"></label></div>
				<div class="clear"></div>
			</div>		

			<p class="gab_caption">Ülke</p>
			<div class="gab_fieldrow">
				<div class="gab_fieldname"><label for="bilgi_ulke"><?php _e('The production countries of movie','offshore'); ?></label></div>
				<div class="gab_fieldinput"><input type="text" class="gab_textfield" name="bilgi_ulke" class="regular-text" id="bilgi_ulke" value="<?php if($bilgi_ulke !== '') { echo $bilgi_ulke; } ?>" /><label class="not_available" style="color:#F30;"  id="bilgi_ulke_label"></label></div>
				<div class="clear"></div>
			</div>		

			<p class="gab_caption">Vizyon Tarihi</p>
			<div class="gab_fieldrow">
				<div class="gab_fieldname"><label for="bilgi_vizyon"><?php _e('The release date of movie','offshore'); ?></label></div>
				<div class="gab_fieldinput"><input type="text" class="gab_textfield" name="bilgi_vizyon" class="regular-text" id="bilgi_vizyon" value="<?php if($bilgi_vizyon !== '') { echo $bilgi_vizyon; } ?>" /><label class="not_available" style="color:#F30;"  id="bilgi_vizyon_label"></label></div>
				<div class="clear"></div>
			</div>		

			<p class="gab_caption">Süre</p>
			<div class="gab_fieldrow">
				<div class="gab_fieldname"><label for="bilgi_sure"><?php _e('The runtime of movie','offshore'); ?></label></div>
				<div class="gab_fieldinput"><input type="text" class="gab_textfield" name="bilgi_sure" class="regular-text" id="bilgi_sure" value="<?php if($bilgi_sure !== '') { echo $bilgi_sure; } ?>" /><label class="not_available" style="color:#F30;"  id="bilgi_sure_label"></label></div>
				<div class="clear"></div>
			</div>		

			<p class="gab_caption">Bütçe</p>
			<div class="gab_fieldrow">
				<div class="gab_fieldname"><label for="bilgi_butce"><?php _e('The budget of movie','offshore'); ?></label></div>
				<div class="gab_fieldinput"><input type="text" class="gab_textfield" name="bilgi_butce" class="regular-text" id="bilgi_butce" value="<?php if($bilgi_butce !== '') { echo $bilgi_butce; } ?>" /><label class="not_available" style="color:#F30;"  id="bilgi_butce_label"></label></div>
				<div class="clear"></div>
			</div>		

			<p class="gab_caption">Hasılat</p>
			<div class="gab_fieldrow">
				<div class="gab_fieldname"><label for="bilgi_hasilat"><?php _e('The revenue of movie','offshore'); ?></label></div>
				<div class="gab_fieldinput"><input type="text" class="gab_textfield" name="bilgi_hasilat" class="regular-text" id="bilgi_hasilat" value="<?php if($bilgi_hasilat !== '') { echo $bilgi_hasilat; } ?>" /><label class="not_available" style="color:#F30;"  id="bilgi_hasilat_label"></label></div>
				<div class="clear"></div>
			</div>				

			<script>
				jQuery( function($) {
					
					//hide the search result div
					$("#searchresults").hide();
					
					//on click of a button
					$("#search_button").click(function() {

					$("#overview").val("");
					$("#poster_path").val("");
					$("#backdrop_path").val("");
					$("#backdrops_path").val("");
					$("#genres").val("");
					$("#cast").val("");
					$("#trailer").val("");
					$("#imdb_rating").val("");
					$("#imdb_link").val("");
					$("#bilgi_ulke").val("");
					$("#bilgi_sure").val("");
					$("#bilgi_vizyon").val("");
					$("#bilgi_butce").val("");
					$("#bilgi_hasilat").val("");
					
					$("#overview_label").text("");
					$("#poster_path_label").text("");
					$("#backdrop_path_label").text("");
					$("#backdrops_path_label").text("");
					$("#genres_label").text("");
					$("#cast_label").text("");
					$("#trailer_label").text("");
					$("#imdb_rating_label").text("");
					$("#imdb_link_label").text("");
					$("#bilgi_ulke_label").text("");
					$("#bilgi_sure_label").text("");
					$("#bilgi_vizyon_label").text("");
					$("#bilgi_butce_label").text("");
					$("#bilgi_hasilat_label").text("");
							// if searchString is not empty
					
					//getting the value that user typed
					var searchString    = $("#idMovie").val();
					if(searchString) {
						// ajax call
						$.ajax({
							type: "POST",
							url: "<?php echo site_url(); ?>/wp-content/plugins/ob_movie_database/includes/load_movie_details.php",
							data: {movie_id : searchString},
							//dataType: "json",
							beforeSend: function(html) { // this happen before actual call
								$("#results").html(''); 
								$("#searchresults").show();
								$(".word").html(searchString);
						   },
						   success: function(html){ // this happen after we get result
								$("#results").s();
								$("#results").append(html);
								$("#searchresults").hide();
						  }
						});    
					}
					return false;
					
					});
				});
				</script>	
			<?php	
		}
		
		add_action( 'save_post', 'offshore_meta_box_save' );
		function offshore_meta_box_save( $post_id )
		{
			// Bail if we're doing an auto save
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
			
			// if our nonce isn't there, or we can't verify it, bail
			if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
			
			// if our current user can't edit this post, bail
			if( !current_user_can( 'edit_post' ) ) return;
			
			// now we can actually save the data
			$allowed = array( 
				'a' => array( // on allow a tags
					'href' => array() // and those anchords can only have href attribute
				),
				'img' => array(
					'src' => array(),
					'alt' => array(),
					'title' => array(),
					'class' => array()
				),
				'span' => array(
					'class' => array()
				),
				'div' => array(
					'class' => array()
				)
			);
			
			// Probably a good idea to make sure your data is set			
			if( isset( $_POST['idMovie'] ) && !empty( $_POST['idMovie'] ) )
				update_post_meta( $post_id, 'idMovie', wp_kses( $_POST['idMovie'], $allowed ) );		

			if( isset( $_POST['trailer'] ) && !empty( $_POST['trailer'] ) )
				update_post_meta( $post_id, 'trailer', wp_kses( $_POST['trailer'], $allowed ) );					
				
			if( isset( $_POST['overview'] ) && !empty( $_POST['overview'] ) )
				update_post_meta( $post_id, 'overview', wp_kses( $_POST['overview'], $allowed ) );
			
			if( isset( $_POST['genres'] ) && !empty( $_POST['genres'] ) )
				update_post_meta( $post_id, 'genres', wp_kses( $_POST['genres'], $allowed ) );	
				
			if( isset( $_POST['poster_path'] ) && !empty( $_POST['poster_path'] ) )
				update_post_meta( $post_id, 'poster_path', wp_kses( $_POST['poster_path'], $allowed ) );	

			if( isset( $_POST['backdrop_path'] ) && !empty( $_POST['backdrop_path'] ) )
				update_post_meta( $post_id, 'backdrop_path', wp_kses( $_POST['backdrop_path'], $allowed ) );				

			if( isset( $_POST['backdrops_path'] ) && !empty( $_POST['backdrops_path'] ) )
				update_post_meta( $post_id, 'backdrops_path', wp_kses( $_POST['backdrops_path'], $allowed ) );				
			
			if( isset( $_POST['cast'] ) && !empty( $_POST['cast'] ) )
				update_post_meta( $post_id, 'cast', wp_kses( stripslashes($_POST['cast']), $allowed ) );		
			
			if( isset( $_POST['imdb_rating'] ) && !empty( $_POST['imdb_rating'] ) )
				update_post_meta( $post_id, 'imdb_rating', wp_kses( $_POST['imdb_rating'], $allowed ) );
			
			if( isset( $_POST['imdb_link'] ) && !empty( $_POST['imdb_link'] ) )
				update_post_meta( $post_id, 'imdb_link', wp_kses( $_POST['imdb_link'], $allowed ) );

			if( isset( $_POST['bilgi_ulke'] ) && !empty( $_POST['bilgi_ulke'] ) )
				update_post_meta( $post_id, 'bilgi_ulke', wp_kses( $_POST['bilgi_ulke'], $allowed ) );	

			if( isset( $_POST['bilgi_sure'] ) && !empty( $_POST['bilgi_sure'] ) )
				update_post_meta( $post_id, 'bilgi_sure', wp_kses( $_POST['bilgi_sure'], $allowed ) );	

			if( isset( $_POST['bilgi_vizyon'] ) && !empty( $_POST['bilgi_vizyon'] ) )
				update_post_meta( $post_id, 'bilgi_vizyon', wp_kses( $_POST['bilgi_vizyon'], $allowed ) );	

			if( isset( $_POST['bilgi_butce'] ) && !empty( $_POST['bilgi_butce'] ) )
				update_post_meta( $post_id, 'bilgi_butce', wp_kses( $_POST['bilgi_butce'], $allowed ) );	

			if( isset( $_POST['bilgi_hasilat'] ) && !empty( $_POST['bilgi_hasilat'] ) )
				update_post_meta( $post_id, 'bilgi_hasilat', wp_kses( $_POST['bilgi_hasilat'], $allowed ) );
		}
	}
}

add_action('init', function(){
	new ob_Post_Type();
	include dirname(__FILE__).'/ob-movie-database-shortcodes.php';
   
});
	
	if (is_admin()) {	
		add_action('admin_print_styles-post.php', 'offshore_adminstyle');
		add_action('admin_print_styles-post-new.php', 'offshore_adminstyle');

		function offshore_adminstyle() {
			wp_enqueue_style('adminstyle', get_template_directory_uri() .'/inc/custom-fields.css');
		}
	}