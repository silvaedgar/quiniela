
function backgroundRow(status) {
    if (status == 'Proceso')
        return 'bg-warning '
    if (status == 'Finalizado')
        return 'bg-danger text-white'
    return 'bg-ligth'
}

function createCell(contenido, row, item, alignText) {
    var celda = row.insertCell(); // celda del item
    celda.style = "text-align: " + alignText
    celda.innerHTML = contenido
}

function deleteTable(table) {
    var filas = table.rows.length;
    try {
        for (let i = 1; i < filas;) {
            table.deleteRow(i);
            filas--;
        } // elimina las celdas existentes comienza en uno para no eliminar el encabezado
    } catch (e) {
        alert(e);
    }
}


