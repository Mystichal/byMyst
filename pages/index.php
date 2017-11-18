<?php require_once("_header.php"); ?>

<?php
$userList = json_encode($objUsers->allUsers());
$current = json_encode($objUsers->numUsersThis());
$last = json_encode($objUsers->numUsersLast());
echo '<script type="text/javascript">var userList = ' . $userList . ';</script>';
echo '<script type="text/javascript">var current = ' . $current . ';</script>';
echo '<script type="text/javascript">var last = ' . $last . ';</script>';
?>

<div class="tab">
    <button class="tablinks active" onclick="openTab(event,'dashboard');">Dashboard</button>
    <button class="tablinks" onclick="openTab(event,'userList');">Userlist</button>
    <button class="tablinks" onclick="openTab(event,'settings');">Settings</button>
</div>

<!-- Start dashboard layout. -->
<div id="dashboard" class="tabcontent">
    <div class="flex-container">
        <div id="piechart1" style="display: inline-block;"></div>
        <div id="piechart2" style="display: inline-block;"></div>
        <div id="piechart3" style="display: inline-block;"></div>
        <div id="piechart4" style="display: inline-block;"></div>
    </div>
</div>
<!-- End dashboard layout. -->

<!-- Start user list layout. -->
<div id="userList" class="tabcontent">
    <div class="container-list">
        <div id="userListModule" class="module">
            <input type="text" id="search" placeholder="Seach users" style="margin-bottom: 15px;">
            <table id="userList">
                <thead>
                <th scope="col">email</th>
                <th scope="col">status</th>
                <th scope="col">regdate</th>
                <th scope="col"></th>
                </thead>
                <tbody id="userList">
                <script id="userList-template" type="Mustache/template">
                    {{#users}}
                    <tr>
                        <td>{{email}}</td>
                        <td>{{status}}</td>
                        <td>{{regdate}}</td>
                        <td><a class="buttonIcon" href="?page=userprofile&amp;id={{id}}"><i class="fa fa-pencil fa-fw"></i></a></td>
                    </tr>
                    {{/users}}
                </script>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- End user list layout. -->

<!-- Start settings layout. -->
<div id="settings" class="tabcontent">
    <p>there is something on the settings</p>
</div>
<!-- End settings layout. -->

<script type="text/javascript">
    document.getElementById('dashboard').style.display = "block";
    $("#search").keyup(function () {
        var value = this.value.toLowerCase().trim();

        $("table tr").each(function (index) {
            if (!index) return;
            $(this).find("td").each(function () {
                var id = $(this).text().toLowerCase().trim();
                var not_found = (id.indexOf(value) == -1);
                $(this).closest('tr').toggle(!not_found);
                return not_found;
            });
        });
    });

    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var winWidth = (1920 / 4) - 5;
        var winHeight = winWidth * 0.55;

        var data = google.visualization.arrayToDataTable([
            ['Type', 'Users per month'],
            ['Current month    ', current],
            ['Last month   ', last]
        ]);

        var options = {
            'title': 'Users',
            backgroundColor: {fill: 'transparent'},
            width: winWidth,
            height: winHeight,
            is3D: true
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart1'));

        chart.draw(data, options);

        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

        chart.draw(data, options);

        var chart = new google.visualization.PieChart(document.getElementById('piechart3'));

        chart.draw(data, options);

        var chart = new google.visualization.PieChart(document.getElementById('piechart4'));

        chart.draw(data, options);
    }

    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
<script src="js/userlist.js"></script>

<?php require_once("_footer.php"); ?>
