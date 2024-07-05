window.onload = function() {
    var my_talk = document.getElementById('my_talk');
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

onMounted(() => {
    const observer = new MutationObserver((mutation) => {
        my_talk.value.scrollTo({
        top: 10000,
        behavior: "smooth"
      });
    });
    observer.observe(messageAreaElement.value, {
      childList: true
    });
  });

// let target = document.getElementById('scroll-inner');
// target.scrollIntoView(false);

// ケバブメニューのjs
// "use strict";
// $(function () {
//   const hamburger = $(".kebabu");
//   const nav = $(".nav");

//   hamburger.click(function () {
//     $(this).find(".kebab-ball").toggleClass("is_active");
//     nav.toggleClass("is_active");
//   });
// });


//モーダル表示
function openSubWindow() {
  document.querySelector('.bg_sub_window').style.visibility = 'visible';
  document.querySelector('.bg_sub_window').style.opacity = '1';
  document.querySelector('.bg_sub_window').style.pointerEvents = 'auto';
  document.querySelector('.bg_sub_window').style.position = 'fixed';
  document.querySelector('.bg_sub_window').style.zIndex = '5';
}

function closeSubWindow() {
  document.querySelector('.bg_sub_window').style.visibility = 'hidden';
  document.querySelector('.bg_sub_window').style.opacity = '0';
  document.querySelector('.bg_sub_window').style.pointerEvents = 'none';
}

function fetchUpdates() {
  fetch('talk2.php')
      .then(response => response.text())
      .then(data => {
          document.getElementById('content').innerHTML = data;
      })
      .catch(error => console.error('Error:', error));
}