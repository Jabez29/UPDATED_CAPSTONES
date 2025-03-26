$(document).ready(function () {
    // Initialize DataTables
    $('#user-table').DataTable();
    $('#graduatesTable').DataTable();

$('.details-btn').click(function () {
        const id = $(this).data('id');
        $('#modalContent').html('<p>Loading details...</p>');

        $.ajax({
            url: '../capstone/models/survey.php',
            method: 'GET',
            data: { id: id },
            success: function (response) {
                $('#modalContent').html(response);
            },
            error: function () {
                $('#modalContent').html('<p>Error loading details.</p>');
            }
        });
    });

   
    const btnDelElements = document.getElementsByClassName("btn-del");
    if (btnDelElements.length > 0) {
        for (let i = 0; i < btnDelElements.length; i++) {
            btnDelElements[i].addEventListener("click", function (e) {
                e.preventDefault();

                const studentNumber = this.closest("tr").querySelector("td:nth-child(1)").textContent;
                
                confirmModal.setMessage(`
                    Do you want to delete the record with Student Number: 
                    <span class="fw-bold">${studentNumber}</span>?
                `);

                document.getElementById("Id").value = this.getAttribute("data-id");
                confirmModal.modal.show();
            });
        }
    }
});


function deleteUser() {
    const formData = new FormData();
    formData.append("id", document.getElementById("Id").value);
    formData.append("action", "delete-graduate");

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "controllers/crud.php");

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            confirmModal.modal.hide();
            alertModal.setTitle("Delete");
            alertModal.setMessage(response.message);

            alertModal.btnOk().addEventListener("click", function (e) {
                e.preventDefault();
                window.location.reload();
            });

            alertModal.modal.show();
        } else {
            console.error("Error submitting form");
        }
    };

    xhr.send(formData); // Removed setRequestHeader
}