<?php
require '../db-connect.php';
$pdo = new PDO($connect, USER, PASS);

function calculateAge($birthdate) {
    $dob = new DateTime($birthdate);
    $now = new DateTime();
    $difference = $now->diff($dob);
    return $difference->y;
}

function getLikesGiven($userId) {
    global $conn;
    $sql = "SELECT users.user_id, users.username, users.profile_image, users.birthdate FROM likes
            JOIN users ON likes.liked_id = users.user_id
            WHERE likes.liker_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $likes = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($likes as &$like) {
        $like['age'] = calculateAge($like['birthdate']);
    }

    if (empty($likes)) {
        return ["message" => "誰もいません"];
    } else {
        return $likes;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id'])) {
    $userId = intval($_GET['user_id']);
    $likesGiven = getLikesGiven($userId);
    header('Content-Type: application/json');
    echo json_encode($likesGiven);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../menu/menu.css">
    <title>menu</title>
</head>

<body>
    <div class="menu">
        <div class="logo-space">
            <a href="../top/top.html"><img src="../image/logo.png" class="logo"></a>
        </div>
        <div class="icon"></div>
        <!-- バックエンドの方、ユーザーネームの出力お願いします -->
        <div class="name">ユーザー名</div>
        <div class="link-space">
            <p><img src="../menu-image/parson-free-icon.png" class="parson-free-icon"><a href="../profile/profile.html">プロフィール</a></p>
            <p><img src="../menu-image/seach-free-icon.png" class="seach-free-icon"><a href="../search/search.php">さがす</a></p>
            <p><img src="../menu-image/like-free-icon.png" class="like-free-icon"><a href="../likes/ilike.php">いいね</a></p>
            <p><img src="../menu-image/talk-free-icon.png" class="talk-free-icon"><a href="../talk/talk.php">トーク</a></p>
            <p><img src="../menu-image/community-free-icon.png" class="community-free-icon"><a href="../community/community.php">コミュニティ</a></p>
            
        </div>
    </div>

    <div class="main">
    いいねした人<img src="../menu-image/like-free-icon.png" class=""><button onclick="location.href='./youlike.php'">あなたへいいね</button><img src="../image/unlike.svg" class="">
    <hr></hr>
    <div id="likes_user_id">
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
    </div>
</body>
</html>