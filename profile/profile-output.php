<?php require '../header.php';?>
</head>

<?php
    $pdo=new PDO($connect,USER,PASS);
    if(isset($_POST['btn'])&&$_POST['btn']==='submit'){
        $select='select user_id from user mail=?';
        $insert='insert into profile values (null,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

        $id = $pdo->prepare($select);
        $id->execute($_SESSION['user']['id']);
    }
?>