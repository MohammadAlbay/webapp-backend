async function changePictureProcessor(self) {
    self.disabled = true;

    let input = createChild('input', {
        'type': 'file', 'style': 'display:none',
        'accept': ".jpg, .jpeg, .png"
    });
    input.addEventListener('change', processProfileChange);
    input.click();


    self.disabled = false;
}




async function processProfileChange(e) {
    let fileInput = e.target;
    const file = fileInput.files[0];
    const formData = new FormData();
    let ext = file.name.toLowerCase();
    if (!ext.endsWith('.png') && !ext.endsWith('.jpg')
        && !file.name.endsWith('.jpeg')) {
        Swal.fire({
            icon: 'warning', title: 'خطأ',
            text: 'لم يتم التعرف على نوع ملف الصور '
        });
        return;
    }

    let fileSize = (file.size / 1e6).toFixed(1);

    if (fileSize > 4) {
        Swal.fire({
            icon: 'warning', title: 'خطأ',
            text: 'لا يمكن ان يكون حجم الصورة اكبر من 4 ميجابايت'
        });
        return;
    }

    formData.append('img', file); // add file
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content); // add token
    sendFormData('/customer/set-profile', 'POST', formData, v => {
        if (v.State == 1) {
            Swal.fire({
                icon: 'warning', title: 'خطأ',
                text: v.Message
            });
        } else {
            Swal.fire({
                icon: 'success', title: 'اكتملت العمية بنجاح',
                text: v.Message
            }).then(() => {
                location.reload();
            });

        }
    });
}



function confromEditData() {
    Swal.fire({
        icon: 'question',
        title: 'هل انت متأكد؟',
        text: 'تغيير بيانات حسابك لا يمكن التراجع عنه',
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonText: 'موافق',
        cancelButtonText: 'الغاء',
    }).then(confirm => {
        if (confirm.isConfirmed) {
            document.forms['form_customer_edit'].submit();
        }
    });
}