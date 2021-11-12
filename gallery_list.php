<!DOCTYPE html>
<html lang="en">
<head>
  <title>Photosen &mdash;</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;700&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">

  <link rel="stylesheet" href="css/lightgallery.min.css">    

  <link rel="stylesheet" href="css/bootstrap-datepicker.css">

  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

  <link rel="stylesheet" href="css/swiper.css">

  <link rel="stylesheet" href="css/aos.css">

  <link rel="stylesheet" href="css/style.css">
  <style type="text/css">
    img {
    -webkit-filter: none;
}
  </style>
</head>
<body>
  <div class="site-wrap">
    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    <header class="site-navbar py-3" role="banner">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-6 col-xl-2" data-aos="fade-down">
            <nav class="site-navigation position-relative text-right text-lg-center" role="navigation">
              <br><br><br>
            </nav>
          </div>
          <div class="col-10 col-md-8 d-none d-xl-block" data-aos="fade-down">
            <center><h1 class="mb-0"><a href="index.php" class="text-white h2 mb-0"><img src="images/logo-qoobah.png" alt="Image" class="img-fluid w20"style="-webkit-filter: none;" height="200" width="200"></a></h1>
            </center>
            <div class="row justify-content-center">
              <div class="col-md-7">
                <div class="row mb-5">
                  <div class="col-12 ">
                    <h2 class="site-section-heading text-center v" style="text-transform:uppercase;color: black">Pulau <?php echo $_GET['island']; ?></h2>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-xl-2 text-right" data-aos="fade-down">
            <div class="d-none d-xl-inline-block">
              <ul class="site-menu js-clone-nav ml-auto list-unstyled d-flex text-right mb-0" data-class="social">
                <li>
                  <a href="https://www.facebook.com/qoobah.ofc" class="pl-0 pr-3" target="_blank" rel="noopener noreferrer"><span class="icon-facebook"></span></a>
                </li>
                <li>
                  <a href="https://www.instagram.com/qoobahofficial/" class="pl-3 pr-3" target="_blank" rel="noopener noreferrer"><span class="icon-instagram"></span></a>
                </li>
                <li>
                  <a href="https://www.youtube.com/channel/UCMzLGdh7-e-JxH-G9HTcpug" class="pl-3 pr-3" target="_blank" rel="noopener noreferrer"><span class="icon-youtube-play"></span></a>
                </li>
                <li>
                  <a href="http://qoobah.co.id/" class="pl-3 pr-3" target="_blank" rel="noopener noreferrer"><span class="icon-globe"></span></a>
                </li>
              </ul>
            </div>

            <div class="d-inline-block d-xl-none ml-md-0 mr-auto py-3" style="position: relative; top: 3px;"><a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>
          </div>
        </div>
      </div>
      
    </header>

    <div class=""  data-aos="fade">
      <div class="container-fluid">

        
        <div class="row" id="lightgallery">
          <?php
              require_once('admin/function/pagedresults.php');
              include( 'admin/config.php' );
              global $dbLink;
              $q = "SELECT * from gallery WHERE location like '%".$_GET['island']."%'";
              $rs = new MySQLPagedResultSet($q, 30, $dbLink);
              while ($query_data = $rs->fetchArray()) {
                if (file_exists('admin/uploads/'.$query_data['img'])) {
                  echo '<div class="col-lg-4 col-md-12 item" data-aos="fade" data-src="admin/uploads/'.$query_data['img'].'" data-sub-html="<h2>'.$query_data['title'].'</h2><p>'.$query_data['caption'].'</p>" style="padding: 4px;">
                  <a href="#"><img src="admin/uploads/'.$query_data['img'].'" alt="IMage" class="img-fluid" onerror="this.onerror=null; this.remove();"></a>
                  </div>';

                }
              }
          ?>
        </div>
      </div>
    </div>

    <div class="footer py-4">
      <div class="container-fluid text-center">
        <p>
          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          Copyright &copy;<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        </p>
      </div>
    </div>
    
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/swiper.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/picturefill.min.js"></script>
  <script src="js/lightgallery-all.min.js"></script>
  <script src="js/jquery.mousewheel.min.js"></script>
  <script src="js/main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.0/masonry.pkgd.min.js" type="text/javascript"></script>
  <script>
    $(document).ready(function(){
      $('#lightgallery').lightGallery();

      var $container = $('#lightgallery').masonry();
      $container.imagesLoaded( function() {
        $container.masonry(
        { 
          "columnWidth": ".grid-sizer", 
          "itemSelector": ".item", 
          "gutter":10
        });
      });

    });
  </script>

</body>
</html>