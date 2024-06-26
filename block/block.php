<!-- モーダルの表示(ポップアップ表示)　ブロック -->
<section id="block">
    <!-- <h3>ブロックしますか？</h2> -->
    <form action="./block.php" method="post">
        <button type="submit" name="check" value="1">はい</button>
        <button type="submit" name="check" value="0">いいえ</button>
    </form>
</section>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Modaal/0.4.4/js/modaal.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>

<?php
require '../db-connect.php';
$pdo=new PDO($connect,USER,PASS);


?>