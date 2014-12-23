
function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function empty (obj) {
    for (var i in obj) {
        return false;
    }
    return true;
}

function styleCell () {
    var size = document.settings.elements.sizeCell.value;

    document.getElementById('styleCell').innerHTML = "<style>input[type=\"checkbox\"] + label span, .resizeable {width: "+size+"px; height: "+size+"px;}</style>";
}

function verify () {
    var rowsObj = document.settings.elements.rows;
    var colsObj = document.settings.elements.cols;

    var correctRows = /^[1-9]{1}$|^[1-5]{1}[0-9]{1}$|^60$/.test(rowsObj.value);
    var correctCols = /^[1-9]{1}$|^[1-9]{1}[0-9]{1}$|^100$/.test(colsObj.value);

    rowsObj.style.border = (!correctRows) ? '2px solid red' : '';
    colsObj.style.border = (!correctCols) ? '2px solid red' : '';

    if (!correctRows || !correctCols) {
        document.settings.elements.but_create.setAttribute('disabled', '');
        //document.getElementById('conrolStart').style.visibility = "hidden";
        return false;
    } else {
        document.settings.elements.but_create.removeAttribute('disabled');
        //document.getElementById('conrolStart').style.visibility = "visible";
        return true;
    }
}

function randomArrangement () {
    var i, j;
    for (i = 1; i <= rows; i++) 
        for (j= 1; j <= cols; j++) {
            document.formField.elements["cell_"+i+"_"+j].checked = false;
            if (getRandomInt(1, 6) == 5)
                document.formField.elements["cell_"+i+"_"+j].checked = true;
        }
}

function createSpaceForInput () {
    rows = document.settings.elements.rows.value;
    cols = document.settings.elements.cols.value;
    
    var i, j, checkedMemory, curCell;
    var table = "";
    //cycle for rows
    for (i = 1; i <= rows; i++) {
        table += "<tr>\n";
        //cycle for colums
        for (j= 1; j <= cols; j++) {
            //reading from memory last position |begin
            curCell = "cell_"+i+"_"+j;
            checkedMemory= (aliveCellMemory && (curCell in aliveCellMemory)) ? 'checked' : '';
            //end
            table += "<td><input type='checkbox' name='cell_"+i+"_"+j+"' id='chb_"+i+"_"+j+"'  value='1' "+checkedMemory+" /><label for='chb_"+i+"_"+j+"'><span></span></label></td>\n";
        }
        table += "</tr>\n";
    }

    if (aliveCellMemory)
        aliveCellMemory = false;
    document.getElementById('mainField').innerHTML = table;
    return table;


}

function motion () {
    document.getElementById('section_input').style.display = 'none';
    document.getElementById('section_return').style.display = 'block';
    document.getElementById('butForward').style.display = 'none';
    document.getElementById('butPause').style.display = 'inline';
    
    sizeCell = document.settings.elements.sizeCell.value;
    document.settings.elements.rows.value = rows;
    document.settings.elements.cols.value = cols;

    aliveCells = initializationCheckedBoxes(rows, cols);
    //remember last position
    aliveCellMemory = initializationCheckedBoxes(rows, cols);

    index = setInterval(changeGeneration, 100);

    //below func is used for initialization object that has picked cells
    function initializationCheckedBoxes (rows, cols) {
        var aliveCells = {};
        var i, j;
        for (i = 1; i <= rows; i++)
            for (j= 1; j <= cols; j++) {
                if (document.formField.elements["cell_"+i+"_"+j].checked)
                    aliveCells["cell_"+i+"_"+j] = 1;
            }
        //viewProps(aliveCells);
        return aliveCells;
    }

}

function changeGeneration () {
        var listOfDel = [];
        var listOfAlive = [];
        var i, j, quantityAlive, curCell, banner, status, table = '';

        for (i = 1; i <= rows; i++) {
            table += "<tr>\n";
            for (j = 1; j <= cols; j++) {
                curCell = "cell_"+i+"_"+j;

                quantityAlive = aliveNeighbours(i, j, rows, cols, aliveCells);
                //suppose that this cell is alive
                banner = true;
                //verification of alive
                if (curCell in aliveCells){
                    if ((quantityAlive != 2) && (quantityAlive != 3)){
                        listOfDel.push(curCell);
                        banner = false;
                    }
                } else if (quantityAlive == 3){
                    listOfAlive.push(curCell);
                } else 
                    banner = false;

                status = (banner) ? 'alive' : '';
                table += "<td><div class='"+status+" resizeable' ></div</td>\n";
            }
            table += "</tr>\n";
        }

        if (!empty(listOfAlive)) {
            for (var prop in listOfAlive) {
                //console.log('For add: '+prop);
                aliveCells[listOfAlive[prop]] = '1';
            }
        }

        //delete var prop for redifine it in next cycle
        delete prop;

        if (!empty(listOfDel)) {
            for (var prop in listOfDel) {
                //console.log('For del: '+prop);
                delete aliveCells[listOfDel[prop]];
            }
        }

        document.getElementById('mainField').innerHTML = table;
        if (empty(aliveCells) || (empty(listOfAlive) && empty(listOfDel))) {
            clearInterval(index);
            document.getElementById('butPause').style.display = 'none';
        }
    
    //this func is used for counting alive neighbours of one cell
    function aliveNeighbours (cur_i, cur_j, rows, cols, aliveCells){
        var amount = 0, i, j, next_i, next_j, curCell;
        for (i = -1; i <= 1; i++) {
            for (j = -1; j <= 1; j++) {
                if ((i == 0) && (j == 0))
                    continue;

                next_i = cur_i + i;
                next_j = cur_j + j;

                if (next_i == 0)
                    next_i = rows;

                if (next_j == 0)
                    next_j = cols;

                if (next_i > rows)
                    next_i = next_i - rows;

                if (next_j > cols)
                    next_j = next_j - cols;

                curCell = "cell_"+next_i+"_"+next_j;
                if (curCell in aliveCells)
                    amount++;
            }
        }
        //console.log(amount);
        return amount;
    }
}

function pause () {
    clearInterval(index);
    
    document.getElementById('butPause').innerHTML = 'Continue';
    document.getElementById('butPause').onclick = continueMotion;
    
    document.getElementById('butForward').style.display = 'inline';
}

function continueMotion () {
    document.getElementById('butPause').innerHTML = 'Pause';
    document.getElementById('butPause').onclick = pause;
    
    document.getElementById('butForward').style.display = 'none';
    
    index = setInterval(changeGeneration, 100);
}

function stop () {
    clearInterval(index);
    
    document.getElementById('butPause').innerHTML = 'Pause';
    document.getElementById('butPause').onclick = pause;
    
    document.getElementById('butForward').style.display = 'none';
    
    document.getElementById('section_input').style.display = 'block';
    document.getElementById('section_return').style.display = 'none';
    document.settings.elements.sizeCell.value = sizeCell;
    styleCell();
    createSpaceForInput();
}
