var googleRecaptchaValid = false;
var birthDate = document.getElementById('birthDate');

if (birthDate != null){
    birthDate.onload(setDate());
}

function setDate(){
    var datepicker = document.getElementById("birthDate");
    datepicker.max = new Date().toJSON().split('T')[0];
    datepicker.min = (new Date() - 100).toJSON().split('T')[0];
}

function validateRecaptcha(){
    var recaptchaError = document.getElementById("captchaError");
    recaptchaError.innerHTML = "";

    googleRecaptchaValid = true;
}

function validatePassword(){
    var password = document.getElementById("password");
    var repeat = document.getElementById("repeat");

    if (password.value != repeat.value){
        repeat.setCustomValidity("Passwords must match");
    }
    else{
        repeat.setCustomValidity("");
    }
}

function validateRegistration(event){
    if (!googleRecaptchaValid){
        var recaptchaError = document.getElementById("captchaError");
        recaptchaError.innerHTML = "Google reCAPTCHA is not valid!";
        
        event.preventDefault();
    }
}

function clickUpload(){
    document.getElementById('upload').click();
}


function displayImage(file){
    var img = document.getElementById('displayImg');

    var pattern = /(\.jpg|\.jpeg|\.svg|\.png)$/;
    var btn = document.getElementById('id');

    if (pattern.exec(file.name)){
        img.src = URL.createObjectURL(file);
        
        if (btn.classList.contains('is-invalid')){
            btn.classList.remove('is-invalid');
        }
    }
    else if (file.size / 1024 > 1024){
        var msg = document.getElementById('errorMsg');
        msg.innerText = "File is too large";
        btn.classList.add('is-invalid');
    }
    else{
        var msg = document.getElementById('errorMsg');
        msg.innerText = "Unsupported file type";
        btn.classList.add('is-invalid');
    }
}

function dragover(event){
    event.preventDefault();
}

function drop(event){
    let dt = event.dataTransfer
    let file = dt.files[0];

    var fileUpload = document.getElementById('upload');
    fileUpload.file = file;

    event.preventDefault();

    displayImage(file);
}

var id_counter;
var used_ids = [];
function addNewsItem(link){
    var div = document.getElementById('news-container');

    if (id_counter == null){
        id_counter = div.children.length + 1;
    }
    
    do{
        var id = randomiseString(12);
    }
    while (used_ids.includes(id))

    used_ids.push(id);

    var date = new Date();
    var display_date = date.toLocaleString('UTC', {month: 'long'}) + ' ' + date.getUTCDay() + ', '+ date.getUTCFullYear()+ '.';
    var div_html = `
        <div class="card my-3" id="div-` + id_counter + `">
            <input type="text" name="news_item[` + id +`][id]" value="` + id +`" hidden>
            <div class="row g-0">
                <div class="col-md-4 p-3" ondragover="dragover(event)" ondrop="dropNewsImage(event, `+ id_counter +`)">
                    <img src="` + link + `/cloud-upload.svg" id="news-img-`+ id_counter +`" height="298" draggable="false" class="card-img-top rounded-3" style="cursor: pointer" onclick="clickNewsImageUpload(`+ id_counter +`)">
                    <input type="file" id="upload-`+ id_counter +`" name="news_item[` + id +`][image]" accept=".jpg,.jpeg,.svg,.png" onchange="displayNewsImage(this.files[0], `+ id_counter +`)" required hidden>
                </div>
                <div class="col-md-8">
                    <div class="card-body text-start">
                        <div class="d-flex">
                            <input type="text" name="news_item[` + id +`][title]" class="card-title textbox-news h5 w-100" placeholder="News Item Title" required>
                            <img src="` + link + `/delete-icon.svg" width="48" height="48" draggable="false" class="img-fluid rounded-3 p-2 ml-auto" title="Remove Item" style="cursor: pointer" onclick="removeNewsItem('div-`+ id_counter +`')">
                        </div>
                        <textarea class="card-text textbox-news w-100" name="news_item[` + id +`][content]" placeholder="News Item Content" style="height: 186px" required></textarea>
                        <p class="text-end"><small class="text-muted">Last updated on ` + display_date + `</small></p>
                    </div>
                </div>
            </div>
        </div>`;

    div.insertAdjacentHTML('afterbegin', div_html);

    id_counter++;
}

function randomiseString(length) {
    var pattern = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var patternLength = pattern.length;
    var result = '';
    for ( var i = 0; i < length; i++ ) {
       result += pattern.charAt(Math.floor(Math.random() * patternLength));
    }
    return result;
 }

function removeNewsItem(id){
    var div = document.getElementById(id);
    div.remove();
}

function dropNewsImage(event, id){
    let dt = event.dataTransfer
    let file = dt.files[0];

    var fileUpload = document.getElementById('upload-' + id);
    fileUpload.file = file;

    event.preventDefault();

    displayNewsImage(file, id);
}

function clickNewsImageUpload(id){
    document.getElementById('upload-' + id).click();
}

function displayNewsImage(file, id){
    var img = document.getElementById('news-img-' + id);

    var pattern = /(\.jpg|\.jpeg|\.svg|\.png)$/;

    if (pattern.exec(file.name)){
        img.src = URL.createObjectURL(file);
    }
}
