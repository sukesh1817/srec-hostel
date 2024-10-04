<nav class="navbar navbar-expand-md bg-dark sticky-top border-bottom py-4" data-bs-theme="dark">

  <div class="container" bis_skin_checked="1">
    <div class="d-flex justify-content-start me-5">
      <a class="navbar-brand justify-content-start fs-4 text-white fw-medium" href="/">
      <small>Women Admin</small> 
      </a>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas"
      aria-controls="offcanvas" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel"
      bis_skin_checked="1">
      <div class="offcanvas-header" bis_skin_checked="1">
        <h5 class="offcanvas-title" id="offcanvasLabel">Women Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body" bis_skin_checked="1">
        <ul class="navbar-nav flex-grow-1 justify-content-between">
          <li class="nav-item"><a
              class="nav-link <?php if (str_contains($_SERVER['REQUEST_URI'], "stud-details")) {
                echo "active";
              } ?>"
              href="/stud-details/">Student records</a></li>
          <li class="nav-item"><a
              class="nav-link <?php if (str_contains($_SERVER['REQUEST_URI'], "token-records")) {
                echo "active";
              } ?>"
              href="/token-records/">Token records</a></li>
          <li class="nav-item"><a
              class="nav-link <?php if (str_contains($_SERVER['REQUEST_URI'], "accommodation")) {
                echo "active";
              } ?>"
              href="/accommodation/">Accommodation</a></li>
          <li class="nav-item"><a
              class="nav-link <?php if (str_contains($_SERVER['REQUEST_URI'], "complaint")) {
                echo "active";
              } ?>"
              href="/complaint/">Complaints</a></li>
          <li class="nav-item"><a
              class="nav-link <?php if (str_contains($_SERVER['REQUEST_URI'], "gate-pass")) {
                echo "active";
              } ?>"
              href="/gate-pass/">Gate pass</a></li>
          <li class="nav-item"><a class="btn btn-outline-light rounded-1" href="/logout">Logout</a></li>

        </ul>
      </div>
    </div>
  </div>
</nav>