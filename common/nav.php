<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="navbar navbar-default"">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" 
             role="button" aria-haspopup="true" aria-expanded="false">
             Cursillo Management <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php makeLink('cursillo/add.php') ?>">Create Cursillo</a></li>
            <li><a href="<?php makeLink('cursillo/list.php') ?>">Cursillo List</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?php makeLink('parish/list.php') ?>">Parish List</a></li>
            <li><a href="<?php makeLink('parish/add.php') ?>">Create Parish</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" 
             role="button" aria-haspopup="true" aria-expanded="false">
             Individual Management <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php makeLink('individual/add.php') ?>">Create Candidate</a></li>
            <li><a href="<?php makeLink('individual/list.php') ?>">Individual List</a></li>
            <li><a href="#"></a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" 
             role="button" aria-haspopup="true" aria-expanded="false">
             Team Management <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="#">Role List</a></li>
            <li><a href="<?php makeLink('role/add.php') ?>">Create Role</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Team History</a></li>
            <li><a href="#">Build a Team</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Talk Topics</a></li>
            <li><a href="#">Create a Topic</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" 
             role="button" aria-haspopup="true" aria-expanded="false">
             Dropdown <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>