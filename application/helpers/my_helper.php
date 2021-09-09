<?php defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('my_crypt'))
{
    function my_crypt($string, $action = 'e' )
    {
        $secret_key = strtolower(str_replace(" ", '_', APP_NAME)).'_key';
	    $secret_iv = strtolower(str_replace(" ", '_', APP_NAME)).'_iv';

	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    $key = hash( 'sha256', $secret_key );
	    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

	    if( $action == 'e' ) {
	        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
	    }
	    else if( $action == 'd' ){
	        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
	    }

	    return $output;
    }   
}

if ( ! function_exists('re'))
{
    function re($array='')
    {
        echo "<pre>";
        print_r($array);
        exit;
    }
}

if ( ! function_exists('e_id'))
{
    function e_id($id)
    {
        return $id * 44545;
    }
}

if ( ! function_exists('d_id'))
{
    function d_id($id)
    {
        return $id / 44545;
    }
}

if ( ! function_exists('admin'))
{
    function admin($url='')
    {
        return ADMIN.'/'.$url;
    }
}

if ( ! function_exists('b_asset'))
{
    function b_asset($url='')
    {
        return base_url('assets/back/'.$url);
    }
}

if ( ! function_exists('flashMsg'))
{
    function flashMsg($success, $succmsg, $failmsg, $redirect)
    {
        $CI =& get_instance();
        
        if ($success)
            $CI->session->set_flashdata(['title' => 'Success | ','notify' => 'success', 'message' => $succmsg]);
        else
            $CI->session->set_flashdata(['title' => 'Error ! ', 'notify' => 'danger', 'message' => $failmsg]);
        
        return redirect($redirect);
    }
}

if ( ! function_exists('auth'))
{
    function auth()
    {
        $CI =& get_instance();
        
        return (object) $CI->user;
    }
}

if ( ! function_exists('check_ajax'))
{
    function check_ajax()
    {
        $CI =& get_instance();
        if (!$CI->input->is_ajax_request())
            die;
    }
}

if ( ! function_exists('check_access'))
{
    function check_access($name, $operation)
    {
        $CI =& get_instance();
        if (auth()->role === 'Super Admin')
            return TRUE;
        else
            if ($CI->main->check('access', ['role' => auth()->sub_role, 'sub_menu' => $name, 'operation' => $operation], 'role'))
                return TRUE;
            else
                return false;
    }
}

if ( ! function_exists('check_view_access'))
{
    function check_view_access($name)
    {
        $CI =& get_instance();
        if (auth()->role === 'Super Admin')
            return TRUE;
        else
            if ($CI->main->check('access', ['role' => auth()->sub_role, 'sub_menu' => $name, 'operation' => 'view'], 'role'))
                return TRUE;
            else
                $data['name'] = 'error 403';
                $data['title'] = 'error 403';
                die($CI->template->load('template', 'error_403', $data, TRUE));
    }
}

if ( ! function_exists('in_array_r'))
{
    function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }
}

if ( ! function_exists('convert_webp'))
{
    function convert_webp($path, $image, $name) {
        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);
        imagewebp($image, "$path$name.webp", 100);
        imagedestroy($image);
    }
}