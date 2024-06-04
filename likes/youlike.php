<?php require '../menu/menu.html';?>
<?php
    const SERVER = 'mysql301.phy.lolipop.lan';
    const DBNAME = 'LAA1517801-friends';
    const USER = 'LAA1517801';
    const PASS = 'pass0625';
 
    $connect = 'mysql:host='. SERVER . ';dbname='. DBNAME . ';charset=utf8';
?>
<head>
    <link rel="stylesheet" href="../menu/menu.css">
</head>

<body>
    <button onclick="location.href='./ilike.php'">いいねした人</button><img src="../menu-image/like-free-icon.png" class="">あなたへいいね<img src="../image/unlike.svg" class="">
    <hr></hr>
    <div id="liked_user_id">
    <script>
        const userId = 1; // 表示したいユーザーのID

        function fetchLikes(type, containerId) {
            fetch(`/${type}.php?user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById(containerId);
                    if (data.message) {
                        container.innerHTML = `<p>${data.message}</p>`;
                    } else {
                        const list = document.createElement('ul');
                        data.forEach(like => {
                            const listItem = document.createElement('li');
                            listItem.textContent = like.username;
                            list.appendChild(listItem);
                        });
                        container.appendChild(list);
                    }
                })
                .catch(error => console.error('Error fetching likes:', error));
        }

        fetchLikes('likes_given', 'likes-given');
        fetchLikes('likes_received', 'likes-received');
    </script>
</body>
</html>