<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
ini_set("display_errors", 1);
session_start();
include __DIR__ . '/config.php';
include __DIR__ . '/pdio_api_functions.php';

set_time_limit(0);

// Same auth guard as api_pdio_serendah.php - only a logged-in user (or the
// lvl_id=2 API/system role) can trigger a pull.
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
    header('Location: ../index.php');
    exit();
}

$username = $_SESSION['username'];

if (!isset($_POST['triggerPdioPull'])) {
    header('Location: api_pdio_serendah.php');
    exit();
}

$targetDate = $_POST['pull_date'] ?? date('Y-m-d');
$pdioNumber = trim($_POST['pdio_number'] ?? '');
$organizations = $_POST['organizations'] ?? [];

if (!DateTime::createFromFormat('Y-m-d', $targetDate)) {
    echo "<script>alert('Invalid date.'); window.location='api_pdio_serendah.php';</script>";
    exit();
}

if (empty($organizations)) {
    echo "<script>alert('Select at least one organization (PMSB and/or PGMSB).'); window.location='api_pdio_serendah.php';</script>";
    exit();
}

$plantDlv = '3100';

logPdioDebug("=== Manual pull triggered by $username: date=$targetDate organizations=" . implode(',', $organizations)
    . " pdio_number=" . ($pdioNumber !== '' ? $pdioNumber : '(whole day)'));

try {
    $result = pullPdioForDateAndOrganizations($dbc, $targetDate, $username, $plantDlv, $organizations, $pdioNumber);
    $totals = $result['totals'];

    $perOrgLines = [];
    foreach ($result['by_organization'] as $org => $s) {
        $perOrgLines[] = "$org: {$s['inserted']} inserted, {$s['updated']} updated, {$s['skipped_approved']} already Approved, {$s['skipped_duplicate']} duplicates";
    }

    $message = sprintf(
        "PDIO pull for %s done.\n%s\nTotal: %d inserted, %d updated, %d already Approved (skipped), %d duplicate rows skipped.",
        $targetDate, implode("\n", $perOrgLines),
        $totals['inserted'], $totals['updated'], $totals['skipped_approved'], $totals['skipped_duplicate']
    );

    $redirectUrl = 'api_pdio_serendah.php?pulled_date=' . urlencode($targetDate);
    echo "<script>alert(" . json_encode($message) . "); window.location=" . json_encode($redirectUrl) . ";</script>";
} catch (Throwable $e) {
    logPdioDebug('ERROR: ' . $e->getMessage());
    error_log('[PDIO API trigger] ' . $e->getMessage());
    $message = 'PDIO pull failed: ' . $e->getMessage();
    echo "<script>alert(" . json_encode($message) . "); window.location='api_pdio_serendah.php';</script>";
}
