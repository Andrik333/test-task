function showModal(title, message) {
    $('#modal .modalTitle').html(title);
    $('#modal .modalText').html(message);
    $('#modal').modal('show');
}

function ajaxSubmitForm(formSelector = ['.ajaxForm']) {
    $(formSelector.toString).submit(function(e) {
        e.preventDefault();

        let $form = $(e.target);
        let formData = $form.serialize();

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: formData,
            dataType: 'json',
            success: function(response) {
                if(response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    showModal('Сообщение', response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                showModal('Ошибка', jqXHR?.responseJSON?.message ?? 'Непредвиденная ошибка');
            }
        });
    });
}

module.exports = {
  showModal: showModal,
  ajaxSubmitForm: ajaxSubmitForm
};
