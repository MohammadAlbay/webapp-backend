//alert("Done");

function toggleDialog(dialog) {
    [...document.getElementsByTagName("dialog")].forEach(element => {
        if(dialog != element) element.removeAttribute('open');
    });
    
    if(dialog.getAttribute('open') != null)
        dialog.removeAttribute('open');
    else
        dialog.setAttribute('open', '');
};