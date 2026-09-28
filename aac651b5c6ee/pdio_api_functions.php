<?php

// ---------------------------------------------------------------------
// Shared PDIO API client functions - used by both the scheduled CLI pull
// (api_pdio_import.php) and the manual web trigger (api_pdio_trigger.php,
// wired to the checkboxes on api_pdio_serendah.php).
//
// Matches the real Perodua API spec (Perodua API Integration Guide),
// confirmed against the live dev environment on 14-17/09/2026 - notably
// different from the guide's documented shape in a few places, see the
// inline notes below.
//
// Requires PDIO_API_BASE_URL, PDIO_API_CLIENT_ID, PDIO_API_CLIENT_SECRET,
// PDIO_VENDOR_ID to already be defined (see config.php). PDIO_ORGANIZATION
// (singular) is no longer used here - "organization" is now selected per
// pull (PMSB / PGMSB, see PDIO_ORGANIZATIONS below), not one fixed value.
// ---------------------------------------------------------------------

// dlv_upload_pdio.cust_code / dlv_pdio_generate.cust_code store a specific
// customer id (cust_detail.id_cust, e.g. "100124") - NOT the "PERODUA"
// group code (cust_detail.cust_ID) shown in the Upload PDIO customer
// dropdown's WHERE clause. Confirmed by the search screen
// (view_pdio_serendah-dlv.php) filtering on cust_code = <id_cust value
// from that dropdown> - using a single hardcoded cust_code for every
// pulled row silently broke that search/filter for PDIOs belonging to a
// different customer.
//
// getPDIOData's "organization" parameter is itself the customer selector
// - confirmed against the live dev environment on 14-17/09/2026:
// organization=PMSB returns only PM* PDIOs, organization=PGMSB returns
// only PG* PDIOs. So the customer is known directly from which
// organization was queried, not guessed from the PDIO number prefix
// (an earlier version of this code guessed by prefix, which required
// assuming a PS*->organization mapping that was never confirmed to
// exist - see pdio_api_debug.log history / email thread with Perodua).
const PDIO_ORGANIZATIONS = [
    'PMSB'  => ['cust_code' => '100000', 'label' => 'PMSB (PM* - PERODUA MANUFACTURING SDN BHD)'],
    'PGMSB' => ['cust_code' => '100124', 'label' => 'PGMSB (PG* - PERODUA GLOBAL MANUFACTURING SDN. BHD.)'],
];

function getCustCodeForOrganization(string $organization): string
{
    if (!isset(PDIO_ORGANIZATIONS[$organization])) {
        throw new RuntimeException("Unrecognized organization '$organization' - no known customer mapping (expected one of: " . implode(', ', array_keys(PDIO_ORGANIZATIONS)) . ").");
    }

    return PDIO_ORGANIZATIONS[$organization]['cust_code'];
}

// Appends one line to pdio_api_debug.log (same folder) - lets you see the
// exact request/response for every pull without needing server SSH/log
// access, e.g. via FTP or a hosting file manager.
function logPdioDebug(string $message): void
{
    $line = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
    @file_put_contents(__DIR__ . '/pdio_api_debug.log', $line, FILE_APPEND | LOCK_EX);
}

function getPdioAccessToken(): string
{
    $url = PDIO_API_BASE_URL . '/dataspider/trigger/auth/getAccessToken/';
    $body = [
        'client_id'     => PDIO_API_CLIENT_ID,
        'client_secret' => PDIO_API_CLIENT_SECRET,
        'grant_type'    => 'client_credentials',
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS     => json_encode($body),
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr  = curl_error($ch);
    curl_close($ch);

    // client_secret redacted from the log - everything else is safe to see.
    $loggedBody = $body;
    $loggedBody['client_secret'] = '***';
    logPdioDebug("getAccessToken REQUEST url=$url body=" . json_encode($loggedBody));
    logPdioDebug("getAccessToken RESPONSE http=$httpCode curl_error=\"$curlErr\" body=$response");

    if ($curlErr !== '') {
        // Most common cause on older Windows/PHP builds: outdated CA bundle
        // or no outbound internet from the server - curl_exec() returns
        // false with httpCode 0 in that case, and the generic "HTTP 0"
        // message below is useless without this.
        throw new RuntimeException("curl error while getting PDIO access token: $curlErr");
    }

    if ($httpCode !== 200) {
        throw new RuntimeException("Failed to get PDIO access token (HTTP $httpCode): $response");
    }

    $data = json_decode($response, true);

    if (empty($data['access_token'])) {
        throw new RuntimeException("PDIO token response missing access_token: $response");
    }

    return $data['access_token'];
}

// $productionDate is Y-m-d internally; converted to dd/mm/yyyy for the
// request, since that's the format Perodua's API expects.
// $pdioNumber is optional - lets a manual re-sync target a single PDIO
// instead of pulling the whole day again.
function fetchPdioDetails(string $accessToken, string $vendorId, string $productionDate, string $organization, string $pdioNumber = ''): array
{
    $url = PDIO_API_BASE_URL . '/dataspider/trigger/getPDIOData';
    $body = [
        'vendor_id'       => $vendorId,
        'production_date' => reformatDateForApi($productionDate),
        'organization'    => $organization,
        'pdio_number'     => $pdioNumber,
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'token: ' . $accessToken,   // custom header, NOT Authorization: Bearer
        ],
        CURLOPT_POSTFIELDS => json_encode($body),
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr  = curl_error($ch);
    curl_close($ch);

    logPdioDebug("getPDIOData REQUEST url=$url body=" . json_encode($body));
    logPdioDebug("getPDIOData RESPONSE http=$httpCode curl_error=\"$curlErr\" body=$response");

    if ($curlErr !== '') {
        throw new RuntimeException("curl error while fetching PDIO details: $curlErr");
    }

    if ($httpCode !== 200) {
        throw new RuntimeException("Failed to fetch PDIO details (HTTP $httpCode): $response");
    }

    $data = json_decode($response, true);

    $rowCount = count($data['DATA'] ?? []);
    logPdioDebug("getPDIOData parsed $rowCount row(s) from response");

    return $data['DATA'] ?? [];
}

// Date helpers - API uses dd/mm/yyyy, the DB uses yyyy-mm-dd throughout.
function reformatDateForApi(string $ymd): string
{
    $dt = DateTime::createFromFormat('Y-m-d', $ymd);
    if ($dt === false) {
        throw new InvalidArgumentException("Expected Y-m-d date, got '$ymd'");
    }

    return $dt->format('d/m/Y');
}

function reformatDateFromApi(string $raw): string
{
    // Confirmed against the live dev environment on 14/09/2026: DELIVERY_DATE
    // actually comes back as 8 digits with no separators ("10092026"), not
    // the "dd/mm/yyyy" the integration guide documents. Accept both, in
    // case Perodua's format varies by field/environment.
    $dt = DateTime::createFromFormat('dmY', $raw);
    if ($dt === false) {
        $dt = DateTime::createFromFormat('d/m/Y', $raw);
    }
    if ($dt === false) {
        throw new InvalidArgumentException("Expected ddmmyyyy or d/m/Y date from API, got '$raw'");
    }

    return $dt->format('Y-m-d');
}

// Normalizes one API row (UPPERCASE keys) into the lowercase field names
// used by dlv_upload_pdio. Keeping this as one place to edit when
// Perodua's field list changes.
function mapApiRowToDbFields(array $row, string $requestedProductionDate): array
{
    return [
        'pdio_no'      => $row['PDIO_NUMBER'],
        // Confirmed against the live dev environment on 14/09/2026: the
        // actual field is SUPPLY_COURSE, not SUPPLY_ORDER as documented in
        // the integration guide. Falling back to SUPPLY_ORDER in case a
        // future response (or a different environment) matches the guide.
        'order_no'     => $row['SUPPLY_COURSE'] ?? $row['SUPPLY_ORDER'],
        'back_no'      => $row['BACK_NUMBER'],
        'material_no'  => $row['PART_NUMBER'],
        // The response doesn't echo production_date back - it's the
        // parameter we queried by, so use that rather than DELIVERY_DATE
        // (delivery date can differ from production date).
        'prod_date'    => $requestedProductionDate,
        'pdio_qty'     => $row['QTY_PER_BOX'],
        'dlv_date'     => reformatDateFromApi($row['DELIVERY_DATE']) . ' ' . $row['DELIVERY_TIME'] . ':00',

        // TODO: no confirmed column in dlv_upload_pdio for these yet -
        // DOCK_CODE/DOCK_CODE_DESC look like they may correspond to the
        // Excel report's "Dock"/"Delivery Category" columns, and
        // QTY_BOX_UNIT to its separate "Total Order (Box)" column, but
        // that needs confirming with Perodua/the DBA before wiring them
        // into an UPDATE statement. Left out of insert/update on purpose
        // rather than guessed at.
        // 'dock_code'      => $row['DOCK_CODE'],
        // 'dock_code_desc' => $row['DOCK_CODE_DESC'],
        // 'qty_box_unit'   => $row['QTY_BOX_UNIT'],

        // TRIP showed up in the live dev response on 14/09/2026 even though
        // it isn't in the integration guide - maps cleanly to trip_no.
        'trip_no'      => $row['TRIP'] ?? '',

        // Still not in the API response at all - left blank same as before.
        'dlv_category' => '',
        'line_no'      => '',
        'cycle_pdio'   => '',
        'material_desc' => '', // filled in by enrichPdioRow() from table_material_itsb
    ];
}

// Finds an existing line for this PDIO, keyed the same way the duplicate
// check in ups_pdio_serendah01.php treats a unique delivery line
// (pdio_no + order_no + material_no + prod_date).
function findExistingPdioLine(mysqli $dbc, string $pdioNo, string $orderNo, string $materialNo, string $prodDate): ?array
{
    $sql = "SELECT id, status_pdio FROM dlv_upload_pdio
            WHERE pdio_no = ? AND order_no = ? AND material_no = ? AND prod_date = ?
            LIMIT 1";
    $stmt = $dbc->prepare($sql);
    $stmt->bind_param('ssss', $pdioNo, $orderNo, $materialNo, $prodDate);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc() ?: null;
}

// Insert a brand new line (mirrors Stage 1 of the Excel upload script)
function insertPdioRow(mysqli $dbc, array $f, string $username, string $currentdate, string $plantDlv, string $custCode): int
{
    $statusBaru = 'New';
    $uploadId   = '0';                        // no ftp_ups_pdio batch record for API-sourced rows
    $fileName   = 'API_' . date('Ymd_His');

    $sql = "INSERT INTO dlv_upload_pdio
        (pdio_no, order_no, dlv_category, trip_no, line_no, prod_date, dlv_date,
         cycle_pdio, back_no, material_no, material_desc, pdio_qty,
         created_by, date_create, status_pdio, plant_code, upload_id, file_name, cust_code)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $dbc->prepare($sql);
    $stmt->bind_param(
        'sssssssssssssssssss',
        $f['pdio_no'], $f['order_no'], $f['dlv_category'], $f['trip_no'], $f['line_no'],
        $f['prod_date'], $f['dlv_date'], $f['cycle_pdio'], $f['back_no'], $f['material_no'],
        $f['material_desc'], $f['pdio_qty'],
        $username, $currentdate, $statusBaru, $plantDlv, $uploadId, $fileName, $custCode
    );
    $stmt->execute();

    return $dbc->insert_id;
}

// Refresh an existing line when the vendor changed data and someone
// re-triggers the pull for that date. Only touches rows that have not
// moved past Draft - once a line is Approved it has already been copied
// into dlv_pdio_generate, so silently rewriting it here could desync an
// instruction that has already gone out.
function updatePdioRow(mysqli $dbc, int $id, array $f, string $updateBy): void
{
    $sql = "UPDATE dlv_upload_pdio SET
            back_no = ?, pdio_qty = ?, dlv_category = ?, trip_no = ?, line_no = ?,
            dlv_date = ?, cycle_pdio = ?, material_desc = ?,
            update_by = ?, date_update = NOW()
        WHERE id = ?";
    $stmt = $dbc->prepare($sql);
    $stmt->bind_param(
        'sssssssssi',
        $f['back_no'], $f['pdio_qty'], $f['dlv_category'], $f['trip_no'], $f['line_no'],
        $f['dlv_date'], $f['cycle_pdio'], $f['material_desc'],
        $updateBy, $id
    );
    $stmt->execute();
}

// Enrich against table_material_itsb / cust_detail (mirrors Stage 2 of
// the Excel upload script)
function enrichPdioRow(mysqli $dbc, int $id, string $plantCode, string $custCode): void
{
    $sql = "SELECT TB1.id, TB1.back_no, TB2.material_no AS sap_material_no,
                   TB2.material_desc AS sap_material_desc, TB2.BUn AS uom
            FROM dlv_upload_pdio AS TB1
            JOIN table_material_itsb AS TB2
              ON (TB1.material_no = TB2.material_cust_no OR TB1.material_no = TB2.material_no)
            WHERE TB1.id = ?
              AND TB2.status_BOM = 'Y'
              AND TB2.plant_code = ?";
    $stmt = $dbc->prepare($sql);
    $stmt->bind_param('is', $id, $plantCode);
    $stmt->execute();
    $match = $stmt->get_result()->fetch_assoc();

    if ($match === null) {
        // no BOM match - leave status as 'New' so it surfaces for manual review
        return;
    }

    $custStmt = $dbc->prepare('SELECT cust_desc FROM cust_detail WHERE id_cust = ? AND status_cust = ?');
    $active = 'Y';
    $custStmt->bind_param('ss', $custCode, $active);
    $custStmt->execute();
    $custDesc = $custStmt->get_result()->fetch_assoc()['cust_desc'] ?? '';

    $backNoClean = str_replace(' ', '', $match['back_no']);
    $yearNow  = date('Y');
    $monthNow = date('m');

    $updateSql = "UPDATE dlv_upload_pdio SET
            material_no_sap = ?, material_desc = ?, uom_pdio = ?, cust_name = ?,
            back_no = ?, status_pdio = 'Draft', yr_plan = ?, mth_plan = ?
        WHERE id = ?";
    $updateStmt = $dbc->prepare($updateSql);
    $updateStmt->bind_param(
        'sssssssi',
        $match['sap_material_no'], $match['sap_material_desc'], $match['uom'], $custDesc,
        $backNoClean, $yearNow, $monthNow, $id
    );
    $updateStmt->execute();
}

// Import (or re-sync) one production date's worth of PDIO data for ONE
// organization (e.g. "PMSB" or "PGMSB"). Call once per organization the
// user selected - see pullPdioForDateAndOrganizations() below for the
// multi-organization wrapper used by the web trigger / CLI.
function importPdioForDate(mysqli $dbc, string $targetDate, string $username, string $plantDlv, string $organization, string $pdioNumber = '', ?string $genDocDir = null): array
{
    $genDocDir = $genDocDir ?? __DIR__;

    $custCode = getCustCodeForOrganization($organization);

    $accessToken = getPdioAccessToken();

    // In production this would loop over each active vendor_id configured
    // for API integration, not a single hard-coded value.
    $vendorId = PDIO_VENDOR_ID;
    $rawRows  = fetchPdioDetails($accessToken, $vendorId, $targetDate, $organization, $pdioNumber);

    $summary = ['inserted' => 0, 'updated' => 0, 'skipped_approved' => 0, 'skipped_duplicate' => 0, 'skipped_unknown_customer' => 0];

    // Confirmed against the live dev environment on 14/09/2026: a single
    // getPDIOData response can repeat the exact same line dozens of times
    // - one date pull returned 1072 rows collapsing to 192 unique lines.
    // Without this, every repeat re-runs a redundant UPDATE + enrichment
    // query against the same row.
    $seenKeys = [];

    foreach ($rawRows as $rawRow) {
        $f = mapApiRowToDbFields($rawRow, $targetDate);

        $key = $f['pdio_no'] . '|' . $f['order_no'] . '|' . $f['material_no'] . '|' . $f['prod_date'];
        if (isset($seenKeys[$key])) {
            $summary['skipped_duplicate']++;
            continue;
        }
        $seenKeys[$key] = true;

        $existing = findExistingPdioLine($dbc, $f['pdio_no'], $f['order_no'], $f['material_no'], $f['prod_date']);

        if ($existing === null) {
            $id = insertPdioRow($dbc, $f, $username, $targetDate, $plantDlv, $custCode);
            enrichPdioRow($dbc, $id, $plantDlv, $custCode);
            $summary['inserted']++;
            continue;
        }

        if (in_array($existing['status_pdio'], ['New', 'Draft'], true)) {
            updatePdioRow($dbc, (int)$existing['id'], $f, $username);
            enrichPdioRow($dbc, (int)$existing['id'], $plantDlv, $custCode);
            $summary['updated']++;
            continue;
        }

        // Already Approved -> already copied into dlv_pdio_generate. Don't
        // silently rewrite an instruction that has already gone out; flag
        // it instead so someone decides whether a manual correction is needed.
        error_log("[PDIO API import] pdio_no={$f['pdio_no']} material_no={$f['material_no']} "
            . "changed by vendor but is already Approved (id={$existing['id']}) - not auto-updated.");
        $summary['skipped_approved']++;
    }

    // Early warning if the vendor's data quality shifts.
    $totalRows = count($rawRows);
    if ($totalRows > 0) {
        $duplicateRatio = $summary['skipped_duplicate'] / $totalRows;
        if ($duplicateRatio > 0.5) {
            error_log(sprintf(
                '[PDIO API import] WARNING: %s - %d of %d rows (%.0f%%) were duplicates within a single response.'
                    . ' Confirm with Perodua whether this is expected before assuming the import ran correctly.',
                $targetDate, $summary['skipped_duplicate'], $totalRows, $duplicateRatio * 100
            ));
        }
    }

    // Same downstream step as the Excel flow: generate dlv_pdio_generate
    // rows and flip status_pdio to Approved, for whatever is still Draft.
    if ($summary['inserted'] > 0 || $summary['updated'] > 0) {
        generateAndApprovePdioDocs($dbc, $plantDlv, $username, $genDocDir);
    }

    logPdioDebug("importPdioForDate($targetDate) summary: " . json_encode($summary));

    return $summary;
}

// Runs importPdioForDate() once per selected organization (user can pick
// PMSB, PGMSB, or both from the checkboxes on api_pdio_serendah.php) and
// returns both the combined total and each organization's own numbers,
// so the result screen can show "PMSB: 12 inserted / PGMSB: 8 inserted"
// rather than one opaque combined count.
function pullPdioForDateAndOrganizations(mysqli $dbc, string $targetDate, string $username, string $plantDlv, array $organizations, string $pdioNumber = '', ?string $genDocDir = null): array
{
    if (empty($organizations)) {
        throw new InvalidArgumentException('At least one organization (PMSB and/or PGMSB) must be selected.');
    }

    $totals = ['inserted' => 0, 'updated' => 0, 'skipped_approved' => 0, 'skipped_duplicate' => 0];
    $perOrganization = [];

    foreach ($organizations as $organization) {
        if (!isset(PDIO_ORGANIZATIONS[$organization])) {
            throw new RuntimeException("Unrecognized organization '$organization' - expected one of: " . implode(', ', array_keys(PDIO_ORGANIZATIONS)));
        }

        $summary = importPdioForDate($dbc, $targetDate, $username, $plantDlv, $organization, $pdioNumber, $genDocDir);
        $perOrganization[$organization] = $summary;

        $totals['inserted']          += $summary['inserted'];
        $totals['updated']           += $summary['updated'];
        $totals['skipped_approved']  += $summary['skipped_approved'];
        $totals['skipped_duplicate'] += $summary['skipped_duplicate'];
    }

    return ['totals' => $totals, 'by_organization' => $perOrganization];
}

// Looks up request_status.status_desc for a given status_id - same lookups
// ups_pdio_serendah01.php does at the top of the file ($rst_sta = id 1
// "New", $rst_sta3 = id 3 "Approved", $rst_sta7 = id 7 "In Progress").
function getRequestStatusDesc(mysqli $dbc, string $statusId): string
{
    $stmt = $dbc->prepare('SELECT status_desc FROM request_status WHERE status_id = ?');
    $stmt->bind_param('s', $statusId);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc()['status_desc'] ?? '';
}

// Orchestrates gen_mat_doc_PDIO.php / _cls.php exactly the way
// ups_pdio_serendah01.php does around its own include of them: generate
// one doc number ($ref) for this run, copy every currently-Draft line for
// this plant into dlv_pdio_generate under that doc number, persist the
// counter (_cls.php), then flip those source lines to Approved.
//
// Unlike the Excel flow (which scopes this to one upload_id batch), the
// API flow has no batch id - all API-sourced rows share upload_id '0' -
// so this scopes by status_pdio = 'Draft' + plant_code instead, which is
// the API-import equivalent of "everything this run just enriched".
function generateAndApprovePdioDocs(mysqli $dbc, string $plantDlv, string $username, string $genDocDir): void
{
    if (!file_exists($genDocDir . '/gen_mat_doc_PDIO.php') || !file_exists($genDocDir . '/gen_mat_doc_PDIO_cls.php')) {
        error_log('[PDIO API import] gen_mat_doc_PDIO.php / _cls.php not found in ' . $genDocDir . ' - skipping doc generation, rows stay at Draft.');
        return;
    }

    // gen_mat_doc_PDIO.php reads $plant_dlv (not $plantDlv) and sets $ref,
    // $number2 - matches the variable names it actually uses (given as-is,
    // unmodified, from the real app).
    $plant_dlv = $plantDlv;
    include $genDocDir . '/gen_mat_doc_PDIO.php';

    if (!isset($ref)) {
        error_log("[PDIO API import] gen_mat_doc_PDIO.php did not produce \$ref for plant_dlv=$plantDlv - skipping doc generation.");
        return;
    }

    $statusNew        = getRequestStatusDesc($dbc, '1');
    $statusInProgress = getRequestStatusDesc($dbc, '7');
    $statusApproved   = getRequestStatusDesc($dbc, '3');

    $draftStmt = $dbc->prepare("SELECT * FROM dlv_upload_pdio WHERE status_pdio = 'Draft' AND plant_code = ?");
    $draftStmt->bind_param('s', $plantDlv);
    $draftStmt->execute();
    $rows = $draftStmt->get_result();
    while ($row = $rows->fetch_assoc()) {
        $insert = $dbc->prepare(
            "INSERT INTO dlv_pdio_generate
                (id_gen, mat_doc, pdio_no, order_no, dlv_category, trip_no, line_no, prod_date, dlv_date,
                 cycle_pdio, back_no, material_no, material_desc, pdio_qty, uom_pdio,
                 created_by, date_create, update_by, date_update, status_upload, status_pdio,
                 plant_code, upload_id, file_name, mth_plan, yr_plan, cust_code, cust_name,
                 status_DO, material_no_cust)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $insert->bind_param(
            'sssssssssssssssssssssssssssss',
            $row['id'], $ref, $row['pdio_no'], $row['order_no'], $row['dlv_category'], $row['trip_no'], $row['line_no'],
            $row['prod_date'], $row['dlv_date'], $row['cycle_pdio'], $row['back_no'], $row['material_no_sap'],
            $row['material_desc'], $row['pdio_qty'], $row['uom_pdio'], $row['created_by'], $row['date_create'],
            $username, $statusInProgress, $statusApproved, $row['plant_code'], $row['upload_id'], $row['file_name'],
            $row['mth_plan'], $row['yr_plan'], $row['cust_code'], $row['cust_name'], $statusNew, $row['material_no']
        );
        $insert->execute();
    }

    // gen_mat_doc_PDIO_cls.php reads $plant_dlv, $number2 (from the include
    // above) and $fdate to persist the counter.
    $fdate = date('Y-m-d');
    include $genDocDir . '/gen_mat_doc_PDIO_cls.php';

    $dbc->query("UPDATE dlv_upload_pdio SET status_pdio = '" . $dbc->real_escape_string($statusApproved) . "' "
        . "WHERE status_pdio = 'Draft' AND plant_code = '" . $dbc->real_escape_string($plantDlv) . "'");
}
