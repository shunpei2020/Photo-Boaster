'use strict';
{
   // モーダル
   const modal = () => {
    // コメントモーダル
    const cBtn = document.querySelector('.c-btn i');
    const modal = document.querySelector('.modal');
    const mask = document.querySelector('.mask');
    cBtn.addEventListener('click' , () => {
      modal.classList.add('modal-active');
      mask.classList.add('mask-active');
    });
  
    //コメント送信
    const form = document.querySelector('form');
    const text = document.querySelector('.form textarea');
    const msg = document.querySelector('.msg');
    const submit = document.querySelector('.submit');
    submit.addEventListener('click', () => {
      if(!text.value) {
        msg.innerText = '※コメントが入力されていません！';
        return;
      }
      if(text.value.length > 144) {
        msg.innerText = '※コメントが長すぎます！(144文字以内)';
        return;
      }
      if(!confirm('送信しますか？')) {
        return;
      } 
      form.submit();
      
    });
  
    //コメントキャンセル
    const cancel = document.querySelector('.cancel');
    cancel.addEventListener('click', () => {
      text.value = '';
      msg.innerText = '';
      modal.classList.remove('modal-active');
      mask.classList.remove('mask-active');
    });
  }
  modal();
}