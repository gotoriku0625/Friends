<?php require '../db-connect.php';?>
<?php require '../menu/menu.html';?>
<body>
        <div class="main">
            <div class="pro-log">
                <p>プロフィール</p>
                    <form action="/logout">
                        <input type="submit" value="ログアウト">
                    </form>
            </div>
                <hr>
            <form action="profile.php" method="post">
            <p>サブ写真</p>
                <image>
            <p>ユーザー名</p>
            <p>自己紹介</p>
                <input type="text"size="100"style="line-height: 4;" name="introduce">
            <p>趣味/特技</p>
                <input type="text"size="100"style="line-height: 4;" name="hobby">
            <p>性別</p>
                <select id="sex" name="sex">
                    <option value="man">男</option>
                    <option value="woman">女</option>
                    <option value="another">その他</option>
                </select>
            <p>年齢</p>
                <input type="text">
            <p>血液型</p>
                <select id="blood" name="blood">
                    <option value="a">A</option>
                    <option value="b">B</option>
                    <option value="o">O</option>
                    <option value="ab">AB</option>
                </select>
            <p>学校</p>
                <input type="text" name="name">
            <p>出身地</p>
                <select id="hometown">
                    <option value="北海道">北海道</option>
                    <option value="青森県">青森県</option>
                    <option value="iwate">岩手県</option>
                    <option value="miyagi">宮城県</option>
                    <option value="akita">秋田県</option>
                    <option value="yamagata">山形県</option>
                    <option value="fukushima">福島県</option>
                    <option value="ibaraki">茨城県</option>
                    <option value="tochigi">栃木県</option>
                    <option value="gunma">群馬県</option>
                    <option value="saitama">埼玉県</option>
                    <option value="chiba">千葉県</option>
                    <option value="tokyo">東京都</option>
                    <option value="kanagawa">神奈川県</option>
                    <option value="niigata">新潟県</option>
                    <option value="toyama">富山県</option>
                    <option value="ishikawa">石川県</option>
                    <option value="fukui">福井県</option>
                    <option value="yamanashi">山梨県</option>
                    <option value="nagano">長野県</option>
                    <option value="gifu">岐阜県</option>
                    <option value="shizuoka">静岡県</option>
                    <option value="aichi">愛知県</option>
                    <option value="mie">三重県</option>
                    <option value="shiga">滋賀県</option>
                    <option value="kyoto">京都府</option>
                    <option value="osaka">大阪府</option>
                    <option value="hyogo">兵庫県</option>
                    <option value="nara">奈良県</option>
                    <option value="wakayama">和歌山県</option>
                    <option value="tottori">鳥取県</option>
                    <option value="shimane">島根県</option>
                    <option value="okayama">岡山県</option>
                    <option value="hiroshima">広島県</option>
                    <option value="yamaguchi">山口県</option>
                    <option value="tokushima">徳島県</option>
                    <option value="kagawa">香川県</option>
                    <option value="ehime">愛媛県</option>
                    <option value="kochi">高知県</option>
                    <option value="fukuoka">福岡県</option>
                    <option value="saga">佐賀県</option>
                    <option value="nagasaki">長崎県</option>
                    <option value="kumamoto">熊本県</option>
                    <option value="oita">大分県</option>
                    <option value="miyazaki">宮崎県</option>
                    <option value="kagoshima">鹿児島県</option>
                    <option value="okinawa">沖縄県</option>
                </select>
            <p>居住地</p>
                <select id="residence">
                    <option value="hokkaido">北海道</option>
                    <option value="aomori">青森県</option>
                    <option value="iwate">岩手県</option>
                    <option value="miyagi">宮城県</option>
                    <option value="akita">秋田県</option>
                    <option value="yamagata">山形県</option>
                    <option value="fukushima">福島県</option>
                    <option value="ibaraki">茨城県</option>
                    <option value="tochigi">栃木県</option>
                    <option value="gunma">群馬県</option>
                    <option value="saitama">埼玉県</option>
                    <option value="chiba">千葉県</option>
                    <option value="tokyo">東京都</option>
                    <option value="kanagawa">神奈川県</option>
                    <option value="niigata">新潟県</option>
                    <option value="toyama">富山県</option>
                    <option value="ishikawa">石川県</option>
                    <option value="fukui">福井県</option>
                    <option value="yamanashi">山梨県</option>
                    <option value="nagano">長野県</option>
                    <option value="gifu">岐阜県</option>
                    <option value="shizuoka">静岡県</option>
                    <option value="aichi">愛知県</option>
                    <option value="mie">三重県</option>
                    <option value="shiga">滋賀県</option>
                    <option value="kyoto">京都府</option>
                    <option value="osaka">大阪府</option>
                    <option value="hyogo">兵庫県</option>
                    <option value="nara">奈良県</option>
                    <option value="wakayama">和歌山県</option>
                    <option value="tottori">鳥取県</option>
                    <option value="shimane">島根県</option>
                    <option value="okayama">岡山県</option>
                    <option value="hiroshima">広島県</option>
                    <option value="yamaguchi">山口県</option>
                    <option value="tokushima">徳島県</option>
                    <option value="kagawa">香川県</option>
                    <option value="ehime">愛媛県</option>
                    <option value="kochi">高知県</option>
                    <option value="fukuoka">福岡県</option>
                    <option value="saga">佐賀県</option>
                    <option value="nagasaki">長崎県</option>
                    <option value="kumamoto">熊本県</option>
                    <option value="oita">大分県</option>
                    <option value="miyazaki">宮崎県</option>
                    <option value="kagoshima">鹿児島県</option>
                    <option value="okinawa">沖縄県</option>
                </select>
            <p>休日の過ごし方</p>
                <input type="text"size="100"style="line-height: 4;" name="holiday">
                <form>
                    <label for="option1">
                    <input type="checkbox" id="option1" name="options" value="Option 1">
                    飲酒
                </label>
                <label for="option2">
                    <input type="checkbox" id="option2" name="options" value="Option 2">
                    喫煙
                </label>
            <br>
            <form action="../top/top.html">
                <input type="submit" value="保存">
            </form>
            <form action="../login/login.html">
                <input type="submit" value="キャンセル">
            </form>
        </div>
    </body>
</html>
