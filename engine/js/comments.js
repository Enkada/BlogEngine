
if (commentsData != null) {
    document.querySelector('#comments > h2').innerHTML = `Комментарии: ${commentsData.length} `;

    var commentList = document.getElementById('comment-list');
    var commentTemplate = document.getElementById('template-comment');

    var commentName = commentTemplate.content.querySelector('.comment-name');
    var commentText = commentTemplate.content.querySelector('.comment-text');
    var commentDate = commentTemplate.content.querySelector('.comment-date');
    var commentDelete = commentTemplate.content.querySelector('#btn-delete-comment');

    var months = ["Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря"];
    addComment();
}

function addComment(index = 0) {
    if (index + 1 > commentsData.length) { return; }

    comment = commentsData[index];

    commentName.innerHTML = comment['name'];
    commentText.innerHTML = comment['text'];

    var d = new Date(comment['date']);    
    commentDate.innerHTML = `${d.toLocaleTimeString('ru-RU', { hour: "numeric", minute: "numeric"})} ${d.getDate()} ${months[d.getMonth()]}, ${d.getFullYear()}`;
      
    if (commentDelete != null) {
        commentDelete.setAttribute('data-comment-id', comment['id']);
    }

    commentList.append(commentTemplate.content.cloneNode(true));

    setTimeout(() => {
        addComment(++index);
    }, 300);
}

function deleteComment(comment) {
    showYesNoDialog("Удаление комментария", "Вы действительно хотите удалить данный комментарий?", "engine/delete_comment.php?id=" + comment.getAttribute('data-comment-id'));
}