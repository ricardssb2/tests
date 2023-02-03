@include ('layouts/app')


    <div class="container first-cont">
        <div class="row">
            <div class="col-lg-6">
                <div class="block-text">
                    <div class="text-left">
                        <p>is simply dummy text of the printing<br>
                            and typesetting industry. Lorem Ipsum<br>
                            has been the industry's standard,<br></p>
                    </div>
                    <div class="btn-text">
                        <a href="{{ route('login') }}"type="button" class="btn btn-light">Get Started</a>
                    </div>
                </div> 
            </div>
            <div class="col-lg-6">
                <div class="right-photo">
                    <img src="{{url('/images/mainphoto.png')}}" alt="Man at a pc with a black hoodie.">
                </div>
            </div>
        </div>
    </div>

    <div class="container second-cont">
        <div class="row">
            <div class="col-lg-4">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-building-gear" viewBox="0 0 16 16">
                    <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6.5a.5.5 0 0 1-1 0V1H3v14h3v-2.5a.5.5 0 0 1 .5-.5H8v4H3a1 1 0 0 1-1-1V1Z"/>
                    <path d="M4.5 2a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm-6 3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm-6 3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm4.386 1.46c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z"/>
                    </svg>
                </div>
                <div class="header">
                    <p>Loreum Ipsum</p>
                </div>
                <div class="under-text">
                 <p>
                    Lorem Ipsum is simply dummy text of the
                    printing and typesetting industry. Lorem 
                    Ipsum has been the industry's standard dum
                    my text ever since the 1500s, when an unknown
                     printer took a galley of type and scrambled it 
                     to make a type specimen book. It has survived n
                     ot only five centuries, but also the leap into 
                     electronic typesetting, remaining essentially
                      unchanged.
                 </p>
                </div>
            </div>
            <div class="col-lg-4">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-square" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z"/>
                </svg>
            </div>
                <div class="header">
                    <p>Loreum Ipsum</p>
                </div>
                <div class="under-text">
                    <p>
                    Lorem Ipsum is simply dummy text of the
                    printing and typesetting industry. Lorem 
                    Ipsum has been the industry's standard dum
                    my text ever since the 1500s, when an unknown
                     printer took a galley of type and scrambled it 
                     to make a type specimen book. It has survived n
                     ot only five centuries, but also the leap into 
                     electronic typesetting, remaining essentially
                      unchanged.
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
            <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                    </svg>
            </div>
            <div class="header">
                <p>Loreum Ipsum</p>
            </div>
                <div class="under-text">
                    <p>
                    Lorem Ipsum is simply dummy text of the
                    printing and typesetting industry. Lorem 
                    Ipsum has been the industry's standard dum
                    my text ever since the 1500s, when an unknown
                     printer took a galley of type and scrambled it 
                     to make a type specimen book. It has survived n
                     ot only five centuries, but also the leap into 
                     electronic typesetting, remaining essentially
                      unchanged.
                    </p>
                </div>
            </div>
        </div>
    </div>


    <div class="container third-cont">
        <div class="row">
            <div class="col-lg-6">
                <div class="third-header">
                    <h1>What can you use it for ?</h1>
                </div>
                <div class="third-under-text">
                    <p>
                    Lorem Ipsum is simply dummy text of the
                    printing and typesetting industry. Lorem 
                    Ipsum has been the industry's standard dum
                    my text ever since the 1500s, when an unknown
                     printer took a galley of type and scrambled it 
                     to make a type specimen book. It has survived n
                     ot only five centuries, but also the leap into 
                     electronic typesetting, remaining essentially
                      unchanged.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="third-photo">
                    <img src="{{url('/images/thirdphoto.png')}}" alt="">
                </div>
            </div>
        </div>
    </div>


@extends ('layouts/footer')