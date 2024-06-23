// likes.js
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.actions button.unlike').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            unlikeUser(userId, this);
        });
    });

    document.querySelectorAll('.actions button.like').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            likeUser(userId);
        });
    });
});

function unlikeUser(userId, button) {
    console.log("削除:", userId);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../likes/unlike.php'); // いいね削除を処理するPHPファイルへのパスを指定
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                // UIの更新
                const userItem = button.closest('.flex');
                userItem.remove();
            } else {
                console.error('いいね削除処理に失敗しました');
            }
        }
    };
    xhr.send('user_id=' + userId);
}

function likeUser(userId) {
    console.log("いいね:", userId);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../matchs/match.php'); // いいねを処理するPHPファイルへのパスを指定
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                // 必要に応じてUIを更新
            } else {
                console.error('いいね処理に失敗しました');
            }
        }
    };
    xhr.send('user_id=' + userId);
}
