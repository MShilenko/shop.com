document.addEventListener("DOMContentLoaded", function() {
    let addCategory = document.forms.addCategory;
    let editCategory = document.forms.editCategory; 

    function fetchForForm(formData, action) {
        let result = '';
        let status = '';
        let resultMessagesTag = document.createElement('div');
        resultMessagesTag.className = 'status'; 

        formData.onsubmit = async (event) => {
            event.preventDefault();
            let response = await fetch(action, {
                method: 'POST',
                body: new FormData(formData)
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
                resultMessagesTag.innerHTML = '';
                resultMessagesTag.classList.remove('error');
                resultMessagesTag.classList.remove('success');

                resultMessagesTag.classList.add(result.status);
                resultMessagesTag.innerHTML = result.message;
                formData.before(resultMessagesTag);
            }
        };
    }

    if (addCategory) {
        fetchForForm(addCategory, '/functions/addCategory.php');
    }

    if (editCategory) {
        fetchForForm(editCategory, '/functions/editCategory.php');
    }
    
});