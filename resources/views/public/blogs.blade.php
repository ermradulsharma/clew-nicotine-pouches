@extends('layouts.app')
@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page' => 'blogs'])
    @include('public.parts.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    <div class="homeSlider">
        <div>
            <img src="images/blog-banner.jpg" class="w100 shwoMobile" />
            <img src="images/blog-banner-d.png" class="w100 show-desktop" />
        </div>
    </div>
    
    <div class="blog-container">
        <div class="headingRow">Clew Blog</div>
        <div style="width:90%; margin-left:auto; margin-right:auto;">
            <p class="hdcheck mt30px">Featured Blog</p>
        </div>
        <div class="blog-press-slid mt20px">
            @foreach ($blogPosts as $post)
                <div>
                    <div class="blogBox">
                        <a href="{{ route('blogDetails', $post->post_name) }}">
                            <img src="{{ \Helper::getFeaturedImage($post->ID) }}" />
                            <p class="sbhd">{{ $post->post_title }}</p>
                            <p class="blgcnt">
                                {{ $post->post_excerpt }}...<a href="{{ route('blogDetails', $post->post_name) }}"
                                    title="Read More">Read More</a>
                            </p>
                        </a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <div class="recommendation-container">
        <p class="hdcheck mt30px">Recommended</p>
        <div class="recom-row">
            @foreach ($recPosts as $post)
                <div class="recommend-box">
                    <a href="{{ route('blogDetails', $post->post_name) }}"><img
                            src="{{ \Helper::getFeaturedImage($post->ID) }}" /></a>
                    <div class="remLeft">
                        <p class="hdrem">{{ $post->post_title }}</p>
                        <p class="hdCn">
                            {{ $post->post_excerpt }}...<a href="{{ route('blogDetails', $post->post_name) }}"
                                title="Read More">Read More</a>
                        </p>
                    </div>
                </div>
            @endforeach
            <!-- <div class="recommend-box">
                    <a href="{{ route('blog2') }}"><img src="{{ asset('images/choosing-The-Right-Nicotine-blog.jpg') }}"/></a>
                    <div class="remLeft">
                        <p class="hdrem">How to choose the right Nicotine Pouch Flavor and Strength</p>
                        <p class="hdCn">
                            Our award-winning CLEW Nicotine pouches have become highly
                            popular as a smoke-free, discreet, and versatile alternative
                            to traditional smoking and vaping....<a href="{{ route('blog2') }}" title="Read More">Read More</a>
                        </p>
                    </div>
                </div>
                <div class="recommend-box">
                    <a href="{{ route('blog3') }}"><img src="{{ asset('images/would-Nicotine-Pouches-Suit-Me-blog.jpg') }}"/></a>
                    <div class="remLeft">
                        <p class="hdrem">Would Nicotine Pouches Suit Me</p>
                        <p class="hdCn">
                            Nicotine use has evolved significantly over the years, with new,
                            smoke-free, and more discreet forms of delivery capturing the attention of
                            traditional smokers, vapers, and nicotine replacement seekers alike.....<a href="{{ route('blog3') }}" title="Read More">Read More</a>
                        </p>
                    </div>
                </div> -->
            {{--
            <div class="recommend-box">
                 <img src="images/blog.jpg"/>
                 <div class="remLeft">
                     <p class="hdrem">How to use CLEW?</p>
                     <p class="hdCn">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                     <div class="auname">
                        <span><img src="images/profile-pic.jpg" alt=""> Oliver</span>
                        <span>November 16</span>   
                     </div>  
                  </div>
            </div>
            <div class="recommend-box">
                 <img src="images/blog-2.jpg"/>
                 <div class="remLeft">
                     <p class="hdrem">Best Clew pouches</p>
                     <p class="hdCn">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                     <div class="auname">
                         <span><img src="images/profile-pic.jpg" alt=""> Oliver</span>
                         <span>November 16</span>   
                     </div>  
                  </div>
            </div>
            <div class="recommend-box">
                 <img src="images/blog.jpg"/>
                 <div class="remLeft">
                     <p class="hdrem">How to use CLEW?</p>
                     <p class="hdCn">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                     <div class="auname">
                     <span><img src="images/profile-pic.jpg" alt=""> Oliver</span>
                         <span>November 16</span>   
                     </div>  
                  </div>
            </div>
            <div class="recommend-box">
                 <img src="images/blog-2.jpg"/>
                 <div class="remLeft">
                     <p class="hdrem">How to use CLEW?</p>
                     <p class="hdCn">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                     <div class="auname">
                     <span><img src="images/profile-pic.jpg" alt=""> Oliver</span>
                         <span>November 16</span>   
                     </div>  
                  </div>
            </div>
            --}}
        </div>
    </div>
    @include('layouts.parts.footer')
@endsection
