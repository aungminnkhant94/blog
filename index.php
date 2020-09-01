<?php
session_start();
require 'config/config.php';
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('Location:login.php');
}
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
<h1 class="text-blue-500 text-4xl text-center upppercase tracking-wide font-semibold mb-5">Welcome to my blog</h1>

<?php
  $stmt=$pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
  $stmt->execute();
  $result=$stmt->fetchAll();
?>

<div class="grid lg:grid-cols-3 gap-4">
<?php if($result){
      foreach($result as $value) {
?>
	<div class="card mx-auto">
	<div class="bg-gray-800 max-w-sm rounded overflow-hidden shadow-lg border-gray-600 mb-6">
		  <img class="object-scale-down h-48 w-full" src="admin/images/<?php echo $value['image'] ?>" alt="">
		  <div class="px-6 py-6">
			  <div class="font-bold text-xl mb-2">
				  <?php echo $value['title'] ?>
			  </div>
			  <p class="text-black-900 text-base">
			  <?php echo substr($value['content'],0,50)?>
			  </p>
		  </div>
	  </div>
	</div>
	<?php
	  }
	}?>
</div>


</body>
</html>