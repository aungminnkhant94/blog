<?php

session_start();
require 'config/config.php';
if ($_POST){
    $name =$_POST['name'];
    $email =$_POST['email'];
    $password=$_POST['password'];

    $stmt=$pdo->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->bindValue(':email',$email);
    $stmt->execute();
    $user=$stmt->fetch(PDO::FETCH_ASSOC);

    if($user){
        echo"<script>alert('This email already registered')</script>";
    }else{
        $stmt=$pdo->prepare("INSERT INTO users (name,email,password) VALUES (:name,:email,:password)");
        $result=$stmt->execute(
            array(':name'=>$name,':email'=>$email,':password'=>$password)
        );
        if($result){
            echo "<script>alert('Successfully Register,You can now login');window.location.href='login.php';</script>";
        }
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Please Register to read a blog</title>
    <meta name="description" content="description here">
    <meta name="keywords" content="keywords,here">
	
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://unpkg.com/tailwindcss/dist/tailwind.min.css" rel="stylesheet"> <!--Replace with your tailwind.css once created-->

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
<body class="bg-black-alt font-sans ">

<div class="font-bold text-3xl text-gray-600 text-center mb-8">Please Kindly register</div>

<div class="container mx-auto flex justify-center ">
    <div class="px-12 py-4 bg-gray-200 border border-gray-400 rounded-lg">
        <div class="col-md-8">
                
                    <form method="POST" action="">

                        
                        <div class="mb-6">
                            <label  class="block mb-2 uppercase font-bold text-xs text-gray-700"
                                    for="name">
                                    Name
                                </label>
                            <input  class="border border-gray-400 p-2 w-full"
                                    type="text"
                                    name="name"
                                    id="name"
                                    value=""
                            >
                        </div>

                        <div class="mb-6">
                            <label  class="block mb-2 uppercase font-bold text-xs text-gray-700"
                                    for="email">
                                    Email
                                </label>
                            <input  class="border border-gray-400 p-2 w-full"
                                    type="email"
                                    name="email"
                                    id="email"
                            >
                        </div>

                        <div class="mb-6">
                            <label  class="block mb-2 uppercase font-bold text-xs text-gray-700"
                                    for="password">
                                    Password
                                </label>
                            <input  class="border border-gray-400 p-2 w-full"
                                    type="password"
                                    name="password"
                                    id="password"
                            >
                        </div>

                        <div>
                            <button type="submit"
                                    class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500 mr-2">
                                    Register
                                </button>
                                <a href="login.php"class="bg-indigo-400 text-white rounded py-2 px-4 hover:bg-indigo-500 mr-2"">Back</a>

                        </div>

                    </form>
                </div>
    </div>
</div>
</body>
</html>