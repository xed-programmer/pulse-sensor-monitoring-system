@extends('layouts.app')

@section('header')
<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">
  <div class="container" data-aos="zoom-out" data-aos-delay="100">
    <h1>Blood Oxygen Level <br><span>Monitoring System</span></h1>
    <div class="d-flex">
      <a href="#about" class="btn-get-started scrollto">Get Started</a>
    </div>
  </div>
</section><!-- End Hero -->
@endsection

@section('content')
<!-- ======= Featured Services Section ======= -->
<section id="featured-services" class="featured-services">
  <div class="container" data-aos="fade-up">

    <div class="row">

      <div class="col-md-6 col-lg-3 offset-md-3 d-flex align-items-stretch mb-5 mb-lg-0">
        <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
          <div class="icon"><i class="bx bx-tachometer"></i></div>
          <h4 class="title"><a href="">Pulse Rate Sensor</a></h4>
          <p class="description">
            Utilize a pulse sensor device that measures SpO2 levels.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
        <div class="icon-box" data-aos="fade-up" data-aos-delay="400">
          <div class="icon"><i class="bx bx-world"></i></div>
          <h4 class="title"><a href="">Access Through Internet</a></h4>
          <p class="description">
            capable of simultaneously monitoring the SpO2 levels of patients accessible remotely without human
            intervention
          </p>
        </div>
      </div>

    </div>

  </div>
</section><!-- End Featured Services Section -->

<!-- ======= About Section ======= -->
<section id="about" class="about section-bg">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>About</h2>
      <h3>Find Out More <span>About Us</span></h3>
      <p>Monitor oxygen saturation levels, and readily identify patients
        in need of support.</p>
    </div>

    <div class="row">
      <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
        <img src="{{ asset('BizLand/assets/img/pulse-oximeter.jpg') }}" class="img-fluid" alt="">
      </div>
      <div class="col-lg-6 pt-4 pt-lg-0 content d-flex flex-column justify-content-center" data-aos="fade-up"
        data-aos-delay="100">
        <h3>BOOM Dev</h3>
        <p>
          Blood Oxygen Online Monitoring Device or in short
          ‘BOOM Dev’. BOOM Dev is connected to a network that displays the status of each client
          device as well as alerting the medical staff or concerned personnel who are monitoring
          the status of the patient and will send an alert notification remotely on the internet if
          SpO2 levels are detected below the threshold.
        </p>
      </div>
    </div>

  </div>
</section><!-- End About Section -->

<!-- ======= Contact Section ======= -->
<section id="contact" class="contact">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>Contact</h2>
      <h3><span>Contact Us</span></h3>
      <p>If you want to know something, contact us.</p>
    </div>

    <div class="row" data-aos="fade-up" data-aos-delay="100">
      <div class="col-lg-6">
        <div class="info-box mb-4">
          <i class="bx bx-map"></i>
          <h3>Our Address</h3>
          <p>Mabalacat, Pampanga, Brgy. Dolores multipurpose hall</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="info-box  mb-4">
          <i class="bx bx-envelope"></i>
          <h3>Email Us</h3>
          <p>Aeb201533000@gmail.com</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="info-box  mb-4">
          <i class="bx bx-phone-call"></i>
          <h3>Call Us</h3>
          <p>09206890801</p>
        </div>
      </div>

    </div>

    <div class="row" data-aos="fade-up" data-aos-delay="100">

      <div class="col-lg-12">
        <form action="#" method="post" role="form" class="php-email-form">
          <div class="row">
            <div class="col form-group">
              <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
            </div>
            <div class="col form-group">
              <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
            </div>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
          </div>
          <div class="form-group">
            <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
          </div>
          <div class="my-3">
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your message has been sent. Thank you!</div>
          </div>
          <div class="text-center"><button type="submit">Send Message</button></div>
        </form>
      </div>

    </div>

  </div>
</section><!-- End Contact Section -->
@endsection