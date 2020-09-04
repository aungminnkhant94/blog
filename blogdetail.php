<?php
session_start();
require 'config/config.php';
require 'config/common.php';
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('Location:login.php');
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stmt->execute();
$result=$stmt->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to my blog</title>
    <meta name="description" content="description here">
    <meta name="keywords" content="keywords,here">
	
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://unpkg.com/tailwindcss/dist/tailwind.min.css" rel="stylesheet"> <!--Replace with your tailwind.css once created-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js" integrity="sha256-XF29CBwU1MWLaGEnsELogU6Y6rcc5nCkhhx89nFMIDQ=" crossorigin="anonymous"></script>

	<style>
		.bg-black-alt  {
			background:#191919;
		}
		.text-black-alt  {
			color:#191919;
		}
		.border-black-alt {
			border-color: #191919;
		}
		
	</style>

</head>

<body class="bg-black-alt font-sans leading-normal tracking-normal">
<h1 class="text-blue-500 text-4xl text-center upppercase tracking-wide font-semibold mb-5"><h4><?php echo escape($result[0]['title'])?></h4></h1>
<div class="card">
  <img class="object-cover  w-full" src="admin/images/<?php echo $result[0]['image'] ?>" alt="Sunset in the mountains">
  <div class="px-6 py-4">
    <p class="text-gray-500 text-lg ">
    <?php echo escape($result[0]['content'])?>
    </p>
  </div>

  

  <div class="box-content h-20 w-full p-4 border-4 border-gray-700 bg-gray-700">
  
  <h1 class="text-blue-500 text-4xl text-left upppercase tracking-wide font-semibold mb-5"><?php echo $auResult[0]['name'] ?></h1>







</div>
</body>
</html>

