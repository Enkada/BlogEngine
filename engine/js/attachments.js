var files = [];

const attachmentList = document.querySelector('.form-attachemnt-list');
const realAttachmentList = document.querySelector('input[name="attachments[]"]');

function addAttachment(input) {
    if (input.files[0] != null && ['image', 'video', 'audio'].includes(input.files[0].type.split('/')[0])) {
        var file = input.files[0];
        files.push(file);
        updateAttachments();
    }    
    else {
        console.log("Wrong file type! - ", input.files[0].type.split('/')[0]);
    }
}

const textArea = document.querySelector('textarea');

function removeAttachment(file) {
    files = files.filter(f => f !== file);
    updateAttachments();
}

function insertAttachment(attachment) {
    //IE support
    if (document.selection) {
        textArea.focus();
        sel = document.selection.createRange();
        sel.text = attachment;
    }
    //MOZILLA and others
    else if (textArea.selectionStart || textArea.selectionStart == '0') {
        var startPos = textArea.selectionStart;
        var endPos = textArea.selectionEnd;
        textArea.value = textArea.value.substring(0, startPos)
            + attachment
            + textArea.value.substring(endPos, textArea.value.length);
    } else {
        textArea.value += attachment;
    }
}

function createAttachment(file) {  
    var attachment = document.createElement('div');

    var btnInsert = document.createElement('span');    
    btnInsert.addEventListener('click', () => insertAttachment(file.name))    
    attachment.append(btnInsert);

    var btnDelete = document.createElement('span');
    btnDelete.setAttribute('class', 'material-icons');
    btnDelete.addEventListener('click', () => removeAttachment(file))
    btnDelete.innerHTML = "delete";
    attachment.append(btnDelete);

    

    
    if (file.type.split('/')[0] === 'image') {
        
        attachment.setAttribute('class', 'attachment-image');

        setTimeout(function(){ 
            attachment.style.backgroundImage = `url(${URL.createObjectURL(file)})`;
        }, 0);

        btnInsert.setAttribute('class', 'material-icons');
        btnInsert.innerHTML = "add";       
    }
    else {
        attachment.setAttribute('class', 'attachment-other');
        btnInsert.innerHTML = file.name; 
    }      

    return attachment;
}

function updateAttachments() {
    document.querySelectorAll('.attachment-image, .attachment-other').forEach(attachment => {
        attachment.parentElement.removeChild(attachment);
    });

    files.forEach(file => {
        attachmentList.append(createAttachment(file));
    });

    var dt = new DataTransfer();
    files.forEach(file => {
        dt.items.add(file);
    });

    realAttachmentList.files = dt.files;
}

const btnGallery = document.querySelector('.form-attachemnts-buttons span:nth-of-type(2)');
const gallery = document.querySelector('#form-attachments-gallery');

btnGallery.addEventListener('click', () => {
    btnGallery.classList.toggle('btn-toggled');
    gallery.style.display = gallery.style.display == "none" ? "flex" : "none";
});


if (galleryAttachments != null) {
    galleryAttachments.forEach(attachment => {
        var ext = attachment.split('.').pop();
        if (['jpg', 'png', 'jpeg', 'gif', 'jfif'].includes(ext)) {
            gallery.innerHTML += (`<img src="/uploads/${attachment}" title="${attachment}" onclick="insertAttachment('${attachment}')">`);
        }
        if (['webm', 'mp4'].includes(ext)) {
            gallery.innerHTML += (`<img src="/engine/images/video.png" title="${attachment}" onclick="insertAttachment('${attachment}')">`);
        }
        if (['mp3', 'ogg', 'wav'].includes(ext)) {
            gallery.innerHTML += (`<img src="/engine/images/audio.png" title="${attachment}" onclick="insertAttachment('${attachment}')">`);
        }
    });
}