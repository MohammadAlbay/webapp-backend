var Homepage = {
    container: null,
    containerView: null,
    prepare(_container) {
        this.containerView = _container;
        this.container = this.containerView.querySelector(".body");
        let inputField = document.querySelector('#search-techncain-input');
        inputField.addEventListener('input', this.onInputProcessor);
        let closeButton = this.containerView.querySelector("#search-view-hide-btn");
        closeButton.addEventListener('click', () => {
            this.containerView.style.display = "none";
        })
    },
    show() {this.containerView.style.display = "block";},

    async onInputProcessor(e) {
        let inputElement = e.target;
        let value = inputElement.value;
        
        // check if value is empty
        if(value === "") return;
        // send request to fetch technicains
        let result = await sendFormDataNoCallback('/customer/search', 'Post', {technicain: value});
        // prcess request results
        if(result.State == 1) {
            // there's an error for sure!
            alert(result.Message);
        } else {
            // at this point we have to display the result to the container
            Homepage.display(result.Message);
        }

    },


    display(technicains) {
        this.container.replaceChildren();
        
        technicains.forEach(t => {
            let profile = t.profile == "Male.jpg" || t.profile == "Female.jpg" ? 
             `/sources/img/${t.profile}` : `/cloud/technicain/${t.id}/images/${t.profile}`;
            let container = document.createChild('DIV', {
                'class': 'item',
                child: [
                    document.createChild('IMG', {'class': "icon", src: profile}),
                    document.createChild('I', {'class': "name", text: t.fullname}),
                    document.createChild('I', {'class': "desc", text: t.description}),
                    document.createChild('DIV', {
                        'class': "rate-block",
                        child: [
                            document.createChild('SPAN', {'class': "fa fa-star checked"}),
                            document.createChild('SPAN', {'class': "fa fa-star checked"}),
                            document.createChild('SPAN', {'class': "fa fa-star checked"}),
                            document.createChild('SPAN', {'class': "fa fa-star checked"}),
                            document.createChild('SPAN', {'class': "fa fa-star checked"}),
                        ]
                    }),
                ],
                event: {
                    onclick(self) {
                        location.href = "/customer/technicain-view/"+t.id;
                    }
                }
            });

/*<img class="icon" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRLe5PABjXc17cjIMOibECLM7ppDwMmiDg6Dw&s" alt="">
            <i class="name">محمدمحمدمحمدمحمدمحمدمحمدمحمدمحمد اللبي</i>
            <i class="desc">dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd</i>
            <div class="rate-block">
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
            </div> */
            this.container.appendChild(container);
        });
    }
}