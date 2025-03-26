function addFields(sectionId) {
    let container = document.getElementById(sectionId);
    let newFields = container.cloneNode(true);

    // Clear input values
    newFields.querySelectorAll('input').forEach(input => input.value = '');

    // Append new fields
    container.parentNode.insertBefore(newFields, container.nextSibling);
}

function removeFields(sectionId) {
    let container = document.getElementById(sectionId);
    if (container.parentNode.childElementCount > 2) { 
        container.parentNode.removeChild(container.nextSibling);
    }
}
