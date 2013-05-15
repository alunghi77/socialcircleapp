<?php


class Controller_Api_Images extends Controller_Api
{    

    protected $format = 'json';

    /**
     * Crop an image file
     *
     * POST /images/crop
     *
     * payload['file_to']
     * payload['crop']
     *
     */
    public function post_crop()
    {  
        
        $file       = Input::post('file_to');
        $file_info  = pathinfo($file);

        $crop       = Input::post('crop');
        $crop_sizes = json_decode($crop, true);

        $unique_id  = uniqid();
        $img        = DOCROOT.'files'.DS.'posts'.DS.$file_info['basename'];

        if ( !file_exists( $img )){

            if ( file_exists( $tmp ) ){

                $file_exists = $tmp;
            }

            # download
            file_put_contents($img, file_get_contents($file));

        } 

        $image = Image::load( $img )
            ->crop( $crop_sizes['x'],$crop_sizes['y'],$crop_sizes['x2'],$crop_sizes['y2'] )
            ->save_pa('cropped_'.$unique_id);

        echo 'http://'.$_SERVER['HTTP_HOST'].DS.'assets'.DS.'files'.DS.'posts'.DS.'cropped_'.$unique_id.$file_info['basename'];

    }

    /**
     * Upload an Image
     *
     * POST /images/
     *
     * payload['file_to']
     * payload['crop']
     *
     */
    public function post_index()
    {  
        $this->format = 'html';

        $video_ext_whitelist = array('mpeg', 'mp4', 'avi', 'mov', 'm2v');
        $image_ext_whitelist = array('img', 'jpg', 'jpeg', 'gif', 'png');

        # handle upload
        $config = array(

            'path'          => DOCROOT.'files'.DS.'feeds',
            'randomize'     => true,
            'ext_whitelist' => array_merge( $video_ext_whitelist, $image_ext_whitelist ),
        
        );

        $unique_id  = uniqid();

        // process the uploaded files in $_FILES
        Upload::process($config);

        // if there are any valid files
        if (Upload::is_valid())
        {
            
            // save them according to the config
            Upload::save();

            $response_arr = Upload::get_files(0);

            if ( !$response_arr['error'] ){

                switch ( true ){

                    # uploaded video 
                    case (in_array(Str::lower($response_arr['extension']), $video_ext_whitelist)) : 

                        $size   = '415x320';
                        $start  = 1;
                        $frames = 1;

                        $unique_id   = uniqid();

                        $FFmpeg = new FFmpeg( Config::get('FFMPEG_PATH') );
                        $FFmpeg
                            ->input( DOCROOT . 'files' . DS . 'posts' . DS . $response_arr["saved_as"] )
                            ->thumb( $size , $start, $frames )
                            ->output( DOCROOT . 'files' . DS . 'posts' . DS . $unique_id . '.jpg' )
                            ->ready();

                        $data = array(

                            'preview' => array(

                                'type'          => 'video',
                                'site_name'     => 'local_video',
                                'image_src'     => Uri::base(false). 'files' . DS . 'posts' . DS . $unique_id . '.jpg',
                                'video_link'    => Uri::base(false).Str::lower('files/feeds/'.$response_arr["saved_as"]),

                            )

                        );

                        echo Uri::base(false).Str::lower('files/feeds/'.$response_arr["saved_as"]);
                        exit();

                    break;

                    # uploaded image
                    case (in_array(Str::lower($response_arr['extension']), $image_ext_whitelist)) : 

                        $sizes = Image::sizes(DOCROOT.'files'.DS.'feeds'.DS.$response_arr["saved_as"]);

                        if ($sizes->width >= 400){

                            Image::load(DOCROOT.'files'.DS.'feeds'.DS.$response_arr["saved_as"])->resize(400,null)->save_pa('cropped_'.$unique_id);

                            $image_src = Uri::base(false).Str::lower('files/feeds/cropped_'.$unique_id.$response_arr["saved_as"]);

                        } else {

                            $image_src = Uri::base(false).Str::lower('files/feeds/'.$response_arr["saved_as"]);

                        }

                        echo $image_src;
                        exit();

                    break;               

                }

            }

        }



        foreach (Upload::get_errors() as $file)
        {
            // $file is an array with all file information,
            // $file['errors'] contains an array of all error occurred
            // each array element is an an array containing 'error' and 'message'

            print '<pre>';
            var_dump( $file['errors'] ); 

        }

    }


}