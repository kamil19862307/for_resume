<?php
switch($id){
	case 'vacancy': include 'inc/vacancy.php'; break;
	case 'vacancy-details': include 'inc/vacancy-details.php'; break;
	case 'resume': include 'inc/resume.php'; break;
	case 'search': include 'inc/search.php'; break;
	case 'search_prof': include 'inc/search_prof.php'; break;
	case 'resreg': include 'inc/resreg.php'; break;
	case 'contact': include 'inc/contact.php'; break;
	case 'resdet': include 'inc/resdet.php'; break;
	case 'newdet': include 'inc/newdet.php'; break;
	case 'news': include 'inc/news.php'; break;
	case 'imp_news': include 'inc/imp_news.php'; break;
	case 'oth_news': include 'inc/oth_news.php'; break;
	case 'thankyou': include 'inc/thankyou.php'; break;
	case 'home': include 'inc/index.php'; break;
	case 'about': include 'inc/about.php'; break;
	case 'login': include 'inc/login.php'; break;
	case 'unauthorized': include 'inc/unauthorized.php'; break;
	default: include 'inc/index.php';
}