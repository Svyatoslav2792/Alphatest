var expanded = false;

function showCheckboxes() {
    var checkboxes = document.getElementById("checkboxes");
    if (!expanded) {
        checkboxes.style.display = "block";
        expanded = true;
    } else {
        checkboxes.style.display = "none";
        expanded = false;
    }
}

function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("authorTable");
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.getElementsByTagName("TR");
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}

function addMagazine() {
    var form_data = new FormData($('#magazineAddForm')[0]);
    $.ajax({
        url: '/magazine',
        data: form_data,
        type: "POST",
        processData: false,
        contentType: false,
        cache: false,
        success: function (response) {
            // $("#errors").html(response);
            modalBox("#myModalBox", '#message', response['message']);
            if (response['redirect'] === 1) {
                modalBoxRedirectOnHide("#myModalBox", "/magazine");
            }

        },
        error: function (jqXHR, textStatus, errorThrown) {
            modalBox("#myModalBox", '#message', 'Ошибка: ' + textStatus + '|' + errorThrown);
        }
    });
}

function editMagazine(id) {
    var form_data = new FormData($('#magazineEditForm')[0]);
    $.ajax({
        url: '/magazine/' + id,
        data: form_data,
        type: "POST",
        processData: false,
        contentType: false,
        cache: false,
        success: function (response) {
            // $("#errors").html(response);
            modalBox("#myModalBox", '#message', response['message']);
            if (response['redirect'] === 1) {
                modalBoxRedirectOnHide("#myModalBox", "/magazine");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            modalBox("#myModalBox", '#message', 'Ошибка: ' + textStatus + '|' + errorThrown);
        }
    });
}

function deleteMagazine(id) {
    $.ajax({
        url: "/magazine/" + id,
        type: "DELETE",
        cache: false,
        success: function (response) {
            modalBox("#myModalBox", '#message', response['message']);
            if (response['redirect'] === 1) {
                modalBoxRedirectOnHide("#myModalBox", "/magazine");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            modalBox("#myModalBox", '#message', 'Ошибка: ' + textStatus + '|' + errorThrown);
        }
    });
}

function addAuthor() {
    var form_data = new FormData($('#authorAddForm')[0]);
    $.ajax({
        url: '/author',
        data: form_data,
        type: "POST",
        processData: false,
        contentType: false,
        cache: false,
        success: function (response) {
            // $("#errors").html(response);
            modalBox("#myModalBox", '#message', response['message']);
            if (response['redirect'] === 1) {
                modalBoxRedirectOnHide("#myModalBox", "/author");
            }

        },
        error: function (jqXHR, textStatus, errorThrown) {
            modalBox("#myModalBox", '#message', 'Ошибка: ' + textStatus + '|' + errorThrown);
        }
    });
}

function editAuthor(id) {
    var form_data = new FormData($('#authorEditForm')[0]);
    $.ajax({
        url: '/author/' + id,
        data: form_data,
        type: "POST",
        processData: false,
        contentType: false,
        cache: false,
        success: function (response) {
            // $("#errors").html(response);
            modalBox("#myModalBox", '#message', response['message']);
            if (response['redirect'] === 1) {
                modalBoxRedirectOnHide("#myModalBox", "/author");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            modalBox("#myModalBox", '#message', 'Ошибка: ' + textStatus + '|' + errorThrown);
        }
    });
}

function deleteAuthor(id) {
    $.ajax({
        url: "/author/" + id,
        type: "DELETE",
        cache: false,
        success: function (response) {
            modalBox("#myModalBox", '#message', response['message']);
            if (response['redirect'] === 1) {
                modalBoxRedirectOnHide("#myModalBox", "/author");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            modalBox("#myModalBox", '#message', 'Ошибка: ' + textStatus + '|' + errorThrown);
        }
    });
}
function encrypt() {
    crypt('#cryptoTextarea','/encrypt');
}
function decrypt() {
    crypt('#cryptoTextarea','/decrypt');
}

function crypt(textArea, route) {
    $.ajax({
        url: route,
        data: $(textArea).serialize(),
        type: "POST",
        cache: false,
        success: function (response) {
            $("#errors").html(response);
            // modalBox("#myModalBox", '#message', response['message']);
            // if (response['redirect'] === 1) {
            //     modalBoxRedirectOnHide("#myModalBox", "/magazine");
            // }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            modalBox("#myModalBox", '#message', 'Ошибка: ' + textStatus + '|' + errorThrown);
        }
    });
}



function modalBox(box_id, text_id, value) {
    $(box_id).find(text_id).text(value);
    $(box_id).modal('show');
}

function modalBoxRedirectOnHide(box_id, url) {
    $(box_id).on('hide.bs.modal', function () {
        window.location = url;
    });
}
