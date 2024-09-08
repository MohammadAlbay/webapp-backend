var ViewFetch = {
    // Searchs for links and bind them with the default route. after that fetching view content
    // is "Load" responsibility
    // displaying content is "Render" responsibility
    Init(host) {
        this.Host = host;
        let links = document.querySelectorAll('a.nav-link');

        links.forEach(link => {
            link.addEventListener('click', async (e) => {
                e.preventDefault();
                await ViewFetch.ProxyOnClick(link);
            })
        });

        window.addEventListener("popstate", this.Router);

        this.addToHistory('/employee/page/');
        this.addToHistory('main');
    },

    async ProxyOnClick(self) {
        if (self == null) {
            console.error("ViewFetch::ProxyOnClick(self) : self cannot be null");
            return;
        }

        let href = self.getAttribute('href');
        if (href == null || href == "") {
            console.error("ViewFetch::ProxyOnClick(self) : self.href cannot be null/empty");
            return;
        }
        if(href.startsWith("#")) return;
        await this.Load(href);
    },
    Unload() {
        if(this.CurrentView == null) return;

        let scripts = document.querySelectorAll('script[for-view="'+this.CurrentView+'"], link[for-view="'+this.CurrentView+'"]');
        scripts.forEach(element => element.remove());
    },
    async Load(href, backward = false) {
        this.Unload();

        if(backward) {
            let temp = href.split('/');
            href = temp[temp.length-1];
        }
        let view = await fetch('/employee/resources/' + href).then(a => a.text());

        let parser = new DOMParser();
        let page = parser.parseFromString(view, "text/html");
        this.Host.replaceChildren();
        let body = page.children[0].children[1];
        let head = page.children[0].children[0];
        let scripts = body.querySelectorAll('script');
        let newScriptElements = [];
        scripts.forEach(s => {
            let newScript = document.createElement("script");
            newScript.setAttribute('for-view', href);
            if(s.getAttribute('src') !== null) {
                newScript.src = s.src;
            } else {
                let inlineScript = document.createTextNode(s.innerText);
                newScript.appendChild(inlineScript);
            }
            
            newScriptElements.push(newScript);
            s.remove();
        });

        let links = head.querySelectorAll('link[rel="stylesheet"]');

        links.forEach(l => {
            l.setAttribute('for-view', href);
            document.head.appendChild(l);
        });

        newScriptElements.forEach(script => document.body.appendChild(script));

        this.Host.appendChild(body);

        this.CurrentView = href;

        this.addToHistory(href, backward ? true : false);
        //history.pushState(null, null, href);
        //history.replaceState(null, null, href);
    },

    addToHistory(url, fix = false) {
        fixedUrlPath = location.pathname.split('/');
        fixedUrlPath = fixedUrlPath[fixedUrlPath.length-1];
        
        
        if(fix) {
            newUrl = url.split('/');
            newUrl = newUrl[newUrl.length-1];

            if(newUrl === fixedUrlPath) return;
            history.pushState(null, null, newUrl);
        }
        else {
            if(url === fixedUrlPath) return;
            history.pushState(null, null, url);
        }
    },

    async Router() {
          //alert('"'+location.pathname+'"');
        await ViewFetch.Load(location.pathname, true);
    },
    Host: document.body,
    CurrentView : null
}



















ViewFetch.Init(document.getElementById('main_panel'));

