<nav class="navbar sticky-top navbar-expand-md navbar-light bg-light">
    <a class="navbar-brand" href="index.php">
        <img src="image/400.png" width="40" height="40">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <form method="POST" action="search1.php" class="d-flex">
        <div class="input-group">
            <input class="form-control me-2" type="search" name="query" id="query" placeholder="<?= __('Search')?>" aria-label="<?= __('Search')?>">
        </div>
    </form>
            <div class="collapse navbar-collapse justify-content-right" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto mr-1">
                <li class="nav-item px-3">
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="https://github.com/CGUltimateno/FCAIH-QAW">
                        <i class="fa fa-github fa-2x" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="users-view.php">
                        <i class="fa fa-users fa-2x" aria-hidden="true"></i>
                    </a>
                </li>
                  <li class="nav-item dropdown px-3">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cog fa-2x" aria-hidden="true"></i>
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="profile.php"><?= __('My Profile')?></a>
                          <a class="dropdown-item" href="edit.php"><?= __('Edit Profile')?></a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="users-view.php"><?= __('Find People')?></a>
                          <a class="dropdown-item" href="contact.php"><?= __('Contact us')?></a>
                      </div>
                  </li>
                  <li class="nav-item dropdown px-3">
                      <a class="nav-link dropdown-toggle languageDropdown" href="#" id="languageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-globe fa-2x" aria-hidden="true"></i>
                      </a>
                      <div class="dropdown-menu" aria-labelledby="languageDropdown">
                          <a class="dropdown-item" href="index.php?lang=en">English</a>
                          <a class="dropdown-item" href="index.php?lang=ar">العربية</a>
                      </div>
                  </li>
                <li class="nav-item px-3">
                  <a class="nav-link" href="inc/logout.inc.php">
                      <i class="fa fa-sign-out fa-2x" aria-hidden="true"></i>
                  </a>
                </li>
              </ul>
            </div>
        </nav>
        
     

