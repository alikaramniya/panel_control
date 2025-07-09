"use strict";

const createNewUser = document.querySelector('.create-user-btn');
const profileView = document.querySelector('.profile-view');
const profilePlaceholder = document.querySelector('.profile-placeholder');
const userList = document.querySelector('.user-list');
const formSendDocument = document.getElementById('send-document');
const listDocumentUser = document.getElementById('listDocumentUser');

userList.addEventListener('click', function (e) {
    let element = e.target;
    if (
        element.classList.contains('user-list-item') ||
        element.classList.contains('user-email') ||
        element.classList.contains('user-name') ||
        element.classList.contains('user-avatar')
    ) {
        let id = element.dataset.id;

        profileView.style.display = "block";
        profilePlaceholder.style.display = "none";

        for (let i = 0; i <= 3; i++) {
            if (findUserListItem(element)) {
                break;
            }
            element = element.parentNode;
        }

        formSendDocument.firstElementChild.value = id;

        let href = new URL(listDocumentUser.href);
        // href.searchParams.remove('id');
        href.searchParams.set('id', id)

        listDocumentUser.href = href;

        // getUserInfo(id);
    }
})

function findUserListItem(element) {
    resetAllActiveList();

    if (element.classList.contains('user-list-item')) {
        element.classList.add('active');
        return true;
    } else {
        return false;
    }
}

function resetAllActiveList() {
    let items = userList.querySelectorAll('li');

    for (const li of items) {
        li.classList.remove('active')
    }
}

createNewUser.addEventListener('click', function () {
    console.log('button clicked');
    location.href = createNewUser.dataset.href;
});

formSendDocument.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    sendFormDocumentData(formData, this.action);

    this.reset();
});

function sendFormDocumentData(data, url) {
    try {
        const xhr = new XMLHttpRequest();

        xhr.open('POST', url);

        xhr.addEventListener('load', function () {
            if (xhr.status >= 200 && xhr.status < 300 || xhr.status === 304) {
                let res = xhr.responseText;

                console.log(res);
            } else {
                console.log(xhr.status);
            }
        });

        xhr.send(data);
    } catch (e) {
        console.log(e.message);
    }
}

// function getUserInfo(id) {
//     let infoUserUrl = userList.dataset.infoUser;

//     let url = new URL(infoUserUrl);

//     url.searchParams.append('id', id);

//     try {
//         const xhr = new XMLHttpRequest();

//         xhr.open('GET', url.href);

//         xhr.addEventListener('load', function () {
//             if (xhr.status >= 200 && xhr.status < 300 || xhr.status === 304) {
//                 let res = xhr.responseText;

//                 console.log(res);
//             } else {
//                 console.log(xhr.status);
//             }
//         });

//         xhr.send();
//     } catch (e) {
//         console.log(e.message);
//     }
// }
