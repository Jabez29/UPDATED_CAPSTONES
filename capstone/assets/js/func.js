function validnum_block(num_block) {
  const numberRegex = /^[1-4]$/;
  return numberRegex.test(num_block);
}

function validateMiddleName(middleName) {
  const nameRegex = /^[A-Za-z\s]{2,}$/;
  return middleName === '' || nameRegex.test(middleName);
}

function validateApplicationNumber(applicationNumber) {
  return applicationNumber.trim() !== '';
}

function validateContactNumber(contactNo) {
  const contactNoRegex = /^(09|\+639)\d{9}$/;
  return contactNoRegex.test(contactNo);
}

function validateGender(gender) {
  const validGenders = ["Male", "Female", "Other"];
  return validGenders.includes(gender);
}

function getElementById(selector) {
  return document.getElementById(selector);
}

function initInput(selector, label, value = "") {
  const element = getElementById(selector);
  const errDiv = element.parentNode.querySelector(".text-danger");

  const _setError = function (bool, msg = "") {
    if (errDiv) {
      msg = msg || "This field cannot be empty";
      errDiv.textContent = bool ? "" : msg;
    }
    // Adjust border color based on the error state
    element.classList.toggle("border-success", bool);
    element.classList.toggle("border-danger", !bool);
  };

  const _clearError = function () {
    if (errDiv) {
      errDiv.textContent = "";
    }
    // Remove border colors from the element
    element.classList.remove("border-success");
    element.classList.remove("border-danger");
  };

  return {
    selector: selector,
    value: value,
    label: label,
    required: false,
    element: function () {
      return element;
    },
    getValue: function () {
      this.value = this.element().value;
      return this.value;
    },
    setValue: function (value, updateElemVal = false) {
      this.value = value;

      if (updateElemVal) {
        this.setElementValue();
      }

      return this.value;
    },
    setElementValue: function (value) {
      this.element().value = value !== undefined ? value : this.value;
    },
    // For Contact
    isValidContact() {
      const bool = validateContactNumber(this.value);
      _setError(bool, "Please Enter Valid Number!");
      return bool;
    },
    // For Num_block
    isValidNumblock() {
      const bool = validnum_block(this.value);
      _setError(bool, "Please Enter (1-4) blocks!");
      return bool;
    },
    // For Gender
    isValidGender() {
      const bool = validateGender(this.value);
      _setError(bool, "Please Select either Male, Female or Others!");
      return bool;
    },
    isValidAcount() {
      const bool = validateApplicationNumber(this.value);
      _setError(bool, "Please Select Account Number");
      return bool;
    },
    // For other fields
    isEmpty() {
      var bool = false;
      if (this.required) {
        bool = this.value === "";
        if (bool) {
          _setError(false);
        } else {
          _setError(true);
        }
      }
      return bool;
    },
    clearError: function () {
      _clearError();
    },
  };
}

function togglePassword() {
  const passwordField = document.getElementById("password");
  const toggleIcon = document.getElementById("toggleIcon");
  if (passwordField.type === "password") {
    passwordField.type = "text";
    toggleIcon.classList.remove("bi-eye");
    toggleIcon.classList.add("bi-eye-slash");
  } else {
    passwordField.type = "password";
    toggleIcon.classList.remove("bi-eye-slash");
    toggleIcon.classList.add("bi-eye");
  }
}

function initDialogModal(
  selector,
  selectorTitle = "confirm-title",
  selectorMessage = "confirm-message",
  selectorOk = "dialog-ok"
) {
  let modal = new bootstrap.Modal(document.getElementById(selector));
  return {
    modal: modal,
    message: "",
    title: "",
    setTitle: function (title = "") {
      this.title = title === "" ? this.title : title;
      document.getElementById(selectorTitle).innerHTML = this.title;
    },
    setMessage: function (message = "") {
      this.message = message === "" ? this.message : message;
      document.getElementById(selectorMessage).innerHTML = this.message;
    },
    setOkCaption: function (caption) {
      document.getElementById(selectorOk).innerHTML = caption;
    },
    btnOk: function () {
      return document.getElementById(selectorOk);
    },
  };
}
