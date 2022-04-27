<?
session_start();
setlocale(LC_ALL, 'ru_RU.utf8');// Устанавливаю локаль для даты
include_once 'inc/headers.php';//тут титлы, заголовки и id страницы
include_once 'inc/config.php';//соединение с базой, Возвращает объект, представляющий подключение к серверу MySQL.
include_once 'inc/lib.php';//библиотека функций
include_once 'inc/contact.inc.php';//запрос к переменным с контактами
ini_set("display_errors","1");
if (version_compare(phpversion(), "5.0.0", ">")==1) {
	ini_set("error_reporting", E_ALL | E_STRICT);
} else {
	ini_set("error_reporting", E_ALL);
}
if(isset($_POST['clientEmail'])){
	$client_email = clearStr($_POST['clientEmail']);
	if(!preg_match('/\A[^@]+@([^@\.]+\.)+[^@\.]+\z/', $client_email)){
		echo"<script>alert('Введите корректный адрес');
			document.location.href = 'index.php'</script>";
			exit;
	}
	$sql="SELECT email FROM client_email WHERE email='$client_email'";
	$run=mysqli_query($link, $sql) or die(mysqli_error($link));
	if(mysqli_num_rows($run)>0){
		echo"<script>alert('Такая почта уже существует');
			document.location.href = 'index.php'</script>";
			exit;
	}
	$sql="INSERT INTO client_email (email) VALUES('$client_email')";
	mysqli_query($link, $sql) or die(mysqli_error($link));
	echo"<script>alert('Ваша почта добавлена');
	document.location.href = 'index.php'</script>";
	exit;
}
ob_start();
if(isset($_GET['logout'])) logout();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-41199583-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-41199583-2');
</script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Кадровое агентство, Рекрутинговое агентство мы помогаем в трудоустройстве за рубежом (Корея, Европа)">
    <meta name="author" content="">
    <title>Кадровое агентство | Главная</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script><!-- От кнопки "добавить ещё фото" -->

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
	<script src="js/datepicker.js" type="text/javascript" charset="UTF-8" language="javascript"></script><!--Календарь-->
	<link rel="stylesheet" type="text/css" href="css/datepicker.css" /><!--Календарь-->
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills" style="margin: 0 10px">
								<li><a href="tel:+79297213040"><i class="fa fa-phone"></i> +998 00 00 00 00</a></li>
								<li><span style="position: relative; display: block; padding: 8px 15px;"><i class="fa fa-envelope"></i> info@example.com</span></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4" style="width: 45%">
						<div class="logo pull-left">
							<a href="index.php"><img src="images/logo.jpg" alt="" /></a>
						</div>
						<div class="btn-group pull-right">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									Русский
									<span class="caret"></span>
									<img src="images/home/rus.jpg" class="rounded pull-right" style="width:40px; height:20px; margin-left: 5px">
								</button>
								<ul class="dropdown-menu" style="min-width: 180px;">
									<li><a href="http://en.hrd-uzb.com<?=$_SERVER['REQUEST_URI']?>">English<img src="images/home/eng.jpg" class="rounded pull-right" style="width:40px; height:20px;"></a></li>
									<!--<li><a href="#">Uzbekcha<img src="images/home/uzb.jpg" class="rounded pull-right" style="width:40px; height:20px;"></a></li>-->
									<!--<li><a href="http://kor.hrd-uzb.com<?=$_SERVER['REQUEST_URI']?>">한국어<img src="images/home/kor.jpg" class="rounded pull-right" style="width:40px; height:20px;"></a></li>-->
								</ul>
							</div>
							
						<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									Андижан
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">Каракалпакстан</a></li>
									<li><a href="#">Бухара</a></li>
									<li><a href="#">Андижан</a></li>
									<li><a href="#">Джиззак</a></li>
									<li><a href="#">Кашкадарьё</a></li>
									<li><a href="#">Навои</a></li>
									<li><a href="#">Наманган</a></li>
									<li><a href="#">Самарканд</a></li>
									<li><a href="#">Сурхандарьё</a></li>
									<li><a href="#">Сырдарья</a></li>
									<li><a href="#">Ташкент</a></li>
									<li><a href="#">Фергана</a></li>
									<li><a href="#">Хорезм</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-sm-8" style="width: 55%;">
						<div class="shop-menu pull-right">
						<p><H3>Сайт не работает, все вакансии и резюме не действительны!</H3></p>
							<ul class="nav navbar-nav">
								<!--<li><a href="index.php?id=resume"><i class="fa fa-user"></i> Резюмэ</a></li>
								<li><a href="#"><i class="fa fa-star"></i> Понравившиеся</a></li>-->
								<li><a href="index.php?id=resreg"><i class="fa fa-crosshairs"></i>Создать резюмэ</a></li>
<?
if(isset($_SESSION['guest'])){
	echo '<li><a href="#"><i class="fa fa-star"></i> Понравившиеся</a></li>';	
	echo '<li><a href="index.php?logout"><i class="fa fa-lock"></i> Выйти</a></li>';	
	}
else echo '<li><a href="index.php?id=login"><i class="fa fa-lock"></i> Войти</a></li>';
?>
								
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.php?id=home" class="active">Главная</a></li>
								<li><a href="index.php?id=about">О нас</a></li>
								<li class="dropdown"><a href="#">Меню<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="index.php?id=vacancy">Все вакансии</a></li>
										<li><a href="index.php?id=resume">Все резюмэ</a></li> 
										<li><a href="index.php?id=resreg">Создать резюмэ</a></li> 
										<li><a href="index.php?id=login">Войти</a></li> 
                                    </ul>
                                </li> 
								<li class="dropdown"><a href="index.php?id=news">Новости<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="index.php?id=news">Все новости</a></li>
										<li><a href="index.php?id=imp_news">Важные новости</a></li>
                                        <li><a href="index.php?id=oth_news">Разные новости</a></li>
                                    </ul>
                                </li> 
								<li><a href="index.php?id=contact">Контакты</a></li>
								<!-- <li><a href="index.php?id=search">Поиск</a></li> -->
							</ul>
						</div>
					</div>
<?
/*
if(isset($_GET['id'])){///////////////////////////////////   ПОИСК
if($_GET['id']=='resume'){
	echo ('
					<div class="col-sm-3">
						<form role="search" action="index.php?id=search" method="POST">
						<div class="search_box pull-right">
							<input type="text" placeholder="Поиск резюмэ" name="word">
							<button type="submit" class="btn btn-sm" style="
								background-image: url(../images/home/searchicon.png);
								background-repeat: no-repeat;
								background-position: center center;
								height: 35px;
								width: 25px;"></button>
						</div>
						</form>
					</div>
');
}
}
*/
?>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
		

				
<!--ROUTING--><!--ROUTING--><!--ROUTING--><!--ROUTING--><!--ROUTING--><!--ROUTING--><!--ROUTING-->		
<?
	include_once 'inc/routing.inc.php';
?>
<!--ROUTING--><!--ROUTING--><!--ROUTING--><!--ROUTING--><!--ROUTING--><!--ROUTING--><!--ROUTING-->

	
	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<div class="logo pull-left">
							<a href="index.php"><img src="images/logo.jpg" alt="" /></a>
						</div>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="images/home/iframe1.png" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="images/home/iframe2.png" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="images/home/iframe3.png" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="images/home/iframe4.png" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="address">
							<img src="images/home/map.png" alt="" />
							<p style="font-size: 16px; font-weight: 500; color: #666663; top: 22px; text-transform: uppercase;">Адрес адрес адрес.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Работа</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Работа в Корее</a></li>
								<li><a href="#">Работа в Польше</a></li>
								<li><a href="#">Работа в Германии</a></li>
								<li><a href="#">Работа в АОЕ</a></li>
								<li><a href="#">Работа в Турции</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Учёба</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Учёба в Корее</a></li>
								<li><a href="#">Учёба в Польше</a></li>
								<li><a href="#">Учёба в Германии</a></li>
								<li><a href="#">Учёба в АОЕ</a></li>
								<li><a href="#">Учёба в Турции</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Наши партнёры</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="vktm.uz" target="_blank">Центр оценки квалицикций и знаний</a></li>
								<li><a href="#">Обучающий центр</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Карта сайта</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">О нас</a></li>
								<li><a href="#">Новости</a></li>
								<li><a href="#">Добавить резюмэ</a></li>
								<li><a href="#">Все резюмэ</a></li>
								<li><a href="#">Контакты</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
							<h2>Подписаться на новости</h2>
							<form method="post" action="" class="searchform">
								<input type="text" name="clientEmail" placeholder="Ваш email" />
								<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
								<p>Get the most recent updates from <br />our site and be updated your self...</p>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2019 Human Resourses Agency. All rights reserved.</p>
					<p class="pull-right">Нашли ошибку <span>напишите на почту: info@example.com</span></p>
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
	

  
    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/contact.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>