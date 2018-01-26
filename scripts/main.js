/**
 * Created by Nick on 9/18/17.
 */
// Creates a cookie at the current time with an offset of the given number of days
function createCookie(name, value) {
    var date, expires;
    if (days) {
        date = new Date();
        date.setTime(date.getTime()+(24*60*60*365*5));
        expires = "; expires="+date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = name+"="+value+expires+"; path=/";
}