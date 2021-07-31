<!doctype html>
<html lang="en-CA">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
<title>The Real Hotdog Mark</title>

<meta property="og:url" content="http://therealhotdogmark.com/">
<meta property="og:type" content="website">
<meta property="og:title" content="The Real Hotdog Mark">
<meta property="og:description" content="I'm totally a hotdog! Look at me go!">
<meta property="og:image" content="http://therealhotdogmark.com/images/share-photo.jpg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">

<link href="https://fonts.googleapis.com/css?family=Chewy|Press+Start+2P|Gaegu:700" rel="stylesheet">
<link href="css/normalize.css" type="text/css" rel="stylesheet">
<link href="css/main.css" type="text/css" rel="stylesheet">

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-24981697-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-24981697-3');
</script>

</head>
<body>

<?php
// The following code is based on this "PHP quickstart" guide:
// https://developers.google.com/analytics/devguides/reporting/core/v4/quickstart/service-php

// Load the Google API PHP Client Library.
require_once __DIR__ . "/vendor/autoload.php";

$analytics = initializeAnalytics();
$response = getReport($analytics);
$result = getResults($response);

/**
 * Initializes an Analytics Reporting API V4 service object.
 *
 * @return An authorized Analytics Reporting API V4 service object.
 */
function initializeAnalytics() {
  // Use the developers console and download your service account
  // credentials in JSON format. Place them in this directory or
  // change the key file location if necessary.
  // $KEY_FILE_LOCATION = __DIR__ . '/service-account-credentials.json';
  $KEY_FILE_LOCATION = "../service-account-credentials.json";

  // Create and configure a new client object.
  $client = new Google_Client();
  $client->setApplicationName("Data Analytics");
  $client->setAuthConfig($KEY_FILE_LOCATION);
  $client->setScopes(["https://www.googleapis.com/auth/analytics.readonly"]);
  $analytics = new Google_Service_AnalyticsReporting($client);

  return $analytics;
}

/**
 * Queries the Analytics Reporting API V4.
 *
 * @param service An authorized Analytics Reporting API V4 service object.
 * @return The Analytics Reporting API V4 response.
 */
function getReport($analytics) {
  // Replace with your view ID, for example XXXX.
  // You can get this number from https://ga-dev-tools.appspot.com/account-explorer/
  // First, select the property, then the number will appear in the
  // "view" column of the "Showing view selected above" table.
  $VIEW_ID = "177566365";

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("2018-06-21");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $users = new Google_Service_AnalyticsReporting_Metric();
  $users->setExpression("ga:users");
  $users->setAlias("users");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setMetrics(array($users));

  // Documentation for the batchGet method:
  // https://developers.google.com/analytics/devguides/reporting/core/v4/rest/v4/reports/batchGet
  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests(array($request));
  return $analytics->reports->batchGet($body);
}

/**
 * Parses and prints the Analytics Reporting API V4 response.
 *
 * @param An Analytics Reporting API V4 response.
 */
function getResults($reports) {
  $returnValue = NULL;
  for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
    $report = $reports[$reportIndex];
    $header = $report->getColumnHeader();
    $dimensionHeaders = $header->getDimensions();
    $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
    $rows = $report->getData()->getRows();

    for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
      $row = $rows[$rowIndex];
      $dimensions = $row->getDimensions();
      $metrics = $row->getMetrics();
      for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
        // print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
      }
      for ($j = 0; $j < count($metrics); $j++) {
        $values = $metrics[$j]->getValues();
        for ($k = 0; $k < count($values); $k++) {
          $entry = $metricHeaders[$k];
          // print($entry->getName() . ": " . $values[$k] . "\n");
          if ($entry->getName() === "users") {
            $returnValue = $values[$k];
          }
        }
      }
    }
  }
  return $returnValue;
}
?>

<div id="container" role="main">
  <h1>The Real Hotdog Mark</h1>
  <figure>
    <img src="images/hotdog-mark.gif" width="400" height="400" alt="Mark dancing while wearing a hotdog suit" />
    <figcaption>Look at me go!</figcaption>
  </figure>
  <?php
    if ($result) {
      $paddedResult = str_pad($result, 5, "0", STR_PAD_LEFT);
      print '<p class="counter-message">You are visitor number: ';
      print '<span class="visually-hidden">' . $result . '</span>';
      print '<span class="counter" aria-hidden="true">';
      $numbers = str_split($paddedResult);
      for ($i = 0; $i < count($numbers); $i++) {
        print '<span class="number">' . $numbers[$i] . '</span>';
      }
      print '</span></p>';
    }
  ?>
</div>

</body>
</html>