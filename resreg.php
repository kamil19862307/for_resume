<?
//Добавление записи, если данные пришли		
if($_SERVER['REQUEST_METHOD']=='POST'){
	$prof = $_POST['prof'];
	$i = 0;
	foreach($prof as $prof_id) {
		// Достаю из массива профессии -- из чекбокса и проверяю на количество
		$i++;
		if($i==6){ 
			header('location: index.php?id=thankyou');
			$_SESSION['answer'] = 'Ошибка! Вы выбрали больше чем пять профессий, это недопустимо. Попробуйте ещё раз.';
			exit;
			break;
		}
	}
	$name = clearStr($_POST['name']);
	$lastname = clearStr($_POST['lastname']);
	$surname = clearStr($_POST['surname']);
	$birthdate = clearStr($_POST['date']);
	$pasport = clearStr($_POST['pasport']);
	$adres = clearStr($_POST['adres']);
	$email = clearStr($_POST['email']);	
	$opis = clearStr($_POST['opis']);
	$tel = clearStr($_POST['tel']);
	$lang = clearStr($_POST['lang']);
	
	
	//$img_tmp = $_FILES['image']['tmp_name'];
	//$img = $_FILES['image']['name'];
	// Перезапишем переменные для удобства
	$filePath  = $_FILES['image']['tmp_name'];
	$errorCode = $_FILES['image']['error'];
	// Проверим на ошибки
	if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($filePath)) {
		// Массив с названиями ошибок
		$errorMessages = array(
			UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
			UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
			UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
			UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
			UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
			UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
			UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
		);
		// Зададим неизвестную ошибку
		$unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';
		// Если в массиве нет кода ошибки, скажем, что ошибка неизвестна
		$outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;
		// Выведем название ошибки
		die($outputMessage);
	}
	// Создадим ресурс FileInfo
	$fi = finfo_open(FILEINFO_MIME_TYPE);
	// Получим MIME-тип
	$mime = (string) finfo_file($fi, $filePath);
	// Закроем ресурс
	finfo_close($fi);
	// Проверим ключевое слово image (image/jpeg, image/png и т. д.)
	if (strpos($mime, 'image') === false) die('Можно загружать только изображения.');
	// Результат функции запишем в переменную
	$image = getimagesize($filePath);
	// Зададим ограничения для картинок
	$limitBytes  = 1024 * 1024 * 5;
	$limitWidth  = 1280;
	$limitHeight = 768;
	// Проверим нужные параметры
	if (filesize($filePath) > $limitBytes) die('Размер изображения не должен превышать 5 Мбайт. Уменьшите размер картинки');
	if ($image[1] > $limitHeight)          die('Высота изображения не должна превышать 768 точек. Уменьшите размер картинки');
	if ($image[0] > $limitWidth)           die('Ширина изображения не должна превышать 1280 точек. Уменьшите размер картинки');
	// Сгенерируем новое имя файла на основе MD5-хеша
	$img = md5_file($filePath);
	// Сгенерируем расширение файла на основе типа картинки
	$extension = image_type_to_extension($image[2]);
	// Сократим .jpeg до .jpg
	$format = str_replace('jpeg', 'jpg', $extension);
	// Переместим картинку с новым именем и расширением в папку /pics
	$img = $img . $format;


	
	$sql = "INSERT INTO gallery (foto, name, lastname, surname, birthdate, pasport, adres, tel, opis, lang, email) VALUES ('$img', '$name', '$lastname', '$surname', '$birthdate', '$pasport', '$adres', '$tel', '$opis', '$lang', '$email')";
	mysqli_query($link, $sql) or die(mysqli_error($link));

	$main_id = mysqli_insert_id($link);//узнаю айди последнего запроса
	foreach($prof as $prof_id) {
		// Достаю из массива профессии -- из чекбокса и Вставляю в отдельную таблицу. Объединяющую две таблицы vacancy , vacancy name = resume_add
		$sql = "INSERT INTO resume_add (job_id, resume_id) VALUES ('$prof_id', '$main_id')";
		mysqli_query($link, $sql) or die(mysqli_error($link));
		}

	mkdir("images/items/$main_id", 0777) or die('Не могу создать директорию');//создаю отдельную папку под каждый товар

	if (!move_uploaded_file($filePath, "images/items/$main_id/$img")) {
		die('При записи изображения на диск произошла ошибка.');
	}
	//move_uploaded_file($img_tmp, "images/items/$main_id/$img");

	header('location: index.php?id=thankyou');
	$_SESSION['answer'] = 'Спасибо! Ваше резюмэ появится на сайте сразу после проверки модератором.';
	exit;
	}
?>
<script type="text/javascript">
$(document).ready(function ()
{
    $('#addProf').click(function ()
    {
        $('#files').append('<select style="background: #F0F0E9; margin-bottom: 10px; width: 60%; display: inline" class="form-control rounded-0" name="prof[]"><option>Выберите профессию</option><?$sqll = "SELECT id, name FROM vacancy_name";$ress = mysqli_query($link, $sqll) or die(mysqli_error($link));while($row = mysqli_fetch_assoc($ress)){	$name = $row["name"];$prof_id = $row["id"];?><option value="<?=$prof_id?>"><?=$name?></option><?}?></select>');
		
    });
 
});</script>
<section id="cart_items">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
			  <li><a href="index.php">Главная</a></li>
			  <li class="active">Создать резюмэ</li>
			</ol>
		</div><!--/breadcrums-->

		<div class="step-one">
			<h2 class="">Шаг 1</h2>
		</div>
		<div class="checkout-options">
			<h3>Создайте своё резюмэ</h3>

		</div><!--/checkout-options-->

		<div class="register-req">
			<p>Обратите внимание, что надо обязательно заполнить поле "Дополнительно о себе". Там выможете подробно рассказать о своих преимуществах перед другими участниками данного сайта. Работодатель всегда обращает внимание на это поле. Так-же все данные будут передаваться работодателям. Если Вы согласны на распространение своих данных, то нажмите ссылку ниже. Всю отведственность за внесённые на сайт данные несёт пользователь внёсший данные. Администрация сайта не несёт никакой отведственности за введённые пользователём данные на сайт. Администрация сайта может не разделять взгляды пользователя. Сайт использует технологию Java Script, пользователи отключившие данную технологию автоматически являются нарушителями законадательста об отведственности вторых сторон (владельцы данного сайта (hrd-uz.com)). Максимум можно выбрать ТОЛЬКО пять профессий!</br></br> <a data-toggle="collapse" href="#hide">Я согласен с условиями лицензионного соглашения!</a></p>
		</div><!--/register-req-->

	<div class="collapse" id="hide">

		<div class="shopper-informations">
			<div class="row">
				<div class="col-sm-5">
					<div class="shopper-info">
						<p>Заполните все поля</p>
					
						<form method="post" enctype="multipart/form-data" action="">
							<select style="background: #F0F0E9; margin-bottom: 10px; width: 60%; display: inline" class="form-control rounded-0" name="prof[]">
							<option>Выберите профессию</option>
<?
$sqll = "SELECT id, name
			FROM vacancy_name";
$ress = mysqli_query($link, $sqll) or die(mysqli_error($link));
while($row = mysqli_fetch_assoc($ress)){
	$prof_id = $row['id'];
	$name = $row['name'];
?>
								<option value="<?=$prof_id?>"><?=$name?></option>
<?
}
?>
							</select>
							<input type="button" class="btn btn-primary" value="Добавить профессию" id="addProf" style="width: 35%; margin: 0 0 10px 15px">
							
							<div id="files"></div>

							<input class="form-control rounded-0" type="text" placeholder="Фамилия" name="lastname" required>
							<input class="form-control rounded-0" type="text" placeholder="Имя" name="name" required>
							<input class="form-control rounded-0" type="text" placeholder="Отчество" name="surname" required>
							<input class="form-control rounded-0" type="text" placeholder="Паспорт" name="pasport" required>
				<input class="form-control rounded-0" type="text" name="date" placeholder="Дата рождения dd.mm.yyyy" style="width:70%; display: inline" required>
				<input type="button" style="background: url('css/datepicker.jpg') no-repeat; width: 30px; margin: 5px; padding: 5px; border: 0px;" onclick="displayDatePicker('date', false, 'dmy', '.'); refreshDatePicker('date', 1990, 0, 1)">
							<input class="form-control rounded-0" type="text" placeholder="Адрес" name="adres" required>
							<input class="form-control rounded-0" type="text" placeholder="Телефон" name="tel" required>
							<input class="form-control rounded-0" type="text" placeholder="Email" name="email" required>
							<input class="form-control rounded-0" type="text" placeholder="Знание языков" name="lang">
							<!--<input type="text" placeholder="Возраст">
							<input type="text" placeholder="Рост">
							<input type="text" placeholder="Вес">
							<input type="text" placeholder="Семейное положение">
							<input type="text" placeholder="Дата регистрации">-->
					</div>
				</div>

				<div class="col-sm-7">
					<div class="order-message">
						<p>Дополнительно о себе</p>
						<textarea style="background: #F0F0E9;" class="form-control rounded-0" rows="10" name="opis"  placeholder="Здесь вы можете описать все ваши хорошие качества и преимущества"></textarea>
						<p>
							Добавить фото
						</p>
						<input class="btn btn-primary" type="file" name="image"/><br />						
						<input type="reset" class="btn btn-primary" value="Очистить поля">
						<input type="submit" class="btn btn-primary" value="Продолжить">
						</form>
					</div>	
				</div>					
			</div>
		</div>
		<h2>Ваше резюмэ появится на сайте только после проверки модератором!</h2>
		</div><!--/#Hide-->
		
	</div>
</section> <!--/#cart_items-->