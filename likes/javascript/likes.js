document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.actions button.unlike').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            unlikeUser(userId, this);
        });
    });
});

function unlikeUser(userId, button) {
    console.log("削除:", userId);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../likes/unlike.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        const userItem = button.closest('.flex');
                        userItem.remove();
                    } else {
                        console.error(response.message);
                    }
                } catch (error) {
                    console.error('レスポンスの解析に失敗しました:', error);
                }
            } else {
                console.error('いいね削除処理に失敗しました:', xhr.status, xhr.statusText);
            }
        }
    };
    xhr.send('user_id=' + userId);
}
