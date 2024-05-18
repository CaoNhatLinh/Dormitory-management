    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("deviceTable");
        switching = true;
        dir = "asc";
        while (switching) {
            switching = false;
            rows = table.rows;
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
        var headers = document.querySelectorAll("#deviceTable th");
        headers.forEach(header => { 
            header.innerHTML = header.innerHTML.replace(' <i class="fa fa-sort-down"></i>', '');
            header.innerHTML = header.innerHTML.replace(' <i class="fa fa-sort-up"></i>', '');
            header.innerHTML = header.innerHTML.replace(' <i class="fa fa-sort"></i>', '');
            if (header.cellIndex != n && header.innerHTML.trim() != "Thao tác") { 
                header.innerHTML += ' <i class="fa fa-sort"></i>';
            }
        });
        var clickedHeader = document.querySelector("#deviceTable th:nth-child(" + (n+1) + ")");
        if (n !== (headers.length - 1) && clickedHeader.innerHTML.trim() != "Thao tác") { 
            if (dir == "asc") {
                clickedHeader.innerHTML += ' <i class="fa fa-sort-down"></i>';
            } else {
                clickedHeader.innerHTML += ' <i class="fa fa-sort-up"></i>';
            }
        }
    }