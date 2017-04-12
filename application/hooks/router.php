<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );
 
class Router {
     
    //private static $_format = '';
     
    /*public function route() {
       // print_r($_SERVER['REQUEST_URI']);
      //  exit;
        $request                = strstr( $_SERVER['REQUEST_URI'], '?', true );
       // print_r($request);
        //var_dump($request);
        if ( !$request ) {
            $request            = $_SERVER['REQUEST_URI'];
        }
        $parts                  = explode( '.', $request );
        self::$_format          = $parts[ sizeof($parts) - 1 ];
         
        if ( self::$_format == 'json' || self::$_format == 'xml' || self::$_format == 'rss' || self::$_format == 'atom' ) {
            $_SERVER['REQUEST_URI'] = substr( $request, 0, ( strlen( $request ) - strlen( self::$_format ) - 1 ) );
        } else {
            self::$_format  = '';
        }
    }*/

    public function config() {

        $CI =& get_instance();
      //  $CI->config->set_item('response_format', self::$_format);
        //print_r($CI->uri->segment(3));
        $data = $CI->input->get();
        $data['id'] = 2;
        $CI->config->set_item('data', $data);
        //redirect('Welcome');
        //$data = $CI->input->post();
        //print_r(self::$_format);
        //print_r($_REQUEST);
    }
}
?>