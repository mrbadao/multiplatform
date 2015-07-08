/**
 * Created by HieuNguyen on 7/8/2015.
 */

var option = {
    theme: "eclipse",
    lineNumbers: true,
    matchBrackets: true,
    mode: "application/x-httpd-php",
    indentUnit: 4,
    indentWithTabs: true
};
window.onload = function() {
    var editableCodeMirror = CodeMirror.fromTextArea(document.getElementById('codemirrorElement'), option);
}

