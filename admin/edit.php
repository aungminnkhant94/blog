<?php

session_start();
require '../config/config.php';
require '../config/common.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('Location:index.php');
}

if($_POST){
    if(empty($_POST['title'])||empty($_POST['content'])){
        if (empty($_POST['title'])) {
            $titleError = 'Title cannot be null';
          }
          if (empty($_POST['content'])) {
            $contentError = 'Content cannot be null';
          }
    }else{
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
    }

    if($_FILES['image']['name']!=null){
        $file ='images/'.($_FILES['image']['name']);
        $imageType=pathinfo ($file,PATHINFO_EXTENSION);

        if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg'){
            echo "<script>alert('Image Extension not found')</script>";
        }else{
            $image=$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],$file);
            
            $stmt=$pdo->prepare("UPDATE posts SET title='$title',content='$content',image='$image' WHERE id='$id' ");
            $result=$stmt->execute();
            if($result){
                echo "<script>alert('Successfully Updated');window.location.href='index.php';</script>";
            }
        }
    }
}

$stmt =$pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stmt->execute();

$result=$stmt->fetchAll();

?>

<?php
include('../main/header.html');
?>

<div class="static mx-auto mt-auto flex justify-center pt-10  ">
    <div class="px-12 py-4 bg-gray-200 border border-gray-400 rounded-lg">
        <div class="col-md-8">
                
                    <form method="POST" action=""enctype="multipart/form-data">
                    <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                        <div class="mb-6">
                        <input type="hidden"name="id"value="<?php echo $result[0]['id'] ?>">
                            <label  class="block mb-2 uppercase font-bold text-xs text-gray-700"
                                    for="title">
                                    Title
                                </label>
                            <input  class="border border-gray-400 p-2 w-full"
                                    type="text"
                                    name="title"
                                    id="title"
                                    value="<?php echo escape($result[0]['title'])?>"
                            >
                        </div>

                        <div class="mb-6">
                            <label  class="block mb-2 uppercase font-bold text-xs text-gray-700"
                                    for="content">
                                    Content
                                </label>
                            <textarea class="resize-none border rounded focus:outline-none focus:shadow-outline" name="content" id="content" cols="30" rows="10">
                            <?php echo escape($result[0]['content'])?>
                            </textarea>
                        </div>

                        <div class="mb-6">
                            <label for="image">Image</label>
                            <img src="images/<?php echo $result[0]['image'] ?>"width="150"height="150" alt="">
                            <br>
                            <input type="file"name="image"value="">
                        </div>

                        <div>

                        <input type="submit"class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500 mr-2"name=""value="SUBMIT">


                            <button type="submit"
                                    class="bg-yellow-400 text-white rounded py-2 px-4 hover:bg-yellow-500 mr-2">
                                        <a href="index.php">Back</a>
                                </button>

                        </div>

                    </form>
                </div>
    </div>
</div>

<?php
include('../main/footer.html');
?>