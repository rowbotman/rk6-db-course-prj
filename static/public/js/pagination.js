'use strict';
import ajax from './ajax.js';

const pagination = (path, page) => {
    const url = `/ajax${path}page=${page}`;
    return ajax.doGet({path: url}).then(
        (response) => {
            if (response.status > 499) {
                throw new Error('Server error');
            }
            return response.json().then((data) => data);
        },
        (error) => {
            throw new Error(error);
        });
};

const redrawButtons = (num) => {
    let buttons = document.getElementsByClassName('pagination__elem');
    let i = 0;
    let buttonsArray = Array.from(buttons);
    for (let j = 0; j < buttonsArray.length; ++j) {
        if (buttonsArray[j].innerText === '...') {
            if (num - 2 !== 1) {
                buttonsArray[j - 3].innerText = '...';
                buttonsArray[j - 3].innerText = num - 3;
            }
            if (num + 2 !== buttonsArray.length) {
                buttonsArray[j + 3].innerText = '...';
                buttonsArray[j + 3].innerText = num - 3;
            }
            buttonsArray[j - 1].innerText = num - 1;
            buttonsArray[j - 1].setAttribute('values', num - 1);
            buttonsArray[j + 1].innerText = num + 1;
            buttonsArray[j + 1].setAttribute('values', num + 1);
            buttonsArray[j].innerText = num;
            buttonsArray[j].setAttribute('values', num);
        }
    }
    // Array.from(buttons).forEach((btn) => {
    //     console.log(i, +btn.innerText, num);
    //     if (isNaN(+btn.innerText)) {
    //         btn.innerText = num;
    //     }
    //     if ((num - 1 <= +btn.innerText) && (+btn.innerText <= num + 1 )) {
    //         btn.setAttribute('value', num - 1 + i);
    //         btn.innerText = num - 1 + i;
    //         console.log(num - 1 + i);
    //     }
    // });
};

const isExtra = (elem) => elem.className.search('extra') >= 0;

const buttons = document.getElementsByClassName('pagination__elem');
const btnArray = Array.from(buttons);
if (btnArray.length > 1) {
    btnArray.forEach((btn) => {
        const handler = () => {
            let child = document.getElementsByClassName('report__items')[0];
            child.innerHTML = '';
            let url = window.location.pathname + window.location.search;
            const pos = url.indexOf('?');
            url += pos > 0 ? '&' : '?';
            let newPage = +btn.getAttribute('value');
            const currentBtn = document.getElementsByClassName('pagination__elem_current')[0];
            let currentPage = +currentBtn.getAttribute('value');
            const lastPage = +document.getElementsByClassName(
                'pagination__elem_extra')[1].getAttribute('value');
            console.log(newPage);
            if (!isExtra(btn)) {
                if (newPage > 0) {
                    currentPage += (currentPage < lastPage) ? newPage : 0;
                } else {
                    currentPage += (currentPage > 1) ? newPage : 0;
                }
            } else {
                currentPage = newPage;
            }
            currentBtn.setAttribute('value', currentPage);
            currentBtn.innerText = currentPage;
            pagination(url, currentPage).then(
                (data) => {
                    // const currentBtn = document.getElementsByClassName('pagination__elem_current')[0];
                    // currentBtn.className = 'pagination__elem';
                    // Array.from(buttons).some((btn) => {
                    //     if (btn.getAttribute('value') === newPage) {
                    //         btn.className = 'pagination__elem pagination__elem_current';
                    //         if (btn.innerText === '...') {
                    //             redrawButtons(+newPage);
                    //         }
                    //         return true;
                    //     }

                    const titleRow = document.createElement('div');
                    titleRow.className = 'report__row';
                    child.appendChild(titleRow);
                    let elem = document.createElement('div');
                    elem.className = 'report__elem report__elem_main';
                    elem.innerHTML = '№';
                    child.appendChild(elem);
                    for (let elemData in data[0]) {
                        elem = document.createElement('div');
                        elem.className = 'report__elem report__elem_main';
                        elem.innerHTML = elemData;
                        child.appendChild(elem);
                    }
                    data.forEach((rowData, index) => {
                        const row = document.createElement('div');
                        row.className = 'report__row';
                        child.appendChild(row);
                        elem = document.createElement('div');
                        elem.className = 'report__elem';
                        elem.innerHTML = ++index + (currentPage - 1) * 10;
                        child.appendChild(elem);
                        for (let elemData in rowData) {
                            const elem = document.createElement('div');
                            elem.className = 'report__elem';
                            elem.innerHTML = rowData[elemData];
                            child.appendChild(elem);
                            elemData = +elemData;
                        }
                    });
                }
            );

        };
        btn.addEventListener('click', handler);
    });
}
