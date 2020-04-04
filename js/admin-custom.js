document.addEventListener("DOMContentLoaded", function() {
    let addCategory = document.forms.addCategory;
    let editCategory = document.forms.editCategory;
    let addProduct = document.forms.addProduct;
    let editProduct = document.forms.editProduct;
    let productList = document.querySelector('.page-products__list');

    function fetchForForm(currentForm, action, destination) {
        let result = '';
        let status = '';
        let popupEnd = document.querySelector('.page-add__popup-end');
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
                    currentFormhidden = true;
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

    if(productList){
        productList.onclick = async (event) => {
            if(event.target.classList.contains('product-item__delete')){
                let response = await fetch('/functions/deactivateProduct.php', {
                method: 'POST',
                body: event.target.getAttribute('data-product-id')
            });
            let result = await response.text();
            console.log(result);
            }
        };
    }
});