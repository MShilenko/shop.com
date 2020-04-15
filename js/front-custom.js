document.addEventListener("DOMContentLoaded", function() {
    let filter = document.forms.filter;
    let order = document.forms.order;
    let headerMenuElements = document.querySelectorAll('.main-menu--header > li');
    let footerMenuElements = document.querySelectorAll('.main-menu--footer > li');
    let sortMenuElements = document.querySelectorAll('.filter__list > li');
    let productsList = document.querySelector('.shop__list');
    let sortButton = document.querySelector('.shop__sorting-item .button');
    let filterButton = document.querySelector('form[name="filter"] .button');
    let sorting = document.querySelectorAll('.shop__sorting-item .custom-form__select');

    function activeMenuElement(menu) {
        for (let elem of menu) {
            let childLinkATag = elem.children[0];
            if (childLinkATag.getAttribute('href') == document.location.pathname + window.location.search) {
                childLinkATag.classList.add('active');
            } else {
                childLinkATag.classList.remove('active');
            }
        }
    }
    if (headerMenuElements) {
        activeMenuElement(headerMenuElements);
    }
    if (footerMenuElements) {
        activeMenuElement(footerMenuElements);
    }
    if (sortMenuElements) {
        activeMenuElement(sortMenuElements);
    }
    if (productsList) {
        productsList.addEventListener('click', (event) => {
            let productIdInput = order.productId;
            if (event.target.classList.contains('product')) {
                productIdInput.value = event.target.getAttribute('data-product-id');
            }
        });
    }

    function addQueryString(elements, submitButton, defaultValues = {}, requiredParameter = '') {
        let searchParams = new URLSearchParams(window.location.search);
        let getEvent = defaultValues ?? {};
        for (let elem of elements) {
            elem.addEventListener('change', async (event) => {
                if (event.target.type == 'checkbox' || event.target.type == 'radio') {
                    getEvent[event.target.name] = event.target.checked ? 'on' : 'off';
                } else {
                    getEvent[event.target.name] = event.target.value;
                }
                if (requiredParameter != '') {
                    if (getEvent[requiredParameter] != '' || searchParams.has(requiredParameter)) {
                        for (let key in getEvent) {
                            getEvent[key] != '' ? searchParams.set(key, getEvent[key]) : '';
                        }
                        history.replaceState({
                            sort: 1
                        }, '', '?' + searchParams.toString());
                        submitButton.classList.add('active');
                    }
                } else {
                    for (let key in getEvent) {
                        getEvent[key] != '' ? searchParams.set(key, getEvent[key]) : '';
                    }
                    history.replaceState({
                        sort: 1
                    }, '', '?' + searchParams.toString());
                    if (submitButton) {
                        submitButton.classList.add('active');
                    }
                }
            });
        }
        if (submitButton) {
            submitButton.addEventListener('click', () => {
                event.preventDefault();
                document.location.reload();
            });
        }
    }
    if (sorting) {
        let defaultValues = {
            sort_d: 'asc',
        }
        addQueryString(sorting, sortButton, defaultValues, 'sort_q');
    }
    if (filter) {
        addQueryString(filter.elements, filterButton);
    }
});