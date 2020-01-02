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
