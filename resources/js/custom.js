//CUSTOM JS
$('#edit-modal').on('shown.bs.modal', function (event) {
    let button = $(event.relatedTarget) // Button that triggered the modal
    let user = button.data('user');

    let modal = $(this);

    modal.find('#editId').val(user.id);
    modal.find('#editName').text(user.name);
    modal.find('#editRole').val(user.role);

    $('#edit-modal').on('hide.bs.modal', function () {
        $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
        $("#edit-form").trigger("reset");
    })
})

$('#delete-modal').on('shown.bs.modal', function (event) {
    let button = $(event.relatedTarget) // Button that triggered the modal
    let user = button.data('user');

    let modal = $(this);

    modal.find('#deleteId').val(user.id);
    modal.find('#deleteName').text(user.name);

    $('#delete-modal').on('hide.bs.modal', function () {
        $('.delete-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
        $('#delete-modal').trigger("reset");
    })
})
