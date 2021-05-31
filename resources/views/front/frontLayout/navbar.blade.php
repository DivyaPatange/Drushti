<!-- navigation -->
<div class="navbar-inner">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light p-0">
            <div class="agileits-navi_search">
                <!-- <form action="#" method="post">
                    <select id="agileinfo-nav_search" name="agileinfo_search" class="border" required="">
                        <option value="">ALL CATEGORY</option>
                        <option value="beauty">BEAUTY</option>
                        <option value="agriculture">AGRICULTURE</option>
                        <option value="personal">PERSONAL</option>
                        <option value="health">HEALTH</option>
                    </select>
                </form> -->
                <a href="{{ url('/') }}">
                    <img src="{{ asset ('asset/images/mcp123.png')}}" alt=" " class="" style="width: 100px;
                        height: 100px;"><span style="font-size: 30px;
                        color:#0879c9;font-weight: 900;font-family: fangsong;" class="text-uppercase">Market Career Power</span>
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto text-center mr-xl-5">
                    <li class="nav-item active mr-lg-2 mb-lg-0 mb-2">
                        <a class="nav-link" href="{{ url('/') }}">Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item mr-lg-2 mb-lg-0 mb-2">
                        <a class="nav-link" href="{{ url('product') }}">Our Product</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('contact') }}">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('document')}}">Legal Documents</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('plan')}}">Plan</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- //navigation -->