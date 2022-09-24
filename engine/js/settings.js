var title = document.querySelector('#blog-title');
var inputTitle = document.querySelector('input[name="blog_title"]');
var subtitle = document.querySelector('#blog-subtitle');
var inputSubtitle = document.querySelector('input[name="blog_subtitle"]');

inputTitle.addEventListener("input", () => title.innerHTML = inputTitle.value );
inputSubtitle.addEventListener("input", () => subtitle.innerHTML = inputSubtitle.value );

var preview = document.getElementById('settings-logo-preview');

function showLogo(input) {
    if (input.files[0] != null) {
        var file = input.files[0];
        if (file.type.split('/')[0] === 'image') {
            console.log(file);
            preview.src = URL.createObjectURL(file);
        }
        else {
            console.log("wrong file type");
        }        
    }    
}