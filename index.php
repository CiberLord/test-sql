<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .columns{
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
            grid-template-rows: auto;
            font-size: 30px;
        }
        .columns>div{
            margin: 10px 12px;
            color: blueviolet;
            padding: 10px 0px;
            text-align: center;
        }
        .item{
            font-size: 18px;
            color: #000 !important;
        }
    </style>
    <title>sql test</title>
</head>
<body>
<?
    $host="localhost"; 
    $db_name="testdb";
    $login="root"; //пользователь
    $password="root"; //пароль для получения доступа к mysql
    $users="users"; //имя таблицы пользователей
    $objects="objects"; //имя таблицы обьектов

    echo "connect to sql <br>";

    //соединение с sql
    $link= mysqli_connect($host,$login,$password); //подключению к mysql

    // создание новой бд если его не существует
    $query="CREATE DATABASE $db_name";
    $res = mysqli_query($link,$query);
    if($res==false){
        echo "такая бд уже существует <br>";
    }else{
        echo "бд создана <br>";
    }
    //выбор бд
    mysqli_select_db($link,$db_name);

    //создать таблицу users 
    $query="CREATE TABLE $users
    (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        login VARCHAR(200) NOT NULL,
        password VARCHAR(200) NOT NULL,
        object_id INT NOT NULL)";
    $res = mysqli_query($link,$query);
    if($res==false){
        echo mysqli_error($link),"<br>";
    }else{
        echo "таблица $users успешно создана <br>";
    }

    //создать таблицу objects
    $query="CREATE TABLE $objects
    (
        id INT NOT NULL, 
        name VARCHAR(30) NOT NULL,
        status INT NOT NULL)";//запрос на создание новой таблицы
    $res = mysqli_query($link,$query);
    if($res==false){
        echo mysqli_error($link),"<br>";
    }else{
        echo "таблица objects успешно создана <br>";
    }

    //заполнение данными таблицы users

    $query='INSERT INTO users VALUES(NULL, "login", "432lamp", 101),
    (NULL, "loggin324", "heroe432", 102),
    (NULL, "login123", "853211", 103),
    (NULL, "login999", "54band54", 105)';

    $res = mysqli_query($link,$query);
    if($res==false){
        echo mysqli_error($link),"<br>";
    }else{
        echo "данные users успешно записаны <br>";
    }

    //заполнение данными таблицы objects

    $query="INSERT INTO objects VALUES(122, 'andrey', 1),
    (101, 'vladimir', 2),
    (103, 'антон', 3)";

    $res = mysqli_query($link,$query);
    if($res==false){
        echo mysqli_error($link),"<br>";
    }else{
        echo "данные $objects успешно записаны <br>";
    }

    // ВЫПОЛНЕНИЕ ВЫБОРКИ МЕТОДОМ JOIN INNER !!!

    $query="SELECT * FROM $users INNER JOIN $objects ON $users.object_id = $objects.id";
    $res = mysqli_query($link,$query);
    if($res==fasle){
        echo mysqli_error($link);
    }else{
        echo "<h2>вывод результата работы выборки методом INNER JOIN</h2>";
        echo '<div class="columns"><div>id</div><div>login</div><div>password</div><div>objects_id</div><div>id</div><div>name</div><div>status</div>';
        while($row = mysqli_fetch_row($res)){
            for($index=0;$index<count($row);$index++){
                echo "<div class=\"item\">$row[$index]</div>";
            }
        }
        echo "</div>";
    }


    //очистка данных с таблиц
    $res = $query="DELETE FROM users";
    $res= mysqli_query($link,$query);
    $query="DELETE FROM objects";
    $res= mysqli_query($link,$query);
?>
</body>
</html>