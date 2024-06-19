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

         //保存するフォルダの名前
        $main = 'user_image/main/';
        $sub = 'user_image/sub/';

        $subImg = array("subPhoto1", "subPhoto2", "subPhoto3");

        $fileName_main = basename($_FILES['profileIcon']['name']);//登録したいファイルの名前
        $path = $main . $fileName_main;//二つをドッキング
        $fileType_main = pathinfo($path,PATHINFO_EXTENSION);
            
        // アイコンをサーバーのフォルダに送信
        if(!empty($_FILES['profileIcon']['name'])){
            $allowTypes = array('jpg','png','jpeg','gif');
            if(in_array($fileType,$allowTypes)){
                if(move_uploaded_file($_FILES['profileIcon']['tmp_name'],"../". $path)){
                    if (!exif_imagetype("../".$path)) {//画像ファイルかのチェック
                        if (!empty($_SERVER['HTTP_REFERER'])){
                            header("Location:". $_SERVER['HTTP_REFERER']);
                        }
                    }
                }
            }
        }

        if($_POST[$subImg[0]]){
            //登録したいファイルの名前
            $fileName_sub1 = basename($_FILES[$subImg[0]]['name']);
            //二つをドッキング
            $subpath1 = $sub . $fileName_sub1;
            $fileType_sub1 = pathinfo($subpath1,PATHINFO_EXTENSION);
            // 画像をサーバーにアップロード
            if(!empty($_FILES[$subImg[0]]['name'])){
                $allowTypes = array('jpg','png','jpeg','gif');
                if(in_array($fileType,$allowTypes)){
                    if(move_uploaded_file($_FILES[$subImg[0]]['tmp_name'],"../". $path)){
                        if (!exif_imagetype("../".$path)) {//画像ファイルかのチェック
                            if (!empty($_SERVER['HTTP_REFERER'])){
                                header("Location:". $_SERVER['HTTP_REFERER']);
                            }
                        }
                    }
                }
            }
        }
        if($_POST[$subImg[1]]){
            //登録したいファイルの名前
            $fileName_sub1 = basename($_FILES[$subImg[1]]['name']);
            //二つをドッキング
            $subpath2 = $sub . $fileName_sub2;
            // 画像パスの拡張子を変数に入れる
            $fileType_sub2 = pathinfo($subpath2,PATHINFO_EXTENSION);
            if(!empty($_FILES[$subImg[1]]['name'])){
                $allowTypes = array('jpg','png','jpeg','gif');
                if(in_array($fileType,$allowTypes)){
                    if(move_uploaded_file($_FILES[$subImg[1]]['tmp_name'],"../". $path)){
                        //画像ファイルかのチェック
                        if (!exif_imagetype("../".$path)) {
                            if (!empty($_SERVER['HTTP_REFERER'])){
                                header("Location:". $_SERVER['HTTP_REFERER']);
                            }
                        }
                    }
                }
            }
        }
        if($_POST[$subImg[2]]){
            //登録したいファイルの名前
            $fileName_sub1 = basename($_FILES[$subImg[2]]['name']);
            //二つをドッキング
            $subpath3 = $sub . $fileName_sub3;
            // 画像パスの拡張子を変数に入れる
            $fileType_sub3 = pathinfo($subpath3,PATHINFO_EXTENSION);
            if(!empty($_FILES[$subImg[2]]['name'])){
                $allowTypes = array('jpg','png','jpeg','gif');
                if(in_array($fileType,$allowTypes)){
                    if(move_uploaded_file($_FILES[$subImg[2]]['tmp_name'],"../". $path)){
                        //画像ファイルかのチェック
                        if (!exif_imagetype("../".$path)) {
                            if (!empty($_SERVER['HTTP_REFERER'])){
                                header("Location:". $_SERVER['HTTP_REFERER']);
                            }
                        }
                    }
                }
            }
        }
        $update =    
        $select='select user_id from user mail=?';
        $id = $pdo->prepare($select);
        $id->execute($_SESSION['user']['id']);

        // 全てのサブ写真が設定されている場合
        if($_POST['subPhoto1']&&$_POST['subPhoto2']&&$_POST['subPhoto3']){
            $insert='insert into profile values (null,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
            $sql=$pdo->prepare($insert);
            $sql->execute([
                $id,$_POST['selfIntro'],$_POST['hobbies'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['message'],$_POST['profileIcon'],
                $_POST['subPhoto1'],$_POST['subPhoto2'],$_POST['subPhoto3'],$drinking,$smoking
            ]);
        // 1つ目のサブ写真が設定されている場合
        }else if($_POST['subPhoto1']){
            // 2つ目のサブ写真が設定されている場合
            if($_POST['subPhot2']){
                $insert='insert into profile values (null,?,?,?,?,?,?,?,?,?,?,?,?,?,null,?,?)';
                $sql=$pdo->prepare($insert);
                $sql->execute([
                    $id,$_POST['selfIntro'],$_POST['hobbies'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                    $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['message'],$_POST['profileIcon'],
                    $_POST['subPhoto1'],$_POST['subPhoto2'],$drinking,$smoking
                ]);
            // 2つ目のサブ写真が設定されている場合
            }else if($_POST['subPhot3']){
                $insert='insert into profile values (null,?,?,?,?,?,?,?,?,?,?,?,?,null,?,?,?)';
                $sql=$pdo->prepare($insert);
                $sql->execute([
                    $id,$_POST['selfIntro'],$_POST['hobbies'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                    $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['message'],$_POST['profileIcon'],
                    $_POST['subPhoto1'],$_POST['subPhoto3'],$drinking,$smoking
                ]);
            }
            // 1つ目のサブ写真のみが設定されている場合
            $insert='insert into profile values (null,?,?,?,?,?,?,?,?,?,?,?,?,null,null,?,?)';
            $sql=$pdo->prepare($insert);
            $sql->execute([
                $id,$_POST['selfIntro'],$_POST['hobbies'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['message'],$_POST['profileIcon'],
                $_POST['subPhoto1'],$drinking,$smoking
            ]);
        // 2つ目のサブ写真が設定されている場合
        }else if($_POST['subPhoto2']){
            // 3つ目のサブ写真が設定されている場合
            if($_POST['subPhot3']){
                $insert='insert into profile values (null,?,?,?,?,?,?,?,?,?,?,?,null,?,?,?,?)';
                $sql=$pdo->prepare($insert);
                $sql->execute([
                    $id,$_POST['selfIntro'],$_POST['hobbies'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                    $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['message'],$_POST['profileIcon'],
                    $_POST['subPhoto2'],$_POST['subPhoto3'],$drinking,$smoking
                ]);
            }
            // 1つ目のサブ写真のみが設定されている場合
            $insert='insert into profile values (null,?,?,?,?,?,?,?,?,?,?,?,null,?,null,?,?)';
            $sql=$pdo->prepare($insert);
            $sql->execute([
                $id,$_POST['selfIntro'],$_POST['hobbies'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['message'],$_POST['profileIcon'],
                $_POST['subPhoto2'],$drinking,$smoking
            ]);
        // 3つ目のみに画像が設定されている場合
        }else{
            $insert='insert into profile values (null,?,?,?,?,?,?,?,?,?,?,?,null,null,?,?,?)';
            $sql=$pdo->prepare($insert);
            $sql->execute([
                $id,$_POST['selfIntro'],$_POST['hobbies'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['message'],$_POST['profileIcon'],
                $_POST['subPhoto3'],$drinking,$smoking
            ]);
        }
        // ｾｯｼｮﾝに性別、年齢、アイコン画像を設定
        foreach($sql as $row){
            $_SESSION['user']=[
                'gender'=>$row['gender'],'age'=>$row['age'],'icon'=>$row['icon_image']
            ];
        }
        // トップへ飛ぶ
        header("Location: ../top/top.php");
        exit;
    }
?>