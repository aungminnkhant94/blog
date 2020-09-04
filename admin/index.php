<?php
session_start();
require '../config/config.php';
require '../config/common.php';
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('Location:index.php');
}

if ($_SESSION['role'] != 1) {
  header('Location: login.php');
}

if ($_SESSION['role'] != 1) {
  header('Location: login.php');
}

if ($_POST['search']) {
  setcookie('search',$_POST['search'], time() + (86400 * 30), "/");
}else{
  if ($_GET['pageno']) {
    unset($_COOKIE['search']); 
    setcookie('search', null, -1, '/'); 
  }
}
?>

<?php
include('../main/header.html');
?>

<!--Container-->
<div class="container w-full mx-auto pt-20">
<div class="flex flex-row mx-auto ">
<a href="add.php"class="square-full bg-green-500 mb-3 px-5 py-3 text-white ">Create New</a>
</div>
<div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-600 leading-normal">

<div class="flex flex-row flex-wrap flex-grow mt-2">
<div class="bg-gray-900 border border-gray-800 rounded shadow">
<table class="table-fixed container mx-auto ">

<thead>
<tr class="border-b border-gray-800">
<th class="border px-4 py-2 px-4 py-2">ID</th>
<th class="border px-4 py-2 px-4 py-2">Title</th>
<th class="border px-4 py-2 px-4 py-2">Content</th>
<th class="border px-4 py-2 px-4 py-2">Actions</th>
</tr>
</thead>

<?php

if(!empty($_GET['pageno'])){
  $pageno=$_GET['pageno'];
}else{
  $pageno=1;
}
$numOfrecs=3;
$offset=($pageno-1)* $numOfrecs;

if(empty($_POST['search']) && !isset($_COOKIE['search'])){
  $stmt=$pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
  $stmt->execute();
  $rawresult=$stmt->fetchAll();
  $total_pages=ceil(count($rawresult)/$numOfrecs);
  
  $stmt=$pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrecs");
  $stmt->execute();
  $result=$stmt->fetchAll();
}else{
  $searchKey=$_POST['search'] ? $_POST['search']:$_COOKIE['search'];
  $stmt=$pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC");
  $stmt->execute();
  $rawresult=$stmt->fetchAll();
  $total_pages=ceil(count($rawresult)/$numOfrecs);
  
  $stmt=$pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
  $stmt->execute();
  $result=$stmt->fetchAll();
}

?>

<tbody >
<?php
if($result){
  $i=1;
  foreach ($result as $value){
    ?>
    <tr >
    <td class="border px-4 py-2 text-center"><?php echo $i; ?></td>
    <td><?php echo escape($value['title'])?></td>
    <td><?php echo escape(substr($value['content'],0,50))?></td>
    <td class="border px-4 py-2 text-center ">
    <a href="edit.php?id=<?php echo $value['id'];?>"class="square-full bg-yellow-500 px-4 py-2 text-white mr-2">Edit</a>
    <a href="delete.php?id=<?php echo $value['id'];?>"
    onclick="return confirm('Are you sure you want to delete this?')"
    class="square-full bg-red-500 px-3 py-2 text-white">Delete</a>
    </td>
    </tr>
    
    <?php
    $i++;
  }
}
?>


</tbody>

</table>
</div>
</div>

<!--/ Console Content-->			
</div>


</div> 
<!--/container-->

<?php
include('../main/pagination.html');
?>

<?php
include('../main/footer.html');
?>


</body>
</html>

