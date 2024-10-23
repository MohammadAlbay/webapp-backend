var PostsView = {
    defultRoute: '/technicain/post/addcomment/',
    isTechnicain: true,
    actorId: -1,

    // slider is Dive containing the slideshow. we want it to keep tracking of slide current index
    // next is the next button
    // prev is the prev button
    setupNewSlider(slider, next, prev) {
        const slides = slider.querySelector('.slides');
        const slide = slider.querySelectorAll('.slide');
        //console.log(slides);
        slider.setAttribute('slider-index', 0);
        slider.setAttribute('slider-max', slide.length);

        // Function to update slide position
        function updateSlidePosition(newIndex) {
            if(newIndex < 0)
                slides.style.transform = `translateX(0%)`;
            else
                slides.style.transform = `translateX(${newIndex}00%)`;
        }

        // Setup next button click event
        next.addEventListener('click', () => {
            let currentIndex = parseInt(slider.getAttribute('slider-index')) + 1;
            let maxIndex = parseInt(slider.getAttribute('slider-max'));
            if(currentIndex >= maxIndex) return;
            slider.setAttribute('slider-index', currentIndex);
            updateSlidePosition(currentIndex);
        });

        // Setup prev button click event
        prev.addEventListener('click', () => {
            let currentIndex = parseInt(slider.getAttribute('slider-index')) - 1;
            let maxIndex = parseInt(slider.getAttribute('slider-max'));
            if(currentIndex > maxIndex || currentIndex < 0) return;
            slider.setAttribute('slider-index', currentIndex);
            updateSlidePosition(currentIndex);
        });

        // Initial position update
        updateSlidePosition();
    },

    toggleCommentsSection(n) {
        if (n.classList.contains('close'))
            n.classList.replace('close', 'open');
        else
            n.classList.replace('open', 'close');
    },

    async addComment(postId, inputElement) {
    
        if(this.actorId == -1) return;
        
        let comment = inputElement.value.trim();
        if(comment == '') return;

        let route = null;
        if(this.isTechnicain) {
            route = this.defultRoute;
        } else {
            route = "/customer/post/addcomment/"
        }

        const data = {
            'id': this.actorId,
            'comment': comment,
            'post-id': postId
        };

        let result = await sendFormDataNoCallback(route, "Post", data);
        if(result.State == 1) {
            Swal.fire({
                icon: 'warning',
                title: 'لم يتم حفظ التعليق',
                text: result.Message
            });
        } else {
            Swal.fire({
                toast: true,
                icon: "success",
                title: 'اكتملت العملية',
                text: result.Message,
                position: "top-end",
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                },

                didClose: () => {
                    location.reload();
                }
            });
            
        }
    }

}

