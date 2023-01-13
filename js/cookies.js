/**
 * Set a cookie
 * @param name the name of the cookie
 * @param value the value of the cookie
 * @param expire the number of hours until the cookie expires
 */
function setCookie(name, value, expire = 24 * 7) {
    let date = new Date();
    date.setTime(date.getTime() + (expire * 60 * 60 * 1000));
    let expires = "; expires=" + date.toUTCString();
    document.cookie = name + "=" + value + expires + "; path=/Journal";
}

function hasCookie(name) {
    return getCookie(name) !== "";
}

function getCookie(name) {
    let value = "; " + document.cookie;
    let parts = value.split("; " + name + "=");
    if (parts.length === 2) return parts.pop().split(";").shift();
}

function deleteCookie(name) {
    let date = new Date();
    date.setTime(date.getTime() - (1000 * 24 * 60 * 60));
    let expires = "; expires=" + date.toUTCString();
    document.cookie = name + "=" + expires + "; path=/Journal";
}