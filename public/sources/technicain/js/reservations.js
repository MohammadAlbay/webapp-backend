var Calendar = {
    container: null,
    calendar: null,
    calendarBody: null,
    date: null,
    prepare(_container) {
        this.container = _container;
        this.calendar = _container.querySelector('.calendar');
        this.calendarBody = _container.querySelector('.calendar > tbody');
        this.setupCalendarDays();
    },
    toggle() {
        if (this.container.classList.contains('hide'))
            this.container.classList.remove('hide');
        else
            this.container.classList.add('hide')
    },
    async addReservation(techID) {
        if(this.date == null) {
            swal.fire({
                'icon': 'error',     'title': "العملية ملغية",
                "text": "يجب ان يتم تحديد تاريخ اولا"
            });

            return;
        }

        swal.fire({
            'icon': 'info',     'title': "تنويه قبل الحجز",
            "text": `حتى تتمكن من الحجز يجب ان تحتوي محفظتك على مبلغ 15د.لأ على الاقل. علما بأنه لا يتم خصم القيمة عند 
            الحجز وإنما هو اجراء ضروري لحماية حق الفني والنظام من التلاعب. `,
            showConfirmButton: true,
            confirmButtonText: "تم",
        }).then(result => {
            if(result.isConfirmed) {
                swal.fire({
                    'icon': 'info',     'title': "تنويه قبل الحجز",
                    "text": "الموقع غير مسؤول عن أي خلاف يحدث او أي اضرار فنية او تقنية تحدث نتيجة تعاملك مع الفني",
                    showConfirmButton: true,
                    confirmButtonText: "تم",
                }).then(result => {
                    if(result.isConfirmed) {
                        this.submitProcess(techID);
                    }
                });
            }
        });
        
    },
    async submitProcess(techID) {
        let payload = {
            'date': this.date,

        };
        let result = await sendFormDataNoCallback(`/customer/addreservation/${techID}`, 'Post', payload);

        if(result.State == 1) {
            swal.fire({
                'icon': 'error',     'title': "العملية ملغية",
                "text": result.Message
            });
        } else {
            swal.fire({
                'icon': 'success',     'title': "نجحت العملية ",
                "text": result.Message
            });
        }
    },
    setDate(self) {
        let date = self.getAttribute('date');
        swal.fire({
            'icon': 'info',     'title': "تم تحديد تاريخ الحجز",
            "text": `هل انت متأكد من رغبتك بالحجز في التاريخ التالي : ${date}`,
            showConfirmButton: true,
            showCancelButton: true,
            cancelButtonText: "الغاء",
            confirmButtonText: "تم",
        }).then(result => {
            if(result.isConfirmed) {
                this.date = date;
            }
        });
    },
    setupCalendarDays() {
        // clear dates..
        this.calendarBody.replaceChildren();
        // setup dates
        let date = new Date();
        let day = date.getDate();
        let dayNameIndex = date.getDay();
        let dayName = getDayName(dayNameIndex);
        let month = date.getMonth()+1;
        let year = date.getFullYear();
        let maxDays = getDaysInMonth(month, year);
        let kids = [];

        // two weeks tracker
        let fromTheDay = 1;
        // day cursor
        let k = day - (dayNameIndex)
        // generating first row
        for(let i = 0; i < 7; i++, k++) {
            if(k > maxDays) {
                k = 1;
                month += 1;
            }

            if(i == dayNameIndex)
                kids.push(document.createChild('TD', {date: `${k}-${month}-${year}`, text:"اليوم" , 'class': "today", 'onclick': `Calendar.setDate(this)`}));
            else {
                if(i < dayNameIndex) 
                    kids.push(document.createChild('TD', {text:`${k}/${month}`, 'class': "old"}));
                else {
                    fromTheDay++;
                    kids.push(document.createChild('TD', {date: `${k}-${month}-${year}`, text:`${k}/${month}`, 'class': "new", 'onclick': `Calendar.setDate(this)`}));
                }
            }

        }
        // add first row of dates
        this.calendarBody.appendChild(document.createChild('TR', {
            child: kids
        }));
        // generating second row of dates
        kids = [];
        for(let i = 0; i < 7; i++, k++) {
            fromTheDay++;
            if(k > maxDays) {
                k = 1;
                month += 1;
            }
            if(fromTheDay < 14)
                kids.push(document.createChild('TD', {date: `${k}-${month}-${year}`, text:`${k}/${month}`, 'class': "new", 'onclick': `Calendar.setDate(this)`}));
            else
                kids.push(document.createChild('TD', {date: `${k}-${month}-${year}`, text:`${k}/${month}`, 'class': "outbound", 'onclick': `Calendar.setDate(this)`}));
        }
        // add second row of dates
        this.calendarBody.appendChild(document.createChild('TR', {
            child: kids
        }));
        // generating third row of dates
        kids = [];
        for(let i = 0; i < 7; i++, k++) {
            fromTheDay++;
            if(k > maxDays) {
                k = 1;
                month += 1;
            }
            
            if(fromTheDay < 14)
                kids.push(document.createChild('TD', {date: `${k}-${month}-${year}`, text:`${k}/${month}`, 'class': "new", 'onclick': `Calendar.setDate(this)`}));
            else
                kids.push(document.createChild('TD', {date: `${k}-${month}-${year}`, text:`${k}/${month}`, 'class': "outbound", 'onclick': `Calendar.setDate(this)`}));
        }
        // add third row of dates
        this.calendarBody.appendChild(document.createChild('TR', {
            child: kids
        }));
    },

    notAllowed() {
        swal.fire({
            'icon': 'error',     'title': "العملية ملغية",
            "text": "حساب الفني معطل. لا يمكن الحجز عنده مؤقتا"
        });
    }
}

function getDaysInMonth(m, y) {  
    return m===2?y&3||!(y%25)&&y&15?28:29:30+(m+(m>>3)&1);
}

function getDayName(dayIndex) {
    let day = "";
    switch (dayIndex) {
        case 0:
            day = "Sun"
            break;
        case 1:
            day = "Mon"
            break;
        case 2:
            day = "Tue";
            break;
        case 3:
            day = "Wed";
            break;
        case 4:
            day = "Thu";
            break;
        case 5:
            day = "Fri";
            break;
        case 6:
            day = "Sat";
            break;
        default:
            day = ""
            break;
    }

    return day;
}