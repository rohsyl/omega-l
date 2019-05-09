Mousetrap.bindGlobal('mod+s', function (e) {
    e.preventDefault();

    let save = document.getElementById("omega-modal-button-1");
    if (save) save.click();

    let edit = document.getElementById("edit");
    if (edit) edit.click();

    let form = document.getElementsByClassName("main-form")[0];
    if (form) form.submit();

});
