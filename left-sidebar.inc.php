<div class="col-sm-3">
	<div class="left-sidebar">
		<h2>Вакансии</h2>
		<div class="panel-group category-products" id="accordian"><!--category-productsr-->
		
<?
$i = 0;
$job_sql = "SELECT id, name
			FROM vacancy_name
			ORDER BY ID DESC";
$job_res = mysqli_query($link, $job_sql) or die(mysqli_error($link));
while($row = mysqli_fetch_assoc($job_res)){
	$job_id = $row['id'];
	$job_name = $row['name'];
	$i++;
	if($i==11){
		echo ('<div class="collapse" id="hide">');
	}
?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordian" href="#<?=$job_name?><?=$i?>">
							<span class="badge pull-right"><i class="fa fa-plus"></i></span>
							<?=$job_name?>
						</a>
					</h4>
				</div>
				<div id="<?=$job_name?><?=$i?>" class="panel-collapse collapse">
					<div class="panel-body">
						<ul>
<?
$vacancy_add_sql = "SELECT vacancy_id
			FROM vacancy_add
			WHERE job_id = $job_id";
$vacancy_add_res = mysqli_query($link, $vacancy_add_sql) or die(mysqli_error($link));
while($row = mysqli_fetch_assoc($vacancy_add_res)){
	$vacancy_add_id = $row['vacancy_id'];

	$country_add_sql = "SELECT country_id
				FROM country_add
				WHERE vacancy_id = $vacancy_add_id";
	$country_add_res = mysqli_query($link, $country_add_sql) or die(mysqli_error($link));
	while($row = mysqli_fetch_assoc($country_add_res)){
		$country_add_id = $row['country_id'];

		$country_sql = "SELECT id, name
					FROM country_name
					WHERE id = $country_add_id";
		$country_res = mysqli_query($link, $country_sql) or die(mysqli_error($link));
		while($row = mysqli_fetch_assoc($country_res)){
			$country_id = $row['id'];
			$country_name = $row['name'];
?>
							<li><a href="index.php?id=vacancy-details&vac_id=<?=$vacancy_add_id?>"><?=$country_name?></a></li>
<?
		}
	}
}
?>
						</ul>
					</div>
				</div>
			</div>
<?
}
?>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<button type="button" class="btn btn-default usa" data-toggle="collapse" href="#hide" style="font-size: 14px; color: #333;">
						Показать все вакансии
						<span class="caret"></span>
					</button>
					<!-- <h4 class="panel-title"><a data-toggle="collapse" href="#hide">Все вакансии</a> -->
					</h4>
				</div>
			</div>	

<!-- 
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordian" href="#mens">
							<span class="badge pull-right"><i class="fa fa-plus"></i></span>
							Повар
						</a>
					</h4>
				</div>
				<div id="mens" class="panel-collapse collapse">
					<div class="panel-body">
						<ul>
							<li><a href="index.php?id=vacancy">Все</a></li>
							<li><a href="index.php?id=vacancy">Кувейт</a></li>
							<li><a href="index.php?id=vacancy">Австрия</a></li>
							<li><a href="index.php?id=vacancy">Польша</a></li>
							<li><a href="index.php?id=vacancy">ОАЭ</a></li>
							<li><a href="index.php?id=vacancy">Чехия</a></li>
						</ul>
					</div>
				</div>
			</div>
			
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title"><a href="index.php?id=vacancy">Программист</a></h4>
				</div>
			</div>
--!>
		</div><!--/category-products-->
	
		<div class="brands_products"><!--brands_products-->
			<h2>Резюмэ</h2>
			<div class="brands-name">
				<ul class="nav nav-pills nav-stacked">
					<li><a href="index.php?id=resume"> <span class="pull-right">(756)</span>Все резюмэ</a></li>
					<li><a href="index.php?id=resume"> <span class="pull-right">(89)</span>Повар</a></li>
					<li><a href="index.php?id=resume"> <span class="pull-right">(56)</span>Официант</a></li>
					<li><a href="index.php?id=resume"> <span class="pull-right">(125)</span>Продавец</a></li>
					<li><a href="index.php?id=resume"> <span class="pull-right">(67)</span>Фермер</a></li>
					<li><a href="index.php?id=resume"> <span class="pull-right">(32)</span>Нянька</a></li>
					<li><a href="index.php?id=resume"> <span class="pull-right">(74)</span>Швея</a></li>
					<li><a href="index.php?id=resume"> <span class="pull-right">(14)</span>Программист</a></li>
				</ul>
			</div>
		</div><!--/brands_products-->

		

		
		<div class="shipping text-center"><!--как формить документы-->
			<a href="http://hrd-uzb.com/index.php?id=newdet&p=52"><img height="329" width="270" src="images/home/work-in-europe.jpg" alt="Зарплата в Европе" /></a>
		</div><!--/как формить документы-->
		<div class="shipping text-center"><!--shipping-->
			<img height="329" width="270"  src="images/license2.jpg" alt="" />
		</div><!--/shipping-->
		<div class="shipping text-center"><!--shipping-->
			<a href="http://www.mbsm.uz/" target="_blank"><img height="329" width="270"  src="images/home/vktm.gif" alt="Центр оценки квалификаций и знаний" /></a>
		</div><!--/shipping-->

	
	</div>
</div>