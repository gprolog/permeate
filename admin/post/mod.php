<?php
	header("content-type:text/html;charset=utf-8");
	include "../public/demon.php";
	include "../conf/dbconfig.php";
	include "../includes/mysql_func.php";
?>
<?php
	
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}

	if(!empty($_POST['cid'])){
		$cid = $_POST['cid'];
		$title = $_POST['title'];
		$content = $_POST['content'];
		
		$sql = "update ".DB_PRE."post set cid='$cid',title='$title',content='$content' where id='$id'";

		$row = mysql_func($sql);
		if(!$row===0){
			echo "<script>alert('抱歉！更新用户名失败，请稍后再试！')</script>";
			echo "<script>window.location.href='list.php'</script>";
			exit;
		}
		//执行过程中没有出现意外，将跳转到LIST列表当中
		echo "<script>window.location.href='./list.php'</script>";
		exit;
	}
	//POST不存在，将查询表中数据
	$sql = "select p.*,c.cname from ".DB_PRE."post as p,".DB_PRE."cate as c where p.cid=c.id and p.id='$id'";
	$row = mysql_func($sql);
	$post = $row[0];
?>
<div class="container">
<table >
<form action="mod.php?id=<?php echo $id ?>" method="post" >
		<?php $sql = "select * from ".DB_PRE."cate";
		$row1 = mysql_func($sql); ?>
   <tr><td>所属板块：</td><td><select name="cid"> 
		<?php foreach($row1 as $cate){?>
		<option value="<?php echo $cate['id'] ?>" >
		<?php echo $cate['cname'] ?></option><?php } ?>
	</select></td></tr>
	<tr><td>主题：</td><td><input type="text" name="title" value="<?php echo $post['title'] ?>" /></td></tr>
	<tr><td>内容：</td><td><input type="text" name="content" value="<?php echo $post['content'] ?>" /></td></tr>
	<tr><td colspan=2><input type="submit" value="确定修改" class="btn btn-default navbar-btn" />
	<input type="reset" value="重新填写" class="btn btn-default navbar-btn" /></td></tr>
</form>
</table>
</div>