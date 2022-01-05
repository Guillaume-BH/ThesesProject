/**
 * Toutes les lignes, y compris celles non-affichées.
 * @type {RowData[]}
 */
var lines = [];
/**
 * Toutes les lignes, accessible par leur index.
 * @type {Map<string, RowData>}
 */
var linesMap = new Map();

/** Numéro de la page actuel -1. */
var currentPage = 0;

/** Nombre de ligne par page. */
const linePerPage = 10;
/** Id de la table de résultat. */
const idResults = "table-result";



/**
 * Permet de stocker les données d'une ligne
 * @param {Element} row
 */
class RowData {

    /** @type {Element} */
    row;

    constructor(row) {
        this.row = row;
    }

}

/** Initialise la page de résultat. */
function initPageManager() {
    let tableElem = document.getElementById(idResults);
    /** @type RowData */
    let lastInsteredRow;
    let currentRowNum = 0;

    for (let i = 0; i < tableElem.children.length; i++) {
        let rowElem = tableElem.children[i];
        console.log(tableElem.children[i].innerHTML);
        rowElem.id = `row_${currentRowNum++}`;
        row = new RowData(rowElem);
        lines.push(row);
        linesMap.set(rowElem.id, row);
        console.log(linesMap);
        lastInsteredRow = row;
    }
    console.log(linesMap);
    loadPage();
}


/** Recharge la page. */
function loadPage() {

    let tableElem = document.getElementById(idResults);

    tableElem.innerHTML = "";
    for (let i=0; i<linePerPage && i+currentPage*linePerPage < lines.length; i++) {
        let rowData = lines[i+currentPage*linePerPage];
        tableElem.appendChild(rowData.row);
    }
}

function dynamicMenu() {
    var x = document.getElementById(idResults);
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        x.style.display = "block";
    }
}







