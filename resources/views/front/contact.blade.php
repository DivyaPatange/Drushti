@extends('front.frontLayout.main')
@section('customecss')
@endsection
@section('content')
<!-- banner-2 -->
<div class="page-head_agile_info_w3l">

</div>
<!-- page -->
<div class="services-breadcrumb">
    <div class="agile_inner_breadcrumb">
        <div class="container">
            <ul class="w3_short">
                <li>
                    <a href="index">Home</a>
                    <i>|</i>
                </li>
                <li>Contact Us</li>
            </ul>
        </div>
    </div>
</div>
<!-- //page -->

<!-- contact -->
<div class="contact py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">
        <!-- tittle heading -->
        <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
            <span>C</span>ontact
            <span>U</span>s
        </h3>
        <!-- //tittle heading -->
        <div class="row contact-grids agile-1 mb-5">
            <div class="col-sm-4 contact-grid agileinfo-6 mt-sm-0 mt-2">
                <div class="contact-grid1 text-center">
                    <div class="con-ic">
                        <i class="fas fa-map-marker-alt rounded-circle"></i>
                    </div>
                    <h4 class="font-weight-bold mt-sm-4 mt-3 mb-3">Address</h4>
                    <p>Plot No: - 47 old kanpthi road,balaji nagar, near yashvant school,Dr.Ambedkar marg, Nagpur, Maharashtra - 440017.
                    </p>
                </div>
            </div>
            <div class="col-sm-4 contact-grid agileinfo-6 my-sm-0 my-4">
                <div class="contact-grid1 text-center">
                    <div class="con-ic">
                        <i class="fas fa-phone rounded-circle"></i>
                    </div>
                    <h4 class="font-weight-bold mt-sm-4 mt-3 mb-3">Call Us</h4>
                    <p>9372493313
                    </p>
                </div>
            </div>
            <div class="col-sm-4 contact-grid agileinfo-6">
                <div class="contact-grid1 text-center">
                    <div class="con-ic">
                        <i class="fas fa-envelope-open rounded-circle"></i>
                    </div>
                    <h4 class="font-weight-bold mt-sm-4 mt-3 mb-3">Email</h4>
                    <p>
                        <label>
                            <a href="info@marketdrushti.com">info@marketcareerpower.com</a>
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <!-- form -->
        <form action="#" method="post">
            <div class="contact-grids1 w3agile-6">
                <div class="row">
                    <div class="col-md-6 col-sm-6 contact-form1 form-group">
                        <label class="col-form-label">Name</label>
                        <input type="text" class="form-control" name="Name" placeholder="" required="">
                    </div>
                    <div class="col-md-6 col-sm-6 contact-form1 form-group">
                        <label class="col-form-label">E-mail</label>
                        <input type="email" class="form-control" name="Email" placeholder="" required="">
                    </div>
                </div>
                <div class="contact-me animated wow slideInUp form-group">
                    <label class="col-form-label">Message</label>
                    <textarea name="Message" class="form-control" placeholder="" required=""> </textarea>
                </div>
                <div class="contact-form">
                    <input type="submit" value="Submit">
                </div>
            </div>
        </form>
        <!-- //form -->
    </div>
</div>
<!-- //contact -->

<!-- map -->
<div class="map mt-sm-0 mt-4">
    <div class="container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d29760.016083735798!2d79.08976458322437!3d21.192079093809834!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sPlot%20No%3A%20-%2047%20old%20kanpthi%20road%2Cbalaji%20nagar%2C%20near%20yashvant%20school%2CDr.Ambedkar%20marg%2C%20Nagpur%2C%20Maharashtra%20-%20440017.!5e0!3m2!1sen!2sin!4v1619254623007!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</div>
<!-- //map -->
 @endsection
 @section('customjs')
 @endsection