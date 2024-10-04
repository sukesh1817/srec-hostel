<nav class="navbar navbar-expand-md bg-dark sticky-top border-bottom py-4 nav-noti" data-bs-theme="dark">
  <div class="container" bis_skin_checked="1">
    <div class="d-flex justify-content-start me-5">
      <a class="navbar-brand justify-content-start fs-4 text-white fw-medium" href="/">
        Home
      </a>
    </div>

    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas"
      aria-controls="offcanvas" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel"
      bis_skin_checked="1">
      <div class="offcanvas-header" bis_skin_checked="1">
        <h5 class="offcanvas-title" id="offcanvasLabel">Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body" bis_skin_checked="1">

        <ul class="navbar-nav flex-grow-1 justify-content-between ms-3 me-3">

          <li class="nav-item me-1"><a
              class="nav-link <?php if (str_contains($_SERVER['REQUEST_URI'], "token")) {
                echo "active";
              } ?>"
              href="/token/">Token</a></li>
          <li class="nav-item me-1"><a
              class="nav-link <?php if (str_contains($_SERVER['REQUEST_URI'], "gate-pass")) {
                echo "active";
              } ?>"
              href="/gate-pass/">Gate pass</a></li>
          <li class="nav-item me-1"><a
              class="nav-link <?php if (str_contains($_SERVER['REQUEST_URI'], "committees")) {
                echo "active";
              } ?>"
              href="/committees/">Committee</a></li>
          <li class="nav-item me-1"><a
              class="nav-link <?php if (str_contains($_SERVER['REQUEST_URI'], "complaint")) {
                echo "active";
              } ?>"
              href="/complaint/">Complaint</a></li>
          <!--<li class="nav-item"><a class="nav-link <?php if (str_contains($_SERVER['REQUEST_URI'], "notifications")) {
            echo "active";
          } ?>" href="/stud-panel/notifications/">Notifications</a></li>-->
          <li class="nav-item me-1"><a
              class="nav-link <?php if (str_contains($_SERVER['REQUEST_URI'], "profile")) {
                echo "active";
              } ?>"
              href="/profile/">Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="#">
              <svg class="bi" width="24" height="24">
                <use xlink:href="#cart"></use>
              </svg>
            </a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>