async function openFilePicker(callback, multiple = false) {
    let input = createChild('input', {
        'type': 'file', 'style': 'display:none',
        'accept': "video/*, image/*"
    });
    if (multiple) {
        input.setAttribute('multiple', '');
    }
    input.addEventListener('change', callback);
    input.click();
}
async function changeProfileImageProcessor() {
    let input = createChild('input', {
        'type': 'file', 'style': 'display:none',
        'accept': ".jpg, .jpeg, .png"
    });
    input.addEventListener('change', processProfileChange);
    input.click();
}

async function changeCoverImageProcessor() {
    let input = createChild('input', {
        'type': 'file', 'style': 'display:none',
        'accept': ".jpg, .jpeg, .png"
    });
    input.addEventListener('change', processCoverChange);
    input.click();
}

async function processCoverChange(e) {
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

    if (fileSize > 7) {
        Swal.fire({
            icon: 'warning', title: 'خطأ',
            text: 'لا يمكن ان يكون حجم الصورة اكبر من 7 ميجابايت'
        });
        return;
    }

    formData.append('img', file); // add file
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content); // add token
    sendFormData('/technicain/set-cover', 'POST', formData, v => {
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
    sendFormData('/technicain/set-profile', 'POST', formData, v => {
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
            document.forms['form_technicain_edit'].submit();
        }
    });
}



var newPost = null;
let newPostDialog = document.querySelector('#add-post-dialog');
function showDialog() {
    if (newPostDialog.getAttribute('open') != null) {
        newPostDialog.removeAttribute('open');
        removeNewPostInstance();

    }
    else {
        newPostDialog.setAttribute('open', '');
        createNewPostInstance();
    }
}
function createNewPostInstance() { newPost = new AddPost(newPostDialog); }
function removeNewPostInstance() { newPost = null; }
class AddPost {
    #files = [];
    #text = "";
    #formData = null;
    container = null;
    imagesContainer = null;
    postTextArea = null;
    constructor(parentContainer) {
        this.#files = [];
        this.#formData = new FormData();
        this.container = parentContainer;
        this.imagesContainer = parentContainer.querySelector('#techincain-add-post-imagelist');
        this.postTextArea = parentContainer.querySelector('#techincain-add-post-textarea');
        parentContainer.querySelector('#techincain-add-post-addmedia')
                .onclick = () => {
                    this.addFile();
                };
        parentContainer.querySelector('#techincain-add-post-submit')
            .addEventListener('click', e => {
                this.submit();
            });
        this.postTextArea.addEventListener('change', e => this.#text = e.target.value);
    }
    submit() {
        if (this.#text == "") {
            Swal.fire({
                icon: 'warning',
                title: 'المنشور غير مكتمل',
                text: 'لا يمكن اضافة منشور بدون كتابة نص للمنشور '
            });
            return;
        }
        Swal.fire({
            icon: 'question',
            title: "اضافة منشور",
            text: "هل انت متأكد؟",
            inputAttributes: {
                autocapitalize: "off"
            },
            showCancelButton: true,
            confirmButtonText: "نشر",
            cancelButtonText: 'الغاء',
            showLoaderOnConfirm: true,
            preConfirm: async (login) => {
                try {
                    const url = "/technicain/addpost";

                    // let formData = new FormData();
                    this.#formData.append('text', this.#text); // adding post text
                    this.#formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                    // collecting file names
                    this.#formData.append('files-list', this.#files.map(r => r.name).join(','));
                    // adding post media
                    // this.#files.forEach(fileObject => {
                    //     //formData.append(fileObject.name, fileObject.file)
                    //     formData.append('files[]', fileObject.file);
                    // });
                    // send request
                    const response = (await sendFormDataNoCallback(url, 'Post', this.#formData));
                    if (response.State == 1) {
                        return Swal.showValidationMessage(`
                            ${response.Message}
                        `);
                    }
                    return response;
                } catch (error) {
                    Swal.showValidationMessage(`
                  فشل الطلب: ${error}
                `);
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    toast: true,
                    icon: "success",
                    title: 'اكتملت العملية',
                    text: `${result.value.Message}`,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    },

                    didClose: () => {
                        this.reset();
                        showDialog();
                    }
                });
            }
        });
    }
    #noFileDuplicate(name) {
        return (this.#files.filter(f => f.name == name).length) == 0;
    }
    addFile() {
        openFilePicker((e) => {
            let fileInput = e.target;
            for(let i = fileInput.files.length -1; i > -1; i--) {
                let file= fileInput.files[i];
                if (this.#noFileDuplicate(file.name)) {
                    if (file.type.startsWith('video/') && file.size > 200 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'فشلت اضافة الملف',
                            text: 'لا يمكن اضافة ملف فيديو اكبر من 200 ميجا بايت'
                        });
                        return;
                    }
                    this.#formData.append("file_"+this.#files.length, file);
                    this.#files.push({ 'name': "file_"+this.#files.length, 'file': file });
                    this.displayFile(file);
                }
            }
            // [...fileInput.files].forEach(file => {
                
            // })
        }, true);
    }

    displayFile(file) {

        const image = document.createElement("img");
        if (file.type.startsWith('video/')) {
            this.#generateVideoThumbnail(file, image);
        } else {
            image.src = URL.createObjectURL(file);
        }

        image.alt = image.title = file.name;

        let imageBox = createChild('DIV', {
            'class': 'post-img-container',
            child: [
                image,
                createChild('DIV', {
                    'class': 'remove',
                    event: {
                        onclick: (self) => {
                            this.#files = this.#files.filter(f => {
                                f.name != file.name
                            });
                            this.#formData.delete(f.name);
                            self.parentElement.remove();
                        }
                    }
                })
            ]
        });

        this.imagesContainer.appendChild(imageBox);
    }

    #generateVideoThumbnail(file, imgContainer) {
        const video = document.createElement('video');
        video.src = URL.createObjectURL(file);
        video.currentTime = 1;

        video.addEventListener('loadeddata', function () {
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            imgContainer.src = canvas.toDataURL('image/png');
        });
    }

    reset() {
        this.#files = [];
        this.postTextArea.value = "";
        this.#text = "";
        this.imagesContainer.replaceChildren();
    }
}