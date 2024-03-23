<?php

require 'connect.php';

function get_pathC($path)
{
    $place = '/shopsite/pages/client/';
    return $_SERVER['DOCUMENT_ROOT'] . $place . $path;
}

function get_pathA($path)
{
    $place = '/shopsite/pages/admin/';
    return $_SERVER['DOCUMENT_ROOT'] . $place . $path;
}


function tableEmpty($dbc, $table)
{
    $query = 'SELECT * from ' . $table;
    $row = null;
    if ($stmt = $dbc->prepare($query)) {
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    }
    return empty($row);
}

function getItem($dbc, $id)
{
    $query = 'Select * from prodInfo where id = ?;';

    $row = null;
    if ($stmt = $dbc->prepare($query)) {
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    }

    return $row;
}


function getTable($dbc, $table)
{
    $query = 'SELECT * from ' . $table;
    $rows = null;
    if ($stmt = $dbc->prepare($query)) {
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
    }
    return $rows;
}


function addItem($dbc, $id, $amount)
{



    if (in_array($id, array_column($_SESSION['cart'], 'id'))) {

        foreach ($_SESSION['cart'] as $key => $value) {

            $row = getItem($dbc, $value['id']);



            if ($value['id'] == $id) {
                if ($row['stock'] <= $amount) {
                    $_SESSION['cart'][$key]['amount'] = $row['stock'];
                } else {
                    $_SESSION['cart'][$key]['amount'] += $amount;
                    break 1;
                }
            }
        }
    } else {
        $new = array(
            'id' => $id,
            'amount' => $amount
        );

        array_push($_SESSION['cart'], $new);
    }
}

function checkout($dbc, $cart)
{



    foreach ($cart as $prod) {
        $id = $prod['id'];
        $amount = $prod['amount'];

        $r = [];


        $query = 'SELECT * FROM prodInfo where id = ?';

        if ($stmt = $dbc->prepare($query)) {
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $amount = $row['stock'] - $amount;
        }
        $updateQuery = 'UPDATE prodInfo
                        SET stock=' . $amount . '
                        where id = ?;';

        if ($stmt = $dbc->prepare($updateQuery)) {
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $stmt->close();
        }
    }
}
