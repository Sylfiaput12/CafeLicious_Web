<?php
//memanggil file php
include 'config.php';
?>
<?php
$id = $_GET['edit'];
//mengecek tombol edit menu sudah di klik
if (isset($_POST['edit_menu'])) {

    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar']['name'];
    $nama_gambar = $_FILES['gambar']['tmp_name'];
    $folder_gambar = 'uploaded_img/' . $gambar;

    if (empty($nama) || empty($harga) || empty($kategori) || empty($deskripsi) || empty($gambar)) {
        $message[] = 'tolong isi semua kolom';
    } else {

        $update_data = "UPDATE produk SET nama='$nama', harga='$harga', kategori='$kategori', deskripsi='$deskripsi', gambar='$gambar'  WHERE id = '$id'";
        $upload = mysqli_query($conn, $update_data);

        if ($upload) {
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            header('location:tambah_menu.php');
        } else {
            $$message[] = 'Tolong isi kolom semua!';
        }
    }
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<span class="message">' . $message . '</span>';
        }
    }
    ?>

    <div class="container">
        <div class="admin-product-form-container centered">
            <?php
            $select = mysqli_query($conn, "SELECT * FROM produk WHERE id = '$id'");
            while ($row = mysqli_fetch_assoc($select)) {
            ?>

                <form action="" method="post" enctype="multipart/form-data">
                    <h3 class="title">Mengedit Menu</h3>
                    <input type="text" class="box" name="nama" value="<?php echo $row['nama']; ?>" placeholder="Masukkan nama menu">
                    <input type="number" min="0" class="box" name="harga" value="<?php echo $row['harga']; ?>" placeholder="Masukkan harga menu">
                    <select name="kategori" placeholder="Kategori" class="box">
                        <option value="main course">Main Course</option>
                        <option value="drink">Drink</option>
                        <option value="coffe">Coffe</option>
                        <option value="desert">Desert</option>
                    </select class="box">
                    <input type="text" placeholder="Masukan deskripsi menu" name="deskripsi" class="box">
                    <input type="file" class="box" name="gambar" accept="image/png, image/jpeg, image/jpg">
                    <input type="submit" value="edit menu" name="edit_menu" class="btn">
                    <a href="tambah_menu.php" class="btn">kembali</a>
                </form>

            <?php }; ?>
        </div>

    </div>
</body>

</html>