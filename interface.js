document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.contentBox').forEach(function(box) {
        var id = box.getAttribute('id');
        var state = localStorage.getItem(id);
        box.style.display = state === 'expanded' ? 'block' : 'none'; // ???????????/??
    });
});

function toggleContent(id) {
    var contentBox = document.getElementById(id);
    var isExpanded = contentBox.style.display !== 'none';

    if (!isExpanded) {
        contentBox.style.display = 'block'; // ???????
        localStorage.setItem(id, 'expanded'); // ??????
    } else {
        contentBox.style.display = 'none'; // ?????
        localStorage.removeItem(id); // ????
    }
}