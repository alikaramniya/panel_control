"use strict";

const createNewUser = document.querySelector('.create-user-btn');
const profileView = document.querySelector('.profile-view');
const profilePlaceholder = document.querySelector('.profile-placeholder');
const userList = document.querySelector('.user-list');
const formSendDocument = document.getElementById('send-document');
const listDocumentUser = document.getElementById('listDocumentUser');

const passwordInput = document.querySelector('input[name="password"]');
const passwordInfo = passwordInput.nextElementSibling;
let oldPasswordInputValue = null;
let passwordUpdateAction = false;

const searchInput = document.getElementById('search');
const searchInfo = searchInput.nextElementSibling;
let oldSearchInputValue = null;
let searchAction = false;
let searchTimer = null;

let id;

userList.addEventListener('click', function (e) {
    let element = e.target;
    if (
        element.classList.contains('user-list-item') ||
        element.classList.contains('user-email') ||
        element.classList.contains('user-name') ||
        element.classList.contains('user-avatar')
    ) {
        id = element.dataset.id;

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

passwordInput.addEventListener('input', function () {
    clearTimeout(passwordUpdateAction);

    if (oldPasswordInputValue !== this.value.trim()) {
        passwordInfo.innerHTML = `<span style="color:blue">در حال ارسال رمز جدید</span>`;
    }

    passwordUpdateAction = setTimeout(() => {
        if (!this.value.trim()) {
            return;
        }
        if (oldPasswordInputValue !== this.value.trim()) {
            oldPasswordInputValue = this.value.trim();

            passwordInput.disabled = true;

            updatePasswordAction(oldPasswordInputValue);
        } else {
            passwordInfo.innerHTML = "";
        }
    }, 1000)
});

function updatePasswordAction(passwordValue) {
    let urlUpdate = passwordInput.dataset.url;

    let url = new URL(urlUpdate);

    url.searchParams.set('id', id);
    url.searchParams.set('password', passwordValue);

    try {
        const xhr = new XMLHttpRequest();

        xhr.open('GET', url.href);

        xhr.addEventListener('load', function () {
            if (xhr.status >= 200 && xhr.status < 300 || xhr.status === 304) {
                let res = JSON.parse(xhr.responseText);

                if (res.status == 'error') {
                    passwordInfo.innerHTML = `<span style="color:red">${res.errors.password}</span>`;
                } else if (res.status === 'success') {
                    passwordInfo.innerHTML = `<span style="color:green">${res.message}</span>`;
                }

                passwordInput.disabled = false;
                setTimeout(() => passwordInfo.innerHTML = '', 5000);
            } else {
                console.log(xhr.status);
            }
        });

        xhr.send();
    } catch (e) {
        console.log(e.message);
    }
}

searchInput.addEventListener('input', function () {
    clearTimeout(searchAction);

    if (oldSearchInputValue !== this.value.trim()) {
        searchInfo.innerHTML = `<span style="color:blue">در حال جستجو</span>`;
    }

    searchAction = setTimeout(() => {
        if (oldSearchInputValue !== this.value.trim()) {
            oldSearchInputValue = this.value.trim();

            searchInput.disabled = true;

            searchUserAction(oldSearchInputValue);
        } else {
            searchInfo.innerHTML = "";
        }
    }, 1000)
});

function searchUserAction(searchValue) {
    let urlUpdate = searchInput.dataset.url;

    let url = new URL(urlUpdate);
    url.searchParams.set('search', searchValue);

    try {
        const xhr = new XMLHttpRequest();

        xhr.open('GET', url.href);

        xhr.addEventListener('load', function () {
            if (xhr.status >= 200 && xhr.status < 300 || xhr.status === 304) {
                let res = JSON.parse(xhr.responseText);

                if (res.status == 'error') {
                    searchInfo.innerHTML = `<span style="color:red">${res.message}</span>`;
                } else if (res.status === 'success') {
                    renderListUsers(res.users);
                    searchInfo.innerHTML = `<span style="color:green">${res.message}</span>`;
                }

                searchInput.disabled = false;
                searchInput.focus();

                if (searchTimer) {
                    clearTimeout(searchTimer);
                }

                searchTimer = setTimeout(() => searchInfo.innerHTML = '', 5000);
            } else {
                console.log(xhr.status);
            }
        });

        xhr.send();
    } catch (e) {
        console.log(e.message);
    }
}

function renderListUsers(users) {
    if (users.length === 0) return;

    userList.innerHTML = "";
    for (const user of users) {
        userList.innerHTML += `
            <li data-id="${user.id}" class="user-list-item" data-id="user1">
                <img src="user-icon.jpg" alt="Avatar" data-id="${user.id}"
                    class="user-avatar">
                <div class="user-info">
                    <div data-id="${user.id}" class="user-name">${user.name}</div>
                    <div data-id="${user.id}" class="user-email">${user.username}</div>
                </div>
            </li>
        ` ;
    }
}
