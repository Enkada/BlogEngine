const imageExtensions = ['jpg', 'png', 'jpeg', 'gif', 'jfif'];
const imageExtStr = '.*\.' + imageExtensions.join("|.*\.");

const videoExtensions = ['webm', 'mp4'];
const videoExtStr = '.*\.' + videoExtensions.join("|.*\.");

const audioExtensions = ['mp3', 'ogg', 'wav'];
const audioExtStr = '.*\.' + audioExtensions.join("|.*\.");

function formatArticleText(t) {

    var imageCollection = [];
    
    // Создание изображений

    t.split('\n').forEach(l => {
        var matchExternal = l.match(new RegExp(`^http.*\/(${imageExtStr})$`, "m"));

        if (matchExternal != null) {
            t = t.replace(new RegExp(`^${matchExternal[0]}$`, "m"), `<img src="${matchExternal[0]}">`);
            return;
        }
        
        var matchInner = l.match(new RegExp(`^(?!(http|\<))(${imageExtStr})$`, "m"));

        if (matchInner != null) {
            t = t.replace(new RegExp(`^${matchInner[0]}$`, "m"), `<img src="/uploads/${matchInner[0]}">`);
            return;
        }
    });

    // Создание коллекций изображений

    t.split('\n').forEach(l => {
        var match = l.match(new RegExp(`^<img src=".*">$`, "m"));

        if (match != null) {               
            imageCollection.push(match[0]);
            return;
        }

        if (imageCollection.length > 1) {
            var imgStr = imageCollection.join('\\r?\\n?');
            t = t.replace(new RegExp(`${imgStr}`), `<div class="image-collection">${imageCollection.join('')}</div>`);
        }
        imageCollection = [];
    });

    if (imageCollection.length > 1) {
        var imgStr = imageCollection.join('\\r?\\n?');
        t = t.replace(new RegExp(`${imgStr}`), `<div class="image-collection">${imageCollection.join('')}</div>`);
    }
    imageCollection = [];

    // Создание видео

    t.split('\n').forEach(l => {
        var matchExternal = l.match(new RegExp(`^http.*\/(${videoExtStr})$`, "m"));

        if (matchExternal != null) {
            t = t.replace(new RegExp(`^${matchExternal[0]}$`, "m"), `<video controls="controls" src="${matchExternal[0]}"></video>`);
            return;
        }
        
        var matchInner = l.match(new RegExp(`^(?!(http|\<))(${videoExtStr})$`, "m"));

        if (matchInner != null) {
            t = t.replace(new RegExp(`^${matchInner[0]}$`, "m"), `<video controls="controls" src="/uploads/${matchInner[0]}"></video>`);
            return;
        }
    });

    // Создание аудио

    t.split('\n').forEach(l => {
        var matchExternal = l.match(new RegExp(`^http.*\/(${audioExtStr})$`, "m"));

        if (matchExternal != null) {
            t = t.replace(new RegExp(`^${matchExternal[0]}$`, "m"), `<audio controls src="${matchExternal[0]}"></audio>`);
            return;
        }
        
        var matchInner = l.match(new RegExp(`^(?!(http|\<))(${audioExtStr})$`, "m"));

        if (matchInner != null) {
            t = t.replace(new RegExp(`^${matchInner[0]}$`, "m"), `<audio controls src="/uploads/${matchInner[0]}"></audio>`);
            return;
        }
    });

    // Ссылки

    t.split('\n').forEach(l => {
        var matches = l.matchAll(/\(\((http.*?) (.*?)\)\)/g);

        if (matches != null) {  
            for (const match of matches) {
                t = t.replace(new RegExp(match[0].replace(/[.*+?^${}()|[\]\\]/g, "\\$&"), 'g'), `<a href="${match[1]}">${match[2]}</a>`);
            }
        }
    });

    // Жирный текст

    t.split('\n').forEach(l => {
        var matches = l.matchAll(/\*\*([^ ].*?[^ ]?)\*\*/g);

        if (matches != null) {  
            for (const match of matches) {
                t = t.replace(new RegExp(match[0].replace(/[.*+?^${}()|[\]\\]/g, "\\$&")), `<b>${match[1]}</b>`);
            }
        }
    });

    // Зачеркнутый текст

    t.split('\n').forEach(l => {
        var matches = l.matchAll(/\-\-([^ ].*?[^ ]?)\-\-/g);


        if (matches != null) {  
            for (const match of matches) {
                t = t.replace(new RegExp(match[0].replace(/[.*+?^${}()|[\]\\]/g, "\\$&")), `<strike>${match[1]}</strike>`);
            }
        }
    });

    // Курсивный текст

    t.split('\n').forEach(l => {
        var matches = l.matchAll(/([^:]|^)(\/\/([^ ].*?[^ ]?)\/\/)/g);

        if (matches != null) {  
            for (const match of matches) {
                console.log(match);
                t = t.replace(new RegExp(match[2].replace(/[.*+?^${}()|[\]\\]/g, "\\$&")), `<i>${match[3]}</i>`);
            }
        }
    });

    // YouTube

    t.split('\n').forEach(l => {
        var matches = l.matchAll(/^https:\/\/www\.youtube\.com\/watch\?v=(.*)(?=&?)/g);
            
        if (matches != null) {  
            for (const match of matches) {
                t = t.replace(new RegExp(match[0].replace(/[.*+?^${}()|[\]\\]/g, "\\$&")), `<iframe width="600" height="338" src="https://www.youtube.com/embed/${match[1]}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`);
            }
        }
    });

    // Перенос строк

    t = t.replace(/\n/g, "<br>");

    return t;
}