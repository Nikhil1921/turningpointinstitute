<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = 'home/error_404';
$route['translate_uri_dashes'] = TRUE;

$route['pdf/(:num)/(:any)'] = 'home/pdf/$1/$2';


$route[ADMIN.'/forgot-password'] = ADMIN.'/login/forgot_password';
$route[ADMIN.'/checkOtp'] = ADMIN.'/login/checkOtp';
$route[ADMIN.'/changePassword'] = ADMIN.'/login/changePassword';
$route[ADMIN.'/role']['post'] = ADMIN.'/role/get';
$route[ADMIN.'/navigation']['post'] = ADMIN.'/navigation/get';
$route[ADMIN.'/operation']['post'] = ADMIN.'/operation/get';
$route[ADMIN.'/user']['post'] = ADMIN.'/user/get';
$route[ADMIN.'/banner']['post'] = ADMIN.'/banner/get';
$route[ADMIN.'/ebook']['post'] = ADMIN.'/ebook/get';
$route[ADMIN.'/student']['post'] = ADMIN.'/student/get';
$route[ADMIN.'/freeStudents']['post'] = ADMIN.'/freeStudents/get';
$route[ADMIN.'/question']['post'] = ADMIN.'/question/get';
$route[ADMIN.'/purchase']['post'] = ADMIN.'/purchase/get';
$route[ADMIN.'/membership']['post'] = ADMIN.'/membership/get';
$route[ADMIN.'/moduleVideo']['post'] = ADMIN.'/moduleVideo/get';
$route[ADMIN.'/module']['post'] = ADMIN.'/module/get';
$route[ADMIN.'/chapter']['post'] = ADMIN.'/chapter/get';
$route[ADMIN.'/subChapter']['post'] = ADMIN.'/subChapter/get';
$route[ADMIN.'/book']['post'] = ADMIN.'/book/get';
$route[ADMIN.'/followUp']['post'] = ADMIN.'/followUp/get';