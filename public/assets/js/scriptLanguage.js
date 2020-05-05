let trash = $('.trash-language');
for (let i = 0; i < trash.length; i++) {
    trash[i].addEventListener('click', (e) => {
        let id = trash[i].getAttribute('data-id');
        let message = 'Voulez vous vraiment supprimer ce language ?'
        if (window.confirm(message)) {
            let formData = new FormData();
            formData.append('id', id);
            $.ajax({
                type: 'POST',
                data: formData,
                url: '/admin/ajaxDeleteLanguage',
                timeout: 3000,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: (data) => {
                    let divSuccess = $('#success-delete');
                    divSuccess.addClass('alert alert-success');
                    divSuccess.html(data);
                }, error: (error) => {
                    let divError = $('#success-delete');
                    divError.addClass('alert alert-warning');
                    divError.html(error);
                }
            })
        }
    })
}
console.log(trash);