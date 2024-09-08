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
    let value = await fetch(url, {
        method: type || "GET",
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
        },

        body: data
    }).catch(e => onfailure?.());

    if(onsuccess != null) {
        value.then(a => a.json()).then(a => onsuccess(a));
        return null;
    }
    else 
        return value;
}