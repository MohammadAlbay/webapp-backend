//alert("Done");

function toggleDialog(dialog) {
    if(dialog.getAttribute('open') != null)
        dialog.removeAttribute('open');
    else
    dialog.setAttribute('open', '');
};