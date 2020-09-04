<?php
session_start();
require '../config/config.php';
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('Location:index.php');
}

if ($_SESSION['role']!=1){
    header('Location:login.php');
}
if($_POST){
    if (empty($_POST['title']) || empty($_POST['content']) || empty($_FILES['image'])) {
        if (empty($_POST['title'])) {
          $titleError = 'Title cannot be null';
        }
        if (empty($_POST['content'])) {
          $contentError = 'Content cannot be null';
        }
        if (empty($_FILES['image'])) {
          $imageError = 'Image cannot be null';
        }
    }else{
        $file = 'images/'.($_FILES['image']['name']);
        $imageType = pathinfo($file,PATHINFO_EXTENSION);
    
        if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
          echo "<script>alert('Image must be png,jpg,jpeg')</script>";
        }else{
          $title = $_POST['title'];
          $content = $_POST['content'];
          $image = $_FILES['image']['name'];
          move_uploaded_file($_FILES['image']['tmp_name'],$file);

          $stmt = $pdo->prepare("INSERT INTO posts(title,content,author_id,image) VALUES (:title,:content,:author_id,:image)");
          $result = $stmt->execute(
              array(':title'=>$title,':content'=>$content,':author_id'=>$_SESSION['user_id'],':image'=>$image)
          );
          if ($result) {
            echo "<script>alert('Successfully added');window.location.href='index.php';</script>";
          }
        }
        header('Location:index.php');
    }
}

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
                            <label  class="block mb-2 uppercase font-bold text-xs text-gray-700"
                                    for="title">
                                    Title
                                </label>
                                <p class="bg-red"><?php echo empty($titleError) ? '' : '*'.$titleError; ?></p>
                            <input  class="border border-gray-400 p-2 w-full"
                                    type="text"
                                    name="title"
                                    id="title"
                                    value=""
                            >
                        </div>

                        <div class="mb-6">
                            <label  class="block mb-2 uppercase font-bold text-xs text-gray-700"
                                    for="content">
                                    Content
                                </label>
                                <p class="bg-red"><?php echo empty($contentError) ? '' : '*'.$contentError; ?></p>
                            <textarea class="resize-none border rounded focus:outline-none focus:shadow-outline" name="content" id="content" cols="30" rows="10"></textarea>
                        </div>

                        <div class="mb-6">
                            <label for="image">Image</label>
                            <p style="color:red"><?php echo empty($imageError) ? '' : $imageError; ?></p>
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