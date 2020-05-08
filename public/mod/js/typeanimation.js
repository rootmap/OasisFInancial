document.addEventListener('DOMContentLoaded', function(event) {
    // array with texts to type in typewriter
    var iterations = 0;
    // type one text in the typwriter
    // keeps calling itself until the text is finished
    function typeWriter(text, i, fnCallback) {
        // chekc if text isn't finished yet
        if (iterations == 6) {
            return false;
        }
        if (i < (text.length)) {
            // add next character to h1
            document.querySelector("span.type").setAttribute("data-word", text);
            document.querySelector("span.type").innerHTML = text.substring(0, i + 1) + '<span aria-hidden="true"></span>';
            // wait for a while and call this function again for next character
            setTimeout(function() {
                typeWriter(text, i + 1, fnCallback)
            }, 100);
        }
        // text finished, call callback if there is a callback function
        else if (typeof fnCallback == 'function') {
            // call callback after timeout
            setTimeout(fnCallback, 900);
            iterations++;
        }
    }
    // start a typewriter animation for a text in the dataText array
    function StartTextAnimation(i) {
        if (typeof dataText[i] == 'undefined') {
            setTimeout(function() {
                StartTextAnimation(0);
            }, 2000);
        }
        // check if dataText[i] exists
        if (dataText && dataText[i] && i < dataText[i].length) {
            // text exists! start typewriter animation
            typeWriter(dataText[i], 0, function() {
                // after callback (and whole text has been animated), start next text
                StartTextAnimation(i + 1);
            });
        }
    }
    // start the text animation
    StartTextAnimation(0);
});
jQuery(function() {
    jQuery('.lazyDiv').lazy();
});