function elementPropertySetter(Me, myData) {
    if(myData == undefined) return;
    for (let key in myData) {
        if (myData[key] == null) continue;
        if (key == "text")
            Me.innerText = myData[key];
        else if (key == "html")
            Me.innerHTML = myData[key];
        else if (key == "child") {
            let child = myData[key];
            if (Array.isArray(child))
                child.forEach(c => Me.appendChild(c));
            else
                Me.appendChild(child);
        }
        else if (key == "event") {
            let events = myData[key];

            for (let event in events) {
                Me[event] = () => events[event](Me);
            }
        }
        else
            Me.setAttribute(key, myData[key]);
    }
}

function addElement(parent, me, myData) {
    let Me = document.createElement(me);
    elementPropertySetter(Me, myData);

    parent.appendChild(Me);
}
function modifyElement(Me, myData) {
    elementPropertySetter(Me, myData);
    return Me;
}
function createChild(me, myData) {
    let Me = document.createElement(me);
    elementPropertySetter(Me, myData);

    return Me;
}


document.createChild = createChild;
document.addElement = addElement;
document.modifyElement = modifyElement;