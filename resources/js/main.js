window.mask = function(event) {
    var matrix = "+7-___-___-__-__",
        i = 0,
        def = matrix.replace(/\D/g, ""),
        val = this.value.replace(/\D/g, "");
    if (def.length >= val.length) val = def;
    this.value = matrix.replace(/./g, function(a) {
        return /[_\d]/.test(a) && i < val.length ? val.charAt(i++) : i >= val.length ? "" : a
    });
    if (event.type == "blur") {
        if (this.value.length == 2) this.value = ""
    } else setCursorPosition(this.value.length, this)
};

window.maskphone = function(textInputID, checkboxID) {
    var checkBox = document.getElementById(checkboxID);
    if (checkBox && checkBox.checked == true){
        var input = document.querySelector("#"+textInputID);
        input.value = "";
        input.removeAttribute("pattern");
        input.removeEventListener("input", window.mask, false);
        input.removeEventListener("focus", window.mask, false);
        input.removeEventListener("blur", window.mask, false);
    } else {
        var input = document.querySelector("#"+textInputID);
        input.pattern = "^[\\+][7]{1}\\s\\-\\d{3}\\-\\s\\d{3}-\\d{2}-\\d{2}$";
        input.addEventListener("input", window.mask, false);
        input.addEventListener("focus", window.mask, false);
        input.addEventListener("blur", window.mask, false);
    }
};


window.pwd = function(id) {
    var input = document.getElementById(id);
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}

/**
 * Изменяет количество элементов на странице
 * @param name
 * @param value
 */
window.pager = function (name, value) {
    var url = new URL(window.location.href);
    var query_string = url.search;
    var search_params = new URLSearchParams(query_string);
    search_params.set(name, value);
    url.search = search_params.toString();
    var new_url = url.toString();
    window.location.href = new_url;
}

/**
 * Добавляет имя файла к file-input
 * @param labelID
 */
window.fileInputGetName = function (labelID)
{
    document.getElementById(labelID).addEventListener('change',function(e){
        var fileName = document.getElementById(labelID).files[0].name;
        var nextSibling = e.target.nextElementSibling
        nextSibling.innerText = fileName
    })
}

/**
 * Показывает/скрывает элемент (запоминает положение при перезагрузке страницы)
 * @param id
 * @param storageItem
 */
window.toggleDiv = function(id, storageItem) {
    var divID = document.getElementById(id);
    divID.style.display = (divID.style.display == 'block') ? 'none' : 'block';
    localStorage.setItem(storageItem, divID.style.display);
}

/**
 * Проверяет видимость элемента
 * @see toggleDiv()
 * @param id
 * @param storageItem
 */
window.checkVisibiliti = function(id, storageItem) {
    var divID = document.getElementById(id);
    if(localStorage.getItem(storageItem) == 'block') {
        divID.style.display = 'block';
    } else {
        divID.style.display = 'none';
    }
}

window.backUrl = function() {
    if (document.referrer.indexOf(window.location.host) !== -1) {
        history.go(-1); return false;
    }
    else {
        window.location = window.location.origin;
    }
}

window.getColumn = function(array, column) {
    return array.map(function(row) {
        return row[column];
    });
}

window.copyDivToClipboard = function(elem) {
    var range = document.createRange();
    range.selectNode(document.getElementById(elem));
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);
    document.execCommand("copy");
    window.getSelection().removeAllRanges();
}
