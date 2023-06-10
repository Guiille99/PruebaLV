<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
       body{
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
       }
       .container{
        max-width: 600px;
        padding: 10px 20px;
        margin: 0 auto;
        background-color: #f4f4f4;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
       }
       .header{
        padding: 50px 15px;
        margin-bottom: 20px;
       }
       .header .title{
        color: #f4f4f4;
        font-size: 1.2rem;
        font-weight: bolder;
        width: 30%;
        text-align: center;
       }
       h1{
        color: #333333;
       }
       p{
        color: #666666;
        line-height: 1.5;
       }
       .btn{
            display: inline-block;
            padding: 8px 18px;
            background-color: #2d3748;
            color: #fff !important;
            border-radius: 3px;
            border: none;
            text-decoration: none;
        }
        .btn:hover{
            background-color: #212a39;
            cursor: pointer;
        }
        .logo__container{
            text-align: center;
            margin-bottom: 20px;
        }
        .logo__container img{
            max-width: 150px;
            height: auto;
        }
        table{
            border-collapse: collapse;
            border-color: #b0aeae;
        }
        th,td{
            padding: 5px;
        }

       @media only screen and (max-width: 600px){
        .container{
            padding: 10px;
        }
       }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo__container">
            <img src="https://res.cloudinary.com/det0ae4ke/image/upload/v1685874349/books/logo-nombre_xvupzm.png" alt="Books">
        </div>
        @yield('content')
    </div>
</body>
</html>