function showTab(tabId) {
    const tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => {
        tab.classList.remove('active');
    });
    document.querySelector(`.tab[onclick="showTab('${tabId}')"]`).classList.add('active');

    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(content => {
        content.classList.remove('active');
    });
    document.getElementById(tabId).classList.add('active');
}

function likeUser(userId) {
    console.log("いいね:", userId);
    
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../matchs/match.php'); // マッチングを処理するPHPファイルへのパスを指定
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
            } else {
                console.error('マッチング処理に失敗しました');
            }
        }
    };
    xhr.send('user_id=' + userId); // ユーザーIDをPOSTリクエストで送信
}

function unlikeUser(userId) {
    console.log("削除:", userId);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'unlike.php'); // いいね削除を処理するPHPファイルへのパスを指定
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
            } else {
                console.error('いいね削除処理に失敗しました');
            }
        }
    };
    xhr.send('user_id=' + userId); // ユーザーIDをPOSTリクエストで送信
}
