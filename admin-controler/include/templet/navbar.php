<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashbord.php">Home</a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
         <li ><a href="members.php">Members</a></li>
        <li><a href="craftsmen.php">Craftsmen</a></li>
        <li><a href="craftsmeninfo.php">Craftsmen Info</a></li>
          <li ><a href="maps.php">maps</a></li>
        <li ><a href="Categories.php">Show Categories</a></li>
     
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown ">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <?php echo $_SESSION['adminname'];?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li>
              <a href="../index.php" target="_blank"><i class="fas fa-warehouse"></i>Visit craftsmen</a></li>
            <li><a href="editprofile.php?do=Edit&adminid=<?php echo $_SESSION['id'];?>">
            <i class="fas fa-user-edit"></i>Edit Profile</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>