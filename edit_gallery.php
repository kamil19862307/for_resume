<?
//Удаление дополнительной картинки ///////////////////////////////////////////////
/*
if(isset($_GET['del'])){
	$del = abs((int)$_GET['del']);//Чищу от всего нехорошего
	$edit_id = abs((int)$_GET['edit_id']);
	$name = $_GET['name'];
	if($del){
		$sql = "DELETE FROM item_foto WHERE id = $del";
		mysqli_query($link, $sql) or die(mysqli_error($link));
		unlink("../images/items/".$edit_id."/".$name) or die('Не могу удалить файл: '.$name);
//Чтобы запрос не отправился заново, перенаправляю на начальную ссылку	
header('location: index.php?id=edit_gallery&edit_id='.$edit_id);
exit;
	}
}
*/
//Добавление записи, если данные пришли	//////////////////////////////////////////
if($_SERVER['REQUEST_METHOD']=='POST'){
	
	$edit_id = $_POST['edit_id'];
	$name = $_POST['name'];
	$lastname = $_POST['lastname'];
	$surname = $_POST['surname'];
	$birthdate = $_POST['birthdate'];
	$show = $_POST['show'];
	$date = $_POST['date'];
	$pasport = $_POST['pasport'];
	$adres = $_POST['adres'];
	$opis = $_POST['opis'];
	$status = $_POST['status'];
	$img = $_FILES['image']['name'];
	$img_tmp = $_FILES['image']['tmp_name'];
	$hid_img = $_POST['hid_img'];
	
if(file_exists($img_tmp)){
	move_uploaded_file($img_tmp, "../images/items/$edit_id/$img");
	unlink("../images/items/".$edit_id."/".$hid_img) or die('Не могу удалить файл: '.$hid_img);
}
else
	$img = $hid_img;

$sql = "UPDATE gallery SET name='$name', opis='$opis', foto='$img', lastname='$lastname', activ=$show, surname='$surname', birthdate='$birthdate', date='$date', pasport='$pasport', adres='$adres', status='$status' WHERE id = $edit_id";

mysqli_query($link, $sql) or die(mysqli_error($link));

/*Для дополнительных фото*/////////////////////////////////////////////////////////////
/*
if(isset($_FILES["sm_img"])){
	$sm_img = $_FILES["sm_img"];
	$sm_img_hid = $_POST['sm_img_hid'];
	$sm_img['id'] = $sm_img_hid;

	foreach ($sm_img["error"] as $key => $error) {
		if ($error == UPLOAD_ERR_OK) {
			$tmp_name = $sm_img["tmp_name"][$key];
			$img2 = $sm_img["name"][$key];
			$id = $sm_img["id"][$key];
			move_uploaded_file($tmp_name, "../images/items/$edit_id/$img2");
			$sql = "UPDATE item_foto SET img='$img', name='$img2' WHERE id=$id";

			mysqli_query($link, $sql) or die(mysqli_error($link));
		}
	}
}
//Для добавляемых дополнительных фото////////////////////////////////////////////
if(isset($_FILES["userfile"])){
	foreach ($_FILES["userfile"]["error"] as $key => $error) {
		if ($error == UPLOAD_ERR_OK) {
			$tmp_name = $_FILES["userfile"]["tmp_name"][$key];
			$img3 = $_FILES["userfile"]["name"][$key];
			move_uploaded_file($tmp_name, "../images/items/$edit_id/$img3");
			$sql = "INSERT INTO item_foto (main_id, img, name) VALUES ($edit_id, '$img', '$img3')";

			mysqli_query($link, $sql) or die(mysqli_error($link));
		}
	}

}
*/

header('location: index.php?id=edit_gallery&edit_id='.$edit_id);
$_SESSION['answer'] = 'edit_ok';
exit;
	}
///////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['edit_id'])){
	$edit_id = abs((int)$_GET['edit_id']);//Чищу от всего нехорошего
//Ниже пример процедурного кода
/* 	$sql = "SELECT id, foto, name, lastname, surname, prof, birthdate, activ, date, pasport, adres, opis, status
				FROM gallery
				WHERE id = $edit_id"; */
// а тут уже ООП
	$res = $link_pdo->prepare('SELECT id, foto, name, lastname, surname, prof, birthdate, activ, date, pasport, adres, opis, status 
							FROM gallery 
							WHERE id = :edit_id');
	$res->execute(array('edit_id' => $edit_id));

	//$res = mysqli_query($link, $sql) or die(mysqli_error($link));//процедурный стиль
	foreach($res as $row){
	$id = $row['id'];
	$foto = $row['foto'];
	$name = $row['name'];
	$lastname = $row['lastname'];
	$surname = $row['surname'];
	$prof = $row['prof'];
	$birthdate = $row['birthdate'];
	$activ = $row['activ'];
	$date = $row['date'];
	$pasport = $row['pasport'];
	$adres = $row['adres'];
	$opis = $row['opis'];
	$status = $row['status'];
	}
}
?>

<!--   Добавление дополнительных фото
<script type="text/javascript">
$(document).ready(function ()
{
    $('#addFoto').click(function ()
    {
        $('#files').append('<input type="file" name="userfile[]" size="35" multiple/><br />');
    });
 
});</script>
-->
<h3>
	<?=$header?>
</h3>
<?
include_once 'inc/answer.php';
?>
<form method="post" enctype="multipart/form-data" action="">
<table width="95%" style='position: relative; bottom: 0px'>
			<tr>
				<td width="125px"><b>Основное фото</b></td>
				<td><input type="file" name="image" size="35"/><br />
				<input type="hidden" name="hid_img" value="<?=$foto?>"></input>
				<input type="hidden" name="edit_id" value="<?=$id?>"></input>
				</td>
				<td rowspan="4" colspan="2"><img src="../images/items/<?=$id?>/<?=$foto?>" width="250" height="300" title="<?=$foto?>"></td>
			</tr>
			<tr>
				<td width="125px"><b>Фамилия</b></td>
				<td><input type="text" value="<?=$lastname?>" size="35" name="lastname"></input></td>
			</tr>
			<tr>
				<td width="125px"><b>Имя</b></td>
				<td><input type="text" value="<?=$name?>" size="35" name="name"></input></td>
			</tr>
			<tr>
				<td width="125px"><b>Отчество</b></td>
				<td><input type="text" value="<?=$surname?>" size="35" name="surname"></input></td>
			</tr>
			<tr>
				<td width="125px"><b>Профессия</b></td>
				<td><input type="text" value="<?=$prof?>" size="35" name="prof"></input></td>
			</tr>
			<tr>
				<td width="125px"><b>Дата рождения</b></td>
				<td><input type="text" value="<?=$birthdate?>" size="35" name="birthdate"></input></td>
			</tr>
			<tr>
				<td width="125px"><b>Дата регистрации</b></td>
				<td><input type="text" value="<?=$date?>" size="35" name="date"></input></td>
			</tr>
			<tr>
				<td width="125px"><b>Паспорт</b></td>
				<td><input type="text" value="<?=$pasport?>" size="35" name="pasport"></input></td>
			</tr>
			<tr>
				<td width="125px"><b>Адрес</b></td>
				<td><input type="text" value="<?=$adres?>" size="35" name="adres"></input></td>
			</tr>
			<tr>
				<td width="125px"><b>Статус</b></td>
				<td><input type="text" value="<?=$status?>" size="35" name="status"></input></td>
			</tr>
			<tr>
			<td><b>Активный</b></td>
				<td>
					<input type="radio" name="show" value="1"<?if($activ==1) echo' checked';?>>Да
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="show" value="0"<?if($activ==0) echo' checked';?>>Нет
				</td>
			</tr>
			<tr>
				<td><b>Описание</b></td>
				<td colspan="3"><textarea name="opis"><?=$opis?></textarea></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="3">
				<input type="submit" class="button" value="Сохранить">
				<input type="reset" class="button" value="Сбросить">
				</td>
			</tr>
		</table>
</form>