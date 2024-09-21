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




async function requestPrepaidCardsGeneration(self, quantity, balance) {
    self.disabled = true;

    let url = "/prepaidcards/generate/"+quantity.value+"/"+balance.value;

    await fetch(url, {
        method: "GET",
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(a => a.json()).then(async cards => {
        await displayCard(cards.map(c => {
            const checker = (c+"").match(/.{1,4}/g);
            return checker.join("  ");
        }));
    });
    self.disabled = false;
}




async function displayCard(cards) {
    let container = document.querySelector(".cards-container");

    cards.forEach(card => {
        let div = document.createElement("div"), 
            imgDiv = document.createElement("div"),
            labelBold = document.createElement("B");
        div.className = "card";
        imgDiv.className = "img";
        labelBold.className = "label";
        labelBold.innerText = card;
        div.appendChild(imgDiv);
        div.appendChild(labelBold);
        container.appendChild(div);

        var qrcode = new QRCode(imgDiv, {
            text: card,
            width: 128,
            height: 128,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    })
}





async function sendFormData(url, type, data, onsuccess, onfailure) {
    let headers = {
        'Accept': 'application/json',
        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
    };

    if(!(data instanceof FormData)) {
        headers['Content-Type'] = 'application/json';
        data = JSON.stringify(data);
    }

    let options = {
        method: type || "GET",
        credentials: "same-origin",
        headers: headers,
        body: data
    };

    if(type.toLowerCase() === "get") {
        delete options['body'];
    }
    
    let value;
    let promise = await fetch(url, options).then(e => e.json()).then(async v => {
        if(onsuccess != undefined) {
            await onsuccess?.(v);
            return v;
        } else {
            value = v;
            return v;
        }
    }).catch(async e => await onfailure?.());
    return value;
}