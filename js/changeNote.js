function changeNote(id) {
    let note_id = id - 1;

    let text = document.getElementsByClassName('content')[note_id].innerHTML;
    let title = document.getElementsByClassName('title')[note_id].innerHTML;
    const note = document.getElementsByClassName('note')[note_id];

    let form = "<form id='changeForm' action='../php/update_note.php' method='post'>";

    let out = form.concat("<label style='margin-bottom: 0;'>Zmień tytuł: </label><br>",
        `<input type='text' value='${title}' name='title'>`,
        `<label>Zmień zawartość: </label> <br> <textarea rows='3' cols='30' name='content'>${text}</textarea><br>`,
        `<button class='notesBtn'type='submit' name='btnId' value='${id}'>Zmień notatkę</button>`,

        "</form>",
    );



    note.innerHTML = out;

    note.innerHTML += `<form id='formNone' action='../php/delete_note.php' method='post'><button class='delateBtn' name='btn' value='${id}' type='submit'>Usuń notatkę</button></form>`;

}
