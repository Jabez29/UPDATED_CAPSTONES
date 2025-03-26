// Initialize input elements
let Firstname = initInput("firstName", "Firstname");
let Middlename = initInput("middleName", "Middlename");
let Lastname = initInput("lastName", "Lastname");
let Username = initInput("userName", "Username");
let Email = initInput("email", "Email");
let Password = initInput("password", "Password");
let Id = initInput("id", "Id");

let confirmTitle = undefined;
let confirmMsg = undefined;

const btnAdd = document.getElementById("user-add");
const userModal = new bootstrap.Modal(document.getElementById("user-modal"));

let userProperties = [Id,Firstname, Middlename, Lastname,Username, Email, Password];

const confirmModal = initDialogModal("confirm-modal");
const alertModal = initDialogModal(
  "alert-modal",
  "alert-title",
  "alert-message",
  "alert-ok"
);

if (confirmModal.modal) {
  confirmModal.setTitle("User");
  confirmModal.setOkCaption("Yes");
  confirmModal.btnOk().addEventListener("click", function (e) {
    e.preventDefault();
    deleteUser();
  });
}


function clear() {
  if (userProperties.length !== 0) {
    for (var i = 0; i < userProperties.length; i++) {
      userProperties[i].setValue("", true);
      userProperties[i].clearError();
    }
  }
}

function deleteUser() {
  const formData = new FormData();
  formData.append("id", Id.value);
  formData.append("action", "delete-user");

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "controllers/crud.php");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

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
      console.log("Error submitting form");
    }
  };

  xhr.send(new URLSearchParams(formData).toString());
}

// Event listener for add button to show modal and clear form
if (btnAdd) {
  btnAdd.onclick = function (e) {
    e.preventDefault();
    Id.value = 0;
    userModal.show();
    Firstname.element().focus();
    clear();
  };
}

// Event listener for form submission
const btn = document.getElementById("frm-submit");
if (btn) {
  btn.onclick = function (e) {
    e.preventDefault();

    let isValid = true;


    Firstname.getValue();
    Middlename.getValue();
    Lastname.getValue();
    Username.getValue();
    Email.getValue();
    Password.getValue();
    

    Firstname.required = true;
    Middlename.required = true;
    Lastname.required = true;
    Username.required =true;
    Email.required = true;
    Password.required = true;
    

    if (Firstname.isEmpty()) {
        isValid = false;
    }

    if (Middlename.isEmpty()) {
        isValid = false;
    }

    if (Lastname.isEmpty()) {
        isValid = false;
    }
    if(Username.isEmpty()){
      isValid = false;
    }

    if (Email.isEmpty()) {
        isValid = false;
    }

    if (Password.isEmpty()) {
        isValid = false;
    } 

    if (isValid) {
      const formData = new FormData();

      formData.append("firstName", Firstname.value);
      formData.append("middleName", Middlename.value);
      formData.append("lastName", Lastname.value);
      formData.append("userName", Username.value);
      formData.append("email", Email.value);
      formData.append("password", Password.value);



      if (Id.value !== 0 && Id.value !== "") {
        formData.append("id", Id.value);
        formData.append("action", "update-user");
      } else {
        formData.append("action", "create-user");
      }

      const xhr = new XMLHttpRequest();
      xhr.open("POST", "controllers/crud.php");
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      xhr.onload = function () {
        if (xhr.status === 200) {
          userModal.hide();
          window.location.reload();
          console.log(xhr.responseText);
        } else {
          console.log("Error submitting form");
        }
      };

      xhr.send(new URLSearchParams(formData).toString());
    }
  };
}

var btnEditElements = document.getElementsByClassName("btn-edit");
if (btnEditElements) {
  for (var i = 0; i < btnEditElements.length; i++) {
    btnEditElements[i].addEventListener("click", function (e) {
      e.preventDefault();

      const formData = new FormData();
      formData.append("id", this.getAttribute("data-id"));
      formData.append("action", "select-user");

      var xhr = new XMLHttpRequest();

      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            response = JSON.parse(xhr.responseText);

            clear();

            Firstname.setValue(response.data.firstName, true);
            Middlename.setValue(response.data.middleName, true);
            Lastname.setValue(response.data.lastName, true);
            Username.setValue(response.data.userName, true);
            Email.setValue(response.data.email, true);
            Password.setValue(response.data.password, true);
            Id.setValue(response.data.id, true);

            userModal.show();
            Firstname.element().focus();

            console.log("Response:", xhr.responseText);
          } else {
            console.error("Error:", xhr.status);
          }
        }
      };

      xhr.open("POST", "controllers/crud.php", true);
      xhr.send(formData);
    });
  }
}

var btnDelElements = document.getElementsByClassName("btn-del");
if (btnDelElements) {
  for (let i = 0; i < btnDelElements.length; i++) {
    btnDelElements[i].addEventListener("click", function (e) {
      e.preventDefault();
      const account =
        this.closest("tr").querySelector("td:nth-child(1)").textContent;
      confirmModal.setMessage(
        `Do you want to delete a user with a Account Number of: <span class="fw-bold">${account}</span>?`
      );
      Id.value = this.getAttribute("data-id");
      confirmModal.modal.show();
    });
  }
}

$(document).ready(function () {
  $('#user-table').DataTable();
});

