'use strict';
{
  // 更新
  const posting = () => {
    const posts = document.querySelectorAll('.posting');
    const title = document.querySelector('.titles');
    const text = document.querySelector('.texts');
    const errMsg = document.querySelector('.err-msgs');
    errMsg.style.color = 'red';

    posts.forEach(post => {
      post.addEventListener('click', () => {
        if(!title.value) {
          errMsg.innerText = 'タイトルを入力してください！';
          return;
        }
        if(title.value.length > 200) {
          errMsg.innerText = 'タイトルは200文字以内で入力してください！';
          return;
        }
        if(!text.value) {
          errMsg.innerText = '本文を入力してください！';
          return;
        }
        if(!confirm('更新しますか？')) {
          return;
        }
        post.parentNode.submit();
      });
    });
  }
  posting();

}