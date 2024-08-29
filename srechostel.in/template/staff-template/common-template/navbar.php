<nav class="navbar navbar-expand-md bg-dark sticky-top border-bottom py-4" data-bs-theme="dark" >
    <div class="container" bis_skin_checked="1">
      <a class="navbar-brand d-md-none" href="/staff-panel/">
        Home
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas"
        aria-controls="offcanvas" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel"
        bis_skin_checked="1">
        <div class="offcanvas-header" bis_skin_checked="1">
          <h5 class="offcanvas-title" id="offcanvasLabel"><?php echo $_SESSION['name']; ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" bis_skin_checked="1">
          <ul class="navbar-nav flex-grow-1 justify-content-between">
            <li class="nav-item"><a class="nav-link <?php if(str_contains($_SERVER['REQUEST_URI'],"accommodation")){echo "active";} ?>" href="/staff-panel/accommodation/">Accomodation</a></li>
            <li class="nav-item"><a class="nav-link <?php if(str_contains($_SERVER['REQUEST_URI'],"food-booking")){echo "active";} ?>" href="/staff-panel/food-booking/">Food booking</a></li>
            <li class="nav-item"><a class="nav-link <?php if(str_contains($_SERVER['REQUEST_URI'],"order-status")){echo "active";} ?>" href="/staff-panel/order-status/">Order status</a></li>
            <li class="nav-item"><a class="nav-link <?php if(str_contains($_SERVER['REQUEST_URI'],"staff-panel/bill-info/")   ){echo "active";} ?>" href="/staff-panel/bill-info/">Bill Info</a></li>
           
            <li class="nav-item"><a class="nav-link <?php if(str_contains($_SERVER['REQUEST_URI'],"profile")){echo "active";} ?>" href="/staff-panel/profile/">Profile</a></li>

          </ul>
        </div>
      </div>
    </div>
  </nav>