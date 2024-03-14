$(() => {
    let table;

    // Initialize DataTable with server-side processing
    table = $('#holidayPlansTable').DataTable({
        serverSide: true,
        processing: true,
        ajax: {
            url: '/holiday-plans/datatable',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        columns: [
            { data: 'id', title: 'ID' },
            { data: 'title', title: 'Title' },
            { data: 'description', title: 'Description' },
            { 
                data: 'date', 
                title: 'Date',
                render: function(data, type, row) {
                    return moment(data).format('DD/MM/YYYY');
                }
            },
            { data: 'location', title: 'Location' },
            { data: 'participants', title: 'Participants' },
            { data: null, title: 'Actions', orderable : false, render: function(data, type, row){
                return actions(data);
            }}
        ],
    });

    // Function to generate action buttons
    function actions(data) {
        return ` <div class="row-action" data-id="${data.id}">
                    <i class="far fa-edit edit-icon" title="Edit"></i>
                    <i class="far fa-trash-alt delete-icon" title="Delete"></i>
                    <i class="fa-solid fa-file-pdf pdf-icon" title="Pdf"></i>
                </div>
                `;
    }

    // Download Pdf
    $('#holidayPlansTable tbody').on('click', '.pdf-icon', function() {
        var id = $(this).closest('.row-action').data('id');
        if (id) {
            window.open('/holiday-plans/' + id + '/generate-pdf', '_blank');
        } else {
            alert('Holiday Plan ID not found.');
        }
    });

    // Show edit modal
    $('#holidayPlansTable tbody').on('click', 'i.edit-icon', function(e) {
        e.stopPropagation();
        var id = $(this).closest('tr').find('.row-action').data('id');

        if (id !== undefined) {
            $.get("/holiday-plans/" + id, function(response) {
                // Fill modal with data for editing
                $("#editTitle").val(response.info.title);
                $("#editDescription").val(response.info.description);
                $("#editDate").val(response.info.date);
                $("#editLocation").val(response.info.location);
                $("#editParticipants").val(response.info.participants);
                $("#editId").val(id);
                // Show edit modal
                $("#editModal").modal("show");
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to load information.',
                });
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to load information. Holiday ID is undefined.',
            });
        }
    });

    // Save edit
    $('#btnSaveEdit').on('click', function() {
        // Get ID
        var formId = 'editForm';

        // Check if required fields are filled
        var requiredFields = ['title', 'description', 'date', 'location'];
        var allFieldsFilled = true;
    
        requiredFields.forEach(function(fieldName) {
            var fieldValue = $('#' + formId + ' [name="' + fieldName + '"]').val().trim();
            if (fieldValue === '') {
                showError(fieldName);
                allFieldsFilled = false;
                return false; 
            }
        });
    
        if (!allFieldsFilled) {
            return;
        }
    
        // Serialize form data
        var formData = $('#' + formId).serialize();
        var productId = $("#editId").val();
        // Send AJAX request to edit holiday plan
        $.ajax({
            url: "/holiday-plans-edit/" + productId,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    swal.fire({
                        icon: 'success',
                        title: 'Saved',
                        text: 'Holiday plan edited.'
                    }).then((result) => {
                        table.ajax.reload();
                        $("#editModal").modal("hide");
                    });
                } else if (response.error) {
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: response.error
                    }).then((result) => {
                        $("#editModal").modal("hide");
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Error editing holiday.',
                });
            }
        });
    });

    // Delete holiday
    $('#holidayPlansTable tbody').on('click', 'i.delete-icon', function (e) {
        e.stopPropagation();
        // Get ID
        var id = $(this).closest('tr').find('.row-action');
        var holidayId = id.data('id');
        if (holidayId !== undefined) {
            Swal.fire({
                title: 'Attention',
                text: 'Removing this holiday plan will also delete associated data. Are you sure you want to continue?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#F08080',
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to delete holiday plan
                    $.ajax({
                        url: "/holiday-plans/" + holidayId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Holiday plan deleted!',
                                    html: 'The holiday plan has been deleted successfully.'
                                }).then(() => {
                                    // Reload DataTable after successful delete
                                    table.ajax.reload();
                                });
                            }

                            if (response.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    html: response.error
                                })
                            }
                        },
                        error: function (error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                html: error
                            });
                        }
                    });
                }
            });
        } else {
            console.error('Failed to find.');
        }
    });

    // Show add holiday modal
    $('#add').on('click', function() {
        $("#addModal").modal("show");
    });

    // Save new holiday
    $('#btnSaveAdd').on('click', function() {
        // Get ID
        var formId = 'addForm';

        var requiredFields = ['title', 'description', 'date', 'location'];
        var allFieldsFilled = true;
    
        requiredFields.forEach(function(fieldName) {
            var fieldValue = $('#' + formId + ' [name="' + fieldName + '"]').val().trim();
            if (fieldValue === '') {
                showError(fieldName);
                allFieldsFilled = false;
                return false; 
            }
        });
    
        if (!allFieldsFilled) {
            return;
        }
    
        // Serialize form data
        var formData = $('#' + formId).serialize();

        // Send AJAX request to store holiday plan
        $.ajax({
            type: 'POST',
            url: '/holiday-plans',
            data: formData,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.success,
                    }).then(() => {
                        // Reload DataTable after successful creation
                        table.ajax.reload();
                        $('#addModal').modal('hide');
                    });
                } else if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: response.error,
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Error registering the holiday plan.',
                });
            }
        });
    });
    
   // Function to display error message
    function showError(fieldName) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Please fill in the ' + fieldName + ' field.',
        });
    }

});


