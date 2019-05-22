'use strict';
import ajax from './ajax.js';

const pagination = (path, page) => {
    const url = `/ajax${path}?page=${page}`
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


const buttons = document.getElementsByClassName('pagination__elem');
Array.from(buttons).forEach((btn) => {
    console.log(btn);
    const handler = () => {
        console.log('event');
        const table = document.getElementsByClassName('report_main')[0];
        let child = document.getElementsByClassName('report__items')[0];
        child.innerHTML = '';
        let url = window.location.pathname;
        const pos = url.indexOf('?');
        if (pos > 0) {
            url = url.substring(0, pos);
        }
        console.log( btn.getAttribute('value'));
        pagination(url, btn.getAttribute('value')).then(
            (data) => {
                console.log(data);
                data.forEach((rowData) => {
                    const elem = document.createElement('div');
                    elem.className = 'report__elem';
                    elem.innerHTML = rowData;
                    child.appendChild(elem);
                    // console.log(rowData);
                    // const row = document.createElement('div');
                    // row.className = 'report__row';
                    // child.appendChild(row);
                    // rowData.forEach((elemData) => {
                    //     const elem = document.createElement('div');
                    //     elem.className = 'report__elem';
                    //     elem.innerHTML = elemData;
                    //     child.appendChild(elem);
                    // });
                });
            }
        );

    };
    btn.addEventListener('click', handler);
});
