<?php
    $pdo=new PDO($connect,USER,PASS);
    if(isset($_POST['btn'])&&$_POST['btn']==='submit'){

        if(isset($_POST['drinking'])){
            $drinking='yes';
        }else{
            $drinking='no';
        }
        if(isset($_POST['smoking'])){
            $smoking='yes';
        }else{
            $smoking='no';
        }

            $main = 'user_image/main/';//保存するフォルダの名前
            $fileName_main = basename($_FILES['profileIcon']['name']);//登録したいファイルの名前
            $sub = 'user_image/sub/';
            $fileName_sub1 = basename($_FILES['subPhoto1']['name']);
            $fileName_sub2 = basename($_FILES['subPhoto2']['name']);
            $fileName_sub3 = basename($_FILES['subPhoto3']['name']);
            $path = $main . $fileName_main;//二つをドッキング
            $fileType = pathinfo($path,PATHINFO_EXTENSION);
            
            if(!empty($_FILES['subPhoto1']['name'])){
                $allowTypes = array('jpg','png','jpeg','gif');
                if(in_array($fileType,$allowTypes)){
                    if(move_uploaded_file($_FILES['image']['tmp_name'],"../". $path)){
                        if (exif_imagetype("../".$path)) {//画像ファイルかのチェック
                        } else {
                        }
                    }
                }
            }

       if($_POST['subPhoto1']&&$_POST['subPhoto2']&&$_POST['subPhoto3']){

       }else if($_POST['subPhoto1']){

            
       }
        $select='select user_id from user mail=?';
        $insert='insert into profile values (null,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

        $id = $pdo->prepare($select);
        $id->execute($_SESSION['user']['id']);
        $sql=$pdo->prepare($insert);
        $sql->execute([
            $id,$_POST['selfIntro'],$_POST['hobbies'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
            $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['message'],$_POST['profileIcon'],
            $_POST['subPhoto1'],$_POST['subPhoto2'],$_POST['subPhoto3'],$drinking,$smoking
        ]);
        foreach($sql as $row){
            $_SESSION['user']=[
                'gender'=>$row['gender'],'age'=>$row['age'],'icon'=>$row['icon_image']
            ];
        }
        header("Location: ../top/top.php");
        exit;
    }
?>