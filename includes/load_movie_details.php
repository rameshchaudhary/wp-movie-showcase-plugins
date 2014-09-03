<?php
require_once('../../../../wp-load.php');
$movie_id = $_POST['movie_id'];
if($movie_id == NULL)
{
	echo "Please Enter the movie id";
	die();
}
//Change the API Key here
$api_key = "468d0884a93dbc7c4cfc12e234d37580";
$language = "tr";

$json_detail=file_get_contents("https://api.themoviedb.org/3/movie/$movie_id?api_key=$api_key&language=$language");
$details=json_decode($json_detail);
$json_cast=file_get_contents("http://api.themoviedb.org/3/movie/$movie_id/casts?api_key=$api_key");
$casts=json_decode($json_cast);
$json_trailer=file_get_contents("http://api.themoviedb.org/3/movie/$movie_id/trailers?api_key=$api_key");
$trailers=json_decode($json_trailer);
$json_backdrop=file_get_contents("http://api.themoviedb.org/3/movie/$movie_id/images?api_key=$api_key");
$backdrops=json_decode($json_backdrop);

$imdb_movieid = $details->imdb_id;
$omdbapi=file_get_contents("http://www.omdbapi.com/?i=$imdb_movieid");
$imdb_details=json_decode($omdbapi);

/*
echo "<pre>".print_r($details)."</pre>";
echo "<pre>".print_r($casts)."</pre>";
echo "<pre>".print_r($trailers)."</pre>";
echo "<pre>".print_r($backdrops)."</pre>";
*/
//Check if respose contains the movie information
if($details != NULL)
{  
	//print_r($details);
	//echo "The movie name is : ".$details->original_title;
	
	//for trailer
	echo "<input type='hidden' id='trailer_is' value='";
	$movie_trailer = $trailers->youtube;
	foreach($movie_trailer as $key=>$value)
	{
		if($value->type == "Trailer")
		{		
			echo "https://www.youtube.com/watch?v=".$value->source;
		}
		break;
	}
	echo "'/>";

	//for overview
	echo "<textarea style='display:none;' id='overview_is'>".$details->overview."</textarea>";
	
	//for cast
	$cast_array = array();
	echo "<textarea style='display:none;' id='casts_is' >";
	$movie_casts = $casts->cast;
	foreach($movie_casts as $key=>$value)
	{
		if ($value->profile_path == '') {
			$imageurl = get_template_directory_uri().'/images/nophoto.png';
		} else { 
			$imageurl = 'http://image.tmdb.org/t/p/w185'.$value->profile_path;
		}
		$castname = $value->name;
		$castcharacter = $value->character;
		
		$cast_array[$value->order] = array();
		$cast_array[$value->order]['img'] = $imageurl;
		$cast_array[$value->order]['name'] = $castname;
		$cast_array[$value->order]['character'] = $castcharacter;
		//echo "<img src='http://image.tmdb.org/t/p/w780".$value->profile_path . "' alt='" . $value->name . "' title ='" . $value->character . "' class='cast_image' /> " . "<span class='cast_name'>" . $value->name . "</span>\n";
		//echo '<div class="moviecast_item"><img src="' . $imageurl . '" alt="' . $value->name . '" title ="' . $value->character . '" class="cast_image" /> ' . '<span class="cast_name">' . $value->name .' - '. $value->character .'</span></div>'."\n";
		
		if($value->order == 5)
			break;
	}
	$castdetail=json_encode($cast_array);
	echo $castdetail;
	echo "</textarea>";
	echo print_r($cast_array);

	//for genres
	echo "<input type='hidden' id='genres_is' value='";
	$genres = $details->genres;
	$genres_count = count($genres);
	$comma = 1;
	foreach($genres as $key=>$value)
	{
	
		echo $value->name;
		if($genres_count > $comma)
		{
			echo ", ";
		}
		$comma++;
		
	}
	echo "'/>";

	//for posterpath
	echo "<input type='hidden' id='poster_path_is' value='http://image.tmdb.org/t/p/w780".$details->poster_path."' />";
	
	//for backdrop_path
	echo "<input type='hidden' id='backdrop_path_is' value='http://image.tmdb.org/t/p/w780".$details->backdrop_path."' />";
	
	//for backdrops
	echo "<textarea style='display:none;' id='backdrops_path_is' >";
	$movie_backdrops = $backdrops->backdrops;
	$backdrops_count = count($movie_backdrops);
	$comma = 1;
	$count = 1;
	foreach($movie_backdrops as $key=>$value)
	{
		if($count<=9)
		{
			echo "http://image.tmdb.org/t/p/w1280".$value->file_path;
			if($backdrops_count > $comma && $comma <= 8)
			{
				echo ", ";
			}
			$comma++;
		}
		else
		{
			break;
		}
		$count++;
	}
	echo "</textarea>";
	
	//for imdb rating
	echo "<input type='hidden' id='vote_average' value='".$imdb_details->imdbRating."' />";
	
	//for production countries
	echo "<textarea style='display:none;' id='countries_is' >";
	$countries_codes = array
	(
		'AF' => 'Afghanistan',
		'AX' => 'Aland Islands',
		'AL' => 'Albania',
		'DZ' => 'Algeria',
		'AS' => 'American Samoa',
		'AD' => 'Andorra',
		'AO' => 'Angola',
		'AI' => 'Anguilla',
		'AQ' => 'Antarctica',
		'AG' => 'Antigua And Barbuda',
		'AR' => 'Argentina',
		'AM' => 'Armenia',
		'AW' => 'Aruba',
		'AU' => 'Australia',
		'AT' => 'Austria',
		'AZ' => 'Azerbaijan',
		'BS' => 'Bahamas',
		'BH' => 'Bahrain',
		'BD' => 'Bangladesh',
		'BB' => 'Barbados',
		'BY' => 'Belarus',
		'BE' => 'Belgium',
		'BZ' => 'Belize',
		'BJ' => 'Benin',
		'BM' => 'Bermuda',
		'BT' => 'Bhutan',
		'BO' => 'Bolivia',
		'BA' => 'Bosnia And Herzegovina',
		'BW' => 'Botswana',
		'BV' => 'Bouvet Island',
		'BR' => 'Brazil',
		'IO' => 'British Indian Ocean Territory',
		'BN' => 'Brunei Darussalam',
		'BG' => 'Bulgaria',
		'BF' => 'Burkina Faso',
		'BI' => 'Burundi',
		'KH' => 'Cambodia',
		'CM' => 'Cameroon',
		'CA' => 'Canada',
		'CV' => 'Cape Verde',
		'KY' => 'Cayman Islands',
		'CF' => 'Central African Republic',
		'TD' => 'Chad',
		'CL' => 'Chile',
		'CN' => 'China',
		'CX' => 'Christmas Island',
		'CC' => 'Cocos (Keeling) Islands',
		'CO' => 'Colombia',
		'KM' => 'Comoros',
		'CG' => 'Congo',
		'CD' => 'Congo, Democratic Republic',
		'CK' => 'Cook Islands',
		'CR' => 'Costa Rica',
		'CI' => 'Cote D\'Ivoire',
		'HR' => 'Croatia',
		'CU' => 'Cuba',
		'CY' => 'Cyprus',
		'CZ' => 'Czech Republic',
		'DK' => 'Denmark',
		'DJ' => 'Djibouti',
		'DM' => 'Dominica',
		'DO' => 'Dominican Republic',
		'EC' => 'Ecuador',
		'EG' => 'Egypt',
		'SV' => 'El Salvador',
		'GQ' => 'Equatorial Guinea',
		'ER' => 'Eritrea',
		'EE' => 'Estonia',
		'ET' => 'Ethiopia',
		'FK' => 'Falkland Islands (Malvinas)',
		'FO' => 'Faroe Islands',
		'FJ' => 'Fiji',
		'FI' => 'Finland',
		'FR' => 'France',
		'GF' => 'French Guiana',
		'PF' => 'French Polynesia',
		'TF' => 'French Southern Territories',
		'GA' => 'Gabon',
		'GM' => 'Gambia',
		'GE' => 'Georgia',
		'DE' => 'Germany',
		'GH' => 'Ghana',
		'GI' => 'Gibraltar',
		'GR' => 'Greece',
		'GL' => 'Greenland',
		'GD' => 'Grenada',
		'GP' => 'Guadeloupe',
		'GU' => 'Guam',
		'GT' => 'Guatemala',
		'GG' => 'Guernsey',
		'GN' => 'Guinea',
		'GW' => 'Guinea-Bissau',
		'GY' => 'Guyana',
		'HT' => 'Haiti',
		'HM' => 'Heard Island & Mcdonald Islands',
		'VA' => 'Holy See (Vatican City State)',
		'HN' => 'Honduras',
		'HK' => 'Hong Kong',
		'HU' => 'Hungary',
		'IS' => 'Iceland',
		'IN' => 'India',
		'ID' => 'Indonesia',
		'IR' => 'Iran, Islamic Republic Of',
		'IQ' => 'Iraq',
		'IE' => 'Ireland',
		'IM' => 'Isle Of Man',
		'IL' => 'Israel',
		'IT' => 'Italy',
		'JM' => 'Jamaica',
		'JP' => 'Japan',
		'JE' => 'Jersey',
		'JO' => 'Jordan',
		'KZ' => 'Kazakhstan',
		'KE' => 'Kenya',
		'KI' => 'Kiribati',
		'KR' => 'Korea',
		'KW' => 'Kuwait',
		'KG' => 'Kyrgyzstan',
		'LA' => 'Lao People\'s Democratic Republic',
		'LV' => 'Latvia',
		'LB' => 'Lebanon',
		'LS' => 'Lesotho',
		'LR' => 'Liberia',
		'LY' => 'Libyan Arab Jamahiriya',
		'LI' => 'Liechtenstein',
		'LT' => 'Lithuania',
		'LU' => 'Luxembourg',
		'MO' => 'Macao',
		'MK' => 'Macedonia',
		'MG' => 'Madagascar',
		'MW' => 'Malawi',
		'MY' => 'Malaysia',
		'MV' => 'Maldives',
		'ML' => 'Mali',
		'MT' => 'Malta',
		'MH' => 'Marshall Islands',
		'MQ' => 'Martinique',
		'MR' => 'Mauritania',
		'MU' => 'Mauritius',
		'YT' => 'Mayotte',
		'MX' => 'Mexico',
		'FM' => 'Micronesia, Federated States Of',
		'MD' => 'Moldova',
		'MC' => 'Monaco',
		'MN' => 'Mongolia',
		'ME' => 'Montenegro',
		'MS' => 'Montserrat',
		'MA' => 'Morocco',
		'MZ' => 'Mozambique',
		'MM' => 'Myanmar',
		'NA' => 'Namibia',
		'NR' => 'Nauru',
		'NP' => 'Nepal',
		'NL' => 'Netherlands',
		'AN' => 'Netherlands Antilles',
		'NC' => 'New Caledonia',
		'NZ' => 'New Zealand',
		'NI' => 'Nicaragua',
		'NE' => 'Niger',
		'NG' => 'Nigeria',
		'NU' => 'Niue',
		'NF' => 'Norfolk Island',
		'MP' => 'Northern Mariana Islands',
		'NO' => 'Norway',
		'OM' => 'Oman',
		'PK' => 'Pakistan',
		'PW' => 'Palau',
		'PS' => 'Palestinian Territory, Occupied',
		'PA' => 'Panama',
		'PG' => 'Papua New Guinea',
		'PY' => 'Paraguay',
		'PE' => 'Peru',
		'PH' => 'Philippines',
		'PN' => 'Pitcairn',
		'PL' => 'Poland',
		'PT' => 'Portugal',
		'PR' => 'Puerto Rico',
		'QA' => 'Qatar',
		'RE' => 'Reunion',
		'RO' => 'Romania',
		'RU' => 'Russian Federation',
		'RW' => 'Rwanda',
		'BL' => 'Saint Barthelemy',
		'SH' => 'Saint Helena',
		'KN' => 'Saint Kitts And Nevis',
		'LC' => 'Saint Lucia',
		'MF' => 'Saint Martin',
		'PM' => 'Saint Pierre And Miquelon',
		'VC' => 'Saint Vincent And Grenadines',
		'WS' => 'Samoa',
		'SM' => 'San Marino',
		'ST' => 'Sao Tome And Principe',
		'SA' => 'Saudi Arabia',
		'SN' => 'Senegal',
		'RS' => 'Serbia',
		'SC' => 'Seychelles',
		'SL' => 'Sierra Leone',
		'SG' => 'Singapore',
		'SK' => 'Slovakia',
		'SI' => 'Slovenia',
		'SB' => 'Solomon Islands',
		'SO' => 'Somalia',
		'ZA' => 'South Africa',
		'GS' => 'South Georgia And Sandwich Isl.',
		'ES' => 'Spain',
		'LK' => 'Sri Lanka',
		'SD' => 'Sudan',
		'SR' => 'Suriname',
		'SJ' => 'Svalbard And Jan Mayen',
		'SZ' => 'Swaziland',
		'SE' => 'Sweden',
		'CH' => 'Switzerland',
		'SY' => 'Syrian Arab Republic',
		'TW' => 'Taiwan',
		'TJ' => 'Tajikistan',
		'TZ' => 'Tanzania',
		'TH' => 'Thailand',
		'TL' => 'Timor-Leste',
		'TG' => 'Togo',
		'TK' => 'Tokelau',
		'TO' => 'Tonga',
		'TT' => 'Trinidad And Tobago',
		'TN' => 'Tunisia',
		'TR' => 'Turkey',
		'TM' => 'Turkmenistan',
		'TC' => 'Turks And Caicos Islands',
		'TV' => 'Tuvalu',
		'UG' => 'Uganda',
		'UA' => 'Ukraine',
		'AE' => 'United Arab Emirates',
		'GB' => 'United Kingdom',
		'US' => 'United States',
		'UM' => 'United States Outlying Islands',
		'UY' => 'Uruguay',
		'UZ' => 'Uzbekistan',
		'VU' => 'Vanuatu',
		'VE' => 'Venezuela',
		'VN' => 'Viet Nam',
		'VG' => 'Virgin Islands, British',
		'VI' => 'Virgin Islands, U.S.',
		'WF' => 'Wallis And Futuna',
		'EH' => 'Western Sahara',
		'YE' => 'Yemen',
		'ZM' => 'Zambia',
		'ZW' => 'Zimbabwe',
	);
 
	$countries = $details->production_countries;
	$countries_count = count($countries);
	$comma = 1;
	foreach($countries as $key=>$value)
	{
		$country_code = $value->iso_3166_1;
		foreach($countries_codes as $code=>$country_name)
		{
			if($code == $country_code)
			{
				echo $country_name;
				if($countries_count > $comma)
				{
					echo ", ";
				}
			}
		}
		$comma++;

	}
	echo "</textarea>";

	//for release date
	echo "<input type='hidden' id='release_date_is' value='".$details->release_date."' />";
	
	//for runtime
	echo "<input type='hidden' id='runtime_is' value='".$imdb_details->Runtime."' />";
	
	//for budget
	echo "<input type='hidden' id='budget_is' value='".$details->budget."' />";
	
	//for revenue
	echo "<input type='hidden' id='revenue_is' value='".$details->revenue."' />";
	
	//for imdb link
	echo "<input type='hidden' id='imdb_link_is' value='http://www.imdb.com/title/".$details->imdb_id."/' />";

	
?>
<script>
jQuery( function($) {
	var not_available = "Not Available!"
	
	var overview_is = $("#overview_is").val();
	if(overview_is == "")
	{
		$("#overview_label").text(not_available);
	}
	else
	{
		$("#overview").val(overview_is);
	}
	
	
	var poster_path_is = $("#poster_path_is").val();
	if(poster_path_is == "")
	{
		$("#poster_path_label").text(not_available);;
	}
	else
	{
		$("#poster_path").val(poster_path_is);
	}


	var backdrop_path_is = $("#backdrop_path_is").val();
	if(backdrop_path_is == "")
	{
		$("#backdrop_path_label").text(not_available);;
	}
	else
	{
		$("#backdrop_path").val(backdrop_path_is);
	}
	
	var backdrops_path_is = $("#backdrops_path_is").val();
	if(backdrops_path_is == "")
	{
		$("#backdrops_path_label").text(not_available);;
	}
	else
	{
		$("#backdrops_path").val(backdrops_path_is);
	}
	
	var genres_is = $("#genres_is").val();
	if(genres_is == "")
	{
		$("#genres_label").text(not_available);;
	}
	else
	{
		$("#genres").val(genres_is);
	}
	
	var casts_is = $("#casts_is").val();
	if(casts_is == "")
	{
		$("#cast_label").text(not_available);;
	}
	else
	{
		$("#cast").val(casts_is);
	}
	
	var trailer_is = $("#trailer_is").val();
	if(trailer_is == "")
	{
		$("#trailer_label").text(not_available);;
	}
	else
	{
		$("#trailer").val(trailer_is);
	}
	
	var vote_average_is = $("#vote_average").val();
	if(vote_average_is == "0")
	{
		$("#imdb_rating_label").text(not_available);;
	}
	else
	{
		$("#imdb_rating").val(vote_average_is);
	}
	
	var countries_is = $("#countries_is").val();
	if(countries_is == "")
	{
		$("#bilgi_ulke_label").text(not_available);;
	}
	else
	{
		$("#bilgi_ulke").val(countries_is);
	}
	
	var release_date_is = $("#release_date_is").val();
	if(release_date_is == "")
	{
		$("#bilgi_vizyon_label").text(not_available);;
	}
	else
	{
		$("#bilgi_vizyon").val(release_date_is);
	}
	
	var runtime_is = $("#runtime_is").val();
	if(runtime_is == "" || runtime_is == "0")
	{
		$("#bilgi_sure_label").text(not_available);;
	}
	else
	{
		$("#bilgi_sure").val(runtime_is);
	}
	
	var budget_is = $("#budget_is").val();
	if(budget_is == "0")
	{
		$("#bilgi_butce_label").text(not_available);;
	}
	else
	{
		$("#bilgi_butce").val(budget_is);
	}
	
	var revenue_is = $("#revenue_is").val();
	if(revenue_is == "0")
	{
		$("#bilgi_hasilat_label").text(not_available);;
	}
	else
	{
		$("#bilgi_hasilat").val(revenue_is);
	}
	
	var imdb_link_is = $("#imdb_link_is").val();
	if(imdb_link_is == "http://www.imdb.com/title/")
	{
		$("#imdb_link_label").text(not_available);;
	}
	else
	{
		$("#imdb_link").val(imdb_link_is);
	}
});
</script>
<?php
}
//Show message if the movie information is not returned by APIs
else
{
     echo "Movie information not available.Please confirm Movie ID";
}

?>