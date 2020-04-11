document.addEventListener("DOMContentLoaded", function() {
    let headerMenuElements = document.querySelectorAll('.main-menu--header > li');
    let sortMenuElements = document.querySelectorAll('.filter__list > li');
    let productsList = document.querySelector('.shop__list');
    let sortButton = document.querySelector('.shop__sorting-item .button');
    let sorting = document.querySelectorAll('.shop__sorting-item .custom-form__select');
    if (document.forms.order) {
        let productIdInput = document.forms.order.productId;
    }

    function activeMenuElement(menu) {
        for (let elem of menu) {
            let childLinkATag = elem.children[0];
            if (childLinkATag.getAttribute('href') == document.location.pathname) {
                childLinkATag.classList.add('active');
            } else {
                childLinkATag.classList.remove('active');
            }
        }
    }
    activeMenuElement(headerMenuElements);
    activeMenuElement(sortMenuElements);
    if (productsList) {
        productsList.addEventListener('click', (event) => {
            if (event.target.classList.contains('product')) {
                productIdInput.value = event.target.getAttribute('data-product-id');
            }
        });
    }
    if (sorting) {
        let searchParams = new URLSearchParams(window.location.search);
        let getEvent = {
            sort_q: '',
            sort_d: 'asc',
        };
        for (let elem of sorting) {
            elem.addEventListener('change', async (event) => {
                getEvent[event.target.name] = event.target.value;
                if (getEvent.sort_q != '' || searchParams.has('sort_q')) {
                    for (let key in getEvent) {
                        getEvent[key] != '' ? searchParams.set(key, getEvent[key]) : '';
                    }
                    history.replaceState({
                        sort: 1
                    }, '', '?' + searchParams.toString());
                    sortButton.classList.add('active');
                }
            });
        }
        if (sortButton) {
            sortButton.addEventListener('click', () => {
                document.location.reload();
            });
        }
    }
});