document.addEventListener("DOMContentLoaded", function() {
    let addCategory = document.forms.addCategory;
    let editCategory = document.forms.editCategory;
    let addProduct = document.forms.addProduct;
    let editProduct = document.forms.editProduct;
    let addPage = document.forms.addPage;
    let editPage = document.forms.editPage;
    let order = document.forms.order;
    let editSettings = document.forms.editSettings;
    let productList = document.querySelector('.page-products__list');
    let pagesList = document.querySelector('.pages .page-products__list');
    let orderList = document.querySelector('.page-order__list');

    function fetchForForm(currentForm, action, destination = '') {
        let result = '';
        let status = '';
        let popupEnd = document.querySelector('.page-add__popup-end, .shop-page__popup-end');
        let popupEndMessageTag = popupEnd.querySelector('.shop-page__end-title');
        let resultMessagesTag = document.createElement('div');
        resultMessagesTag.className = 'status';
        currentForm.onsubmit = async (event) => {
            event.preventDefault();
            let response = await fetch(action, {
                method: 'POST',
                body: new FormData(currentForm)
            });
            if (response.status == 200) {
                result = await response.json();
            } else {
                result = {
                    status: 'error',
                    message: 'Произошла ошибка при добавлении.',
                };
            }
            if (result.length != 0) {
                if (result.status == 'success') {
                    popupEndMessageTag.innerHTML = result.message;
                    if (currentForm.closest('section')) {
                        currentForm.closest('section').hidden = true;
                    }
                    popupEnd.hidden = false;
                    if (destination.length != 0) {
                        setTimeout(() => document.location.href = destination, 3000);
                    }
                }
                resultMessagesTag.innerHTML = '';
                resultMessagesTag.classList.remove('error');
                resultMessagesTag.classList.add(result.status);
                resultMessagesTag.innerHTML = result.message;
                currentForm.before(resultMessagesTag);
            }
        };
    }
    if (addCategory) {
        fetchForForm(addCategory, '/functions/addCategory.php', '/admin/categories/');
    }
    if (editCategory) {
        fetchForForm(editCategory, '/functions/editCategory.php', '/admin/categories/');
    }
    if (addProduct) {
        fetchForForm(addProduct, '/functions/addProduct.php', '/admin/products/');
    }
    if (editProduct) {
        fetchForForm(editProduct, '/functions/editProduct.php', '/admin/products/');
    }
    if (addPage) {
        fetchForForm(addPage, '/functions/addPage.php', '/admin/pages/');
    }  
    if (editPage) {
        fetchForForm(editPage, '/functions/editPage.php', '/admin/pages/');
    }    
    if (order) {
        fetchForForm(order, '/functions/saveOrder.php');
    }    
    if (editSettings) {
        fetchForForm(editSettings, '/functions/editSettings.php', '/admin/');
    }

    function fetchToDelete(buttonsBlock, buttonClass, action, idAttribute){
        buttonsBlock.onclick = async (event) => {
            if(event.target.classList.contains(buttonClass)){
                let response = await fetch(action, {
                    method: 'POST',
                    body: event.target.getAttribute(idAttribute)
                });
                let result = await response.text();
                console.log(result);
            }
        };
    }

    if(productList){
        fetchToDelete(productList, 'product-item__delete', '/functions/deactivateProduct.php', 'data-product-id');
    }

    if(pagesList){
        fetchToDelete(pagesList, 'product-item__delete', '/functions/deactivatePage.php', 'data-page-id');
    }

    if(orderList){
        orderList.onclick = async (event) => {
            if(event.target.classList.contains('order-item__btn')){
                let status = event.target.previousElementSibling.classList.contains('order-item__info--no') ? 0 : 1;
                let response = await fetch('/functions/orderProcessed.php', {
                    method: 'POST',
                    body: [event.target.getAttribute('data-order-id'), status]
                });
            }
        };
    }
});