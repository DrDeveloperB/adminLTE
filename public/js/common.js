/**
 * 쿠키 저장
 * @param cookieName
 * @param cookieValue
 * @param expiresDays : int 유효기간 (일)
 */
function setCookie(cookieName, cookieValue, expiresDays) {
    if (typeof cookieName === "string" && cookieName !== "") {
        let expires = '';
        if (Number.isInteger(expiresDays)) {
            const d = new Date();
            d.setTime(d.getTime() + (expiresDays * 24 * 60 * 60 * 1000));
            expires = "expires="+d.toUTCString();
        }
        document.cookie = cookieName + "=" + encodeURIComponent(cookieValue) + ";" + expires + ";path=/";
    } else {
        console.log('error: check cookieName');
    }
}
// function setCookie(cookie_name, value, days) {
//     var exdate = new Date();
//     exdate.setDate(exdate.getDate() + days); // 설정 일수만큼 현재시간에 만료값으로 지정
//     var cookie_value = escape(value) + ((days == null) ? '' : '; expires=' + exdate.toUTCString());
//     document.cookie = cookie_name + '=' + cookie_value;
// }

/**
 * 쿠키 불러오기
 * @param cookieName
 * @returns {string}
 */
function getCookie(cookieName) {
    if (typeof cookieName === "string" && cookieName !== "") {
        let name = cookieName + "=";
        let cookieArray = document.cookie.split(';');

        if (cookieArray.some((item) => item.trim().startsWith(name))) {
            const cookieValue = cookieArray
                .find((item) => item.trim().startsWith(name))
                .split('=')[1];

            return decodeURIComponent(cookieValue);
        }
    }

    return "";
}
// function getCookie(cookie_name) {
//     var x, y;
//     var val = document.cookie.split(';');
//     for (var i = 0; i < val.length; i++) {
//         x = val[i].substr(0, val[i].indexOf('='));
//         y = val[i].substr(val[i].indexOf('=') + 1);
//         x = x.replace(/^\s+|\s+$/g, ''); // 앞과 뒤의 공백 제거하기
//         if (x == cookie_name) {
//             return unescape(y); // unescape로 디코딩 후 값 리턴
//         }
//     }
// }

/**
 * 동적 form data 생성
 * @param oFrmConfig : object html form 생성 여부, html form method 설정
 'inHtml' : false,        	// true : in HTML || false : not in HTML
 'id' : 'dynamic_frm',		// form id
 'name' : 'dynamic_frm',	// form name
 'method' : 'get',    		// get || post
 'enctype' : 'application/x-www-form-urlencoded',      // application/x-www-form-urlencoded || multipart/form-data || text/plain
 'action' : '',          	// url || URI
 * @param oParam : object 전송할 파라미터 (parameter name : parameter value)
 * @returns {FormData | HTMLFormElement} : form object
 */
function fnCreateFrm(oFrmConfig, oParam) {
    let oFrm = {};
    const bInHtml = oFrmConfig.inHtml || false;
    const sID = oFrmConfig.id || 'dynamic_frm';
    const sName = oFrmConfig.name || 'dynamic_frm';
    const sMethod = oFrmConfig.method || 'get';
    const sEnctype = oFrmConfig.enctype || 'application/x-www-form-urlencoded';
    const sUrl = oFrmConfig.action || '';

    if (bInHtml) {
        // foreground : page move
        oFrm = document.createElement('form');      //$('<form></form>');
        let oInput = document.createElement('input');

        oFrm.setAttribute('id', sID);
        oFrm.setAttribute('name', sName);
        oFrm.setAttribute('method', sMethod);
        oFrm.setAttribute('enctype', sEnctype);      // application/x-www-form-urlencoded || text/plain || multipart/form-data
        oFrm.setAttribute('action', sUrl);

        Object.entries(oParam).forEach(([k, v]) => {
            oInput = document.createElement('input');
            oInput.setAttribute('type', 'hidden');
            oInput.setAttribute('name', k);
            oInput.setAttribute('value', v);
            oFrm.appendChild(oInput);
        });

        const elFrm = document.getElementById(sID);    // HTMLFormElement or null
        // 동적 form 이 생성되어 있는 경우 삭제 후 재생성
        if (elFrm) document.body.removeChild(elFrm);
        document.body.appendChild(oFrm);
    } else {
        // background : call 비동기(Ajax) or 동기(Promise XMLHttpRequest)
        oFrm = new FormData();
        Object.entries(oParam).forEach(([k, v]) => {
            oFrm.append(k, v);
        });
    }

    return oFrm;
}

/**
 * input type="text" 를 이용한 클립보드 복사
 * @param elID : string 복사할 input tag id
 * @param msg : string 알림 메세지
 */
function copy_text_input(elID, msg) {
    let obj = document.getElementById(elID);
    obj.select();   //인풋 컨트롤의 내용 전체 선택
    document.execCommand("copy"); //복사
    obj.setSelectionRange(0, 0); //선택영역 초기화
    if (msg) alert(msg);
}

/**
 * textarea 태그를 이용한 클립보드 복사
 * @param obj : object 클릭한 영역 this object
 * @param msg : string 알림 메세지
 */
function copy_text_target(obj, msg)
{
    let target = document.querySelector('#clip_target');        // textarea
    target.innerText = obj.dataset.clip;        // textarea 에 복사할 텍스트 입력

    try {
        target.select();   // textarea 의 내용 전체 선택
        document.execCommand("copy"); //복사
        target.setSelectionRange(0, 0); //선택영역 초기화
        if (msg) alert(msg);
    } catch (err) {
        alert('이 브라우저는 지원하지 않습니다.');
    }
}

/**
 * 이미지 미리보기
 * @param imgFile
 * @param defaultEl : string 미리보기 영역 기본 이미지
 * @param changeEl
 */
function fnDrawImg(imgFile, defaultEl, changeEl)
{
    let imageDefault = document.getElementById(defaultEl).value;
    let imageView = document.getElementById(changeEl);

    if (imgFile) {
        let reader = new FileReader();
        // reader 동작시 (binary data 생성) 화면에 보여줌
        reader.onloadend = () => {
            imageView.src = reader.result;
        }
        // binary data 생성
        reader.readAsDataURL(imgFile);
    } else {
        imageView.src = imageDefault;
    }
}

/**
 * 숫자 3자리마다 콤마 찍기
 * @param str
 * @returns {string|*}
 */
function fnComma(str) {
    if (typeof (str) == "undefined" || typeof (str) == "object" || typeof (str) === undefined) return str;

    str = String(str);
    return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
}



// DOM 로드 후
window.addEventListener('DOMContentLoaded', function() {
    // console.log(getCookie('darkMode'), typeof getCookie('darkMode'))
    if (getCookie('darkMode') === 'true') {
        const dark_mode_switch = document.getElementById("dark_mode_switch");
        const main_navbar = document.getElementById("main_navbar");
        if (dark_mode_switch) dark_mode_switch.checked = true;
        if (main_navbar) main_navbar.classList.add("navbar-dark");

        document.body.classList.add("dark-mode");

        // $('#dark_mode_switch').prop('checked', true);
        // // $('.fas').addClass('far');
        // // $('.far').removeClass('fas');
        // $('#main_navbar').addClass('navbar-dark');
        // $('body').addClass('dark-mode');
    }
});

// $(function () {
// });

// DOM + 이미지 로드 후
window.addEventListener("load", function(event) {
    const dark_mode_switch = document.getElementById("dark_mode_switch");
    const main_navbar = document.getElementById("main_navbar");
    if (dark_mode_switch) {
        dark_mode_switch.addEventListener('click', function(event) {
            if (dark_mode_switch.checked) {
                main_navbar.classList.add("navbar-dark");
                document.body.classList.add("dark-mode");
                setCookie("darkMode", 'true', 36500);
            } else {
                main_navbar.classList.remove("navbar-dark");
                document.body.classList.remove("dark-mode");
                setCookie("darkMode", 'false', 9999999999);
            }
        });
    }
    // $('#dark_mode_switch').on('click', function () {
    //     if ($(this).is(':checked')) {
    //         // $('.fas').addClass('far');
    //         // $('.far').removeClass('fas');
    //         $('#main_navbar').addClass('navbar-dark');
    //         $('body').addClass('dark-mode');
    //         setCookie("darkMode", '1');
    //     } else {
    //         // $('.far').addClass('fas');
    //         // $('.fas').removeClass('far');
    //         $('#main_navbar').removeClass('navbar-dark');
    //         $('body').removeClass('dark-mode');
    //         setCookie("darkMode", '0');
    //     }
    // });
});
