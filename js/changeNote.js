function changeNote(id)
{
    let note_id = id - 1;
    
    let text = document.getElementsByClassName('content')[note_id].innerHTML;
    let title = document.getElementsByClassName('title')[note_id].innerHTML;
    const note = document.getElementsByClassName('note')[note_id];
    
    let form = "<form action='../php/update_note.php' method='post'>";
    
    let out = form.concat("<h2 style='margin-bottom: 0;'>Zmień tytuł: </h2><br>" ,
    `<input type='text' value='${title}' name='title'>`,
    `<h2 style = 'margin-bottom: 0;'>Zmień zawartość: </h2> <br> <textarea rows='3' cols='30' name='content'>${text}</textarea><br>`,
    `<button type='submit' name='btnId' value='${id}'>Zmień notatkę</button>`,
    "</form>");

    note.innerHTML = out;

    note.innerHTML += `<form action='../php/delete_note.php' method='post'><button name='btn' value='${id}' type='submit'>Usuń notatkę</button></form>`;
}
