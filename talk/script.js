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
$(".modal-open").modaal({
start_open:flag, // ページロード時に表示するか
overlay_close:true,//モーダル背景クリック時に閉じるか
before_open:function(){// モーダルが開く前に行う動作
  $('html').css('overflow-y','hidden');/*縦スクロールバーを出さない*/
},
after_close:function(){// モーダルが閉じた後に行う動作
  $('html').css('overflow-y','scroll');/*縦スクロールバーを出す*/
}
});

// topの文字折り返し用
