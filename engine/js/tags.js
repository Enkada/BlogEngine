const tagContainer = document.querySelector('.tag-container');
const tagInput = document.querySelector('.tag-container input');
const realTagInput = document.querySelector('input[name="tags"]');

var tagList;
if (tagList == null) { tagList = [] }

function removeTag(label) {    
    tagList = tagList.filter(tag => tag !== label);
    updateTags();
}

function createTag(label) {
    const div = document.createElement('div');
    div.setAttribute('class', 'tag');

    const span = document.createElement('span');
    span.innerHTML = label;

    const closeIcon = document.createElement('i');
    closeIcon.innerHTML = 'close';
    closeIcon.setAttribute('class', 'material-icons');
    closeIcon.setAttribute('data-tag-name', label);
    closeIcon.addEventListener('click', () => removeTag(label));

    div.appendChild(span);
    div.appendChild(closeIcon);
    return div;
}

function updateTags() {
    document.querySelectorAll('.tag').forEach(tag => {
        tag.parentElement.removeChild(tag);
    });

    tagList.slice().reverse().forEach(tag => {
        tagContainer.prepend(createTag(tag));
    });
    
    realTagInput.value = JSON.stringify(tagList);
}

tagInput.addEventListener('keyup', (e) => {
    if (e.key === 'Enter') {
        tagList.push(tagInput.value);
        tagInput.value = '';
        updateTags();
    }
})