<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
ini_set("display_errors", 1);
session_start();
include __DIR__ . '/config.php';
include __DIR__ . '/pdio_api_functions.php';

set_time_limit(0);

/**
 * CLI entry point for the scheduled/manual PDIO API pull. The actual
 * logic lives in pdio_api_functions.php, shared with api_pdio_trigger.php
 * (the checkboxes on api_pdio_serendah.php).
 *
 * Runs two ways:
 *   - Scheduled (cron): no date argument -> pulls today's production_date only.
 *   - Manual re-sync: a date argument is passed when the vendor tells us they
 *     added/changed data for a day already pulled. Re-fetches that date and
 *     upserts, instead of skipping rows that already exist.
 *
 * Pulls BOTH known organizations (PMSB and PGMSB) by default - pass a
 * comma-separated list as the 3rd argument to restrict to one.
 */

$plant_dlv = '3100';       // ship_point prefix, same as Serendah upload
$username  = 'API_PDIO';   // system user, not an interactive session

// ---------------------------------------------------------------------
// Entry point
//   php api_pdio_import.php                              -> cron: today, both organizations
//   php api_pdio_import.php 2026-09-14                    -> manual re-sync of a given date, both organizations
//   php api_pdio_import.php 2026-09-14 PM4448228          -> manual re-sync of one PDIO, both organizations
//   php api_pdio_import.php 2026-09-14 PM4448228 PMSB     -> restrict to PMSB only
//   php api_pdio_import.php 2026-09-14 "" PMSB,PGMSB      -> whole day, both organizations (explicit)
// ---------------------------------------------------------------------
try {
    $targetDate = $argv[1] ?? date('Y-m-d');
    $pdioNumber = $argv[2] ?? '';
    $organizations = isset($argv[3]) ? explode(',', $argv[3]) : array_keys(PDIO_ORGANIZATIONS);
    if (!DateTime::createFromFormat('Y-m-d', $targetDate)) {
        throw new InvalidArgumentException("Invalid date '$targetDate', expected YYYY-MM-DD.");
    }

    $result = pullPdioForDateAndOrganizations($dbc, $targetDate, $username, $plant_dlv, $organizations, $pdioNumber);
    $totals = $result['totals'];

    foreach ($result['by_organization'] as $org => $s) {
        echo "  $org: ".html_esc($s['inserted'])." inserted, ".html_esc($s['updated'])." updated, "
            . "".html_esc($s['skipped_approved'])." skipped (already Approved), ".html_esc($s['skipped_duplicate'])." skipped (duplicate).\n";
    }

    echo "PDIO import for $targetDate - TOTAL: ".html_esc($totals['inserted'])." inserted, "
        . "".html_esc($totals['updated'])." updated, ".html_esc($totals['skipped_approved'])." skipped (already Approved), "
        . "".html_esc($totals['skipped_duplicate'])." skipped (duplicate in this API response).\n";
} catch (Throwable $e) {
    logPdioDebug('ERROR: ' . $e->getMessage());
    error_log('[PDIO API import] ' . $e->getMessage());
    echo "PDIO API import failed: " . $e->getMessage() . "\n";
    exit(1);
}
