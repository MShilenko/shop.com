document.addEventListener("DOMContentLoaded", function() {
    let headerMenuElements = document.querySelectorAll('.main-menu--header > li');
    let sortMenuElements = document.querySelectorAll('.filter__list > li');
    let productsList = document.querySelector('.shop__list');
    if(document.forms.order){
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

    if(productsList){
    	productsList.addEventListener('click', (event) => {
			if(event.target.classList.contains('product')){
                productIdInput.value = event.target.getAttribute('data-product-id');
            }
    	});		
    }
});