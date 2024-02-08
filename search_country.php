<?php

include "connect.php";

if (isset($_POST['query1'])) {
    $output1 = '';
    $query1 = "SELECT `name` FROM `countries` WHERE `name` LIKE '%" . $_POST['query1'] . "%' LIMIT 10";
    $result1 = mysqli_query($conn, $query1);
    $output1 = '<ul class="list-unstyled list-group">';
    if (mysqli_num_rows($result1) > 0) {
        while ($row = mysqli_fetch_array($result1)) {
            $output1 .= '<li class="list-group-item list-group-item-action list-group-item-light">' . $row["name"] . '</li>';
        }
    } else {
        $output1 .= '<li>Country Not Found</li>';
    }
    $output1 .= '</ul>';
    echo $output1;
}

if (isset($_POST['query2'])) {
    $output2 = '';
    $query2 = "SELECT `name` FROM `states` WHERE `name` LIKE '%" . $_POST['query2'] . "%' LIMIT 10";
    $result2 = mysqli_query($conn, $query2);
    $output2 = '<ul class="list-unstyled list-group">';
    if (mysqli_num_rows($result2) > 0) {
        while ($row = mysqli_fetch_array($result2)) {
            $output2 .= '<li class="list-group-item list-group-item-action list-group-item-light">' . $row["name"] . '</li>';
        }
    } else {
        $output2 .= '<li>State Not Found</li>';
    }
    $output2 .= '</ul>';
    echo $output2;
}

if (isset($_POST['query3'])) {
    $output3 = '';
    $query3 = "SELECT `name` FROM `cities` WHERE `name` LIKE '%" . $_POST['query3'] . "%' LIMIT 10";
    $result3 = mysqli_query($conn, $query3);
    $output3 = '<ul class="list-unstyled list-group">';
    if (mysqli_num_rows($result3) > 0) {
        while ($row = mysqli_fetch_array($result3)) {
            $output3 .= '<li class="list-group-item list-group-item-action list-group-item-light">' . $row["name"] . '</li>';
        }
    } else {
        $output3 .= '<li>City Not Found</li>';
    }
    $output3 .= '</ul>';
    echo $output3;
}

if (isset($_POST['query4'])) {
    $output4 = '';
    $query4 = "SELECT `Disease_Id`, `Disease_Name` FROM `disease_master` WHERE `Disease_Name` LIKE '%" . $_POST['query4'] . "%' LIMIT 10";
    $result4 = mysqli_query($conn, $query4);
    $output4 = '<ul class="list-unstyled list-group">';
    if (mysqli_num_rows($result4) > 0) {
        while ($row = mysqli_fetch_array($result4)) {
            $output4 .= '<li class="list-group-item list-group-item-action list-group-item-light">' . $row["Disease_Name"] . '</li>';
        }
    } else {
        $output4 .= '<li>Disease Not Found</li>';
    }
    $output4 .= '</ul>';
    echo $output4;
}
