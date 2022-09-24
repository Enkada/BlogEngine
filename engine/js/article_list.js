if (articlesData != null) {
    var months = ["Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря"];

    var articleList = document.getElementById('article-list');
    var articleTemplate = document.getElementById('template-article');

    articlesData.forEach(article => {
        article['text'] = formatArticleText(article['text']);
    });

    var allArticles = articlesData; 

    var articleTitle = articleTemplate.content.querySelector('.article-title');
    var articleText = articleTemplate.content.querySelector('.article-body');
    var articleDate = articleTemplate.content.querySelector('.article-date');
    var articleTags = articleTemplate.content.querySelector('.article-tags');
    var articleEdit = articleTemplate.content.querySelector('.article-edit');

    addArticle(0, new URLSearchParams(window.location.search).has('q'));
}

function addArticle(index = 0, instant = false) {
    if (index + 1 > articlesData.length) { return; }

    article = articlesData[index];

    articleTitle.innerHTML = article['title'];
    articleTitle.href = "post.php?id=" + article['id'];
    if (articleEdit != null) { articleEdit.href = "edit.php?id=" + article['id']; }
    articleText.innerHTML = article['text'];

    var d = new Date(article['date'].replace(/ /g,"T"));   
    articleDate.innerHTML = `${d.getDate()} ${months[d.getMonth()]}, ${d.getFullYear()}`;

    if (article['tags'] != null) {
        articleTags.innerHTML = "";
        article['tags'].forEach(tag => {
            articleTags.innerHTML += `<a href="/?q=${tag.replace(/\<\/?mark\>/g, "")}" class='article-tag'>${tag}</a>`;
        });
    }            

    articleList.append(articleTemplate.content.cloneNode(true));

    if (!instant) {
        setTimeout(() => {
            addArticle(++index);
        }, 300);
    }
    else {
        addArticle(++index, true);
    }
}

const btnSearch = document.querySelector('#search span');
const searchInput = document.querySelector('input[type="search"]');

btnSearch.addEventListener('click', () => {
    searchInput.toggleAttribute('hidden');
    searchInput.focus();
});

searchInput.addEventListener('input', () => {
    document.querySelectorAll('article').forEach(tag => {
        tag.parentElement.removeChild(tag);
    });

    if (searchInput.value != "") {
        articlesData = JSON.parse(JSON.stringify(allArticles));
        articlesData = articlesData.filter(article => 
            article['text'].toLowerCase().includes(searchInput.value.toLowerCase()) || 
            article['title'].toLowerCase().includes(searchInput.value.toLowerCase()) || 
            (article['tags'] != null && article['tags'].filter(t => t.toLowerCase().includes(searchInput.value.toLowerCase())).length > 0) );
    
        articlesData.forEach(article => {
            article['text'] = article['text'].replace(new RegExp(`(?<!<[^>]*)${searchInput.value}`, "gi"), `<mark>${searchInput.value}</mark>`);
            article['title'] = article['title'].replace(new RegExp(`(?<!<[^>]*)${searchInput.value}`, "gi"), `<mark>${searchInput.value}</mark>`);
            if (article['tags'] != null) {
                article['tags'].forEach((tag, index) => {
                    article['tags'][index] = tag.replace(new RegExp(`(?<!<[^>]*)${searchInput.value}`, "gi"), `<mark>${searchInput.value}</mark>`);
                });
            }
        });
    }
    else {
        articlesData = JSON.parse(JSON.stringify(allArticles));
    }

    if (!articlesData.length == 0) {
        addArticle(0, true);
    }
    else {
        articleList.innerHTML += (`<article>По вашему запросу "${searchInput.value}" ничего не найдено.</article>`);
    }   
});

