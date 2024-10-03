<!-- header.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand font-weight-bold" href="index.php">Blog Culture</a> <!-- Brand name in bold -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <div class="collapse navbar-collapse" id="navbarNav">
    <!-- Left side items (Bold) -->
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link font-weight-bold" href="index.php">Home</a> <!-- Bold -->
      </li>
      <li class="nav-item">
        <a class="nav-link font-weight-bold" href="#all-articles">Explore</a> <!-- Connect to All Articles -->
      </li>
    </ul>
    
    <!-- Right side items (Sign-Up & Login) -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link btn btn-primary text-white mx-2 font-weight-bold" href="register.php">Sign-Up</a> <!-- Sign-Up button styled and moved right -->
      </li>
      <li class="nav-item">
        <a class="nav-link btn btn-outline-primary mx-2 font-weight-bold" href="login.php">Login</a> <!-- Login button styled and moved right -->
      </li>
    </ul>
  </div>
</nav>

<style>
  .btn-primary {
    background-color: #007bff; /* Customize the background color */
    border-color: #007bff;
  }

  .btn-outline-primary {
    border-color: #007bff;
    color: #007bff;
  }

  .btn:hover {
    background-color: #0056b3; /* Darker blue on hover */
  }

  .nav-link {
    font-weight: bold; /* Bold text for left side items */
  }

  .navbar-brand {
    font-size: 1.5rem; /* Increase brand font size */
  }
</style>
