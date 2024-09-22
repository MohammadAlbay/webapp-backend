
function printItems(items) {

    let mywindow = window.open('', 'PRINT', 'width=200;height=200');

    mywindow.document.write("<html><head><title>Printing Prepaidcards</title>");
    mywindow.document.write('<link rel="stylesheet" href="/sources/employee/css/printcard.css" />');
    mywindow.document.write(`
    <script>
      var link = document.createElement('link');
      link.rel="stylesheet";
      link.href = "/www/css/childui.css";
      document.head.appendChild(link);
    </script>
    `);

    mywindow.document.write('</head><body>');

    let kids = [];
    items.forEach(item => {
        const checker = (item.serial + "").match(/.{1,4}/g);
        let serialNumber = checker.join("  ");
        let qrCodeImage = document.createChild('div', {'class': 'qrcode'});
        var qrcode = new QRCode(qrCodeImage, {
            text: serialNumber,
            width: 120,
            height: 120,//128,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        let element = document.createChild("div", {
            "class": 'prepaidcard',
            child: document.createChild('div', {
                    'class': "container",
                    child: [
                        qrCodeImage,
                        document.createChild('strong', { text: serialNumber, 'class': 'qrlabel' }),
                        document.createChild('strong', { 
                            text: item.price, 'class': 'pricetag',
                            price: 'د.ل'
                         }),
                    ]
                }),
        });

        kids.push(element);
    });



    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10
    mywindow.addEventListener('load', () => {
        //mywindow.document.body.classList.add('card-container');
        kids.forEach(kid => mywindow.document.body.appendChild(kid));
        setTimeout(() => {
            mywindow.print();
            mywindow.close();
        }, 380);
    }, true);



    return true;
}
function printCards(cardsDetails) {
    const chunkSize = 30;
    const r = cardsDetails.reduce((arr, item, idx) => (arr[idx / chunkSize | 0] ??= []).push(item) && arr, []);
    try {
        r.forEach(items => {
            printItems(items);
        });
    }
    catch (e) {
        alert("حذثت مشكلة اثناء طباعةالفاتورة");
        console.error(e);
    }

}