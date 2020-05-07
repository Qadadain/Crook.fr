let trashLanguage = $('.trash-language');
for (let i = 0; i < trashLanguage.length; i++) {
    trashLanguage[i].addEventListener('click', (e) => {
        let id = trashLanguage[i].getAttribute('data-id');
        let message = 'Voulez vous vraiment supprimer ce langage ?'
        if (window.confirm(message)) {
            let formData = new FormData();
            formData.append('id', id);
            $.ajax({
                type: 'POST',
                data: formData,
                url: '/ajax/ajaxDeleteLanguage',
                timeout: 3000,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: (data) => {
                    let divSuccess = $('#success-delete');
                    divSuccess.addClass('alert alert-success');
                    divSuccess.html(data);
                    trashLanguage[i].parentElement.parentElement.remove();
                }, error: (error) => {
                    let divError = $('#success-delete');
                    divError.addClass('alert alert-warning');
                    divError.html(error);
                }
            })
        }
    })
}
