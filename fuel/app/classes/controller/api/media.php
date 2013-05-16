<?php

class Controller_Api_Media extends Controller_Api
{

	/**
	 * POST /api/media/
	 *
	 **/
	public function post_index()
	{

		$url = Input::post('url', false);

		$val = Validation::forge('media_url');
		$val->add_field('url', 'Media URL', 'required|trim|strip_tags|valid_url');
	
		if(!$val->run())
			return parent::error('Bad Request.', 400, 'A URL is required.');

		$url = preg_replace('#\#.*$#', '', trim($url));
		$url = str_replace('https://', 'http://', $url ); 

		$upload_type = 'article';

    	$services_regexp = array(
        	"#^\w+\.(?P<format>[a-zA-Z0-9]{2,5})#"                      => 'local',
        	'#vimeo\.com\/(?P<id>[0-9]*)[\/\?]?#i'                      => 'vimeo',
        	'#youtube\.[a-z]{0,5}/.*[\?&]?v(?:\/|=)?(?P<id>[^&]*)#i'    => 'youtube',
        	'#soundcloud\.com\/[0-9a-zA-Z_\/\-]{1,99}#i'   			    => 'soundcloud',
        	'#\.(jpe?g|png|gif)#i' 										=> 'image'
    	);

	    foreach ( $services_regexp as $pattern => $service ) {
	        if ( preg_match ( $pattern, $url, $matches ) ) {
	            $upload_type = ( $service === 'local' ) ? $matches['format']  : $service;
	        }
	    }

	    switch ($upload_type){

	    	case 'image' :

	    		$data = array(

	    			'preview' => array(

	    					'type' => 'image',
	    					'image_src' => $url,

	    				)

	    		);

	    	break;
	    	case 'vimeo' 	:
	    	case 'youtube' 	:
	    	case 'soundcloud':

	    		$data = $this->scrape_content( $url );

	    	break;
	    	default : 

	    		$file 	= pathinfo($url);
				$size 	= '415x320';
			    $start 	= 1;
			    $frames = 1;

			    $unique_id   = uniqid();

			    $FFmpeg = new FFmpeg( Config::get('FFMPEG_PATH') );
			    $FFmpeg
		    		->input( DOCROOT . 'files' . DS . 'feeds' . DS . $file['basename'] )
		    		->thumb( $size , $start, $frames )
					->output( DOCROOT . 'files' . DS . 'feeds' . DS . $unique_id . '.jpg' )
		    		->ready();

	    		$data = array(

	    			'preview' => array(

    					'type' 			=> 'video',
    					'site_name'		=> 'local_video',
						'image_src' 	=> DS . 'files' . DS . 'feeds' . DS . $unique_id . '.jpg',
						'video_link' 	=> $url,
						'url'			=> $url,

    				)

	    		);

	    	break;

	    }

		$this->_head['status'] 		= 200;
		$this->_head['resource']  	= Input::uri();
		$this->_head['message'] 	= 'Completed';

	    return $this->response( 

			array( 
				'head' 		=> $this->_head,
				'data' 		=> $data,
			)

		); 

	}

	// private function get_oembed( $url, $type){

	// 	$oembed_sources = array(
	// 		'vimeo' => 'http://vimeo.com/api/oembed.json?url=',
	// 		'youtube' => 'http://www.youtube.com/oembed?url=',
	// 		'soundcloud' => 'http://soundcloud.com/oembed.json?url='

	// 	);

	// 	$oembed = \Request::forge($oembed_sources[$type].$url, 
	// 		array('driver' => 'curl', 
	// 			'set_options' => array(
	// 				CURLOPT_HEADER 			=> 0, 
	// 				CURLOPT_RETURNTRANSFER 	=> 1,
	// 				CURLOPT_SSL_VERIFYPEER  => false,
	// 				CURLOPT_SSL_VERIFYHOST  => 2,
	// 				CURLOPT_FOLLOWLOCATION	=> 1,
	// 			)
	// 		)
	// 	)->execute();

	// 	var_dump( Format::forge( $oembed )->to_array() ); exit();

	// }

	private function scrape_content($url){

		# -- get HTML of URL
		$resource 	= \Request::forge($url, 
			array('driver' => 'curl', 
				'set_options' => array(
					CURLOPT_HEADER 			=> 0, 
					CURLOPT_RETURNTRANSFER 	=> 1,
					CURLOPT_SSL_VERIFYPEER  => false,
					CURLOPT_SSL_VERIFYHOST  => 2,
					CURLOPT_FOLLOWLOCATION	=> 1,
				)
			)
		)->execute();

		# use oembed for youtube, vimeo, soundcloud

		# -- Xpath
		libxml_use_internal_errors(true); 
		$doc = new DomDocument();
		$doc->loadHTML($resource);					
					
		# -- get open graph
		$xpath = new DOMXPath($doc);
		$query = '//*/meta[starts-with(@property, \'og:\')]';
		$metas = $xpath->query($query);
				
		if (!empty($resource) and !empty($metas)){

			foreach ($metas as $meta) {
			    $property 	= $meta->getAttribute('property');
			    $content 	= $meta->getAttribute('content');
			    $rmetas[$property] = $content;
			}

			# replace soundcloud object type to sound
			if ( $rmetas['og:type'] === 'soundcloud:sound'){
				$rmetas['og:type'] = 'audio';
				$rmetas['og:video'] = str_replace('player.soundcloud.com/player.swf?','w.soundcloud.com/player/?',$rmetas['og:video']);
				$rmetas['og:video'] = str_replace('color=3b5998','',$rmetas['og:video']);
				$rmetas['og:video'] = str_replace('show_artwork=false','',$rmetas['og:video']);
				$rmetas['og:video'] = str_replace('origin=facebook','',$rmetas['og:video']);
			}

			return array(

				'preview' => array(

					'site_name'		=> isset( $rmetas['og:site_name'] ) ? $rmetas['og:site_name'] : '',
					'type' 			=> isset( $rmetas['og:type'] ) ? $rmetas['og:type'] : '',
					'title'			=> isset( $rmetas['og:title'] ) ? Str::truncate($rmetas['og:title'],40,'...') : '',
					'description' 	=> isset( $rmetas['og:description'] ) ? Str::truncate($rmetas['og:description'],100,'...') : '',
					'image_src' 	=> isset( $rmetas['og:image'] ) ? $rmetas['og:image'] : '',
					'video_link' 	=> isset( $rmetas['og:video'] ) ? $rmetas['og:video'] : '',
					'url'			=> isset( $rmetas['og:url'] ) ? $rmetas['og:url'] : '',

				)

			);

		} else {

			return array(

				'preview' => array(

					'error' => 'URL could not be parsed'

				)

			);

		}

	}



	/**
	 * POST /media/<id>
	 *
	 **/
	public function post_id($id=null)
	{

	}

}