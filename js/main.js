'use strict';
{
  const posts = document.querySelectorAll('.posting');
  posts.forEach(post => {
    post.addEventListener('click', () => {
      if(!confirm('実行してよろしいですか？')) {
        return;
      }
      post.parentNode.submit();
    });
  });
}