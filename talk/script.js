window.onload = function() {
    var form = document.getElementById('form');
    var container = document.getElementById('container');
        
    // 下までスクロールする
    var scrollToBottom = () => {
        container.scrollTop = container.scrollHeight;
    };
    
    // 一番下までスクロールしているかどうか
    var isScrollBottom = () => {
        return container.scrollHeight === container.scrollTop + container.offsetHeight;
    };
    
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        e.stopPropagation();
    // 一番下までスクロールされていれば追加後も一番下までスクロールする
        if (isScrollBottom()) {
            scrollToBottom();
        }
        // 一番下までスクロールされていなければスクロールしない
        else {
        }
    });
};
