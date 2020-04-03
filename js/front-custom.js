document.addEventListener("DOMContentLoaded", function() {
    let headerMenuElements = document.querySelectorAll('.main-menu--header > li');
    for (let elem of headerMenuElements) {
        let childLinkATag = elem.children[0];
        if (childLinkATag.getAttribute('href') == document.location.pathname) {
            childLinkATag.classList.add('active');
        } else {
            childLinkATag.classList.remove('active');
        }
    }
});