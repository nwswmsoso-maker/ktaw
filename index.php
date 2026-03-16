<?php
$dataFile = 'links.json';

// وظيفة التحويل (Redirect)
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = json_decode(file_get_contents($dataFile), true);
    if (isset($data[$id])) {
        // هنا صفحة العداد (اختياري)
        echo "<body style='background:#121212;color:white;text-align:center;padding-top:100px;font-family:sans-serif;'>";
        echo "<h1>3TX</h1><h3>جاري تحويلك...</h3><h2 id='t'>5</h2>";
        echo "<script>let s=5; setInterval(()=>{s--; document.getElementById('t').innerText=s; if(s<=0)location.href='{$data[$id]}';},1000);</script>";
        exit;
    }
}

// وظيفة الاختصار (Shortening)
$shortUrl = "";
if (isset($_POST['url'])) {
    $longUrl = $_POST['url'];
    $data = json_decode(file_get_contents($dataFile), true) ?: [];
    $id = substr(md5($longUrl . time()), 0, 5); // صناعة كود قصير
    $data[$id] = $longUrl;
    file_put_contents($dataFile, json_encode($data));
    $shortUrl = "http://" . $_SERVER['HTTP_HOST'] . "/?id=" . $id;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>3TX | اختصار الروابط</title>
    <style>
        body { background: #0f0f0f; color: white; font-family: sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .box { background: #1a1a1a; padding: 30px; border-radius: 20px; width: 90%; max-width: 400px; text-align: center; border: 1px solid #333; }
        h1 { color: #00f2ea; font-size: 50px; margin-bottom: 20px; }
        input { width: 100%; padding: 15px; border-radius: 10px; border: 1px solid #444; background: #222; color: white; margin-bottom: 15px; box-sizing: border-box; }
        button { background: #00f2ea; color: black; padding: 15px; width: 100%; border: none; border-radius: 10px; font-weight: bold; cursor: pointer; }
        .res { margin-top: 20px; padding: 15px; border: 1px dashed #00f2ea; word-break: break-all; background: #222; }
    </style>
</head>
<body>
    <div class="box">
        <h1>3TX</h1>
        <form method="POST">
            <input type="url" name="url" placeholder="ضع الرابط الطويل هنا" required>
            <button type="submit">اختصار الرابط</button>
        </form>

        <?php if ($shortUrl): ?>
            <div class="res">
                <p>رابطك القصير جاهز:</p>
                <a href="<?php echo $shortUrl; ?>" style="color:#ff0050;"><?php echo $shortUrl; ?></a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
