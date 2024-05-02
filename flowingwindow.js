const toggleButton = document.getElementById('toggleButton');
const iframe = document.getElementById('interactiveIframe');

toggleButton.addEventListener('click', function() {
    const isExpanded = iframe.style.width !== '0px';

    if (isExpanded) {
        // ??iframe
        iframe.style.width = '0';
        iframe.style.height = '0';
        iframe.style.display = 'none';
    } else {
        // ??iframe?????
        iframe.style.width = '300px'; // Set to your desired width
        iframe.style.height = '400px'; // Set to your desired height
        iframe.style.display = 'block';
    }
});

window.addEventListener('message', function(event) {
    // ??????????
    // ??? `event.origin` ????? `iframe` ?????
    if (event.origin === "https://bioinfmsc8.bio.ed.ac.uk/~s2441797") { // ????????iframe?????
        if (event.data === "closeIframe") {
            // ??iframe
            document.getElementById('interactiveIframe').style.width = '0';
            document.getElementById('interactiveIframe').style.height = '0';
            document.getElementById('interactiveIframe').style.display = 'none';
        }
    }
}, false);

