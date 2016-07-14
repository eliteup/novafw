<?php
function thebear_google_map_script()
{
	global $post;
	wp_register_script("googleapis","https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false",array(),'1.0',false);
	$post_content = $post->post_content;
	if( stripos( $post_content, '[thebear_google_map') ) {
		wp_enqueue_script('googleapis');
	}
}
add_action('wp_enqueue_scripts','thebear_google_map_script',1);
/**
 * The Shortcode
 */
function novafw_google_map_shortcode( $atts, $content = null ) {
	$width = $height = $map_type = $lat = $lng = $zoom = $streetviewcontrol = $maptypecontrol = $top_margin = $pancontrol = $zoomcontrol = $zoomcontrolsize = $dragging = $marker_icon = $icon_img = $map_override = $output = $map_style = $scrollwheel = $el_class = '';
	extract(shortcode_atts(array(
		//"id" => "map",
		"width" => "100%",
		"height" => "300px",
		"map_type" => "ROADMAP",
		"lat" => "18.591212",
		"lng" => "73.741261",
		"zoom" => "18",
		"scrollwheel" => "disable",
		"streetviewcontrol" => "false",
		"maptypecontrol" => "false",
		"pancontrol" => "false",
		"zoomcontrol" => "false",
		"zoomcontrolsize" => "SMALL",
		"dragging" => "true",
		"marker_icon" => "default",
		"icon_img" => "",
		"top_margin" => "page_margin_top",
		"map_override" => "0",
		"map_style" => "",
		"el_class" => "",
		"infowindow_open" => "off",
		"map_vc_template" => ""
	), $atts));
	$marker_lat = $lat;
	$marker_lng = $lng;
	if($marker_icon == "default_self"){
		$icon_url = get_template_directory_uri().'/assets/img/icon-marker-pink.png';
	} elseif($marker_icon == "default"){
		$icon_url = "";
	} else {
		$icon_url = apply_filters('ult_get_img_single', $icon_img, 'url');
	}
	$id = "map_".uniqid();
	$wrap_id = "wrap_".$id;
	$map_type = strtoupper($map_type);
	$width = (substr($width, -1)!="%" && substr($width, -2)!="px" ? $width . "px" : $width);
	$map_height = (substr($height, -1)!="%" && substr($height, -2)!="px" ? $height . "px" : $height);

	$margin_css = '';
	if($top_margin != 'none')
	{
		$margin_css = $top_margin;
	}

	if($map_vc_template == 'map_vc_template_value')
		$el_class .= 'uvc-boxed-layout';

	$output .= "<div id='".$wrap_id."' class='ultimate-map-wrapper ".$el_class."' style='".($map_height!="" ? "height:" . $map_height . ";" : "")."'><div id='" . $id . "' data-map_override='".$map_override."' class='ultimate_google_map wpb_content_element ".$margin_css."'" . ($width!="" || $map_height!="" ? " style='" . ($width!="" ? "width:" . $width . ";" : "") . ($map_height!="" ? "height:" . $map_height . ";" : "") . "'" : "") . "></div></div>";
	if($scrollwheel == "disable"){
		$scrollwheel = 'false';
	} else {
		$scrollwheel = 'true';
	}
	$output .= "<script type='text/javascript'>
			(function($) {
  			'use strict';
			var map_$id = null;
			var coordinate_$id;
			var isDraggable = $(document).width() > 641 ? true : $dragging;
			try
			{
				var map_$id = null;
				var coordinate_$id;
				coordinate_$id=new google.maps.LatLng($lat, $lng);
				var mapOptions=
				{
					zoom: $zoom,
					center: coordinate_$id,
					scaleControl: true,
					streetViewControl: $streetviewcontrol,
					mapTypeControl: $maptypecontrol,
					panControl: $pancontrol,
					zoomControl: $zoomcontrol,
					scrollwheel: $scrollwheel,
					draggable: isDraggable,
					zoomControlOptions: {
					  style: google.maps.ZoomControlStyle.$zoomcontrolsize
					},";
	if($map_style == ""){
		$output .= "mapTypeId: google.maps.MapTypeId.$map_type,";
	} else {
		$output .= " mapTypeControlOptions: {
					  		mapTypeIds: [google.maps.MapTypeId.$map_type, 'map_style']
						}";
	}
	$output .= "};";
	if($map_style !== ""){
		$output .= 'var styles = '.rawurldecode(base64_decode(strip_tags($map_style))).';
						var styledMap = new google.maps.StyledMapType(styles,
					    	{name: "Styled Map"});';
	}
	$output .= "var map_$id = new google.maps.Map(document.getElementById('$id'),mapOptions);";
	if($map_style !== ""){
		$output .= "map_$id.mapTypes.set('map_style', styledMap);
 							 map_$id.setMapTypeId('map_style');";
	}
	if($marker_lat!="" && $marker_lng!="")
	{
		$output .= "var marker_$id = new google.maps.Marker({
						position: new google.maps.LatLng($marker_lat, $marker_lng),
						animation:  google.maps.Animation.DROP,
						map: map_$id,
						icon: '".$icon_url."'
					});
					google.maps.event.addListener(marker_$id, 'click', toggleBounce);";

		if(trim($content) !== ""){
			$output .= "var infowindow = new google.maps.InfoWindow();
							infowindow.setContent('<div class=\"map_info_text\" style=\'color:#000;\'>".trim(preg_replace('/\s+/', ' ', do_shortcode($content)))."</div>');";

			if($infowindow_open == 'off')
			{
				$output .= "infowindow.open(map_$id,marker_$id);";
			}

			$output .= "google.maps.event.addListener(marker_$id, 'click', function() {
								infowindow.open(map_$id,marker_$id);
						  	});";

		}
	}
	$output .= "}
			catch(e){};
			jQuery(document).ready(function($){
				google.maps.event.trigger(map_$id, 'resize');
				$(window).resize(function(){
					google.maps.event.trigger(map_$id, 'resize');
					if(map_$id!=null)
						map_$id.setCenter(coordinate_$id);
				});
				$('.ui-tabs').bind('tabsactivate', function(event, ui) {
				   if($(this).find('.ultimate-map-wrapper').length > 0)
					{
						setTimeout(function(){
							$(window).trigger('resize');
						},200);
					}
				});
				$('.ui-accordion').bind('accordionactivate', function(event, ui) {
				   if($(this).find('.ultimate-map-wrapper').length > 0)
					{
						setTimeout(function(){
							$(window).trigger('resize');
						},200);
					}
				});
				$(window).load(function(){
					setTimeout(function(){
						$(window).trigger('resize');
					},200);
				});
				$('.ult_exp_section').select(function(){
					if($(map_$id).parents('.ult_exp_section'))
					{
						setTimeout(function(){
							$(window).trigger('resize');
						},200);
					}
				});
				$(document).on('onUVCModalPopupOpen', function(){
					if($(map_$id).parents('.ult_modal-content'))
					{
						setTimeout(function(){
							$(window).trigger('resize');
						},200);
					}
				});
				$(document).on('click','.ult_tab_li',function(){
					$(window).trigger('resize');
					setTimeout(function(){
						$(window).trigger('resize');
					},200);
				});
			});
			function toggleBounce() {
			  if (marker_$id.getAnimation() != null) {
				marker_$id.setAnimation(null);
			  } else {
				marker_$id.setAnimation(google.maps.Animation.BOUNCE);
			  }
			}
			})(jQuery);
			</script>";
	return $output;
}
add_shortcode( 'thebear_google_map', 'novafw_google_map_shortcode' );

/**
 * The VC Functions
 */
function novafw_google_map_shortcode_vc() {
	vc_map( array(
		"name" => esc_html__("Google Map", "thebear"),
		"base" => "thebear_google_map",
		"class" => "thebear_google_map",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "thebear-vc-block",
		"description" => esc_html__("Display Google Maps to indicate your location.", "thebear"),
		"category" => esc_html__('Thebear WP Theme', 'thebear'),
		"params" => array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Width (in %)", "thebear"),
				"param_name" => "width",
				"admin_label" => true,
				"value" => "100%",
				"group" => "General Settings"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Height (in px)", "thebear"),
				"param_name" => "height",
				"admin_label" => true,
				"value" => "300px",
				"group" => "General Settings"
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Map type", "thebear"),
				"param_name" => "map_type",
				"admin_label" => true,
				"value" => array(__("Roadmap", "thebear") => "ROADMAP", __("Satellite", "thebear") => "SATELLITE", __("Hybrid", "thebear") => "HYBRID", __("Terrain", "thebear") => "TERRAIN"),
				"group" => "General Settings"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Latitude", "thebear"),
				"param_name" => "lat",
				"admin_label" => true,
				"value" => "18.591212",
				"description" => '<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">'.__('Here is a tool','thebear').'</a> '.__('where you can find Latitude & Longitude of your location', 'thebear'),
				"group" => "General Settings"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Longitude", "thebear"),
				"param_name" => "lng",
				"admin_label" => true,
				"value" => "73.741261",
				"description" => '<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">'.__('Here is a tool','thebear').'</a> '.__('where you can find Latitude & Longitude of your location', "thebear"),
				"group" => "General Settings"
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Map Zoom", "thebear"),
				"param_name" => "zoom",
				"value" => array(
					esc_html__("18 - Default", "thebear") => 12, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 13, 14, 15, 16, 17, 18, 19, 20
				),
				"group" => "General Settings"
			),
			array(
				"type" => "checkbox",
				"heading" => "",
				"param_name" => "scrollwheel",
				"value" => array(
					esc_html__("Disable map zoom on mouse wheel scroll", "thebear") => "disable",
				),
				"group" => "General Settings"
			),
			array(
				"type" => "textarea_html",
				"class" => "",
				"heading" => esc_html__("Info Window Text", "thebear"),
				"param_name" => "content",
				"value" => "",
				"group" => "Info Window",
				"edit_field_class" => "ult_hide_editor_fullscreen vc_col-xs-12 vc_column wpb_el_type_textarea_html vc_wrapper-param-type-textarea_html vc_shortcode-param",
			),
			array(
				"type" => "ult_switch",
				"heading" => esc_html__("Open on Marker Click","thebear"),
				"param_name" => "infowindow_open",
				"options" => array(
					"infowindow_open_value" => array(
						"label" => "",
						"on" => esc_html__("Yes","thebear"),
						"off" => esc_html__("No","thebear"),
					)
				),
				"value" => "infowindow_open_value",
				"default_set" => true,
				"group" => "Info Window",
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Marker/Point icon", "thebear"),
				"param_name" => "marker_icon",
				"value" => array(esc_html__("Use Google Default", "thebear") => "default", __("Use Plugin's Default", "thebear") => "default_self", __("Upload Custom", "thebear") => "custom"),
				"group" => "Marker"
			),
			array(
				"type" => "ult_img_single",
				"class" => "",
				"heading" => esc_html__("Upload Image Icon:", "thebear"),
				"param_name" => "icon_img",
				"admin_label" => true,
				"value" => "",
				"description" => esc_html__("Upload the custom image icon.", "thebear"),
				"dependency" => Array("element" => "marker_icon","value" => array("custom")),
				"group" => "Marker"
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Street view control", "thebear"),
				"param_name" => "streetviewcontrol",
				"value" => array(esc_html__("Disable", "thebear") => "false", __("Enable", "thebear") => "true"),
				"group" => "Advanced"
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Map type control", "thebear"),
				"param_name" => "maptypecontrol",
				"value" => array(esc_html__("Disable", "thebear") => "false", __("Enable", "thebear") => "true"),
				"group" => "Advanced"
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Map pan control", "thebear"),
				"param_name" => "pancontrol",
				"value" => array(esc_html__("Disable", "thebear") => "false", __("Enable", "thebear") => "true"),
				"group" => "Advanced"
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Zoom control", "thebear"),
				"param_name" => "zoomcontrol",
				"value" => array(esc_html__("Disable", "thebear") => "false", __("Enable", "thebear") => "true"),
				"group" => "Advanced"
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Zoom control size", "thebear"),
				"param_name" => "zoomcontrolsize",
				"value" => array(esc_html__("Small", "thebear") => "SMALL", __("Large", "thebear") => "LARGE"),
				"dependency" => Array("element" => "zoomControl","value" => array("true")),
				"group" => "Advanced"
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Disable dragging on Mobile", "thebear"),
				"param_name" => "dragging",
				"value" => array( esc_html__("Enable", "thebear") => "true", __("Disable", "thebear") => "false"),
				"group" => "Advanced"
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Top margin", "thebear"),
				"param_name" => "top_margin",
				"value" => array(
					esc_html__("Page (small)", "thebear") => "page_margin_top",
					esc_html__("Section (large)", "thebear") => "page_margin_top_section",
					esc_html__("None", "thebear") => "none"
				),
				"group" => "General Settings"
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Map Width Override", "thebear"),
				"param_name" => "map_override",
				"value" =>array(
					"Default Width"=>"0",
					"Apply 1st parent element's width"=>"1",
					"Apply 2nd parent element's width"=>"2",
					"Apply 3rd parent element's width"=>"3",
					"Apply 4th parent element's width"=>"4",
					"Apply 5th parent element's width"=>"5",
					"Apply 6th parent element's width"=>"6",
					"Apply 7th parent element's width"=>"7",
					"Apply 8th parent element's width"=>"8",
					"Apply 9th parent element's width"=>"9",
					"Full Width "=>"full",
					"Maximum Full Width"=>"ex-full",
				),
				"description" => esc_html__("By default, the map will be given to the Visual Composer row. However, in some cases depending on your theme's CSS - it may not fit well to the container you are wishing it would. In that case you will have to select the appropriate value here that gets you desired output..", "thebear"),
				"group" => "General Settings"
			),
			array(
				"type" => "textarea_raw_html",
				"class" => "",
				"heading" => esc_html__("Google Styled Map JSON","thebear"),
				"param_name" => "map_style",
				"value" => "",
				"description" => "<a target='_blank' href='http://gmaps-samples-v3.googlecode.com/svn/trunk/styledmaps/wizard/index.html'>".__("Click here","thebear")."</a> ".__("to get the style JSON code for styling your map.","thebear"),
				"group" => "Styling",
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Extra class name", "thebear"),
				"param_name" => "el_class",
				"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "thebear"),
				"group" => "General Settings"
			),
			array(
				"type" => "ult_param_heading",
				"text" => "<span style='display: block;'><a href='http://bsf.io/f57sh' target='_blank'>".__("Watch Video Tutorial","thebear")." &nbsp; <span class='dashicons dashicons-video-alt3' style='font-size:30px;vertical-align: middle;color: #e52d27;'></span></a></span>",
				"param_name" => "notification",
				'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
				"group" => "General Settings"
			),
		)
	));
}
add_action( 'vc_before_init', 'novafw_google_map_shortcode_vc' );