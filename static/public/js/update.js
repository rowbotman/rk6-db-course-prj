'use strict';
import ajax from './ajax.js';

const getButton = (type) => {
    let icon = document.createElement('span');
    icon.classList.add('icon', 'icon-size-16', type, 'icon-black', 'icon-button')
    return icon;
};

const remove = (id) => {
    const url = `/ajax/update/delete?ticket_id=${id}`;
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

const drawRow = (event) => {
    if (event.target.tagName !== 'SPAN') {
        return;
    }
    let row = document.createElement('div');
    row.className = 'report__row';
    row.setAttribute('id', event.currentTarget.id);
    const itemsNum = event.currentTarget.childNodes.length - 3;
    console.log(itemsNum);
    event.currentTarget.childNodes.forEach((node, i) => {
        console.log(node);
        console.log('index', i);
        let block = document.createElement('div');
        block.className = 'report__elem';
        console.log(node);
        console.log(node.firstChild.value);
        console.log(node.value);
        if (i === 0) {
            block.textContent = node.textContent;
        } else {
            block.textContent = node.firstChild.value;
        }
        // } else {
        //     node.textContent = '';
        // }
        console.log('loop length of form: ', row.childElementCount);
        row.appendChild(block);
    });
    let parent = event.currentTarget.parentNode;
    console.log(parent);
    console.log('length of form: ', row.childElementCount);
    row.removeChild(row.lastChild);
    row.lastChild.appendChild(getButton('user-edit-icon'));
    row.addEventListener('click', drawUpdateForm);
    let rubbish = document.createElement('div');
    rubbish.className = 'report__elem';
    rubbish.appendChild(getButton('delete-icon'));
    row.appendChild(rubbish);
    parent.replaceChild(row, event.currentTarget);
    console.log(row.lastChild);
    removeEventListener('click', drawRow, false);
};

const drawUpdateForm = (event) => {
    if (event.target.classList.contains('delete-icon')) {
        let answer = confirm('Вы уверены?');
        let deleteNode = event.currentTarget;
        if (answer) {
            remove(event.currentTarget.id).then(
                (data) => {
                    deleteNode.remove();
                });
        }
        return;
    }
    console.log(event);
    console.log(event.currentTarget);
    console.log(event.target);
    let form = document.createElement('form');
    form.className = 'report__row';
    form.setAttribute('id', event.currentTarget.id);
    form.setAttribute('action', `change/update`);
    form.setAttribute('method', 'GET');
    let items = [];
    const itemsNum = event.currentTarget.childNodes.length - 3;
    console.log(itemsNum);
    event.currentTarget.childNodes.forEach((node, i) => {
        console.log(node);
        let replacement = NaN;
        console.log('index', i);
        replacement = document.createElement('input');
        replacement.setAttribute('type', 'text');
        replacement.setAttribute('value', node.textContent);
        let block = document.createElement('div');
        block.className = 'report__elem';
        if (i === 0 || i >= itemsNum) {
            block.textContent = node.textContent;
        } else {
            node.textContent = '';
            block.appendChild(replacement);
        }
        console.log('loop length of form: ', form.length);
        form.appendChild(block);
    });
    let parent = event.currentTarget.parentNode;
    console.log(parent);
    console.log('length of form: ', form.length);
    form.removeChild(form.lastChild);
    form.lastChild.appendChild(getButton('user-edit-icon'));
    form.addEventListener('click', drawRow);

    parent.replaceChild(form, event.currentTarget);
    console.log(form.lastChild);
    removeEventListener('click', drawUpdateForm, false);
};


const buttons = document.querySelectorAll('.report__row');
const btnArray = Array.from(buttons);
console.log(btnArray);
if (btnArray.length > 1) {
    btnArray.forEach((btn) => {
        btn.addEventListener('click', drawUpdateForm, false);
    });
}
