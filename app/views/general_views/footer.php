<style>
    .fixed-footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        z-index: 1030; 
    }
    @media (max-width: 768px) {
        .fixed-footer {
            position: static;
        }
    }
</style>

<footer class="bg-dark text-white pt-4 pb-4 fixed-footer">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-6 col-lg-3 mb-4">
        <img src="/../img/logo.png" alt="Logo" width="52" height="52">
      </div>

      <div class="col-12 col-md-6 col-lg-3 mb-4">
        <h6>Contact us</h6>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><a href="tel:065456728" class="text-light">065456728</a></li>
          <li><a href="mailto:admin@haarlem.nl" class="text-light">admin@haarlem.nl</a></li>
        </ul>
      </div>

      <div class="col-12 col-md-6 col-lg-3 mb-4">
        <h6>Follow us on</h6>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><a href="#" class="text-light">Visit Haarlem</a></li>
          <li><a href="#" class="text-light">@visithaarlem</a></li>
        </ul>
      </div>

      <div class="col-12 col-md-6 col-lg-3">
        <h6>Cookies</h6>
        <ul class="list-unstyled mb-0">
          <li><a href="#" class="text-light">Functional cookies</a></li>
        </ul>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</footer>
