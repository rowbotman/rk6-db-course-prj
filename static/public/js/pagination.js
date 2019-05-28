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


const buttons = document.getElementsByClassName('pagination__elem');
Array.from(buttons).forEach((btn) => {
    const handler = () => {
        let child = document.getElementsByClassName('report__items')[0];
        child.innerHTML = '';
        let url = window.location.pathname + window.location.search;
        const pos = url.indexOf('?');
        url += pos > 0 ? '&' : '?';
        const newPage = btn.getAttribute('value');
        pagination(url, newPage).then(
            (data) => {
                const currentBtn = document.getElementsByClassName('pagination__elem_current')[0];
                currentBtn.className = 'pagination__elem';
                Array.from(buttons).some((btn) => {
                    if (btn.getAttribute('value') === newPage) {
                        btn.className = 'pagination__elem pagination__elem_current';
                        return true;
                    }
                });

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
                    elem.innerHTML = ++index + (newPage - 1) * 10;
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
