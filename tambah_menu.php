<?php
error_reporting(E_ALL & ~E_NOTICE);
@include 'config.php';


// Prototype object for category
class CategoryPrototype
{
    public $name;

    public function __clone()
    {
    }
}

// Concrete prototype objects for each category
class MainCourseCategory extends CategoryPrototype
{
    public function __construct()
    {
        $this->name = "Main Course";
    }
}

class DrinkCategory extends CategoryPrototype
{
    public function __construct()
    {
        $this->name = "Drink";
    }
}

class CoffeCategory extends CategoryPrototype
{
    public function __construct()
    {
        $this->name = "Coffe";
    }
}

class DesertCategory extends CategoryPrototype
{
    public function __construct()
    {
        $this->name = "Desert";
    }
}

// Client code
if (isset($_POST['tambah_menu'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $kategori_name = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar']['name'];
    $nama_gambar = $_FILES['gambar']['tmp_name'];
    $folder_gambar = 'uploaded_img/' . $gambar;

    if (empty($nama) || empty($harga) || empty($kategori_name) || empty($gambar)) {
        $message[] = 'tolong isi semua kolom';
    } else {
        // Create a new category object from the prototype
        switch ($kategori_name) {
            case 'main course':
                $category_prototype = new MainCourseCategory();
                break;
            case 'drink':
                $category_prototype = new DrinkCategory();
                break;
            case 'coffe':
                $category_prototype = new CoffeCategory();
                break;
            case 'desert':
                $category_prototype = new DesertCategory();
                break;
            default:
                $category_prototype = null;
                break;
        }

        // If category object is created successfully, use it to create new product object
        if ($category_prototype != null) {
            $kategori = clone $category_prototype;
            $insert = "INSERT INTO produk(nama, harga, kategori,deskripsi, gambar) VALUES('$nama', '$harga','$kategori->name', '$deskripsi','$gambar')";
            $upload = mysqli_query($conn, $insert);
            if ($upload) {
                move_uploaded_file($nama_gambar, $folder_gambar);
                $message[] = 'Menu baru berhasil ditambahkan';
            } else {
                $message[] = 'Tidak bisa menambahkan menu baru';
            }
        } else {
            $message[] = 'Kategori tidak valid';
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
    <title>tambah menu</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
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

        <div class="admin-product-form-container">

            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <h3>Menambahkan menu</h3>
                <input type="text" placeholder="Masukan nama menu" name="nama" class="box">
                <input type="number" placeholder="Masukkan harga" name="harga" class="box">
                <select name="kategori" placeholder="Kategori" name="kategori" class="box">
                    <option value="main course">Main Course</option>
                    <option value="drink">Drink</option>
                    <option value="coffe">Coffe</option>
                    <option value="desert">Desert</option>
                </select>
                <input type="text" placeholder="Masukan deskripsi menu" name="deskripsi" class="box">
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="gambar" class="box">
                <input type="submit" class="btn" name="tambah_menu" value="tambah menu">
            </form>

        </div>

        <?php

        $pilih = mysqli_query($conn, "SELECT * FROM produk");

        ?>
        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <th>Gambar Produk</th>
                        <th>Nama Produk</th>
                        <th>Harga Produk</th>
                        <th>Kategori</th>
                        <th>Deskripsi Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <?php while ($row = mysqli_fetch_assoc($pilih)) { ?>
                    <tr>
                        <td><img src="uploaded_img/<?php echo $row['gambar']; ?>" height="100" alt=""></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td>Rp.<?php echo $row['harga']; ?></td>
                        <td><?php echo $row['kategori']; ?></td>
                        <td><?php echo $row['deskripsi']; ?></td>

                        <td>
                            <a href="edit_menu.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
                            <a href="delete.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <br><br>
            <a href="index.php" class="back"> Kembali</a>
        </div>

    </div>


</body>

</html>