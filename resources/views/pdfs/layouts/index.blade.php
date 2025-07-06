<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>

<style>
        body{
                font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
                margin-bottom: 100px;
        }
        .tabla{
        width: 80%;
        border: 1px solid black;
        border-radius: 5px;
        position: relative;
        background-color: #cacaca;
        left: 10%;
        padding-bottom: 100px;
        margin-top: 100px;
        z-index: 0;
        padding-top: 20px;
        padding-left: 20px;
        }
        table.desglose thead tr{
                background-color: #441111;
                color: white;
                border: 1px solid white;
                z-index: 1;
              
        }
        table tr td, table tr th{
                text-align: center;
        }
        table{
                width: 100%;
        }
        .heading{
                 display: flex;
        }
        .heading div.info-escuela, .heading div.logo{
                width: 50%;
        }
      
        .heading .info-escuela{
                float: left;
                padding-top:50px;
                padding-left: 25px;
             
        }
        .heading .info-escuela p{
                line-height: 20px;
        }
        .heading .logo img{
                margin-left: 100px; 
        }
        .heading .logo img{
                width: 250px;
        }
        table.alumno, table.alumno tr td{
                border: 1px solid black;
        }
        table.fechas, table.fechas tr td{
                border: 1px solid black;
        }
        table.fechas{
           
        }
        table.alumno{
                width: 400px;
        }
        table.sistema{
                width: 400px;
                border: 1px solid black;
                margin: auto;
        }
        .flex{
                margin-top: 100px;
                display: flex;
        }
        .total{
                float: right;
                margin-right: 50px;
                position: relative;
                bottom: -20px;
        }
  
</style>
</head>
<body>
        
                @yield('content')
   
        
</body>
</html>



    
  



   
   
    
</body>
</html>