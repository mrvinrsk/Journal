function genStr(length, pattern = "[a-zA-Z0-9]") {
    var result = "";
    var regex = new RegExp(pattern);
    while (result.length < length) {
        var randomChar = String.fromCharCode(crypto.getRandomValues(new Uint32Array(1))[0] % 126);
        if (regex.test(randomChar)) {
            result += randomChar;
        }
    }
    return result;
}

function removeAfter(str, delimiter) {
    const index = str.indexOf(delimiter);
    if (index === -1) {
        return str;
    }
    return str.substring(0, index);
}


function getUrlParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}


$(function () {
    document.querySelector(".back").addEventListener("click", function () {
        history.back();
    });
});