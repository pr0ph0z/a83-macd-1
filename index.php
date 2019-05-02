<!DOCTYPE html>
<html>
<head>
	<title>Pendaftaran Murid</title>
  <style type="text/css">
    /* Fonts */
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400);

    /* fontawesome */
    @import url(http://weloveiconfonts.com/api/?family=fontawesome);
    [class*="fontawesome-"]:before {
      font-family: 'FontAwesome', sans-serif;
    }

    /* Simple Reset */
    * { margin: 0; padding: 0; box-sizing: border-box; }

    /* body */
    body {
      background: #e9e9e9;
      color: #5e5e5e;
      font: 400 87.5%/1.5em 'Open Sans', sans-serif;
    }

    /* Form Layout */
    .form-wrapper {
      background: #fafafa;
      margin: 3em auto;
      padding: 0 1em;
      max-width: 370px;
    }

    h1 {
      text-align: center;
      padding: 1em 0;
    }

    form {
      padding: 0 1.5em;
    }

    .form-item {
      margin-bottom: 0.75em;
      width: 100%;
    }

    .form-item input {
      background: #fafafa;
      border: none;
      border-bottom: 2px solid #e9e9e9;
      color: #666;
      font-family: 'Open Sans', sans-serif;
      font-size: 1em;
      height: 50px;
      transition: border-color 0.3s;
      width: 100%;
    }

    .form-item input:focus {
      border-bottom: 2px solid #c0c0c0;
      outline: none;
    }

    .button-panel {
      margin: 2em 0 0;
      width: 100%;
    }

    .button-panel .button {
      background: #f16272;
      border: none;
      color: #fff;
      cursor: pointer;
      height: 50px;
      font-family: 'Open Sans', sans-serif;
      font-size: 1.2em;
      letter-spacing: 0.05em;
      text-align: center;
      text-transform: uppercase;
      transition: background 0.3s ease-in-out;
      width: 100%;
    }

    .button:hover {
      background: #ee3e52;
    }

    .form-footer {
      font-size: 1em;
      padding: 2em 0;
      text-align: center;
    }

    .form-footer a {
      color: #8c8c8c;
      text-decoration: none;
      transition: border-color 0.3s;
    }

    .form-footer a:hover {
      border-bottom: 1px dotted #8c8c8c;
    }
    table { 
      margin: 0 auto;
      border-collapse: collapse;
      font-family: Agenda-Light, sans-serif;
      font-weight: 100; 
      background: #333; color: #fff;
      text-rendering: optimizeLegibility;
      border-radius: 5px; 
    }
    table caption { 
      font-size: 2rem; color: #444;
      margin: 1rem;
    }
    table thead th { font-weight: 600; }
    table thead th, table tbody td { 
      padding: .8rem; font-size: 1.4rem;
    }
    table tbody td { 
      padding: .8rem; font-size: 1.4rem;
      color: #444; background: #eee; 
    }
    table tbody tr:not(:last-child) { 
      border-top: 1px solid #ddd;
      border-bottom: 1px solid #ddd;  
    }

    @media screen and (max-width: 600px) {
      table caption { background-image: none; }
      table thead { display: none; }
      table tbody td { 
        display: block; padding: .6rem; 
      }
      table tbody tr td:first-child { 
        background: #666; color: #fff; 
      }
      table tbody td:before { 
        content: attr(data-th); 
        font-weight: bold;
        display: inline-block;
        width: 6rem;  
      }
    }
  </style>
</head>
<body>
  <div class="form-wrapper">
    <h1>Pendaftaran Murid</h1>
    <form method="post" action="index.php">
      <div class="form-item">
        <label for="nama"></label>
        <input type="text" name="nama" required="required" placeholder="Nama"></input>
      </div>
      <div class="form-item">
        <label for="kelas"></label>
        <input type="text" name="kelas" required="required" placeholder="Kelas"></input>
      </div>
      <div class="form-item">
        <label for="sekolah"></label>
        <input type="text" name="sekolah" required="required" placeholder="Sekolah"></input>
      </div>
      <div class="button-panel">
        <input type="submit" name="kirim" class="button" title="Kirim" value="Kirim"></input>
      </div>
    </form>
    <div class="form-footer">
    </div>
  </div>
  <table>
    <caption>Daftar Murid</caption>
    <thead>
      <tr>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Sekolah</th>
      </tr>
    </thead>
    <tbody>
  <?php
  $dbHost = "rdsdicoding.database.windows.net";
  $dbUser = "dicoding";
  $dbPass = "D1coding123";
  $dbName = "dicoding";

  try {
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];
    $conn = new PDO("sqlsrv:server = $dbHost; Database = $dbName", $dbUser, $dbPass, $options);
  }
  catch(Exception $e) {
    echo "Failed Connect " . $e;
    die();
  }

  if (isset($_POST['kirim'])) {
    try {
      $nama = $_POST['nama'];
      $kelas = $_POST['kelas'];
      $sekolah = $_POST['sekolah'];

      $queryGetId = "SELECT MAX(id) as id FROM sekolah";
      $stmtGetId = $conn->query($queryGetId);
      $data = $stmtGetId->fetchAll();
      if (count($data) > 0) {
        $maxId = (int) $data[0]['id']; 
      } else {
        $maxId = 1;
      }

      $query = "INSERT INTO sekolah (id, nama, kelas, sekolah) VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($query);
      $stmt->bindValue(1, 5);
      $stmt->bindValue(2, $nama);
      $stmt->bindValue(3, $kelas);
      $stmt->bindValue(4, $sekolah);
      $stmt->execute();
    }
    catch (Exception $e) {
      echo "Failed: ".$e;
    }
  }
  try {
    $query = "SELECT * FROM sekolah";
    $stmt = $conn->query($query);
    $data = $stmt->fetchAll();
    foreach ($data as $item) {
      echo "<tr>";
      echo "<td>".$item['nama']."</td>";
      echo "<td>".$item['kelas']."</td>";
      echo "<td>".$item['sekolah']."</td>";
      echo "</tr>";
    }
  }
  catch (Exception $e) {
    echo "Failed: ".$e;
  }
  ?>
  </tbody>
  </table>
  *kode style form: <a href="https://codepen.io/bowie/pen/erEoh">https://codepen.io/bowie/pen/erEoh</a><br>
  *kode style table: <a href="https://codepen.io/dudleystorey/pen/Geprd">https://codepen.io/dudleystorey/pen/Geprd</a>
</body>
</html>