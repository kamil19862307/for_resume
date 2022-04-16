
<script type="text/javascript">
$(document).ready(function ()
{
    $('#addFoto').click(function ()
    {
        $('#files').append('<input name="userfile[]" type="file" multiple/><br>');
    });
 
});</script>

<?
//Добавление записи, если данные пришли		
// ИСКЛЮЧИТЕЛЬНО в данном проекте мы ПОЛНОСТЬЮ доверяем админу сайта - проверка на пришедшие данные не ведётся
if($_SERVER['REQUEST_METHOD']=='POST'){
	$title = $_POST['title'];
	$opis = $_POST['opis'];
	$price = $_POST['price'];
	$kategory = $_POST['kategory'];
	$size = $_POST['size'];
	$weight = $_POST['weight'];
	$radio = $_POST['show'];
	$img = $_FILES['image']['name'];
	$img_tmp = $_FILES['image']['tmp_name'];
	
	
if($radio==1)
	$show = 1;

else
	$show = 0;

$sql = "INSERT INTO gallery (foto, title, price, opis, activ, size, weight, kategory) VALUES ('$img', '$title', '$price', '$opis', $show, '$size', '$weight', '$kategory')";
mysqli_query($link, $sql) or die(mysqli_error($link));

$main_id = mysqli_insert_id($link);//узнаю айди последнего запроса

mkdir("../images/items/$main_id", 0777) or die('Не могу создать директорию');//создаю отдельную папку под каждый товар

move_uploaded_file($img_tmp, "../images/items/$main_id/$img");

if(isset($_FILES["userfile"])){
	foreach ($_FILES["userfile"]["error"] as $key => $error) {
		if ($error == UPLOAD_ERR_OK) {
			$tmp_name = $_FILES["userfile"]["tmp_name"][$key];
			$img2 = $_FILES["userfile"]["name"][$key];
			move_uploaded_file($tmp_name, "../images/items/$main_id/$img2");
			$sql = "INSERT INTO item_foto (main_id, img, name) VALUES ($main_id, '$img', '$img2')";

			mysqli_query($link, $sql) or die(mysqli_error($link));
		}
	}
}
header('location: index.php?id=gallery');
$_SESSION['answer'] = 'add_ok';
exit;
}
?>
<form method="post" enctype="multipart/form-data" action="">
<table width="95%">
			<tr>
				<td width="125px"><b>Основное фото</b></td>
				<td>
					<input type="file" name="image" size="35"/><br />
				</td>
				<td rowspan="5"><img src="../images/no-image.jpg" width="300" height="300"></td>
			</tr>
			<tr>
				<td width="125px"><b>Доп. фото</b></td>
				<td>
					<input type="file" name="userfile[]" size="35" multiple/><br />
					<div id="files"></div>
					<input type="button" value="Добавить ещё фото" id="addFoto">
				</td>
			</tr>
			<tr>
				<td width="125px"><b>Название</b></td>
				<td><input type="text" size="35" name="title"></input></td>
			</tr>
			<tr>
				<td><b>Цена</b></td>
				<td><input type="text" size="35" name="price"></input></td>
			</tr>
			<tr>
				<td><b>Размеры</b></td>
				<td><input type="text" size="35" name="size"></input></td>
			</tr>
			<tr>
				<td><b>Вес</b></td>
				<td><input type="text" size="35" name="weight"></input></td>
			</tr>
			<tr>
				<td><b>Категория</b></td>
				<td>
<?
$sql = "SELECT name FROM kategory";
$res = mysqli_query($link, $sql);
while($row = mysqli_fetch_assoc($res)){
	$kategory = $row['name'];
?>
				<input type="radio" size="35" name="kategory" value="<?=$kategory?>"><?=$kategory?></input><br>
<?}?>
			</td>
			</tr>
			<tr>
			<td><b>Сделать активным?</b></td>
				<td>
					<input type="radio" name="show" value="1" checked>Да&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="show" value="0">Нет
				</td>
			</tr>
			
			<tr>
				<td><b>Описание</b></td>
				<td colspan="2"><textarea name="opis"></textarea></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="2">
				<input type="submit" class="button" value="Сохранить">
				<input type="reset" class="button" value="Сбросить">
				</td>
			</tr>
		</table>
</form>