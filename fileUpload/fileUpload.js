var listToRead = [];
var validExts = new Array( /*".xlsx", ".xls",*/ ".csv");
var listHeaders = {
    "Accounts": ["Id", "Name", "Parent Id", "Segment"],
    "Bookings": ["Id", "Office Id", "Type", "Bkgs"],
    "Office": ["Id", "Name", "Account Id"]
}

$(document).ready(function () {
    $('.loaderTrans').hide();
    $('table').hide();
    $('.sessionDestroy').on('click', function () {
        location.href = "logout.php";
    });

    $('#accounts').focus(function (e) {
        if (listToRead.includes("accounts"))
            readFile(e, $(this), "all");
    });
    $('#bookings').focus(function (e) {
        if (listToRead.includes("bookings"))
            readFile(e, $(this), "all");
    });
    $('#office').focus(function (e) {
        if (listToRead.includes("office"))
            readFile(e, $(this), "all");
    });
    $('#accounts').change(function (e) {
        if (verifyExts(e, $(this)))
            readFile(e, $(this), "headers");
    });
    $('#bookings').change(function (e) {
        if (verifyExts(e, $(this)))
            readFile(e, $(this), "headers");
    });
    $('#office').change(function (e) {
        if (verifyExts(e, $(this)))
            readFile(e, $(this), "headers");
    });
    $("#uploadBtn").on('click', function () {
        $("table").fadeOut(500);
        $(".loaderTrans").fadeIn(2000);
        verifyAllInput();
        console.log(listToRead);
        if (listToRead.includes("accounts")) {
            $('#accounts').trigger("focus");
        } else if (listToRead.includes("office")) {
            $('#office').trigger("focus");
        } else if (listToRead.includes("bookings")) {
            $('#bookings').trigger("focus");
        }
    });
    $(".loaderOpaco").fadeOut(2000);
});

var responseList;
var responseListKeys;

function showData(elementPath, data) {

    $(elementPath + " .inserted").text(data[0]);
    $(elementPath + " .updated").text(data[1]);
    $(elementPath + " .notInserted").text(data[2]);
    $(elementPath + " .notUpdated").text(data[3]);
    $(elementPath).fadeIn(750);
}

function callDBAccounts(jsonData, count) {
    var p = new Date();
    console.log("Account antes de ligo:" + countT + " " + x + " " + p);
    var fullCount = [0, 0, 0, 0];
    var parseData = JSON.parse(jsonData);
    var countT = 0;
    for (var x = 0; x <= count; x++) {
        $.ajax({
            url: 'dbAccount.php',
            data: parseData[x],
            type: 'POST',
            success: function (response) {
                countT++;
                responseList = JSON.parse(response);
                fullCount[0] += responseList["Inserted"];
                fullCount[1] += responseList["Updated"];
                fullCount[2] += responseList["Not Inserted"];
                fullCount[3] += responseList["Not Updated"];
                var d = new Date();
                console.log("Account dps de ligo:" + countT + " " + x + " " + d);
                if (countT > count) {
                    console.log("Terminou accounts");
                    if (listToRead[0] == "accounts") {
                        listToRead.shift();
                    }
                    if (listToRead.includes("office")) {
                        console.log("Passou para os offices");
                        showData("table.accounts", fullCount);
                        $('#office').trigger("focus");
                    } else if (listToRead.includes("bookings")) {
                        showData("table.accounts", fullCount);
                        $('#bookings').trigger("focus");
                    } else {
                        showData("table.accounts", fullCount);
                        console.log("That's all folks!");
                        $(".loaderTrans").fadeOut(2000);
                    }
                }
            }
        });
    }
}

function callDBOffice(jsonData, count) {
    var p = new Date();
    console.log("Office antes de ligo:" + countT + " " + x + " " + p);
    var fullCount = [0, 0, 0, 0];
    var parseData = JSON.parse(jsonData);
    var countT = 0;
    for (var x = 0; x <= count; x++) {
        $.ajax({
            url: 'dbOffice.php',
            data: parseData[x],
            type: 'POST',
            success: function (response) {
                countT++;
                responseList = JSON.parse(response);
                console.log("offices coise:" + response);
                fullCount[0] += responseList["Inserted"];
                fullCount[1] += responseList["Updated"];
                fullCount[2] += responseList["Not Inserted"];
                fullCount[3] += responseList["Not Updated"];
                console.log("Inserted " + responseList["Inserted"]);
                console.log("Updated " + responseList["Updated"]);
                console.log("Not Inserted " + responseList["Not Inserted"]);
                console.log("Not Updated " + responseList["Not Updated"]);
                var d = new Date();
                console.log(countT + " " + x + " " + d);
                if (countT > count) {
                    console.log("Terminou office");
                    if (listToRead[0] == "office") {
                        listToRead.shift();
                    }
                    if (listToRead.includes("bookings")) {
                        console.log("Passou para os bookings");
                        showData("table.offices", fullCount);
                        $('#bookings').trigger("focus");
                    } else {
                        showData("table.offices", fullCount);
                        console.log("That's all folks!");
                        $(".loaderTrans").fadeOut(2000);
                    }
                }
            }
        });
    }
}

function callDBBooking(jsonData, count) {
    var p = new Date();
    console.log("Bookings antes de ligo:" + countT + " " + x + " " + p);
    var fullCount = [0, 0, 0, 0];
    var parseData = JSON.parse(jsonData);
    var countT = 0;
    for (var x = 0; x <= count; x++) {
        $.ajax({
            url: 'dbBooking.php',
            data: parseData[x],
            type: 'POST',
            success: function (response) {
                countT++;
                responseList = JSON.parse(response);
                fullCount[0] += responseList["Inserted"];
                fullCount[1] += responseList["Updated"];
                fullCount[2] += responseList["Not Inserted"];
                fullCount[3] += responseList["Not Updated"];
                var d = new Date();
                console.log(countT + " " + x + " " + d);
                if (countT > count) {
                    console.log("Terminou bookings");
                    if (listToRead[0] == "bookings") {
                        listToRead.shift();
                    }
                    callToSync(fullCount);
                    console.log("That's all folks!");
                }
            }
        });
    }
}

function callToSync(fullCount) {
    var d = new Date();
    console.log("Entrou no synb Bookings " + d);
    $.ajax({
        url: 'syncBookings.php',
        data: '',
        type: 'POST',
        success: function (response) {
            showData("table.bookings", fullCount);
            $(".loaderTrans").fadeOut(2000);
        }
    });

}

function csvToArray(csv) {
    rows = csv.split("\n");

    return rows.map(function (row) {
        return row.split(";");
    });
}

function arraysEqual(arr1, arr2) {
    if (arr1.length != arr2.length) {
        return false;
    }

    for (var x = 0; x < arr1.length; x++) {
        if (arr1[x].trim() !== arr2[x].trim()) {
            return false;
        }
    }
    return true;
}

function verifyHeaders(headersCsv, id, e, obje) {
    var verify = arraysEqual(headersCsv, listHeaders[id]);
    if (verify) {
        return true;
    } else {
        alert("Invalid header in file selected for " + obje[0].title);
        obje.val("");
        return false;
    }
}

function verifyExts(e, obje) {
    var fileType = "." + e.target.files[0].name.split(".")[1];
    if (!validExts.includes(fileType)) {
        alert("Invalid file selected for " + obje[0].title + ", valid files are " + validExts.toString() + " types.");
        obje.val("");
        return false;
    } else {
        return true;
    }
}

function readFile(e, obje, verification) {
    var fileName = e.target.files[0].name;
    var file = e.target.files[0];
    let reader = new FileReader();

    reader.onload = function (event) {
        var contents = event.target.result;
        var contentsMap = csvToArray(contents);
        contentsMap.pop(contentsMap.lenght - 1);
        var verifyHeadersName;

        if (verification == "headers") {
            verifyHeadersName = verifyHeaders(contentsMap[0], obje[0].title, e, obje);
        } else if (verification == "all") {
            verifyHeadersName = verifyHeaders(contentsMap[0], obje[0].title, e, obje);
            for (var x = 0; x < contentsMap[0].length; x++) {
                contentsMap[0][x] = contentsMap[0][x].replace(/(\r\n|\n|\r|\s)/gm, "");
            }
            var countObj = 0;
            if (verifyHeadersName) {
                var assocAll = {};
                var assocPart = {};
                var j = 0;
                for (var x = 1; x < contentsMap.length; x++) {
                    var assocObj = {}
                    for (var y = 0; y < contentsMap[0].length; y++) {
                        assocObj[contentsMap[0][y]] = contentsMap[x][y].replace(/(\r\n|\n|\r)/gm, "");
                        assocPart[String(j)] = assocObj;
                    }
                    j++;
                    if (x % 200 == 0) {
                        assocAll[String(countObj)] = assocPart;
                        assocPart = {};
                        countObj++;
                        j = 0;
                    }
                }
                assocAll[String(countObj)] = assocPart;

                var jsonData = JSON.stringify(assocAll);

                if (obje[0].title == "Accounts") {
                    callDBAccounts(jsonData, countObj);
                } else if (obje[0].title == "Bookings") {
                    callDBBooking(jsonData, countObj);
                } else if (obje[0].title == "Office") {
                    callDBOffice(jsonData, countObj);
                }
            }
        }
    };
    reader.readAsText(file);
}

function clearFile(id) {
    var verification = confirm('Are you sure?');
    if (verification) {
        if (id == '') {
            document.getElementById('accounts').value = "";
            document.getElementById('bookings').value = "";
            document.getElementById('office').value = "";
        } else {
            document.getElementById(id).value = "";
        }
    }
}

function verifyAllInput() {
    listToRead = [];
    if (document.getElementById('accounts').value) {
        listToRead.push("accounts");
    }

    if (document.getElementById('office').value) {
        listToRead.push("office");
    }

    if (document.getElementById('bookings').value) {
        listToRead.push("bookings");
    }
    if (listToRead == "") {
        $(".loaderTrans").fadeOut(1000);
    }
}
