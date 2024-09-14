
function printItems(items) {

    let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=150');

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

    let generatedNoteKids = [];
    if (document.Configs.Note1 !== "") {
        generatedNoteKids.push(
            document.createChild("li", { text: document.Configs.Note1 })
        );
    }
    if (document.Configs.Note2 !== "") {
        generatedNoteKids.push(
            document.createChild("li", { text: document.Configs.Note2 })
        );
    }
    let generatedKids = [];
    generatedKids.push(
        document.createChild("tr", {
            child: [
                document.createChild("td", { text: "#" }),
                document.createChild("td", { text: "الاسم" }),
                document.createChild("td", { text: "الكمية" }),
                document.createChild("td", { text: "تقاس بـ" }),
                document.createChild("td", { text: "بسعر الجملة" }),
                document.createChild("td", { text: "السعر" }),
                document.createChild("td", { text: "التخفيض" }),
                document.createChild("td", { text: "الاجمالي" }),
            ]
        })
    );
    items.forEach(item => {
        generatedKids.push(
            document.createChild("tr", {
                child: [
                    document.createChild("td", { text: item.Id }),
                    document.createChild("td", { text: item.Fullname }),
                    document.createChild("td", { text: item.RequiredQuantity }),
                    document.createChild("td", { text: item.MeasuingUnit }),
                    document.createChild("td", { text: item.UsesWholesalePrice ? "نعم" : "لا" }),
                    document.createChild("td", { text: item.Price + "د.ل" }),
                    document.createChild("td", { text: item.Discount + "د.ل" }),
                    document.createChild("td", { text: (item.Price * item.RequiredQuantity - item.Discount) + "د.ل" }),
                ]
            })
        );
    });
    let printPageDiv = document.createChild("div", {
        "print-page": true,
        child: document.createChild("div", {
            container: true,

            

        })
    });

    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10
    mywindow.addEventListener('load', () => {
        mywindow.document.body.appendChild(printPageDiv);
        setTimeout(() => {
            mywindow.print();
            mywindow.close();
        }, 350);
    }, true);



    return true;
}
function printCards(cardsDetails) {
    const chunkSize = 9;
    const r = Bill.Items.reduce((arr, item, idx) => (arr[idx / chunkSize | 0] ??= []).push(item) && arr, []);
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