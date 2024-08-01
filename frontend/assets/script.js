const popup_div = document.getElementById('popup-div');
const popup_login = document.getElementById('popup-login');
const popup_reg = document.getElementById('popup-reg');
const popup_new_doc = document.getElementById('popup-new-doc');

// POPUP

function openPopupWindow(popup_id) {
    popup_div.style.display = 'grid';
    popup_div.style.pointerEvents = 'all';
    popup_id.style.display = 'grid';
}

function closePopupWindow() {
    popup_div.style.display = 'none';
    popup_div.style.pointerEvents = 'none';
    document.querySelectorAll('.popup-window').forEach(popup => {
        popup.style.display = 'none';
    });
}

document.getElementById('btn-open-login').addEventListener('click', () => {
    openPopupWindow(popup_login);
});

document.getElementById('btn-open-reg').addEventListener('click', () => {
    openPopupWindow(popup_reg);
});

document.getElementById('btn-open-new-doc').addEventListener('click', () => {
    popup_new_doc.querySelector('h2').innerText = 'Создание нового документа';
    popup_new_doc.setAttribute('data-state', 'new');
    popup_new_doc.reset();
    openPopupWindow(popup_new_doc);
});

document.querySelectorAll('.btn-close').forEach(btn_close => {
    btn_close.addEventListener('click', () => {
        closePopupWindow();
    })
});

document.querySelector('.popup-fade').addEventListener('click', () => {
    closePopupWindow();
})

// FIND

document.getElementById('btn-find').addEventListener('click', () => {
    let field_find = document.getElementById('input-find').value;
    let docs = document.getElementById('doc-table').querySelectorAll('.doc-element');
    
    let res_find;

    for (let i = 0; i < docs.length; i++) {
        fields = docs[i].querySelectorAll('span');
        for (let j = 0; j < fields.length; j++) {
            res_find = fields[j].innerText.toLowerCase().indexOf(field_find.toLowerCase());
            if (res_find > -1) {
                break;
            }
        }
        if (res_find === -1) {
            docs[i].classList.add("hidden");
        } else {
            docs[i].classList.remove("hidden");
        }
    }
});

function findByFields(filter_class, find_values) {
    let docs = document.getElementById('doc-table').querySelectorAll('.doc-element');
    let res_find;

    docs.forEach(element => {
        element.classList.remove("hidden");
    });

    for (let i = 0; i < docs.length; i++) {
        for (let j = 0; j < filter_class.length; j++) {
            if (find_values[j] !== '') {
                field = docs[i].querySelector(filter_class[j]);
                res_find = field.innerText.toLowerCase().indexOf(find_values[j].toLowerCase());
                if (res_find === -1) {
                    docs[i].classList.add("hidden");
                    break;
                }
            }
        }
    }
}

function convertDateToInputFormat(str_date) {
    if (str_date === '') return '';

    let year = str_date.substr(6, 4);
    let month = str_date.substr(3, 2);
    let day = str_date.substr(0, 2);
    return year + '-' + month + '-' + day;
}

function convertDateFromInputFormat(str_date) {
    if (str_date === '') return '';

    let day = str_date.substr(8, 2);
    let month = str_date.substr(5, 2);
    let year = str_date.substr(0, 4);
    return  day + '.' + month + '.' + year;
}

document.getElementById('btn-apply-filters').addEventListener('click', () => {
    filter_class = ['.doc-name', '.doc-author', '.doc-date', '.doc-state', '.doc-description'];

    let select = document.getElementById('input-find-by-state')
    find_values = [
        document.getElementById('input-find-by-name').value,
        document.getElementById('input-find-by-author').value,
        convertDateFromInputFormat(document.getElementById('input-find-by-date').value),
        select.options[select.selectedIndex].text,
        document.getElementById('input-find-by-description').value
    ];

    if (find_values[3] === 'Все статусы') find_values[3] = '';

    let docs = document.getElementById('doc-table').querySelectorAll('.doc-element');
    docs.forEach(element => {
        element.classList.remove("hidden");
    });

    find_values.forEach(element => {
        if (element !== '') {
            findByFields(filter_class, find_values);
            return;
        }
    });
});

// DOC ACTIONS

const doc_name = document.getElementById('doc-name');
const doc_author = document.getElementById('doc-author');
const doc_date = document.getElementById('doc-date');
const doc_state = document.getElementById('doc-state');
const doc_description = document.getElementById('doc-description');

document.getElementById('btn-save-new-doc').addEventListener('click', () => {
    let docRow;
    if (popup_new_doc.getAttribute('data-state') === 'new') {
        docRow = document.querySelector(".doc-element").cloneNode(true);
    } else if (popup_new_doc.getAttribute('data-state') === 'edit') {
        docRow = document.querySelector('input[name="radio-doc"]:checked').parentNode.parentNode;
    } else {
        return;
    }

    docRow.querySelector('.doc-name').innerText = doc_name.value;
    docRow.querySelector('.doc-author').innerText = doc_author.value;
    docRow.querySelector('.doc-date').innerText = convertDateFromInputFormat(doc_date.value);
    docRow.querySelector('.doc-state').innerText = doc_state.options[doc_state.selectedIndex].text;
    docRow.querySelector('.doc-description').innerText = doc_description.value;

    if (popup_new_doc.getAttribute('data-state') === 'new') {
        document.getElementById("doc-table").appendChild(docRow);
    }
    closePopupWindow(popup_new_doc);
});

document.getElementById('btn-delete').addEventListener('click', () => {
    const radio_selected = document.querySelector('input[name="radio-doc"]:checked');
    if (radio_selected === null) {
        return;
    }
    radio_selected.parentNode.parentNode.remove();
});

document.getElementById('btn-edit').addEventListener('click', () => {
    const radio_selected = document.querySelector('input[name="radio-doc"]:checked');
    if (radio_selected === null) {
        return;
    }

    const doc_edit = radio_selected.parentNode.parentNode;

    popup_new_doc.querySelector('h2').innerText = 'Редактирование документа';
    popup_new_doc.setAttribute('data-state', 'edit');
    openPopupWindow(popup_new_doc);

    doc_name.value = doc_edit.querySelector('.doc-name').innerText;
    doc_author.value = doc_edit.querySelector('.doc-author').innerText;

    let str_date = doc_edit.querySelector('.doc-date').innerText;
    doc_date.value = convertDateToInputFormat(str_date);

    doc_state.value = doc_edit.querySelector('.doc-state').innerText

    doc_description.value = doc_edit.querySelector('.doc-description').innerText;
});
