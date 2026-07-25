{{-- @extends('layouts.app')
@section('title', $page->meta_title ?: $page->title)
@push('css')
    <style>
        /* ============ HERO ============ */
        .pageHero{
            position: relative;
            height: 46vh;
            min-height: 380px;
            overflow: hidden;
        }

        .pageHero::before{
            content:'';
            position:absolute;
            inset:0;
            background:linear-gradient(90deg,
                rgba(2,12,27,.90) 0%,
                rgba(4,32,66,.72) 45%,
                rgba(7,66,115,.32) 100%);
            z-index:1;
        }

        .pageHero img{
            width:100%;
            height:100%;
            object-fit:cover;
            animation:heroZoom 10s ease forwards;
        }

        @keyframes heroZoom{
            from{transform:scale(1);}
            to{transform:scale(1.06);}
        }

        .heroContent{
            position:relative;
            z-index:10;
        }

        .heroTagline{
            font-family: Georgia, 'Times New Roman', serif;
            font-style: italic;
            color:#7dd3fc;
        }

        .breadcrumb a{ transition:.3s; }
        .breadcrumb a:hover{ color:#60a5fa; }

        /* ============ HERO STAT STRIP (overlaps hero bottom) ============ */
        .heroStats{
            margin-top:-42px;
            position:relative;
            z-index:40;
        }

        .heroStatBar{
            background:#fff;
            border-radius:20px;
            box-shadow:0 25px 55px rgba(15,23,42,.14);
            display:grid;
        }

        .heroStatItem{
            display:flex;
            align-items:center;
            gap:14px;
            padding:22px 20px;
        }

        .heroStatItem + .heroStatItem{
            border-left:1px solid #eef2f7;
        }

        .heroStatIcon{
            width:46px;
            height:46px;
            min-width:46px;
            border-radius:14px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:20px;
        }

        /* ============ WHO WE ARE ============ */
        .checkItem{
            display:flex;
            gap:14px;
            align-items:flex-start;
        }

        .checkIcon{
            width:38px;
            height:38px;
            min-width:38px;
            border-radius:11px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:16px;
        }

        .aboutImgWrap{
            position:relative;
            border-radius:24px;
            overflow:hidden;
            box-shadow:0 25px 55px rgba(15,23,42,.12);
        }

        .aboutImgWrap img{
            width:100%;
            height:340px;
            object-fit:cover;
        }

        .overviewCard{
            background:#fff;
            border-radius:20px;
            box-shadow:0 20px 45px rgba(15,23,42,.10);
            overflow:hidden;
            border:1px solid #eef2f7;
        }

        .overviewHeader{
            background:linear-gradient(90deg,#2563eb,#06b6d4);
            padding:14px 18px;
            color:#fff;
            font-weight:800;
            font-size:.82rem;
            letter-spacing:.02em;
            display:flex;
            align-items:center;
            gap:8px;
        }

        .overviewRow{
            display:flex;
            justify-content:space-between;
            padding:11px 18px;
            font-size:.85rem;
        }

        .overviewRow + .overviewRow{
            border-top:1px solid #f1f5f9;
        }

        .ctaMini{
            border-radius:20px;
            background:linear-gradient(135deg,#2563eb,#06b6d4);
            color:#fff;
            padding:20px;
            position:relative;
            overflow:hidden;
        }

        .ctaMini::before{
            content:'';
            position:absolute;
            right:-30px;
            top:-30px;
            width:100px;
            height:100px;
            border-radius:50%;
            background:rgba(255,255,255,.10);
        }

        /* ============ SECONDARY STATS BAR ============ */
        .statsBar{
            background:#fff;
            border-radius:22px;
            box-shadow:0 18px 45px rgba(15,23,42,.07);
            border:1px solid #eef2f7;
        }

        .statsBarItem{
            display:flex;
            align-items:center;
            gap:14px;
            padding:26px 22px;
        }

        .statsBarIcon{
            width:52px;
            height:52px;
            min-width:52px;
            border-radius:14px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:22px;
        }

        /* ============ PRIORITY GRID (6 compact cards) ============ */
        .priorityCard{
            background:#fff;
            border:1px solid #eef2f7;
            border-radius:18px;
            padding:22px 18px;
            transition:.3s;
            height:100%;
        }

        .priorityCard:hover{
            transform:translateY(-6px);
            box-shadow:0 20px 40px rgba(15,23,42,.08);
        }

        .priorityIcon{
            width:44px;
            height:44px;
            border-radius:13px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:19px;
        }

        .gradient-title{
            background:linear-gradient(90deg,#2563eb,#06b6d4);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        }

        /* ============ TIMELINE (compact) ============ */
        .timelineCompact{ position:relative; margin-top:36px; }

        .timelineCompact::before{
            content:'';
            position:absolute;
            left:23px;
            top:6px;
            bottom:6px;
            width:2px;
            background:linear-gradient(to bottom,#2563eb,#06b6d4);
        }

        .timelineRow{
            position:relative;
            display:flex;
            gap:22px;
            margin-bottom:26px;
        }

        .timelineNum{
            width:47px;
            height:47px;
            min-width:47px;
            border-radius:50%;
            background:#2563eb;
            color:#fff;
            font-weight:800;
            font-size:.85rem;
            display:flex;
            align-items:center;
            justify-content:center;
            position:relative;
            z-index:5;
            box-shadow:0 10px 22px rgba(37,99,235,.28);
        }

        .timelineRow h4{ font-weight:800; color:#0f172a; }
        .timelineRow p{ color:#64748b; font-size:.92rem; margin-top:2px; }

        /* ============ TRAVEL TIPS BOX ============ */
        .tipsBox{
            background:#fff;
            border-radius:22px;
            border:1px solid #eef2f7;
            box-shadow:0 18px 45px rgba(15,23,42,.06);
            padding:26px;
        }

        .tipRow{
            display:flex;
            gap:12px;
            align-items:flex-start;
            font-size:.92rem;
            color:#334155;
        }

        .tipRow + .tipRow{ margin-top:14px; }

        .tipCheck{
            width:20px;
            height:20px;
            min-width:20px;
            border-radius:50%;
            background:#dbeafe;
            color:#2563eb;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:12px;
            margin-top:2px;
        }

        .tipsPhoto{
            border-radius:16px;
            overflow:hidden;
            margin-top:20px;
        }

        .tipsPhoto img{ width:100%; height:130px; object-fit:cover; }

        /* ============ GALLERY STRIP ============ */
        .galleryStripWrap{ position:relative; }

        .galleryStrip{
            display:grid;
            grid-template-columns: 1.6fr 1fr 1fr 1fr 1fr;
            gap:16px;
        }

        .galleryItem{
            position:relative;
            overflow:hidden;
            border-radius:18px;
            height:210px;
            box-shadow:0 12px 30px rgba(15,23,42,.08);
        }

        .galleryItem img{
            width:100%;
            height:100%;
            object-fit:cover;
            transition:.6s ease;
        }

        .galleryItem:hover img{ transform:scale(1.1); }

        .viewMoreBadge{
            position:absolute;
            left:50%;
            bottom:-20px;
            transform:translateX(-50%);
            background:#0f172a;
            color:#fff;
            padding:12px 26px;
            border-radius:999px;
            font-weight:700;
            font-size:.85rem;
            display:inline-flex;
            align-items:center;
            gap:8px;
            box-shadow:0 15px 35px rgba(15,23,42,.25);
            white-space:nowrap;
            transition:.3s;
        }

        .viewMoreBadge:hover{ transform:translateX(-50%) translateY(-4px); }

        /* ============ CTA BANNER (condensed) ============ */
        .ctaBanner{
            position:relative;
            overflow:hidden;
            border-radius:32px;
            background:linear-gradient(135deg,#1d4ed8,#0891b2);
            padding:52px 46px;
        }

        .ctaBanner::before{
            content:'';
            position:absolute;
            right:-100px;
            top:-100px;
            width:280px;
            height:280px;
            border-radius:50%;
            background:rgba(255,255,255,.08);
        }

        .ctaBanner::after{
            content:'';
            position:absolute;
            left:-80px;
            bottom:-100px;
            width:240px;
            height:240px;
            border-radius:50%;
            background:rgba(255,255,255,.06);
        }

        .ctaStat{ text-align:center; }
        .ctaStat h3{ font-size:1.9rem; font-weight:900; color:#fff; }
        .ctaStat p{ color:#bfdbfe; font-size:.82rem; margin-top:2px; }

        /* ============ RELATED + BLOGS ============ */
        .miniCard{
            background:#fff;
            border-radius:18px;
            overflow:hidden;
            border:1px solid #eef2f7;
            transition:.3s;
        }

        .miniCard:hover{
            transform:translateY(-6px);
            box-shadow:0 20px 40px rgba(15,23,42,.09);
        }

        .miniCard .imgWrap{ position:relative; overflow:hidden; }

        .miniCard img{
            width:100%;
            height:150px;
            object-fit:cover;
            transition:.6s;
        }

        .miniCard:hover img{ transform:scale(1.08); }

        .miniBadge{
            position:absolute;
            left:14px;
            top:14px;
            background:#2563eb;
            color:#fff;
            font-size:.68rem;
            font-weight:800;
            padding:5px 12px;
            border-radius:999px;
        }

        .blogBadge{ background:#0891b2; }

        /* ============ NEWSLETTER + CONTACT ROW ============ */
        .newsletterBox{
            border-radius:26px;
            background:linear-gradient(135deg,#2563eb,#06b6d4);
            position:relative;
            overflow:hidden;
            padding:34px;
            color:#fff;
        }

        .newsletterBox::before{
            content:'';
            position:absolute;
            width:220px;
            height:220px;
            border-radius:50%;
            background:rgba(255,255,255,.08);
            top:-70px;
            right:-60px;
        }

        .newsInline{
            display:flex;
            gap:10px;
            margin-top:20px;
            flex-wrap:wrap;
        }

        .newsInline input{
            flex:1;
            min-width:160px;
            height:52px;
            border-radius:14px;
            border:none;
            padding:0 18px;
            outline:none;
        }

        .newsInline button{
            height:52px;
            padding:0 24px;
            border-radius:14px;
        }

        .contactBox{
            border-radius:26px;
            background:#fff;
            border:1px solid #eef2f7;
            box-shadow:0 18px 45px rgba(15,23,42,.06);
            padding:34px;
            height:100%;
        }

        .contactRow{
            display:flex;
            align-items:center;
            gap:16px;
        }

        .contactRow + .contactRow{ margin-top:18px; }

        .contactIconSm{
            width:48px;
            height:48px;
            min-width:48px;
            border-radius:14px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:20px;
        }

        /* ============ FAQ (kept, restyled) ============ */
        .faqCard{
            background:#fff;
            border-radius:18px;
            overflow:hidden;
            box-shadow:0 12px 30px rgba(15,23,42,.05);
            border:1px solid #eef2f7;
        }
        .faqCard+.faqCard{ margin-top:14px; }
        .faqButton{
            width:100%;
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:20px 24px;
            font-weight:700;
            font-size:1rem;
            color:#0f172a;
        }
        .faqButton i:last-child{ transition:.35s; }
        .faqBody{
            display:none;
            padding:0 24px 22px;
            color:#64748b;
            line-height:26px;
        }
        .faqCard.active .faqBody{ display:block; }
        .faqCard.active .faqButton i:last-child{ transform:rotate(180deg); }

        /* ============ MISC (progress bar, back to top, share, author, prev/next) ============ */
        #readingProgress{
            position:fixed; top:0; left:0; width:0%; height:4px; z-index:9999;
            background:linear-gradient(90deg,#2563eb,#06b6d4);
            box-shadow:0 0 18px rgba(37,99,235,.45);
        }

        .shareBtn{
            width:50px; height:50px; border-radius:15px;
            display:flex; align-items:center; justify-content:center;
            font-size:20px; transition:.3s; border:1px solid #e2e8f0;
        }
        .shareBtn:hover{ transform:translateY(-5px); }

        .authorCard{
            background:#fff; border-radius:26px; padding:28px;
            box-shadow:0 18px 45px rgba(15,23,42,.06);
        }

        .navCard{
            position:relative; overflow:hidden; background:#fff;
            border-radius:22px; padding:26px; transition:.35s;
            box-shadow:0 15px 40px rgba(15,23,42,.06); height:100%;
        }
        .navCard:hover{ transform:translateY(-6px); box-shadow:0 25px 50px rgba(15,23,42,.1); }

        #backToTop{
            position:fixed; right:24px; bottom:24px; width:56px; height:56px;
            border-radius:18px; background:linear-gradient(135deg,#2563eb,#06b6d4);
            color:#fff; display:flex; align-items:center; justify-content:center;
            font-size:24px; box-shadow:0 15px 35px rgba(37,99,235,.35);
            cursor:pointer; opacity:0; visibility:hidden; transform:translateY(20px);
            transition:.3s; z-index:999;
        }
        #backToTop.show{ opacity:1; visibility:visible; transform:translateY(0); }

        .reveal{ opacity:0; transform:translateY(30px); transition:all .7s ease; }
        .reveal.active{ opacity:1; transform:translateY(0); }

        @media (max-width:1024px){
            .heroStatBar{ grid-template-columns:repeat(2,1fr) !important; }
            .heroStatItem:nth-child(2){ border-left:1px solid #eef2f7; }
            .heroStatItem:nth-child(3){ border-left:none; border-top:1px solid #eef2f7; }
            .galleryStrip{ grid-template-columns:repeat(2,1fr); }
            .galleryItem:first-child{ grid-column:span 2; height:260px; }
        }
    </style>
@endpush
@section('content')
    <div id="readingProgress"></div>

    <!------------- HERO ------------->
    <section class="pageHero">
        <img src="{{ $page->banner_image ?: $page->image }}" alt="{{ $page->title }}">
        <div class="absolute inset-0 flex items-center">
            <div class="heroContent max-w-7xl mx-auto w-full px-6">
                <div class="breadcrumb mb-6 flex flex-wrap items-center gap-3 text-sm text-white">
                    <a href="{{ url('/') }}"><i class="ti ti-home mr-1"></i>Home</a>
                    <i class="ti ti-chevron-right text-xs opacity-60"></i>
                    <span class="opacity-80">Pages</span>
                    <i class="ti ti-chevron-right text-xs opacity-60"></i>
                    <span class="text-blue-300 font-semibold">{{ $page->title }}</span>
                </div>

                <span class="text-blue-300 text-xs font-bold tracking-[.15em] uppercase">Our Story</span>

                <h1 class="text-white text-4xl md:text-6xl font-black mt-3 leading-tight">
                    {{ $page->title }}
                </h1>

                <p class="heroTagline text-xl md:text-2xl mt-2">Crafting Memories, Creating Journeys</p>

                @if($page->short_description)
                    <p class="mt-5 text-slate-200 max-w-2xl leading-7">
                        {{ Str::limit(strip_tags($page->short_description), 160) }}
                    </p>
                @endif
            </div>
        </div>
    </section>

    <!------------- HERO STAT STRIP ------------->
    <section class="heroStats">
        <div class="max-w-7xl mx-auto px-6">
            <div class="heroStatBar grid grid-cols-2 lg:grid-cols-4">
                <div class="heroStatItem">
                    <div class="heroStatIcon bg-blue-100 text-blue-600"><i class="ti ti-users"></i></div>
                    <div>
                        <h4 class="font-black text-lg text-slate-900">500+</h4>
                        <p class="text-xs text-slate-500">Happy Travelers</p>
                    </div>
                </div>
                <div class="heroStatItem">
                    <div class="heroStatIcon bg-green-100 text-green-600"><i class="ti ti-map-2"></i></div>
                    <div>
                        <h4 class="font-black text-lg text-slate-900">120+</h4>
                        <p class="text-xs text-slate-500">Destinations</p>
                    </div>
                </div>
                <div class="heroStatItem">
                    <div class="heroStatIcon bg-purple-100 text-purple-600"><i class="ti ti-briefcase"></i></div>
                    <div>
                        <h4 class="font-black text-lg text-slate-900">350+</h4>
                        <p class="text-xs text-slate-500">Premium Tours</p>
                    </div>
                </div>
                <div class="heroStatItem">
                    <div class="heroStatIcon bg-orange-100 text-orange-600"><i class="ti ti-mood-smile"></i></div>
                    <div>
                        <h4 class="font-black text-lg text-slate-900">99%</h4>
                        <p class="text-xs text-slate-500">Satisfaction Rate</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!------------- WHO WE ARE ------------->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-12 gap-10 items-start">

                <!-- TEXT -->
                <div class="lg:col-span-5">
                    <span class="text-blue-600 text-xs font-bold tracking-[.15em] uppercase">Who We Are</span>
                    <h2 class="text-3xl lg:text-4xl font-black mt-3 text-slate-900 leading-tight">
                        Your Trusted Partner For
                        <span class="gradient-title">Unforgettable</span> Journeys
                    </h2>

                    <p class="mt-5 text-slate-600 leading-7">
                        {{ $page->short_description ?: 'Founded with a passion for exploration, we have been helping thousands of travelers explore the world with confidence. Our expert team works around the clock to ensure every trip is smooth, memorable and extraordinary.' }}
                    </p>

                    <div class="mt-8 space-y-5">
                        <div class="checkItem">
                            <div class="checkIcon bg-blue-100 text-blue-600"><i class="ti ti-map-pin-check"></i></div>
                            <div>
                                <h4 class="font-bold text-slate-900">Handpicked Experiences</h4>
                                <p class="text-sm text-slate-500">We carefully select the best destinations, hotels and activities.</p>
                            </div>
                        </div>
                        <div class="checkItem">
                            <div class="checkIcon bg-green-100 text-green-600"><i class="ti ti-discount-2"></i></div>
                            <div>
                                <h4 class="font-bold text-slate-900">Best Price Guarantee</h4>
                                <p class="text-sm text-slate-500">We ensure you get the best value for your money.</p>
                            </div>
                        </div>
                        <div class="checkItem">
                            <div class="checkIcon bg-orange-100 text-orange-600"><i class="ti ti-headset"></i></div>
                            <div>
                                <h4 class="font-bold text-slate-900">24/7 Customer Support</h4>
                                <p class="text-sm text-slate-500">We are always here to assist you before, during and after your trip.</p>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="inline-flex items-center gap-2 mt-9 bg-blue-600 text-white px-7 py-4 rounded-2xl font-bold hover:bg-blue-700 transition">
                        Discover More
                        <i class="ti ti-arrow-right"></i>
                    </a>
                </div>

                <!-- IMAGE -->
                <div class="lg:col-span-4">
                    <div class="aboutImgWrap">
                        @if($page->image)
                            <img src="{{ $page->image }}" alt="{{ $page->title }}">
                        @endif
                    </div>
                </div>

                <!-- SIDEBAR: OVERVIEW + CTA -->
                <div class="lg:col-span-3 space-y-6">
                    <div class="overviewCard">
                        <div class="overviewHeader">
                            <i class="ti ti-info-circle"></i>
                            Quick Overview
                        </div>
                        <div class="p-1">
                            <div class="overviewRow">
                                <span class="text-slate-500">Established</span>
                                <span class="font-bold text-slate-900">2015</span>
                            </div>
                            <div class="overviewRow">
                                <span class="text-slate-500">Team Members</span>
                                <span class="font-bold text-slate-900">45+</span>
                            </div>
                            <div class="overviewRow">
                                <span class="text-slate-500">Offices</span>
                                <span class="font-bold text-slate-900">4 Countries</span>
                            </div>
                            <div class="overviewRow">
                                <span class="text-slate-500">Awards Won</span>
                                <span class="font-bold text-slate-900">12+</span>
                            </div>
                        </div>
                    </div>

                    <div class="ctaMini">
                        <div class="relative">
                            <h4 class="font-black text-lg">Ready To Explore?</h4>
                            <p class="text-blue-100 text-sm mt-2 leading-6">
                                Plan your dream vacation with us and get exclusive travel deals.
                            </p>
                            <a href="#" class="inline-flex items-center gap-2 mt-5 bg-white text-blue-700 px-5 py-3 rounded-xl font-bold text-sm hover:scale-105 transition">
                                Explore Tours
                                <i class="ti ti-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECONDARY STATS BAR -->
            <div class="statsBar mt-14 grid grid-cols-2 lg:grid-cols-4">
                <div class="statsBarItem">
                    <div class="statsBarIcon bg-blue-100 text-blue-600"><i class="ti ti-users"></i></div>
                    <div>
                        <h4 class="font-black text-2xl text-slate-900">500+</h4>
                        <p class="text-sm text-slate-500">Happy Travelers</p>
                    </div>
                </div>
                <div class="statsBarItem">
                    <div class="statsBarIcon bg-green-100 text-green-600"><i class="ti ti-map-2"></i></div>
                    <div>
                        <h4 class="font-black text-2xl text-slate-900">120+</h4>
                        <p class="text-sm text-slate-500">Top Destinations</p>
                    </div>
                </div>
                <div class="statsBarItem">
                    <div class="statsBarIcon bg-purple-100 text-purple-600"><i class="ti ti-briefcase"></i></div>
                    <div>
                        <h4 class="font-black text-2xl text-slate-900">350+</h4>
                        <p class="text-sm text-slate-500">Tour Packages</p>
                    </div>
                </div>
                <div class="statsBarItem">
                    <div class="statsBarIcon bg-amber-100 text-amber-600"><i class="ti ti-star-filled"></i></div>
                    <div>
                        <h4 class="font-black text-2xl text-slate-900">4.8/5</h4>
                        <p class="text-sm text-slate-500">Customer Rating</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!------------- WHY TRAVEL WITH US (priority grid) ------------->
    <section class="py-20 bg-[#f8fbff]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto">
                <span class="text-blue-600 text-xs font-bold tracking-[.15em] uppercase">Why Travel With Us</span>
                <h2 class="text-3xl lg:text-4xl font-black mt-4 text-slate-900">
                    Your Journey, Our <span class="gradient-title">Priority</span>
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-6 gap-5 mt-12">
                <div class="priorityCard">
                    <div class="priorityIcon bg-blue-100 text-blue-600"><i class="ti ti-route"></i></div>
                    <h4 class="font-bold mt-4 text-slate-900 text-sm">Expert Travel Planners</h4>
                    <p class="text-xs text-slate-500 mt-2 leading-5">We craft the perfect itinerary just for you.</p>
                </div>
                <div class="priorityCard">
                    <div class="priorityIcon bg-green-100 text-green-600"><i class="ti ti-diamond"></i></div>
                    <h4 class="font-bold mt-4 text-slate-900 text-sm">Best Price Guarantee</h4>
                    <p class="text-xs text-slate-500 mt-2 leading-5">The most competitive prices, no hidden fees.</p>
                </div>
                <div class="priorityCard">
                    <div class="priorityIcon bg-purple-100 text-purple-600"><i class="ti ti-shield-check"></i></div>
                    <h4 class="font-bold mt-4 text-slate-900 text-sm">Secure Booking</h4>
                    <p class="text-xs text-slate-500 mt-2 leading-5">Your payments and data are 100% secure.</p>
                </div>
                <div class="priorityCard">
                    <div class="priorityIcon bg-cyan-100 text-cyan-600"><i class="ti ti-building-community"></i></div>
                    <h4 class="font-bold mt-4 text-slate-900 text-sm">Handpicked Hotels</h4>
                    <p class="text-xs text-slate-500 mt-2 leading-5">Stay at the best rated hotels with premium comfort.</p>
                </div>
                <div class="priorityCard">
                    <div class="priorityIcon bg-orange-100 text-orange-600"><i class="ti ti-headset"></i></div>
                    <h4 class="font-bold mt-4 text-slate-900 text-sm">24/7 Support</h4>
                    <p class="text-xs text-slate-500 mt-2 leading-5">Our travel experts are available anytime, anywhere.</p>
                </div>
                <div class="priorityCard">
                    <div class="priorityIcon bg-pink-100 text-pink-600"><i class="ti ti-adjustments"></i></div>
                    <h4 class="font-bold mt-4 text-slate-900 text-sm">Custom Packages</h4>
                    <p class="text-xs text-slate-500 mt-2 leading-5">Personalized tours based on your preferences.</p>
                </div>
            </div>
        </div>
    </section>

    <!------------- TIMELINE + TRAVEL TIPS ------------->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-14">

                <!-- TIMELINE -->
                <div>
                    <span class="text-blue-600 text-xs font-bold tracking-[.15em] uppercase">Your Journey</span>
                    <h2 class="text-3xl lg:text-4xl font-black mt-4 text-slate-900">
                        Travel Experience <span class="text-blue-600">Timeline</span>
                    </h2>
                    <p class="mt-4 text-slate-600 leading-7">
                        From the moment you plan your trip until you return home, we take care
                        of everything to make it seamless and memorable.
                    </p>

                    <div class="timelineCompact">
                        <div class="timelineRow">
                            <div class="timelineNum">01</div>
                            <div>
                                <h4>Choose Your Destination</h4>
                                <p>Explore hundreds of amazing destinations and find the one that matches your dream vacation.</p>
                            </div>
                        </div>
                        <div class="timelineRow">
                            <div class="timelineNum" style="background:#06b6d4;">02</div>
                            <div>
                                <h4>Book Your Trip</h4>
                                <p>Secure your booking with instant confirmation and best price guarantee.</p>
                            </div>
                        </div>
                        <div class="timelineRow">
                            <div class="timelineNum" style="background:#16a34a;">03</div>
                            <div>
                                <h4>Start Your Adventure</h4>
                                <p>Pack your bags and get ready for an unforgettable experience.</p>
                            </div>
                        </div>
                        <div class="timelineRow">
                            <div class="timelineNum" style="background:#d97706;">04</div>
                            <div>
                                <h4>Make Memories</h4>
                                <p>Return home with beautiful memories that last a lifetime.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TRAVEL TIPS -->
                <div>
                    <div class="tipsBox">
                        <h3 class="font-black text-xl text-slate-900 mb-5">Travel Tips</h3>

                        <div class="tipRow">
                            <div class="tipCheck"><i class="ti ti-check"></i></div>
                            <span><strong>Best time to visit:</strong> Plan according to the weather.</span>
                        </div>
                        <div class="tipRow">
                            <div class="tipCheck"><i class="ti ti-check"></i></div>
                            <span>Don't forget travel insurance.</span>
                        </div>
                        <div class="tipRow">
                            <div class="tipCheck"><i class="ti ti-check"></i></div>
                            <span>Respect local culture and traditions.</span>
                        </div>
                        <div class="tipRow">
                            <div class="tipCheck"><i class="ti ti-check"></i></div>
                            <span>Try local cuisine and enjoy authentic experiences.</span>
                        </div>
                        <div class="tipRow">
                            <div class="tipCheck"><i class="ti ti-check"></i></div>
                            <span>Keep your documents and belongings safe.</span>
                        </div>

                        @if($page->image)
                            <div class="tipsPhoto">
                                <img src="{{ $page->image }}" alt="{{ $page->title }}">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!------------- MAIN DESCRIPTION (rich content from CMS) ------------->
    @if($page->description)
        <section class="py-4 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="prose prose-lg max-w-none prose-headings:font-black prose-headings:text-slate-900 prose-p:text-slate-700 prose-p:leading-8 prose-img:rounded-3xl prose-img:shadow-xl">
                    {!! $page->description !!}
                </div>
            </div>
        </section>
    @endif

    <!------------- GALLERY STRIP ------------->
    <section class="py-24 bg-[#f8fbff]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-blue-600 text-xs font-bold tracking-[.15em] uppercase">Gallery</span>
                <h2 class="text-3xl lg:text-4xl font-black mt-4 text-slate-900">
                    Moments Worth <span class="text-blue-600">Remembering</span>
                </h2>
            </div>

            <div class="galleryStripWrap">
                <div class="galleryStrip">
                    @if($page->image)
                        <div class="galleryItem"><img src="{{ $page->image }}" alt="{{ $page->title }}"></div>
                    @endif
                    @for($i=1;$i<=4;$i++)
                        <div class="galleryItem">
                            <img src="{{ $page->image }}" alt="{{ $page->title }}">
                        </div>
                    @endfor
                </div>
                <a href="#" class="viewMoreBadge">
                    <i class="ti ti-photo"></i>
                    View More Photos
                </a>
            </div>
        </div>
    </section>

    <!------------- CTA BANNER ------------->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="ctaBanner">
                <div class="relative grid lg:grid-cols-2 gap-10 items-center">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full bg-white/15 backdrop-blur-md text-white px-5 py-2 text-xs font-bold tracking-wide uppercase">
                            <i class="ti ti-world"></i>
                            Ready For Your Next Adventure?
                        </span>
                        <h3 class="text-3xl lg:text-4xl font-black text-white mt-6 leading-tight">
                            Let's Make Your Dream Trip A Reality
                        </h3>
                        <p class="text-blue-100 mt-5 leading-7 max-w-lg">
                            Join thousands of happy travelers and explore the world with confidence.
                        </p>
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mt-8 bg-white text-blue-700 px-7 py-4 rounded-2xl font-bold hover:scale-105 transition">
                            Explore Tours
                            <i class="ti ti-arrow-right"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="ctaStat"><h3>120+</h3><p>Destinations</p></div>
                        <div class="ctaStat"><h3>50K+</h3><p>Happy Travelers</p></div>
                        <div class="ctaStat"><h3>24/7</h3><p>Support</p></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!------------- RELATED PAGES + LATEST BLOGS ------------->
    @if((isset($relatedPages) && $relatedPages->count()) || (isset($latestBlogs) && $latestBlogs->count()))
        <section class="py-24 bg-[#f8fbff]">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-14">

                    @if(isset($relatedPages) && $relatedPages->count())
                        <div>
                            <div class="flex items-center justify-between mb-7">
                                <div>
                                    <span class="text-blue-600 text-xs font-bold tracking-[.15em] uppercase">Related Pages</span>
                                    <h3 class="text-2xl font-black text-slate-900 mt-1">More Pages You May Like</h3>
                                </div>
                                <a href="/" class="text-blue-600 font-bold text-sm inline-flex items-center gap-1 hover:gap-2 transition-all">
                                    View All <i class="ti ti-arrow-right"></i>
                                </a>
                            </div>

                            <div class="space-y-5">
                                @foreach($relatedPages->take(3) as $item)
                                    <article class="miniCard flex">
                                        <div class="imgWrap w-36 shrink-0">
                                            <span class="miniBadge">Page</span>
                                            <img src="{{ $item->image }}" alt="{{ $item->title }}" class="h-full">
                                        </div>
                                        <div class="p-5">
                                            <h4 class="font-black text-slate-900">{{ $item->title }}</h4>
                                            <p class="text-sm text-slate-500 mt-2 line-clamp-2">
                                                {{ Str::limit(strip_tags($item->short_description),90) }}
                                            </p>
                                            <a href="{{ route('pages.show',$item->slug) }}" class="inline-flex items-center gap-1 mt-3 text-blue-600 font-bold text-sm hover:gap-2 transition-all">
                                                Read More <i class="ti ti-arrow-right"></i>
                                            </a>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(isset($latestBlogs) && $latestBlogs->count())
                        <div>
                            <div class="flex items-center justify-between mb-7">
                                <div>
                                    <span class="text-cyan-600 text-xs font-bold tracking-[.15em] uppercase">Latest Blogs</span>
                                    <h3 class="text-2xl font-black text-slate-900 mt-1">Travel Tips & Inspiration</h3>
                                </div>
                                <a href="{{ route('blogs.index') ?? '#' }}" class="text-blue-600 font-bold text-sm inline-flex items-center gap-1 hover:gap-2 transition-all">
                                    View All <i class="ti ti-arrow-right"></i>
                                </a>
                            </div>

                            <div class="space-y-5">
                                @foreach($latestBlogs->take(3) as $blog)
                                    <article class="miniCard flex">
                                        <div class="imgWrap w-36 shrink-0">
                                            <span class="miniBadge blogBadge">Guide</span>
                                            <img src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}" class="h-full">
                                        </div>
                                        <div class="p-5">
                                            <h4 class="font-black text-slate-900">{{ Str::limit($blog->title,50) }}</h4>
                                            <p class="text-sm text-slate-500 mt-2 line-clamp-2">
                                                {{ Str::limit(strip_tags($blog->short_description),90) }}
                                            </p>
                                            <a href="{{ route('blogs.show',$blog->slug) }}" class="inline-flex items-center gap-1 mt-3 text-blue-600 font-bold text-sm hover:gap-2 transition-all">
                                                Read More <i class="ti ti-arrow-right"></i>
                                            </a>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </section>
    @endif

    <!------------- FAQ ------------->
    @if(isset($faqs) && $faqs->count())
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center max-w-2xl mx-auto mb-14">
                    <span class="text-blue-600 text-xs font-bold tracking-[.15em] uppercase">FAQs</span>
                    <h2 class="text-3xl lg:text-4xl font-black mt-4 text-slate-900">Got Questions?</h2>
                </div>

                <div class="max-w-4xl mx-auto">
                    @foreach($faqs as $faq)
                        <div class="faqCard">
                            <button class="faqButton">
                                <span>{{ $faq->question }}</span>
                                <i class="ti ti-chevron-down"></i>
                            </button>
                            <div class="faqBody">{!! $faq->answer !!}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!------------- NEWSLETTER + CONTACT ------------->
    <section class="py-24 bg-[#f8fbff]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-8">

                <div class="newsletterBox">
                    <span class="inline-flex rounded-full bg-white/20 px-4 py-1.5 text-xs font-bold uppercase tracking-wide">Newsletter</span>
                    <h3 class="text-2xl lg:text-3xl font-black mt-5 leading-tight">
                        Get Travel Deals In Your Inbox
                    </h3>
                    <p class="text-blue-100 mt-3 text-sm leading-6">
                        Subscribe and get exclusive offers, travel tips and destination guides.
                    </p>

                    <form action="{{ route('newsletter_subscribers.store') }}" method="POST" class="newsInline">
                        @csrf
                        <input type="email" name="email" placeholder="Enter your email address" class="text-slate-900">
                        <button class="bg-slate-900 hover:bg-black font-bold text-white transition">Subscribe</button>
                    </form>
                </div>

                <div class="contactBox">
                    <span class="text-cyan-600 text-xs font-bold tracking-[.15em] uppercase">Contact Us</span>
                    <h3 class="text-2xl font-black text-slate-900 mt-2 mb-6">Need More Help?</h3>

                    <div class="contactRow">
                        <div class="contactIconSm bg-blue-100 text-blue-600"><i class="ti ti-phone"></i></div>
                        <div>
                            <p class="text-sm text-slate-500">Call Us</p>
                            <p class="font-bold text-slate-900">+92 300 1234567</p>
                        </div>
                    </div>
                    <div class="contactRow">
                        <div class="contactIconSm bg-green-100 text-green-600"><i class="ti ti-mail"></i></div>
                        <div>
                            <p class="text-sm text-slate-500">Email</p>
                            <p class="font-bold text-slate-900">info@travelbook.com</p>
                        </div>
                    </div>
                    <div class="contactRow">
                        <div class="contactIconSm bg-orange-100 text-orange-600"><i class="ti ti-map-pin"></i></div>
                        <div>
                            <p class="text-sm text-slate-500">Office</p>
                            <p class="font-bold text-slate-900">Islamabad, Pakistan</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!------------- SHARE ------------->
    <section class="py-14 bg-dark reveal">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                <div>
                    <h3 class="text-2xl font-black text-slate-900">Enjoyed this page?</h3>
                    <p class="text-slate-600 mt-1">Share it with your friends and fellow travelers.</p>
                </div>
                <div class="flex flex-wrap items-center gap-4">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="shareBtn bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white">
                        <i class="ti ti-brand-facebook"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($page->title) }}" target="_blank" class="shareBtn bg-slate-100 text-slate-800 hover:bg-slate-900 hover:text-white">
                        <i class="ti ti-brand-x"></i>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="shareBtn bg-blue-50 text-blue-700 hover:bg-blue-700 hover:text-white">
                        <i class="ti ti-brand-linkedin"></i>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($page->title.' '.url()->current()) }}" target="_blank" class="shareBtn bg-green-50 text-green-600 hover:bg-green-600 hover:text-white">
                        <i class="ti ti-brand-whatsapp"></i>
                    </a>
                    <button id="copyLinkBtn" class="shareBtn bg-slate-50 text-slate-700 hover:bg-slate-800 hover:text-white">
                        <i class="ti ti-link"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!------------- AUTHOR / META ------------->
    <section class="pb-10 bg-dark reveal">
        <div class="max-w-7xl mx-auto px-6">
            <div class="authorCard">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 text-white flex items-center justify-center text-2xl font-black">TB</div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900">TravelBook Editorial Team</h3>
                            <p class="text-slate-600 mt-1 text-sm">Curated by travel experts & destination specialists</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-6 text-center">
                        <div>
                            <p class="text-xs text-slate-500">Published</p>
                            <p class="font-black text-slate-900 mt-1">{{ optional($page->created_at)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Updated</p>
                            <p class="font-black text-slate-900 mt-1">{{ optional($page->updated_at)->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!------------- PREV / NEXT ------------->
    <section class="py-16 bg-[#f8fbff] reveal">
        <div class="max-w-7xl mx-auto px-6">
            @php
                $previousPage = \App\Models\Page::where('status',1)->where('id','<',$page->id)->latest('id')->first();
                $nextPage = \App\Models\Page::where('status',1)->where('id','>',$page->id)->oldest('id')->first();
            @endphp

            <div class="grid md:grid-cols-2 gap-6">
                @if($previousPage)
                    <a href="{{ route('pages.show',$previousPage->slug) }}" class="navCard block">
                        <div class="flex items-center gap-2 text-blue-600 font-bold text-sm">
                            <i class="ti ti-arrow-left"></i> Previous Page
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mt-3">{{ $previousPage->title }}</h3>
                        <p class="text-slate-600 mt-2 text-sm line-clamp-2">
                            {{ Str::limit(strip_tags($previousPage->short_description),100) }}
                        </p>
                    </a>
                @endif

                @if($nextPage)
                    <a href="{{ route('pages.show',$nextPage->slug) }}" class="navCard block">
                        <div class="flex items-center justify-end gap-2 text-blue-600 font-bold text-sm">
                            Next Page <i class="ti ti-arrow-right"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mt-3 text-right">{{ $nextPage->title }}</h3>
                        <p class="text-slate-600 mt-2 text-sm line-clamp-2 text-right">
                            {{ Str::limit(strip_tags($nextPage->short_description),100) }}
                        </p>
                    </a>
                @endif
            </div>
        </div>
    </section>

    <div id="backToTop"><i class="ti ti-arrow-up"></i></div>

    @push('script')
        <script>
            /* Reading Progress */
            window.addEventListener('scroll', function () {
                const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrolled = (winScroll / height) * 100;
                document.getElementById('readingProgress').style.width = scrolled + '%';
            });

            /* Back To Top */
            const backToTop = document.getElementById('backToTop');
            window.addEventListener('scroll', function () {
                if (window.scrollY > 500) backToTop.classList.add('show');
                else backToTop.classList.remove('show');
            });
            backToTop.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            /* Copy Link */
            const copyBtn = document.getElementById('copyLinkBtn');
            if (copyBtn) {
                copyBtn.addEventListener('click', async function () {
                    try {
                        await navigator.clipboard.writeText(window.location.href);
                        const old = this.innerHTML;
                        this.innerHTML = '<i class="ti ti-check"></i>';
                        this.classList.add('bg-green-600', 'text-white');
                        setTimeout(() => {
                            this.innerHTML = old;
                            this.classList.remove('bg-green-600', 'text-white');
                        }, 2000);
                    } catch (e) {
                        alert('Link copied: ' + window.location.href);
                    }
                });
            }

            /* FAQ Toggle */
            document.querySelectorAll('.faqButton').forEach(button => {
                button.addEventListener('click', function () {
                    const card = this.parentElement;
                    document.querySelectorAll('.faqCard').forEach(item => {
                        if (item !== card) item.classList.remove('active');
                    });
                    card.classList.toggle('active');
                });
            });

            /* Scroll Reveal */
            const revealObserver = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: .15 });
            document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

            /* Smooth Anchor */
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });
        </script>
    @endpush
@endsection --}}


@extends('layouts.app')
@section('title', $page->meta_title ?: $page->title)
@push('css')
    <style>
        /* ============ HERO ============ */
        .pageHero{
            position: relative;
            height: 46vh;
            min-height: 380px;
            overflow: hidden;
        }

        .pageHero::before{
            content:'';
            position:absolute;
            inset:0;
            background:linear-gradient(90deg,
                rgba(2,12,27,.90) 0%,
                rgba(4,32,66,.72) 45%,
                rgba(7,66,115,.32) 100%);
            z-index:1;
        }

        .pageHero img{
            width:100%;
            height:100%;
            object-fit:cover;
            animation:heroZoom 10s ease forwards;
        }

        @keyframes heroZoom{
            from{transform:scale(1);}
            to{transform:scale(1.06);}
        }

        .heroContent{ position:relative; z-index:10; }

        .heroTagline{
            font-family: Georgia, 'Times New Roman', serif;
            font-style: italic;
            color:#7dd3fc;
        }

        .breadcrumb a{ transition:.3s; }
        .breadcrumb a:hover{ color:#60a5fa; }

        /* ============ HERO STAT STRIP ============ */
        .heroStats{ margin-top:-38px; position:relative; z-index:40; }

        .heroStatBar{
            background:#fff;
            border-radius:20px;
            box-shadow:0 25px 55px rgba(15,23,42,.14);
            display:grid;
        }

        .heroStatItem{ display:flex; align-items:center; gap:14px; padding:20px 18px; }
        .heroStatItem + .heroStatItem{ border-left:1px solid #eef2f7; }

        .heroStatIcon{
            width:44px; height:44px; min-width:44px; border-radius:14px;
            display:flex; align-items:center; justify-content:center; font-size:19px;
        }

        /* ============ WHO WE ARE ============ */
        .checkItem{ display:flex; gap:12px; align-items:flex-start; }
        .checkIcon{
            width:36px; height:36px; min-width:36px; border-radius:11px;
            display:flex; align-items:center; justify-content:center; font-size:15px;
        }

        .aboutImgWrap{
            position:relative; border-radius:22px; overflow:hidden;
            box-shadow:0 22px 50px rgba(15,23,42,.12); height:100%; min-height:300px;
        }
        .aboutImgWrap img{ width:100%; height:100%; min-height:300px; object-fit:cover; }

        .overviewCard{
            background:#fff; border-radius:18px;
            box-shadow:0 18px 40px rgba(15,23,42,.09);
            border:1px solid #eef2f7;
            padding:20px;
        }

        .overviewHeader{
            display:flex; align-items:center; gap:9px;
            font-weight:800; font-size:.92rem; color:#0f172a; margin-bottom:10px;
        }

        .overviewHeaderIcon{
            width:28px; height:28px; min-width:28px; border-radius:50%;
            background:#dbeafe; color:#2563eb; display:flex; align-items:center;
            justify-content:center; font-size:13px;
        }

        .overviewDesc{
            color:#64748b; font-size:.78rem; line-height:1.6; margin-bottom:14px;
        }

        .overviewRow{ display:flex; align-items:center; gap:10px; padding:9px 0; }
        .overviewRow + .overviewRow{ border-top:1px solid #f1f5f9; }

        .overviewRowIcon{
            width:30px; height:30px; min-width:30px; border-radius:9px;
            display:flex; align-items:center; justify-content:center; font-size:13px;
        }

        .ctaMini{
            border-radius:18px;
            background:linear-gradient(135deg,#2563eb,#06b6d4);
            color:#fff; padding:18px; position:relative; overflow:hidden;
        }
        .ctaMini::before{
            content:''; position:absolute; right:-30px; top:-30px;
            width:90px; height:90px; border-radius:50%; background:rgba(255,255,255,.10);
        }

        /* ============ SECONDARY STATS BAR ============ */
        .statsBar{
            background:#fff; border-radius:20px;
            box-shadow:0 15px 35px rgba(15,23,42,.06); border:1px solid #eef2f7;
        }
        .statsBarItem{ display:flex; align-items:center; gap:12px; padding:20px 18px; }
        .statsBarIcon{
            width:46px; height:46px; min-width:46px; border-radius:13px;
            display:flex; align-items:center; justify-content:center; font-size:20px;
        }

        /* ============ PRIORITY GRID ============ */
        .priorityCard{
            background:#fff; border:1px solid #eef2f7; border-radius:16px;
            padding:20px 16px; transition:.3s; height:100%;
        }
        .priorityCard:hover{ transform:translateY(-5px); box-shadow:0 16px 32px rgba(15,23,42,.08); }
        .priorityIcon{
            width:40px; height:40px; border-radius:12px;
            display:flex; align-items:center; justify-content:center; font-size:17px;
        }

        .gradient-title{
            background:linear-gradient(90deg,#2563eb,#06b6d4);
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        }

        /* ============ TIMELINE (compact) ============ */
        .timelineCompact{ position:relative; margin-top:26px; }
        .timelineCompact::before{
            content:''; position:absolute; left:19px; top:4px; bottom:4px; width:2px;
            background:linear-gradient(to bottom,#2563eb,#06b6d4);
        }
        .timelineRow{ position:relative; display:flex; gap:18px; margin-bottom:18px; }
        .timelineRow:last-child{ margin-bottom:0; }
        .timelineNum{
            width:40px; height:40px; min-width:40px; border-radius:50%;
            background:#2563eb; color:#fff; font-weight:800; font-size:.78rem;
            display:flex; align-items:center; justify-content:center;
            position:relative; z-index:5; box-shadow:0 8px 18px rgba(37,99,235,.28);
        }
        .timelineRow h4{ font-weight:800; color:#0f172a; font-size:.98rem; }
        .timelineRow p{ color:#64748b; font-size:.86rem; margin-top:2px; line-height:1.5; }

        /* ============ TRAVEL TIPS BOX ============ */
        .tipsBox{
            background:#fff; border-radius:18px; border:1px solid #eef2f7;
            box-shadow:0 15px 35px rgba(15,23,42,.06); padding:22px; height:100%;
        }
        .tipRow{ display:flex; gap:10px; align-items:flex-start; font-size:.86rem; color:#334155; }
        .tipRow + .tipRow{ margin-top:11px; }
        .tipCheck{
            width:18px; height:18px; min-width:18px; border-radius:50%;
            background:#dbeafe; color:#2563eb; display:flex; align-items:center;
            justify-content:center; font-size:11px; margin-top:2px;
        }
        .tipsPhoto{ border-radius:14px; overflow:hidden; margin-top:16px; }
        .tipsPhoto img{ width:100%; height:120px; object-fit:cover; }

        /* ============ PAGE DESCRIPTION (CMS content) ============ */
        .pageContentCard{
            background:#fff;
            border-radius:26px;
            border:1px solid #eef2f7;
            box-shadow:0 18px 45px rgba(15,23,42,.06);
            padding:40px;
        }
        .pageContent h1,.pageContent h2,.pageContent h3,.pageContent h4,.pageContent h5{
            font-weight:800; color:#0f172a; line-height:1.3; margin-top:1.3em; margin-bottom:.5em;
        }
        .pageContent h1:first-child,.pageContent h2:first-child,.pageContent h3:first-child{ margin-top:0; }
        .pageContent h1{ font-size:1.8rem; }
        .pageContent h2{ font-size:1.5rem; }
        .pageContent h3{ font-size:1.25rem; }
        .pageContent h4{ font-size:1.1rem; }
        .pageContent p{ color:#475569; line-height:1.85; margin-bottom:1.1em; font-size:.98rem; }
        .pageContent ul,.pageContent ol{ margin:0 0 1.2em 1.3em; color:#475569; line-height:1.85; font-size:.98rem; }
        .pageContent ul{ list-style:disc; }
        .pageContent ol{ list-style:decimal; }
        .pageContent li{ margin-bottom:.4em; }
        .pageContent a{ color:#2563eb; font-weight:600; text-decoration:underline; text-underline-offset:2px; }
        .pageContent strong{ color:#0f172a; font-weight:700; }
        .pageContent blockquote{
            border-left:4px solid #2563eb; padding:4px 0 4px 18px; margin:1.4em 0;
            color:#334155; font-style:italic; background:#f8fbff; border-radius:0 12px 12px 0;
        }
        .pageContent img{
            border-radius:18px; margin:1.4em 0; box-shadow:0 15px 35px rgba(15,23,42,.08);
            max-width:100%; height:auto;
        }
        .pageContent table{ width:100%; border-collapse:collapse; margin:1.2em 0; font-size:.92rem; }
        .pageContent th,.pageContent td{ border:1px solid #e2e8f0; padding:10px 14px; text-align:left; }
        .pageContent th{ background:#f8fbff; font-weight:700; color:#0f172a; }

        /* ============ GALLERY ============ */
        .galleryStripWrap{ position:relative; }
        .galleryStrip{ display:grid; grid-template-columns:repeat(5,1fr); gap:14px; }
        .galleryItem{
            position:relative; overflow:hidden; border-radius:16px; height:200px;
            box-shadow:0 10px 26px rgba(15,23,42,.08);
        }
        .galleryItem img{ width:100%; height:100%; object-fit:cover; transition:.6s ease; }
        .galleryItem:hover img{ transform:scale(1.1); }

        .viewMoreBadge{
            position:absolute; left:78%; bottom:-18px; transform:translateX(-50%);
            background:#0f172a; color:#fff; padding:11px 24px; border-radius:999px;
            font-weight:700; font-size:.82rem; display:inline-flex; align-items:center; gap:8px;
            box-shadow:0 15px 32px rgba(15,23,42,.28); white-space:nowrap; transition:.3s;
        }
        .viewMoreBadge:hover{ transform:translateX(-50%) translateY(-4px); }

        /* ============ CTA BANNER ============ */
        .ctaBanner{
            position:relative; overflow:hidden; border-radius:28px;
            background:linear-gradient(120deg,#1d4ed8,#0891b2);
            padding:42px 44px;
        }
        .ctaBanner::before{
            content:''; position:absolute; right:-90px; top:-90px; width:240px; height:240px;
            border-radius:50%; background:rgba(255,255,255,.08); pointer-events:none;
        }
        .ctaBanner::after{
            content:''; position:absolute; left:-70px; bottom:-90px; width:200px; height:200px;
            border-radius:50%; background:rgba(255,255,255,.06); pointer-events:none;
        }
        .ctaBannerRow{ position:relative; z-index:2; }
        .ctaStat h3{ font-size:1.6rem; font-weight:900; color:#fff; line-height:1; }
        .ctaStat p{ color:#bfdbfe; font-size:.78rem; margin-top:4px; white-space:nowrap; }

        /* ============ RELATED + BLOGS ============ */
        .miniCard{
            background:#fff; border-radius:16px; overflow:hidden;
            border:1px solid #eef2f7; transition:.3s;
        }
        .miniCard:hover{ transform:translateY(-5px); box-shadow:0 16px 32px rgba(15,23,42,.09); }
        .miniCard .imgWrap{ position:relative; overflow:hidden; }
        .miniCard img{ width:100%; height:100%; object-fit:cover; transition:.6s; }
        .miniCard:hover img{ transform:scale(1.08); }
        .miniBadge{
            position:absolute; left:12px; top:12px; background:#2563eb; color:#fff;
            font-size:.65rem; font-weight:800; padding:4px 11px; border-radius:999px; z-index:2;
        }
        .blogBadge{ background:#0891b2; }

        /* ============ NEWSLETTER + CONTACT ============ */
        .newsletterBox{
            border-radius:24px; background:linear-gradient(135deg,#2563eb,#06b6d4);
            position:relative; overflow:hidden; padding:30px; color:#fff;
        }
        .newsletterBox::before{
            content:''; position:absolute; width:200px; height:200px; border-radius:50%;
            background:rgba(255,255,255,.08); top:-60px; right:-50px; pointer-events:none;
        }
        .newsInline{ display:flex; gap:10px; margin-top:18px; flex-wrap:wrap; position:relative; z-index:2; }
        .newsInline input{ flex:1; min-width:160px; height:50px; border-radius:13px; border:none; padding:0 16px; outline:none; }
        .newsInline button{ height:50px; padding:0 22px; border-radius:13px; }

        .contactBox{
            border-radius:24px; background:#fff; border:1px solid #eef2f7;
            box-shadow:0 15px 35px rgba(15,23,42,.06); padding:30px; height:100%;
        }
        .contactDesc{ color:#64748b; font-size:.85rem; margin-top:6px; }
        .contactRowsWrap{
            display:flex; flex-wrap:wrap; gap:22px; margin-top:22px;
        }
        .contactRow{ display:flex; align-items:center; gap:10px; }
        .contactIconSm{
            width:38px; height:38px; min-width:38px; border-radius:11px;
            display:flex; align-items:center; justify-content:center; font-size:16px;
        }
        .contactRow p:first-child{ color:#94a3b8; font-size:.72rem; }
        .contactRow p:last-child{ color:#0f172a; font-weight:700; font-size:.85rem; }

        /* ============ FAQ ============ */
        .faqCard{
            background:#fff; border-radius:16px; overflow:hidden;
            box-shadow:0 10px 26px rgba(15,23,42,.05); border:1px solid #eef2f7;
        }
        .faqCard+.faqCard{ margin-top:12px; }
        .faqButton{
            width:100%; display:flex; justify-content:space-between; align-items:center;
            padding:18px 22px; font-weight:700; font-size:.96rem; color:#0f172a;
        }
        .faqButton i:last-child{ transition:.35s; }
        .faqBody{ display:none; padding:0 22px 20px; color:#64748b; line-height:24px; font-size:.92rem; }
        .faqCard.active .faqBody{ display:block; }
        .faqCard.active .faqButton i:last-child{ transform:rotate(180deg); }

        /* ============ SHARE / AUTHOR (forced light — guard against theme dark classes) ============ */
        .shareSection, .authorSection{
            background-color:#ffffff !important;
        }

        #readingProgress{
            position:fixed; top:0; left:0; width:0%; height:4px; z-index:9999;
            background:linear-gradient(90deg,#2563eb,#06b6d4);
            box-shadow:0 0 18px rgba(37,99,235,.45);
        }

        .shareCard{
            border-radius:26px;
            background:linear-gradient(120deg,#f0f7ff,#f8fbff);
            border:1px solid #eaf1fb;
            padding:34px 38px;
            position:relative;
            overflow:hidden;
        }
        .shareCard::before{
            content:'';
            position:absolute;
            right:-60px; top:-60px;
            width:180px; height:180px;
            border-radius:50%;
            background:rgba(37,99,235,.06);
            pointer-events:none;
        }
        .shareIconRow{ position:relative; z-index:2; display:flex; flex-wrap:wrap; align-items:center; gap:12px; }
        .shareBtn{
            width:46px; height:46px; border-radius:14px;
            display:flex; align-items:center; justify-content:center;
            font-size:18px; transition:.3s; border:1px solid #e2e8f0; background:#fff;
        }
        .shareBtn:hover{ transform:translateY(-4px); }

        .authorCard{
            background:#fff; border-radius:22px; padding:26px;
            box-shadow:0 15px 35px rgba(15,23,42,.06); border:1px solid #eef2f7;
        }

        .navCard{
            position:relative; overflow:hidden; background:#fff;
            border-radius:20px; padding:24px; transition:.35s;
            box-shadow:0 12px 32px rgba(15,23,42,.06); height:100%; border:1px solid #eef2f7;
        }
        .navCard:hover{ transform:translateY(-5px); box-shadow:0 22px 45px rgba(15,23,42,.1); }

        #backToTop{
            position:fixed; right:22px; bottom:22px; width:52px; height:52px;
            border-radius:16px; background:linear-gradient(135deg,#2563eb,#06b6d4);
            color:#fff; display:flex; align-items:center; justify-content:center;
            font-size:22px; box-shadow:0 15px 32px rgba(37,99,235,.35);
            cursor:pointer; opacity:0; visibility:hidden; transform:translateY(20px);
            transition:.3s; z-index:999;
        }
        #backToTop.show{ opacity:1; visibility:visible; transform:translateY(0); }

        .reveal{ opacity:0; transform:translateY(24px); transition:all .6s ease; }
        .reveal.active{ opacity:1; transform:translateY(0); }

        @media (max-width:1024px){
            .heroStatBar{ grid-template-columns:repeat(2,1fr) !important; }
            .heroStatItem:nth-child(2){ border-left:1px solid #eef2f7; }
            .heroStatItem:nth-child(3){ border-left:none; border-top:1px solid #eef2f7; }
            .galleryStrip{ grid-template-columns:repeat(2,1fr); }
            .viewMoreBadge{ left:50%; }
            .pageContentCard{ padding:26px; }
        }
    </style>
@endpush
@section('content')

    <div id="readingProgress"></div>

    <!------------- HERO ------------->
    <section class="pageHero">
        <img src="{{ $page->banner_image ?: $page->image }}" alt="{{ $page->title }}">
        <div class="absolute inset-0 flex items-center">
            <div class="heroContent max-w-7xl mx-auto w-full px-6">
                <div class="breadcrumb mb-5 flex flex-wrap items-center gap-3 text-sm text-white">
                    <a href="{{ url('/') }}"><i class="ti ti-home mr-1"></i>Home</a>
                    <i class="ti ti-chevron-right text-xs opacity-60"></i>
                    <span class="opacity-80">Pages</span>
                    <i class="ti ti-chevron-right text-xs opacity-60"></i>
                    <span class="text-blue-300 font-semibold">{{ $page->title }}</span>
                </div>

                <span class="text-blue-300 text-xs font-bold tracking-[.15em] uppercase">Our Story</span>

                <h1 class="text-white text-4xl md:text-6xl font-black mt-3 leading-tight">
                    {{ $page->title }}
                </h1>

                <p class="heroTagline text-xl md:text-2xl mt-2">Crafting Memories, Creating Journeys</p>

                @if($page->short_description)
                    <p class="mt-4 text-slate-200 max-w-2xl leading-7">
                        {{ Str::limit(strip_tags($page->short_description), 160) }}
                    </p>
                @endif
            </div>
        </div>
    </section>

    <!------------- HERO STAT STRIP ------------->
    <section class="heroStats">
        <div class="max-w-7xl mx-auto px-6">
            <div class="heroStatBar grid grid-cols-2 lg:grid-cols-4">
                <div class="heroStatItem">
                    <div class="heroStatIcon bg-blue-100 text-blue-600"><i class="ti ti-users"></i></div>
                    <div>
                        <h4 class="font-black text-lg text-slate-900">500+</h4>
                        <p class="text-xs text-slate-500">Happy Travelers</p>
                    </div>
                </div>
                <div class="heroStatItem">
                    <div class="heroStatIcon bg-green-100 text-green-600"><i class="ti ti-map-2"></i></div>
                    <div>
                        <h4 class="font-black text-lg text-slate-900">120+</h4>
                        <p class="text-xs text-slate-500">Destinations</p>
                    </div>
                </div>
                <div class="heroStatItem">
                    <div class="heroStatIcon bg-purple-100 text-purple-600"><i class="ti ti-briefcase"></i></div>
                    <div>
                        <h4 class="font-black text-lg text-slate-900">350+</h4>
                        <p class="text-xs text-slate-500">Premium Tours</p>
                    </div>
                </div>
                <div class="heroStatItem">
                    <div class="heroStatIcon bg-orange-100 text-orange-600"><i class="ti ti-mood-smile"></i></div>
                    <div>
                        <h4 class="font-black text-lg text-slate-900">99%</h4>
                        <p class="text-xs text-slate-500">Satisfaction Rate</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!------------- WHO WE ARE ------------->
    <section class="py-14">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-12 gap-8 items-stretch">

                <!-- TEXT -->
                <div class="lg:col-span-4">
                    <span class="text-blue-600 text-xs font-bold tracking-[.15em] uppercase">Who We Are</span>
                    <h2 class="text-3xl font-black mt-3 text-slate-900 leading-tight">
                        Your Trusted Partner For
                        <span class="gradient-title">Unforgettable</span> Journeys
                    </h2>

                    <p class="mt-4 text-slate-600 leading-7 text-[.95rem]">
                        {{ Str::limit(strip_tags($page->short_description), 220) ?: 'Founded with a passion for exploration, we have been helping thousands of travelers explore the world with confidence. Our expert team works around the clock to ensure every trip is smooth, memorable and extraordinary.' }}
                    </p>

                    <div class="mt-6 space-y-4">
                        <div class="checkItem">
                            <div class="checkIcon bg-blue-100 text-blue-600"><i class="ti ti-map-pin-check"></i></div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Handpicked Experiences</h4>
                                <p class="text-xs text-slate-500">We carefully select the best destinations, hotels and activities.</p>
                            </div>
                        </div>
                        <div class="checkItem">
                            <div class="checkIcon bg-green-100 text-green-600"><i class="ti ti-discount-2"></i></div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Best Price Guarantee</h4>
                                <p class="text-xs text-slate-500">We ensure you get the best value for your money.</p>
                            </div>
                        </div>
                        <div class="checkItem">
                            <div class="checkIcon bg-orange-100 text-orange-600"><i class="ti ti-headset"></i></div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">24/7 Customer Support</h4>
                                <p class="text-xs text-slate-500">We are always here to assist you before, during and after your trip.</p>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="inline-flex items-center gap-2 mt-7 bg-blue-600 text-white px-6 py-3.5 rounded-2xl font-bold text-sm hover:bg-blue-700 transition">
                        Discover More
                        <i class="ti ti-arrow-right"></i>
                    </a>
                </div>

                <!-- IMAGE -->
                <div class="lg:col-span-5">
                    <div class="aboutImgWrap">
                        @if($page->image)
                            <img src="{{ $page->image }}" alt="{{ $page->title }}">
                        @endif
                    </div>
                </div>

                <!-- SIDEBAR: OVERVIEW + CTA -->
                <div class="lg:col-span-3 flex flex-col gap-5">
                    <div class="overviewCard">
                        <div class="overviewHeader">
                            <div class="overviewHeaderIcon"><i class="ti ti-info-circle"></i></div>
                            Quick Overview
                        </div>

                        <p class="overviewDesc">
                            TravelBook simplifies travel planning by offering curated tours, luxury stays, secure bookings and expert support at every step.
                        </p>

                        <div>
                            <div class="overviewRow">
                                <div class="overviewRowIcon bg-blue-100 text-blue-600"><i class="ti ti-calendar-event"></i></div>
                                <span class="text-slate-500 text-xs flex-1">Established</span>
                                <span class="font-bold text-slate-900 text-sm">2015</span>
                            </div>
                            <div class="overviewRow">
                                <div class="overviewRowIcon bg-purple-100 text-purple-600"><i class="ti ti-users"></i></div>
                                <span class="text-slate-500 text-xs flex-1">Team Members</span>
                                <span class="font-bold text-slate-900 text-sm">45+</span>
                            </div>
                            <div class="overviewRow">
                                <div class="overviewRowIcon bg-pink-100 text-pink-600"><i class="ti ti-map-pin"></i></div>
                                <span class="text-slate-500 text-xs flex-1">Offices</span>
                                <span class="font-bold text-slate-900 text-sm">4 Countries</span>
                            </div>
                            <div class="overviewRow">
                                <div class="overviewRowIcon bg-orange-100 text-orange-600"><i class="ti ti-award"></i></div>
                                <span class="text-slate-500 text-xs flex-1">Awards Won</span>
                                <span class="font-bold text-slate-900 text-sm">12+</span>
                            </div>
                        </div>
                    </div>

                    <div class="ctaMini flex-1 flex flex-col justify-center">
                        <div class="relative">
                            <h4 class="font-black text-base">Ready To Explore?</h4>
                            <p class="text-blue-100 text-xs mt-2 leading-5">
                                Plan your dream vacation with us and get exclusive travel deals.
                            </p>
                            <a href="#" class="inline-flex items-center gap-2 mt-4 bg-white text-blue-700 px-4 py-2.5 rounded-xl font-bold text-xs hover:scale-105 transition">
                                Explore Packages
                                <i class="ti ti-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECONDARY STATS BAR -->
            <div class="statsBar mt-8 grid grid-cols-2 lg:grid-cols-4">
                <div class="statsBarItem">
                    <div class="statsBarIcon bg-blue-100 text-blue-600"><i class="ti ti-users"></i></div>
                    <div>
                        <h4 class="font-black text-xl text-slate-900">500+</h4>
                        <p class="text-xs text-slate-500">Happy Travelers</p>
                    </div>
                </div>
                <div class="statsBarItem">
                    <div class="statsBarIcon bg-green-100 text-green-600"><i class="ti ti-map-2"></i></div>
                    <div>
                        <h4 class="font-black text-xl text-slate-900">120+</h4>
                        <p class="text-xs text-slate-500">Top Destinations</p>
                    </div>
                </div>
                <div class="statsBarItem">
                    <div class="statsBarIcon bg-purple-100 text-purple-600"><i class="ti ti-briefcase"></i></div>
                    <div>
                        <h4 class="font-black text-xl text-slate-900">350+</h4>
                        <p class="text-xs text-slate-500">Tour Packages</p>
                    </div>
                </div>
                <div class="statsBarItem">
                    <div class="statsBarIcon bg-amber-100 text-amber-600"><i class="ti ti-star-filled"></i></div>
                    <div>
                        <h4 class="font-black text-xl text-slate-900">4.8/5</h4>
                        <p class="text-xs text-slate-500">Customer Rating</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!------------- WHY TRAVEL WITH US (priority grid) ------------->
    <section class="py-14 bg-[#f8fbff]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto">
                <span class="text-blue-600 text-xs font-bold tracking-[.15em] uppercase">Why Travel With Us</span>
                <h2 class="text-3xl font-black mt-3 text-slate-900">
                    Your Journey, Our <span class="gradient-title">Priority</span>
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-6 gap-4 mt-9">
                <div class="priorityCard">
                    <div class="priorityIcon bg-blue-100 text-blue-600"><i class="ti ti-route"></i></div>
                    <h4 class="font-bold mt-3 text-slate-900 text-sm">Expert Travel Planners</h4>
                    <p class="text-xs text-slate-500 mt-1.5 leading-5">We craft the perfect itinerary just for you.</p>
                </div>
                <div class="priorityCard">
                    <div class="priorityIcon bg-green-100 text-green-600"><i class="ti ti-diamond"></i></div>
                    <h4 class="font-bold mt-3 text-slate-900 text-sm">Best Price Guarantee</h4>
                    <p class="text-xs text-slate-500 mt-1.5 leading-5">The most competitive prices, no hidden fees.</p>
                </div>
                <div class="priorityCard">
                    <div class="priorityIcon bg-purple-100 text-purple-600"><i class="ti ti-shield-check"></i></div>
                    <h4 class="font-bold mt-3 text-slate-900 text-sm">Secure Booking</h4>
                    <p class="text-xs text-slate-500 mt-1.5 leading-5">Your payments and data are 100% secure.</p>
                </div>
                <div class="priorityCard">
                    <div class="priorityIcon bg-cyan-100 text-cyan-600"><i class="ti ti-building-community"></i></div>
                    <h4 class="font-bold mt-3 text-slate-900 text-sm">Handpicked Hotels</h4>
                    <p class="text-xs text-slate-500 mt-1.5 leading-5">Stay at the best rated hotels with premium comfort.</p>
                </div>
                <div class="priorityCard">
                    <div class="priorityIcon bg-orange-100 text-orange-600"><i class="ti ti-headset"></i></div>
                    <h4 class="font-bold mt-3 text-slate-900 text-sm">24/7 Support</h4>
                    <p class="text-xs text-slate-500 mt-1.5 leading-5">Our travel experts are available anytime, anywhere.</p>
                </div>
                <div class="priorityCard">
                    <div class="priorityIcon bg-pink-100 text-pink-600"><i class="ti ti-adjustments"></i></div>
                    <h4 class="font-bold mt-3 text-slate-900 text-sm">Custom Packages</h4>
                    <p class="text-xs text-slate-500 mt-1.5 leading-5">Personalized tours based on your preferences.</p>
                </div>
            </div>
        </div>
    </section>

    <!------------- TIMELINE + TRAVEL TIPS ------------->
    <section class="py-14 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-10">

                <!-- TIMELINE -->
                <div>
                    <span class="text-blue-600 text-xs font-bold tracking-[.15em] uppercase">Your Journey</span>
                    <h2 class="text-2xl lg:text-3xl font-black mt-3 text-slate-900">
                        Travel Experience <span class="text-blue-600">Timeline</span>
                    </h2>
                    <p class="mt-3 text-slate-600 leading-6 text-sm">
                        From the moment you plan your trip until you return home, we take care
                        of everything to make it seamless and memorable.
                    </p>

                    <div class="timelineCompact">
                        <div class="timelineRow">
                            <div class="timelineNum">01</div>
                            <div>
                                <h4>Choose Your Destination</h4>
                                <p>Explore hundreds of amazing destinations and find the one that matches your dream vacation.</p>
                            </div>
                        </div>
                        <div class="timelineRow">
                            <div class="timelineNum" style="background:#06b6d4;">02</div>
                            <div>
                                <h4>Book Your Trip</h4>
                                <p>Secure your booking with instant confirmation and best price guarantee.</p>
                            </div>
                        </div>
                        <div class="timelineRow">
                            <div class="timelineNum" style="background:#16a34a;">03</div>
                            <div>
                                <h4>Start Your Adventure</h4>
                                <p>Pack your bags and get ready for an unforgettable experience.</p>
                            </div>
                        </div>
                        <div class="timelineRow">
                            <div class="timelineNum" style="background:#d97706;">04</div>
                            <div>
                                <h4>Make Memories</h4>
                                <p>Return home with beautiful memories that last a lifetime.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TRAVEL TIPS -->
                <div>
                    <div class="tipsBox">
                        <h3 class="font-black text-lg text-slate-900 mb-4">Travel Tips</h3>

                        <div class="tipRow">
                            <div class="tipCheck"><i class="ti ti-check"></i></div>
                            <span><strong>Best time to visit:</strong> Plan according to the weather.</span>
                        </div>
                        <div class="tipRow">
                            <div class="tipCheck"><i class="ti ti-check"></i></div>
                            <span>Don't forget travel insurance.</span>
                        </div>
                        <div class="tipRow">
                            <div class="tipCheck"><i class="ti ti-check"></i></div>
                            <span>Respect local culture and traditions.</span>
                        </div>
                        <div class="tipRow">
                            <div class="tipCheck"><i class="ti ti-check"></i></div>
                            <span>Try local cuisine and enjoy authentic experiences.</span>
                        </div>
                        <div class="tipRow">
                            <div class="tipCheck"><i class="ti ti-check"></i></div>
                            <span>Keep your documents and belongings safe.</span>
                        </div>

                        @if($page->image)
                            <div class="tipsPhoto">
                                <img src="{{ $page->image }}" alt="{{ $page->title }}">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!------------- MAIN DESCRIPTION (rich content from CMS) ------------->
    @if($page->description)
        <section class="py-14 bg-[#f8fbff]">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center max-w-2xl mx-auto mb-8">
                    <span class="text-blue-600 text-xs font-bold tracking-[.15em] uppercase">More Details</span>
                    <h2 class="text-2xl lg:text-3xl font-black mt-3 text-slate-900">
                        Everything You Need To Know
                    </h2>
                </div>

                <div class="pageContentCard max-w-4xl mx-auto">
                    <div class="pageContent">
                        {!! $page->description !!}
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!------------- GALLERY STRIP ------------->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-blue-600 text-xs font-bold tracking-[.15em] uppercase">Gallery</span>
                <h2 class="text-2xl lg:text-3xl font-black mt-3 text-slate-900">
                    Moments Worth <span class="text-blue-600">Remembering</span>
                </h2>
            </div>

            <div class="galleryStripWrap">
                <div class="galleryStrip">
                    @for($i=1;$i<=5;$i++)
                        @if($page->image)
                            <div class="galleryItem">
                                <img src="{{ $page->image }}" alt="{{ $page->title }}">
                            </div>
                        @endif
                    @endfor
                </div>
                <a href="#" class="viewMoreBadge">
                    <i class="ti ti-photo"></i>
                    View More Photos
                </a>
            </div>
        </div>
    </section>

    <!------------- CTA BANNER ------------->
    <section class="py-14 bg-[#f8fbff]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="ctaBanner">
                <div class="ctaBannerRow flex flex-col lg:flex-row lg:items-center gap-8 lg:gap-10">
                    <div class="lg:flex-1 max-w-xl">
                        <span class="inline-flex items-center gap-2 rounded-full bg-white/15 text-white px-4 py-1.5 text-[.68rem] font-bold tracking-wide uppercase">
                            <i class="ti ti-world"></i>
                            Ready For Your Next Adventure?
                        </span>
                        <h3 class="text-2xl lg:text-3xl font-black text-white mt-4 leading-tight">
                            Let's Make Your Dream Trip A Reality
                        </h3>
                        <p class="text-blue-100 mt-3 leading-6 text-sm">
                            Join thousands of happy travelers and explore the world with confidence.
                        </p>
                    </div>

                    <a href="{{ route('home') }}" class="shrink-0 inline-flex items-center justify-center gap-2 bg-white text-blue-700 px-7 py-3.5 rounded-2xl font-bold text-sm hover:scale-105 transition">
                        Explore Tours
                        <i class="ti ti-arrow-right"></i>
                    </a>

                    <div class="flex items-center gap-8 lg:gap-10 shrink-0 justify-center">
                        <div class="ctaStat"><h3>120+</h3><p>Destinations</p></div>
                        <div class="ctaStat"><h3>50K+</h3><p>Happy Travelers</p></div>
                        <div class="ctaStat"><h3>24/7</h3><p>Support</p></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!------------- RELATED PAGES + LATEST BLOGS ------------->
    @if((isset($relatedPages) && $relatedPages->count()) || (isset($latestBlogs) && $latestBlogs->count()))
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-10">

                    @if(isset($relatedPages) && $relatedPages->count())
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <div>
                                    <span class="text-blue-600 text-xs font-bold tracking-[.15em] uppercase">Related Pages</span>
                                    <h3 class="text-xl font-black text-slate-900 mt-1">More Pages You May Like</h3>
                                </div>
                                <a href="/" class="text-blue-600 font-bold text-sm inline-flex items-center gap-1 hover:gap-2 transition-all">
                                    View All <i class="ti ti-arrow-right"></i>
                                </a>
                            </div>

                            <div class="space-y-4">
                                @foreach($relatedPages->take(3) as $item)
                                    <article class="miniCard flex">
                                        <div class="imgWrap w-32 shrink-0">
                                            <span class="miniBadge">Page</span>
                                            <img src="{{ $item->image }}" alt="{{ $item->title }}">
                                        </div>
                                        <div class="p-4">
                                            <h4 class="font-black text-slate-900 text-sm">{{ $item->title }}</h4>
                                            <p class="text-xs text-slate-500 mt-1.5 line-clamp-2">
                                                {{ Str::limit(strip_tags($item->short_description),80) }}
                                            </p>
                                            <a href="{{ route('pages.show',$item->slug) }}" class="inline-flex items-center gap-1 mt-2 text-blue-600 font-bold text-xs hover:gap-2 transition-all">
                                                Read More <i class="ti ti-arrow-right"></i>
                                            </a>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(isset($latestBlogs) && $latestBlogs->count())
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <div>
                                    <span class="text-cyan-600 text-xs font-bold tracking-[.15em] uppercase">Latest Blogs</span>
                                    <h3 class="text-xl font-black text-slate-900 mt-1">Travel Tips & Inspiration</h3>
                                </div>
                                <a href="{{ Route::has('blogs.index') ? route('blogs.index') : '#' }}" class="text-blue-600 font-bold text-sm inline-flex items-center gap-1 hover:gap-2 transition-all">
                                    View All <i class="ti ti-arrow-right"></i>
                                </a>
                            </div>

                            <div class="space-y-4">
                                @foreach($latestBlogs->take(3) as $blog)
                                    <article class="miniCard flex">
                                        <div class="imgWrap w-32 shrink-0">
                                            <span class="miniBadge blogBadge">Guide</span>
                                            <img src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}">
                                        </div>
                                        <div class="p-4">
                                            <h4 class="font-black text-slate-900 text-sm">{{ Str::limit($blog->title,48) }}</h4>
                                            <p class="text-xs text-slate-500 mt-1.5 line-clamp-2">
                                                {{ Str::limit(strip_tags($blog->short_description),80) }}
                                            </p>
                                            <a href="{{ route('blogs.show',$blog->slug) }}" class="inline-flex items-center gap-1 mt-2 text-blue-600 font-bold text-xs hover:gap-2 transition-all">
                                                Read More <i class="ti ti-arrow-right"></i>
                                            </a>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </section>
    @endif

    <!------------- FAQ ------------->
    @if(isset($faqs) && $faqs->count())
        <section class="py-16 bg-[#f8fbff]">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center max-w-2xl mx-auto mb-10">
                    <span class="text-blue-600 text-xs font-bold tracking-[.15em] uppercase">FAQs</span>
                    <h2 class="text-2xl lg:text-3xl font-black mt-3 text-slate-900">Got Questions?</h2>
                </div>

                <div class="max-w-4xl mx-auto">
                    @foreach($faqs as $faq)
                        <div class="faqCard">
                            <button class="faqButton">
                                <span>{{ $faq->question }}</span>
                                <i class="ti ti-chevron-down"></i>
                            </button>
                            <div class="faqBody">{!! $faq->answer !!}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!------------- NEWSLETTER + CONTACT ------------->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-6">

                <div class="newsletterBox flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="relative z-[2] max-w-sm">
                        <span class="inline-flex rounded-full bg-white/20 px-4 py-1.5 text-xs font-bold uppercase tracking-wide">Newsletter</span>
                        <h3 class="text-xl lg:text-2xl font-black mt-4 leading-tight">
                            Get Travel Deals In Your Inbox
                        </h3>
                        <p class="text-blue-100 mt-2 text-sm leading-6">
                            Subscribe and get exclusive offers, travel tips and destination guides.
                        </p>
                    </div>

                    <form action="{{ route('newsletter_subscribers.store') }}" method="POST" class="newsInline mt-0 lg:w-[340px]">
                        @csrf
                        <input type="email" name="email" placeholder="Enter your email address" class="text-slate-900">
                        <button class="bg-slate-900 hover:bg-black font-bold text-white transition">Subscribe</button>
                    </form>
                </div>

                <div class="contactBox">
                    <span class="text-cyan-600 text-xs font-bold tracking-[.15em] uppercase">Contact Us</span>
                    <h3 class="text-xl font-black text-slate-900 mt-2">Need More Help?</h3>
                    <p class="contactDesc">Our travel experts are ready to help you 24/7.</p>

                    <div class="contactRowsWrap">
                        <div class="contactRow">
                            <div class="contactIconSm bg-blue-100 text-blue-600"><i class="ti ti-phone"></i></div>
                            <div>
                                <p>Call Us</p>
                                <p>+92 300 1234567</p>
                            </div>
                        </div>
                        <div class="contactRow">
                            <div class="contactIconSm bg-green-100 text-green-600"><i class="ti ti-mail"></i></div>
                            <div>
                                <p>Email Us</p>
                                <p>info@travelbook.com</p>
                            </div>
                        </div>
                        <div class="contactRow">
                            <div class="contactIconSm bg-orange-100 text-orange-600"><i class="ti ti-map-pin"></i></div>
                            <div>
                                <p>Office</p>
                                <p>Islamabad, Pakistan</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!------------- SHARE ------------->
    <section class="shareSection py-10 reveal">
        <div class="max-w-7xl mx-auto px-6">
            <div class="shareCard flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="relative z-[2] flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl shrink-0">
                        <i class="ti ti-share"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Enjoyed this page?</h3>
                        <p class="text-slate-500 mt-0.5 text-sm">Share it with your friends and fellow travelers.</p>
                    </div>
                </div>
                <div class="shareIconRow">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="shareBtn bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white">
                        <i class="ti ti-brand-facebook"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($page->title) }}" target="_blank" class="shareBtn bg-slate-100 text-slate-800 hover:bg-slate-900 hover:text-white">
                        <i class="ti ti-brand-x"></i>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="shareBtn bg-blue-50 text-blue-700 hover:bg-blue-700 hover:text-white">
                        <i class="ti ti-brand-linkedin"></i>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($page->title.' '.url()->current()) }}" target="_blank" class="shareBtn bg-green-50 text-green-600 hover:bg-green-600 hover:text-white">
                        <i class="ti ti-brand-whatsapp"></i>
                    </a>
                    <button id="copyLinkBtn" class="shareBtn bg-slate-50 text-slate-700 hover:bg-slate-800 hover:text-white">
                        <i class="ti ti-link"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!------------- AUTHOR / META ------------->
    <section class="authorSection pb-10 reveal">
        <div class="max-w-7xl mx-auto px-6">
            <div class="authorCard">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 text-white flex items-center justify-center text-xl font-black">TB</div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900">TravelBook Editorial Team</h3>
                            <p class="text-slate-600 mt-0.5 text-xs">Curated by travel experts & destination specialists</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-6 text-center">
                        <div>
                            <p class="text-xs text-slate-500">Published</p>
                            <p class="font-black text-slate-900 mt-1 text-sm">{{ optional($page->created_at)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Updated</p>
                            <p class="font-black text-slate-900 mt-1 text-sm">{{ optional($page->updated_at)->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!------------- PREV / NEXT ------------->
    <section class="py-12 bg-[#f8fbff] reveal">
        <div class="max-w-7xl mx-auto px-6">
            @php
                $previousPage = \App\Models\Page::where('status',1)->where('id','<',$page->id)->latest('id')->first();
                $nextPage = \App\Models\Page::where('status',1)->where('id','>',$page->id)->oldest('id')->first();
            @endphp

            <div class="grid md:grid-cols-2 gap-5">
                @if($previousPage)
                    <a href="{{ route('pages.show',$previousPage->slug) }}" class="navCard block">
                        <div class="flex items-center gap-2 text-blue-600 font-bold text-xs">
                            <i class="ti ti-arrow-left"></i> Previous Page
                        </div>
                        <h3 class="text-lg font-black text-slate-900 mt-2">{{ $previousPage->title }}</h3>
                        <p class="text-slate-600 mt-1.5 text-xs line-clamp-2">
                            {{ Str::limit(strip_tags($previousPage->short_description),100) }}
                        </p>
                    </a>
                @endif

                @if($nextPage)
                    <a href="{{ route('pages.show',$nextPage->slug) }}" class="navCard block">
                        <div class="flex items-center justify-end gap-2 text-blue-600 font-bold text-xs">
                            Next Page <i class="ti ti-arrow-right"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-900 mt-2 text-right">{{ $nextPage->title }}</h3>
                        <p class="text-slate-600 mt-1.5 text-xs line-clamp-2 text-right">
                            {{ Str::limit(strip_tags($nextPage->short_description),100) }}
                        </p>
                    </a>
                @endif
            </div>
        </div>
    </section>

    <div id="backToTop"><i class="ti ti-arrow-up"></i></div>

    @push('scripts')
        <script>
            /* Reading Progress */
            window.addEventListener('scroll', function () {
                const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrolled = (winScroll / height) * 100;
                document.getElementById('readingProgress').style.width = scrolled + '%';
            });

            /* Back To Top */
            const backToTop = document.getElementById('backToTop');
            window.addEventListener('scroll', function () {
                if (window.scrollY > 500) backToTop.classList.add('show');
                else backToTop.classList.remove('show');
            });
            backToTop.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            /* Copy Link */
            const copyBtn = document.getElementById('copyLinkBtn');
            if (copyBtn) {
                copyBtn.addEventListener('click', async function () {
                    try {
                        await navigator.clipboard.writeText(window.location.href);
                        const old = this.innerHTML;
                        this.innerHTML = '<i class="ti ti-check"></i>';
                        this.classList.add('bg-green-600', 'text-white');
                        setTimeout(() => {
                            this.innerHTML = old;
                            this.classList.remove('bg-green-600', 'text-white');
                        }, 2000);
                    } catch (e) {
                        alert('Link copied: ' + window.location.href);
                    }
                });
            }

            /* FAQ Toggle */
            document.querySelectorAll('.faqButton').forEach(button => {
                button.addEventListener('click', function () {
                    const card = this.parentElement;
                    document.querySelectorAll('.faqCard').forEach(item => {
                        if (item !== card) item.classList.remove('active');
                    });
                    card.classList.toggle('active');
                });
            });

            /* Scroll Reveal */
            const revealObserver = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: .15 });
            document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

            /* Smooth Anchor */
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });
        </script>
    @endpush
@endsection
