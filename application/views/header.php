<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="<?php echo base_url(); ?>"><?php echo project; ?></a>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item <?php if ($this->uri->segment(1) == "") {echo 'active';}?>">
        <a class="nav-link" href="<?php echo base_url(); ?>">Home</a>
      </li>
      <li class="nav-item <?php if ($this->uri->segment(1) == "Report") {echo 'active';}?>"">
        <a class="nav-link" href="<?php echo base_url('Report'); ?>">Report</a>
      </li>
    </ul>
  </div>
</nav>