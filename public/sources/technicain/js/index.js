let navMenu = document.getElementById('md-nav-menu-id');

let navigationMenuItems = document.querySelectorAll('.md-menu-section');
function closeAllNavOptions(except) {
    document.querySelectorAll('.md-menu-section-list').forEach(e => {
        //e.classList.remove('md-menu-section-list-show');
        if(except == e) return;
        e.parentElement.classList.remove('md-menu-section-expand');
    });
}
navigationMenuItems.forEach(item => {
    item.addEventListener('mouseup', (e) => {
        let list=item.querySelector('.md-menu-section-list');
        if(list == null) return;
        list.classList.toggle('md-menu-section-list-show');
        item.classList.toggle('md-menu-section-expand');
        closeAllNavOptions(list);
    });
});


function showHide(n) {
    if (n.classList.contains('md-nav-menu-hide')) {
        n.classList.replace('md-nav-menu-hide', 'md-nav-menu-show');
        n.classList.toggle('md-navmenu-expand-manualy', true);
        return "shown";
    }
    else if (n.classList.contains('md-nav-menu-show')) {
        n.classList.replace('md-nav-menu-show', 'md-nav-menu-hide');
        n.classList.toggle('md-navmenu-expand-manualy', false);
        return "hidden";
    }
    else if(n.classList.contains('md-navmenu-expand-manualy')){
        n.classList.replace('md-navmenu-expand-manualy', 'md-nav-menu-hide');
        return "hidden";
    } else {
        n.classList.toggle('md-nav-menu-show');
        n.classList.toggle('md-navmenu-expand-manualy', true);
        return "shown";
    }

        //md-navmenu-expand-manualy
}

let navMenuToggleIcon = document.querySelector('.nav-toggle-icon');
if(navMenuToggleIcon != null ) {
    navMenuToggleIcon.addEventListener('click', e => {
        e.target.classList.toggle('close');
        if(navMenu != null) {
            let result = showHide(navMenu);
            if(result == "shown")
                e.target.classList.toggle('close', true);
            else
                e.target.classList.toggle('close', false);
        }
    });
}