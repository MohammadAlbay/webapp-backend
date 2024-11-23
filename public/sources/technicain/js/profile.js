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

async function switchAccountState(state) {
    let url = "/technicain/back-to-business";
    if(state == "pause") {
        url = "/technicain/take-break";
    } 

    let result = await sendFormDataNoCallback(url, 'Post', {});
    if (result.State == 1) {
        Swal.fire({
            icon: 'warning', title: 'خطأ',
            text: result.Message
        });
    } else {
        Swal.fire({
            icon: 'success', title: 'اكتملت العمية بنجاح',
            text: result.Message
        }).then(() => {
            location.reload();
        });

    }
    
}


var newPost = null;
let newPostDialog = document.querySelector('#add-post-dialog');
function showDialog() {
    if (newPostDialog.getAttribute('open') != null) {
        if(newPost.isModify) {
            history.back();
        }
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
    isModify = false;
    #fileCountTracker = -1;
    #files = [];
    #text = "";
    #formData = null;
    container = null;
    imagesContainer = null;
    postTextArea = null;
    url = "/technicain/addpost";
    constructor(parentContainer) {
        this.#fileCountTracker = 0;
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
        parentContainer.querySelector('#techincain-edit-post-submit')
            ?.addEventListener('click', e => {
                this.submit();
            });
        this.postTextArea.addEventListener('change', e => {
            let btn1 = parentContainer.querySelector('#techincain-add-post-submit');
            let btn2 = parentContainer.querySelector('#techincain-edit-post-submit');
            if (isDirty(e.target.value)) {
                btn1?.classList.toggle('disabled', true);
                btn2?.classList.toggle('disabled', true);
                Swal.fire({
                    icon: 'warning',
                    title: ' الفاظا بذيئة',
                    text: 'اكتشف النظام الفاظا اذيئة كنت قد ادخلتها في احد حقول الادخال. لن تتمكن من المتابعة حتى تعدل ما ادخلته',
                    timer: 4200,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            }
            else {
                btn1?.classList.toggle('disabled', false);
                btn2?.classList.toggle('disabled', false);
            }
            this.#text = e.target.value;
        });
    }
    submit() {
        if (this.#text == "") {
            Swal.fire({
                icon: 'warning',
                title: 'المنشور غير مكتمل',
                text: this.isModify ? 'لا يمكن حفظ المنشو بدون كتابة نص للمنشور ' : 
                            'لا يمكن اضافة منشور بدون كتابة نص للمنشور '
            });
            return;
        }
        Swal.fire({
            icon: 'question',
            title: this.isModify ? "حفظ التغييرات" : "اضافة منشور",
            text: "هل انت متأكد؟",
            inputAttributes: {
                autocapitalize: "off"
            },
            showCancelButton: true,
            confirmButtonText: this.isModify ? "حفظ" :"نشر",
            cancelButtonText: 'الغاء',
            showLoaderOnConfirm: true,
            preConfirm: async (login) => {
                try {
                    const url = this.url;

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
                        if(this.isModify) {
                            location.href = "/technicain/posts";
                        }
                        this.reset();
                        showDialog();
                    }
                });
            }
        });
    }
    #noFileDuplicate(name) {
        return (this.#files.filter(f => f.file.name == name).length) == 0;
    }


    static buildFileFromUploadedFiles(arr) {
        let o = {
            target: {
                files: arr.map(a => {
                    return {name: a.image, type: isImageOrVideo(a.image), size: 4194304, virtual: true}
                })
            }
        };

        return o;
    }
    setText(text) {
        this.#text = text;
    }
    async setFiles(e) {
        /*
        Fiels is just a simple object mimicking the actual input file 
        it looks like :
         files = {
            target: {
                files: [
                    {
                        name: ".."
                        type: ".."
                        size:  ..
                    }
                ]
            }
         }
        */

         let fileInput = e.target;
         for (let i = fileInput.files.length - 1; i > -1; i--) {
             const fileName = fileInput.files[i].name;
             let file = await convertUrlToFile(fileName);
             if (this.#noFileDuplicate(file.name)) {
                 if (file.type.startsWith('video/') && file.size > 200 * 1024 * 1024) {
                     Swal.fire({
                         icon: 'error',
                         title: 'فشلت اضافة الملف',
                         text: 'لا يمكن اضافة ملف فيديو اكبر من 200 ميجا بايت'
                     });
                     return;
                 }
                 this.#formData.append("file_" + this.#fileCountTracker, file);
                 this.#files.push({ 'name': "file_" + this.#fileCountTracker, 'file': file });
                 this.displayFile(file);
                 this.#fileCountTracker++;
             }
         }
    }
    addFile() {
        openFilePicker(e => {
            let fileInput = e.target;
            for (let i = fileInput.files.length - 1; i > -1; i--) {
                let file = fileInput.files[i];
                if (this.#noFileDuplicate(file.name)) {
                    if (file.type.startsWith('video/') && file.size > 200 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'فشلت اضافة الملف',
                            text: 'لا يمكن اضافة ملف فيديو اكبر من 200 ميجا بايت'
                        });
                        return;
                    }
                    this.#formData.append("file_" + this.#fileCountTracker, file);
                    this.#files.push({ 'name': "file_" + this.#fileCountTracker, 'file': file });
                    this.displayFile(file);
                    this.#fileCountTracker++;
                }
            }
        }, true);
    }

    displayFile(file) {

        const image = document.createElement("img");
        if (file.type.startsWith('video/')) {
            this.#generateVideoThumbnail(file, image);
        } else {
            image.src = file.virtual == undefined ? URL.createObjectURL(file) : file.name;
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
                            let key = "";
                            this.#files = this.#files.filter(f => {
                                if(f.file.name == file.name) key = f.name;
                                return f.file.name != file.name
                            });
                            this.#formData.delete(key);
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
        video.src = file.virtual == undefined ? URL.createObjectURL(file) : file.name;
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

async function convertUrlToFile(url) {
    const response = await fetch(url);
    const blob = await response.blob();
    const fileName = url.split('/').pop(); 

    const file = new File([blob], fileName, { type: blob.type, lastModified: Date.now() });

    return file;
}

function isImageOrVideo(url) {
    const imageExtensions = /\.(jpg|jpeg|png|gif|bmp|tiff|webp)$/i;
    const videoExtensions = /\.(mp4|avi|mov|wmv|flv|mkv|webm)$/i;

    if (imageExtensions.test(url)) {
        return 'image';
    }
    else if (videoExtensions.test(url)) {
        return 'video';
    } else {
        return 'unknown';
    }
}




var RateProcessor = {
    value: -1,
    show(dialog) { dialog.classList.replace("hide", "show"); dialog.classList.toggle("show", true); },
    hide(dialog) { dialog.classList.replace("show", "hide"); dialog.classList.toggle("hide", true); },
    setupRateDialog(dialog) {
        let stars = dialog.querySelectorAll('.stars-container > img[star-value]');
        stars.forEach(star => {
            star.addEventListener('mouseenter', e => {
                if (star.getAttribute("checked")) return;
                loopThroughPreStars(star, (preStar) => {
                    preStar.setAttribute("src", "/rahma-ui/storage/images/icons8-star-48_colored.png");
                });
            });

            star.addEventListener('mouseleave', e => {
                if (star.getAttribute("checked")) return;
                loopThroughPreStars(star, (preStar) => {
                    if (preStar.getAttribute("checked")) return;
                    preStar.setAttribute("src", "/rahma-ui/storage/images/icons8-star-48_uncolored.png");
                });
            });

            star.addEventListener('click', e => {
                // unselect all
                loopThroughPreStars(star, (preStar) => {
                    preStar.removeAttribute("checked");
                    preStar.setAttribute("src", "/rahma-ui/storage/images/icons8-star-48_uncolored.png");

                }, 5);

                //select new
                loopThroughPreStars(star, (preStar) => {
                    preStar.setAttribute("checked", true);
                    preStar.setAttribute("src", "/rahma-ui/storage/images/icons8-star-48_colored.png");
                });

                // saving the value
                this.setValue(star);
            });
        });

        function loopThroughPreStars(star, callback, from_last = null) {
            let starLevel = parseInt(star.getAttribute("star-value"));

            for (let i = from_last ?? starLevel; i > 0; i--) {
                let preStar = document.querySelector(`.stars-container > img[star-value="${i}"]`);
                callback(preStar, i);
            }
        }
    },

    setValue(star) {
        let value= parseInt(star.getAttribute("star-value"));
        this.value = value;
    },

    async saveRate(technicainID) {
        if(this.value == -1) {
            Swal.fire({icon: 'error', 'title': "قم بإختيار عدد النجوم اولا" });
        }

        let url = `/customer/rate/${technicainID}/${this.value}`;
        let result = await sendFormDataNoCallback(url, 'Post', {})

        if (result.State == 1) {
            Swal.fire({
                icon: 'warning', title: 'خطأ',
                text: result.Message
            });
        } else {
            Swal.fire({
                icon: 'success', title: 'اكتملت العمية بنجاح',
                text: result.Message
            }).then(() => {
                location.reload();
            });
    
        }
    }
}