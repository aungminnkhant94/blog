<?php
session_start();
require 'config/config.php';
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('Location:login.php');
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stmt->execute();
$result=$stmt->fetchAll();


$blogId=$_GET['id'];

$stmtcmt = $pdo->prepare("SELECT * FROM comments WHERE post_id=$blogId");
$stmtcmt->execute();
$cmResult=$stmtcmt->fetchAll();

if ($_POST){
    $comment=$_POST['comment'];

        $stmt=$pdo->prepare("INSERT INTO comments (content,author_id,post_id) VALUES (:content,:author_id,:post_id)");
        $result=$stmt->execute(
            array(':content'=>$comment,':author_id'=>$_SESSION['user_id'],':post_id'=>$blogId)
        );
        if($result){
            header('Location:blogdetail.php?id='.$blogId);
        }


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
<h1 class="text-blue-500 text-4xl text-center upppercase tracking-wide font-semibold mb-5"><?php echo $result[0]['title'] ?></h1>
<div class="card">
  <img class="object-cover  w-full" src="admin/images/<?php echo $result[0]['image'] ?>" alt="Sunset in the mountains">
  <div class="px-6 py-4">
    <p class="text-gray-500 text-lg ">
      <?php echo $result[0]['content'] ?>
    </p>
  </div>

<!-- comment form -->
<div class="flex  shadow-lg  mx-8 mb-4">
   <form class="w-full  px-4 pt-2"method="post">

      <div class="flex flex-wrap -mx-3 mb-6">
         <h2 class="px-4 pt-3 pb-2 text-gray-600 text-lg">Add a new comment</h2>
         <div class="w-full md:w-full px-3 mb-2 mt-2">
         <div class="container font-bold text-2xl mb-0 text-gray-600"><?php echo $cmResult[0]['name'] ?></div>
            <textarea class="bg-gray-100 rounded border border-gray-400 leading-normal resize-none w-full h-20 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white" name="comment" placeholder='Type Your Comment' required></textarea>
         </div>

         <div class="w-full md:w-full flex items-start md:w-full px-3">
            <div class="-mr-1">
               <input type='submit' class="bg-white text-gray-700 font-medium py-1 px-4 border border-gray-400 rounded-lg tracking-wide mr-1 hover:bg-gray-100" value='comment'>
            </div>
         </div>
      </form>
   </div>
</div>
</div>
</body>
</html>

