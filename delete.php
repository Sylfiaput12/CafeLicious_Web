<?php
error_reporting(E_ALL & ~E_NOTICE);
include "config.php";

$id = $_GET['delete'];

$select = mysqli_query($conn, "DELETE FROM produk WHERE id = $id") or die(mysqli_error($conn));

if ($select) {
    echo "<script>alert ('Data dihapus')</script>";
} else {
    echo "<script>alert ('Data gagal dihapus')</script>";
}

echo "<script>window.location.href='tambah_menu.php'</script>";
