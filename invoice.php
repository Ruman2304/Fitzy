<?php
session_start();
// require_once 'vendor/autoload.php';

// use Dompdf\Dompdf;
// $dompdf = new Dompdf();
// $page = file_get_contents("success.php?session_id=" . $session_id . "&plan_id=' . $planid");
// $dompdf->loadHtml($page);
// $dompdf->setPaper('A4', 'portrait');
// $dompdf->render();
if (!empty($_GET['session_id'])) {
    $session_id = $_GET['session_id'];
}

echo $session_id;
// $dompdf->stream($Package_Name . '.pdf');
