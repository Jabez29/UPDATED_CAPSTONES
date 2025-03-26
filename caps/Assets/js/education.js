function addFields() {
    let container = document.getElementById("d1");
    let newFields = container.cloneNode(true);


    newFields.querySelectorAll('input').forEach(input => input.value = '');


    container.parentNode.insertBefore(newFields, container.nextSibling);
}

function removeFields() {
    let container = document.getElementById("d1");
    if (container.parentNode.childElementCount > 2) {
        container.parentNode.removeChild(container.nextSibling);
    }
}

function addFields2() {
    let container = document.getElementById("d2");
    let newFields = container.cloneNode(true);


    newFields.querySelectorAll('input').forEach(input => input.value = '');


    container.parentNode.insertBefore(newFields, container.nextSibling);
}

function removeFields2() {
    let container = document.getElementById("d2");
    if (container.parentNode.childElementCount > 2) {
        container.parentNode.removeChild(container.nextSibling);
    }
}
