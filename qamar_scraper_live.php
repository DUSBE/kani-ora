<?php
$html = @file_get_contents('https://qamaralfajr.com/production/exchange_rates.php');
if (!$html) {
    die("فشل في تحميل أسعار الصرف. تأكد من اتصالك أو من الموقع المصدر.");
}
libxml_use_internal_errors(true);
$dom = new DOMDocument();
$dom->loadHTML($html);
$xpath = new DOMXPath($dom);
$rows = $xpath->query('//table//tr');

echo '<!DOCTYPE html><html lang="ar"><head><meta charset="UTF-8">';
echo '<meta http-equiv="refresh" content="60">';
echo '<title>أسعار الصرف من القمر الفجر</title>';
echo '<style>body{direction:rtl;font-family:tahoma;padding:20px;background:#f9f9f9;} table{width:100%;border-collapse:collapse;margin-top:20px;} th,td{border:1px solid #ccc;padding:10px;text-align:center} th{background:#e0e0e0;} h2{text-align:center;color:#333;}</style>';
echo '</head><body>';
echo '<h2>أسعار العملات مباشرة من القمر الفجر</h2>';
echo '<table><thead><tr><th>العملة</th><th>سعر البيع</th><th>سعر الشراء</th></tr></thead><tbody>';

foreach ($rows as $i => $row) {
    if ($i == 0) continue;
    $cols = $row->getElementsByTagName('td');
    if ($cols->length >= 3) {
        $currency = $cols->item(0)->textContent;
        $sell = $cols->item(1)->textContent;
        $buy  = $cols->item(2)->textContent;
        echo "<tr><td>$currency</td><td>$sell</td><td>$buy</td></tr>";
    }
}

echo '</tbody></table>';
echo '<p style="text-align:center;color:#666;margin-top:20px;">المصدر: qamaralfajr.com — يتم التحديث كل دقيقة تلقائياً</p>';
echo '</body></html>';
?>
