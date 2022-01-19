@if(session('user'))
<footer class="footer  py-4">
        <div class="container">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-12 col-md-12 my-auto">
              <div class="copyright text-center text-sm text-lg-center">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart" aria-hidden="true"></i> by
                <a href="" class="font-weight-bold text-red" target="_blank">Appscioto Tech Pvt. Ltd.</a>
              </div>
            </div>
          </div>
        </div>
</footer>
@else
<footer class="footer position-absolute bottom-2 py-2 w-100">
        <div class="container">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-12 col-md-12 my-auto">
              <div class="copyright text-center text-sm text-white text-lg-center">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart" aria-hidden="true"></i> by
                <a href="" class="font-weight-bold text-white" target="_blank">Appscioto Tech Pvt. Ltd.</a>
              </div>
            </div>
          </div>
        </div>
</footer>
@endif
