<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafelicious</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css2/style.css">

</head>

<body>

    <!-- header section starts     -->
    <header class="header fixed-top">
        <div class="container">
            <div class="row align-items-center">
                <a href="#" class="logo mr-auto"> <i class="fas fa-mug-hot"></i> cafelicious </a>

                <nav class="nav">
                    <a href="#home">Home</a>
                    <a href="#menu">Menu</a>
                    <a href="tambah_menu.php">Tambah Menu</a>
                </nav>

            </div>

        </div>
    </header>


    <!-- home section starts  -->

    <section class="home" id="home">
        <div class="container">
            <div class="row align-items-center text-center text-md-left min-vh-100">
                <div class="col-md-6">
                    <span>cafe house</span>
                    <h3>Selamat datang di cafelicious</h3>
                </div>
            </div>
        </div>
    </section>



    <!-- menu section starts  -->
    <section class="menu" id="menu">
        <h1 class="heading"> Menu </h1>
        <div class="container box-container">
            <form action="" method="post">
                <div class="form-group">
                    <label for="kategori">Pilih Kategori:</label>
                    <select class="form-control" id="kategori" name="kategori">
                        <option value="semua">Semua Kategori</option>
                        <option value="main course">Main Course</option>
                        <option value="drink">Drink</option>
                        <option value="coffe">Coffe</option>
                        <option value="desert">Desert</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form><br>
            <?php
            include 'config.php';
            if (isset($_POST['kategori']) && $_POST['kategori'] != 'semua') {
                $kategori = $_POST['kategori'];
                $select = mysqli_query($conn, "SELECT * FROM `produk` WHERE `kategori` = '$kategori'");
            } else {
                $select = mysqli_query($conn, "SELECT * FROM `produk`");
            }
            if (mysqli_num_rows($select) > 0) {
                while ($menu = mysqli_fetch_assoc($select)) {
            ?>
                    <form action="" method="post">
                        <div class="box">
                            <img src="uploaded_img/<?php echo $menu['gambar']; ?>" alt="">
                            <h3><?php echo $menu['nama']; ?></h3>
                            <div class="price">Rp.<?php echo $menu['harga']; ?></div>
                            <h4><?php echo $menu['deskripsi']; ?></h4>
                            <input type="hidden" name="nama" value="<?php echo $fetch_product['nama']; ?>">
                            <input type="hidden" name="harga" value="<?php echo $menu['harga']; ?>">
                            <input type="hidden" name="deskripsi" value="<?php echo $menu['deskripsi']; ?>">
                            <input type="hidden" name="gambar" value="<?php echo $menu['gambar']; ?>">
                        </div>
                    </form>

            <?php
                };
            };
            ?>
        </div>
    </section>


    <!-- menu section ends -->

    <!-- footer  -->

    <section class="footer container">
        <a href="#" class="logo"> <i class="fas fa-mug-hot"></i> Cafelicious </a>
    </section>

    <!-- footer section ends -->

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>