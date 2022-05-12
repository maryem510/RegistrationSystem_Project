<?php
if (!isset($_SESSION['auth'])) {
  header("location:login.php");
  die();
}
include 'inc/header.php' ?>
<?php include 'inc/nav.php' ?>

<div class="container">
  <div class="row">
    <div class="col-8 mx-auto my-5 border p-2">

      <?php if (isset($_SESSION['auth'])) : ?>

        <h2 class="border my-2 bg-success p-2">Name: <?php echo $_SESSION['auth']['name']; ?> </h2>
        <h2 class="border my-2 bg-primary p-2 ">Email: <?php echo $_SESSION['auth']['email']; ?> </h2>
      <?php endif; ?>

      <?php include 'inc/footer.php' ?>