let popUpIncome = document.getElementById('pop-up-1');
let popUpExpenses = document.getElementById('pop-up-2');

let main = document.getElementById('main');

function openPopUpIncome() {
    popUpIncome.style.display = 'flex';
    main.style.blur = '4px';


}
function closeOpenPopUpIncome() {
    popUpIncome.style.display = 'none';
}

function openPopUpExpenses() {
    popUpExpenses.style.display = 'flex';
    main.style.blur = '4px';


}
function closeOpenPopUpExpenses() {
    popUpExpenses.style.display = 'none';
}
