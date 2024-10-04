<?php
function bread_crumb_gatepass($current_page)
{
  ?>
  <nav aria-label="breadcrumb" class="m-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <li class="breadcrumb-item"><a href="/gate-pass/">Gate pass</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $current_page ?></li>
    </ol>
  </nav>
  <?php
}
?>