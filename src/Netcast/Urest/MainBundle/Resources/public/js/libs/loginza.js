LOGINZA.providers_set = 'facebook,google';
LOGINZA.ajax          = true;

LOGINZA.show = function () {
    // пред выбор провайдера
    LOGINZA.selected_provider = LOGINZA.getQueryStringValue(this, 'provider');
    // установка языка интерфейса
    LOGINZA.lang = LOGINZA.getQueryStringValue(this, 'lang');
    // мобильная версия
    LOGINZA.mobile = LOGINZA.getQueryStringValue(this, 'mobile');
    // определение устройства
    if (LOGINZA.mobile == 'auto') {
        var nav = window.navigator.userAgent;
        var mobua = ['iPhone', 'Android', 'iPad', 'Opera Mobi', 'Kindle/3.0'];
        LOGINZA.mobile = false;
        for (var i=0; i < mobua.length; i ++) {
            if (nav.indexOf(mobua[i]) >= 0) {
                LOGINZA.mobile = true;
                break;
            }
        }
    } else if (LOGINZA.mobile) {
        LOGINZA.mobile = true;
    } else {
        LOGINZA.mobile = false;
    }

    if (!LOGINZA.mobile && !LOGINZA.loaded) {
        var cldDiv = document.createElement("div");
        cldDiv.id = 'loginza_auth_form';
        cldDiv.style.overflow = 'visible';
        cldDiv.style.backgroundColor = 'transparent';
        cldDiv.style.zIndex = '10000';
        cldDiv.style.position = 'fixed';
        cldDiv.style.display = 'block';
        cldDiv.style.top = '0px';
        cldDiv.style.left = '0px';
        cldDiv.style.textAlign = 'center';
        cldDiv.style.height = '878px';
        cldDiv.style.width = '1247px';
        cldDiv.style.paddingTop = '125px';
        cldDiv.style.backgroundImage = 'url('+LOGINZA.service_host+'/img/widget/overlay.png)';

        var cntDiv = document.createElement("div");
        cntDiv.style.position = 'relative';
        cntDiv.style.display = 'inline';
        cntDiv.style.overflow = 'visible';

        var img = document.createElement("img");
        img.onclick = LOGINZA.close;
        img.style.position = 'relative';
        img.style.left = '348px';
        img.style.top = '-332px';
        img.style.cursor = 'hand';
        img.style.width = '7px';
        img.style.height = '7px';
        img.style.border = '0';
        img.alt = 'X';
        img.title = 'Close';
        img.src = LOGINZA.service_host+'/img/widget/close.gif';

        var iframe = document.createElement("iframe");
        iframe.id = 'loginza_main_ifr';
        iframe.width = '359';
        iframe.height = '350';

        if (LOGINZA.mobile) {
            iframe.width = '320';
            iframe.height = '480';
        }
        iframe.scrolling = 'no';
        iframe.frameBorder = '0';
        iframe.src = "javascript:'<html><body style=background-color:transparent><h1>Loading...</h1></body></html>'";

        // appends
        cntDiv.appendChild(img);
        cldDiv.appendChild(cntDiv);
        cldDiv.appendChild(iframe);

        try {
            cldDiv.style.paddingTop = (window.innerHeight-350)/2 + 'px';
        } catch (e) {
            cldDiv.style.paddingTop = '100px';
        }
        cldDiv.style.paddingLeft = 0;
        cldDiv.style.height = '2000px';
        cldDiv.style.width = document.body.clientWidth + 50 + 'px';
        // создание контейнера для формы
        document.body.appendChild(cldDiv);
        // форма загружена
        LOGINZA.loaded = true;

        // включена AJAX авторизация
        if (LOGINZA.ajax) {
            setInterval(LOGINZA.hashParser, 500);
        }
    }

    if (!LOGINZA.token_url) {
        alert('Error token_url value!');
    } else {
        var loginza_url = LOGINZA.service_host+'/api/widget.php?overlay=true&w='
        +document.body.clientWidth+
        '&token_url='+encodeURIComponent(LOGINZA.token_url)+
        '&provider='+encodeURIComponent(LOGINZA.selected_provider)+
        '&providers_set='+encodeURIComponent(LOGINZA.providers_set)+
        '&lang='+encodeURIComponent(LOGINZA.lang)+
        '&ajax='+(LOGINZA.ajax ? 'true' : 'false')+
        (LOGINZA.mobile ? '&mobile=true' : '');

        if (LOGINZA.mobile) {
            document.location = loginza_url;
        } else {
            document.getElementById('loginza_main_ifr').setAttribute('src', loginza_url);
        }
    }

    if (!LOGINZA.mobile) {
        // показать форму
        document.getElementById('loginza_auth_form').style.display = '';
    }
    return false;
};