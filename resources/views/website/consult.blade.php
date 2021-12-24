@extends('website.layouts.webapp')
@section('title', 'Consulting')
@section('content')
<section>
  <div class="news-header">
    <div class="n-container">
      <div class="header-top">
        <nav class="navbar navbar-expand-lg navbar-light">
          <a class="navbar-brand" href="/"><img src="{{ asset ('website/assets/images/logo.svg') }}" alt="" /></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link toplink" href="{{ url('consultmain') }}">컨설팅 중인 기업</a>
              </li>
              <li class="nav-item">
                <a class="nav-link toplink" href="{{ url('newsroom') }}">뉴스룸</a>
              </li>
              <li class="nav-item">
                <a class="nav-link toplink" href="{{ url('about-us') }}">회사소개</a>
              </li>
              <li class="nav-item">
                <a class="nav-link toplink" href="{{ url('service') }}">서비스</a>
              </li>
              <li class="nav-item">
                <a class="nav-link toplink" href="{{ url('blog') }}">블로그</a>
              </li>
              <li class="nav-item">
                <a class="nav-link toplink" href="{{ url('contact-us') }}">상담문의</a>
              </li>
            </ul>
            <span class="navbar-text">
              <a href="tel:832 939 8280"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;
                02-529-1001</a>
            </span>
          </div>
        </nav>
      </div>
    </div>
  </div>

  <!-- Mobile mune for news  -->
  <div class="news-mobile-wrapper">
    <div class="mobile-header-menu" id="mobile-header">
      <div class="left">
        <a href="/"><img src="{{ asset ('website/assets/images/mobilelogo.svg') }}" alt="" /></a>
      </div>
      <div class="right">
        <div class="myicon">
          <i class="fa fa-ellipsis-h menu-dots news-menu-dots" id="menu-dots" aria-hidden="true"></i>
          <span class="cross news-cross"> &times; </span>
        </div>
      </div>
    </div>
    <div class="mymobile-menu">
      <ul>
        <li><a href="{{ url('consultmain') }}">컨설팅 중인 기업</a></li>
        <li><a href="{{ url('newsroom') }}">뉴스룸</a></li>
        <li><a href="{{ url('about-us') }}">회사소개</a></li>
        <li><a href="{{ url('service') }}">서비스</a></li>
        <li><a href="{{ url('blog') }}">블로그</a></li>
        <li><a href="{{ url('contact-us') }}">상담문의</a></li>
      </ul>
      <div class="mphone">
        <a class="mobile-phone" href="tel:832 939 8280"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;
          02-529-1001</a>
      </div>
    </div>
  </div>
  <!-- Mobile mune for news  -->
</section>

<!-- top section -->
<div class="top-section-wrapper">
  <div class="n-container">
    <div class="top-section-inner-wrapper">
      <div class="top-section-inner-left">
        <h2>{{ $consulting->company_name_kor_inner }}</h2>
        <p>{{ $consulting->subtitle }}</p>
        <!-- Tab Video Section  -->
        <div class="tab-video-section">
          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-video1" type="button" role="tab" aria-controls="pills-video1" aria-selected="true">
                기업소개 영상
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-video2" type="button" role="tab" aria-controls="pills-video2" aria-selected="false">
                서비스 소개
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link last-tab-button" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-video3" type="button" role="tab" aria-controls="pills-video3" aria-selected="false">
                사용자 후기
              </button>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-video1" role="tabpanel" aria-labelledby="pills-home-tab">
              <iframe class="consult-iframe" src="{{ $consulting->company_video_link }}" allow="autoplay" frameborder="0" style="cursor: pointer" allowfullscreen></iframe>
            </div>
            <div class="tab-pane fade" id="pills-video2" role="tabpanel" aria-labelledby="pills-profile-tab">
              <iframe class="consult-iframe" src="{{ $consulting->service_video_link }}" allow="autoplay" id="video-1" frameborder="0" style="cursor: pointer" allowfullscreen></iframe>
            </div>
            <div class="tab-pane fade" id="pills-video3" role="tabpanel" aria-labelledby="pills-contact-tab">
              <iframe class="consult-iframe" src="{{ $consulting->user_review_video_link }}" allow="autoplay" id="video-1" frameborder="0" style="cursor: pointer" allowfullscreen></iframe>
            </div>
          </div>
        </div>
        <!-- Tab Video Section  -->
      </div>
      <div class="top-section-inner-right">
        <p class="aitoppara">산업분야</p>
        <h2>{{ $consulting->industry_inner }}</h2>
        <div class="top-right-list-box">
          @if($consulting->highlight_content)
          @foreach ($consulting->highlight_content as $highlight)
          <p>{{ $highlight->content }}</p>
          @endforeach
          @endif
        </div>
        <div class="top-right-bottom-box">
          <div class="value-wrapper">
            <div class="value-left">
              <p>시장가치평가</p>
            </div>
            <div class="value-right">
              <h6>{{ $consulting->market_value }}</h6>
            </div>
          </div>
          <div class="consulting-conactbtn-wrapper">
            <a href="{{ url('contact-us') }}" id="inquirybtn" class="nbtn inquiry-btn">기업관련 문의하기</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- top section -->

  <!-- Bottom Section  -->
  <div class="bottom-section-wrapper">
    <div class="bottom-button-outside-wrapper">
      <!-- Bottom Tab button Section  -->
      <div class="sticky-tab-section">
        <div class="n-container">
          <div class="ntab-btn-wrapper">
            <div class="tab-wrapper">
              <ul class="stickytabul">
                <li>
                  <span class="sticky-tab-active firsttb" id="business-link">사업소개</span>
                </li>
                <li>
                  <span class="firsttb" id="consulting-link">컨설팅 전/후</span>
                </li>
                <li>
                  <span class="firsttb" id="news-link">새로운 소식 <span>2</span></span>
                </li>
                <li>
                  <span class="firsttb" id="questions-link">자주묻는질문</span>
                </li>
              </ul>
            </div>

            <!-- Select menu  -->
            <div class="select-menu-wrapper">
              <div class="selector">
                <div id="selectField">
                  <p id="selectText">사업소개</p>
                  <i class="fa fa-chevron-down" id="arrowIcon" aria-hidden="true"></i>
                </div>
                <ul id="ul-list" class="select-hide">
                  <li class="options selectactive">
                    <a href="#business-introduction" id="select-business-link">사업소개</a>
                  </li>
                  <li class="options">
                    <a href="#consulting" id="select-consulting-link">컨설팅 전/후</a>
                  </li>
                  <li class="options">
                    <a href="#news" id="select-news-link">새로운 소식 (2)</a>
                  </li>
                  <li class="options">
                    <a href="#questions" id="select-questions-link">자주묻는질문</a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- Select menu  -->

            <div class="telephone-no">
              <div class="phone-wrapper">
                <a href="tel:832 939 8280"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;
                  02-529-1001</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Bottom Tab button Section  -->
      <div class="bottom-content-section-wrapper">
        <div class="n-container">
          <div class="bottom-content-inner-wrapper">
            <div class="bottom-content-inner-left">
              <div class="ntab-content-bottom-wrapper">
                <div class="mytab-content">
                  <div class="first-content" id="business-introduction">

                    @if($consulting->highlight)
                    <!-- Content Box  -->
                    <div class="first-content-inner-wrapper" id="highlight">
                      {!! $consulting->highlight !!}
                    </div>
                    <!-- Content Box  -->
                    @endif

                    @if($consulting->problem)
                    <!-- Content Box  -->
                    <div class="first-content-inner-wrapper" id="problem">
                      {!! $consulting->problem !!}
                    </div>
                    <!-- Content Box  -->
                    @endif

                    @if($consulting->suggest_solution)
                    <!-- Content Box  -->
                    <div class="first-content-inner-wrapper" id="suggest_solution">
                      {!! $consulting->suggest_solution !!}
                    </div>
                    <!-- Content Box  -->
                    @endif

                    @if($consulting->service_introduction)
                    <!-- Content Box  -->
                    <div class="first-content-inner-wrapper" id="service_introduction">
                      {!! $consulting->service_introduction !!}
                    </div>
                    <!-- Content Box  -->
                    @endif

                    @if($consulting->service_diff_eff)
                    <!-- Content Box  -->
                    <div class="first-content-inner-wrapper" id="service_diff_eff">
                      {!! $consulting->service_diff_eff !!}
                    </div>
                    <!-- Content Box  -->
                    @endif

                    @if($consulting->market_analysis)
                    <!-- Content Box  -->
                    <div class="first-content-inner-wrapper" id="market_analysis">
                      {!! $consulting->market_analysis !!}
                    </div>
                    <!-- Content Box  -->
                    @endif

                    @if($consulting->business_status)
                    <!-- Content Box  -->
                    <div class="first-content-inner-wrapper" id="business_status">
                      {!! $consulting->business_status !!}
                    </div>
                    <!-- Content Box  -->
                    @endif

                    @if($consulting->about_company)
                    <!-- Content Box  -->
                    <div class="first-content-inner-wrapper" id="about_company">
                      {!! $consulting->about_company !!}
                    </div>
                    <!-- Content Box  -->
                    @endif

                    @if($consulting->ceo)
                    <!-- Content Box  -->
                    <div class="first-content-inner-wrapper" id="ceo">
                      {!! $consulting->ceo !!}
                    </div>
                    <!-- Content Box  -->
                    @endif

                    @if($consulting->members)
                    <!-- Content Box  -->
                    <div class="first-content-inner-wrapper" id="members">
                      {!! $consulting->members !!}
                    </div>
                    <!-- Content Box  -->
                    @endif

                    <!-- Side Menu  -->
                    <div class="left-side-menu-wrapper">
                      <a class="sideactive" href="#highlight">가장 밝은 부분</a>
                      <a href="#problem">문제점</a>
                      <a href="#suggest_solution">해결책 제안</a>
                      <a href="#service_introduction">상품/서비스 소개</a>
                      <a href="#service_diff_eff">서비스 차별성 및 효과</a>
                      <a href="#market_analysis">시장분석</a>
                      <a href="#business_status">사업현황</a>
                      <a href="#about_company">회사 소개</a>
                      <a href="#ceo">CEO 소개</a>
                      <a href="#members">구성원 소개</a>
                    </div>
                    <!-- Side Menu  -->
                  </div>
                  <div class="second-content" id="consulting">
                    <div class="second-content-inner-wrapper">
                      <h2 class="third-title">컨설팅 전/후</h2>
                      {!! $consulting->before_after_desc !!}
                      <div class="big-graph">
                        <div class="new-graph">
                          <img src="{{ asset('website/assets/images/graph-blank.png') }}" alt="" />
                          @if($consulting->show_red_dot_1 == 1)
                          <div class="point" id="point1">
                            <div class="point-top">
                              <h6>{{ $consulting->red_dot_1_title }}</h6>
                              <h2>{{ $consulting->red_dot_1_amount }}</h2>
                              <div class="tringle">
                                <img class="triangleimag" src="{{ asset ('assets/images/Polygon 2.png') }}" alt="" />
                              </div>
                            </div>
                            <div class="dashline">
                              <img class="dash-image" src="{{ asset('assets/images/Line 4.png') }}" alt="" />
                            </div>
                            <div class="red-dot"></div>
                          </div>
                          @endif
                          @if($consulting->show_red_dot_2 == 1)
                          <div class="point" id="point2">
                            <div class="point-top">
                              <h6>{{ $consulting->red_dot_2_title }}</h6>
                              <h2>{{ $consulting->red_dot_1_amount }}</h2>
                              <div class="tringle">
                                <img class="triangleimag" src="{{ asset('assets/images/Polygon 2.png') }}" alt="" />
                              </div>
                            </div>
                            <div class="dashline">
                              <img class="dash-image" src="{{ asset('assets/images/Line 4.png') }}" alt="" />
                            </div>
                            <div class="red-dot"></div>
                          </div>
                          @endif
                          @if($consulting->show_red_dot_3 == 1)
                          <div class="point" id="point3">
                            <div class="point-top">
                              <h6>{{ $consulting->red_dot_3_title }}</h6>
                              <h2>{{ $consulting->red_dot_1_amount }}</h2>
                              <div class="tringle">
                                <img class="triangleimag" src="{{ asset('assets/images/Polygon 2.png') }}" alt="" />
                              </div>
                            </div>
                            <div class="dashline">
                              <img class="dash-image" src="{{ asset('assets/images/Line 4.png') }}" alt="" />
                            </div>
                            <div class="red-dot"></div>
                          </div>
                          @endif
                          @if($consulting->show_red_dot_4 == 1)
                          <div class="point" id="point4">
                            <div class="point-top">
                              <h6>{{ $consulting->red_dot_4_title }}</h6>
                              <h2>{{ $consulting->red_dot_1_amount }}</h2>
                              <div class="tringle">
                                <img class="triangleimag" src="{{ asset('assets/images/Polygon 2.png') }}" alt="" />
                              </div>
                            </div>
                            <div class="dashline">
                              <img class="dash-image" src="{{ asset('assets/images/Line 4.png') }}" alt="" />
                            </div>
                            <div class="red-dot"></div>
                          </div>
                          @endif
                        </div>
                      </div>
                      <!-- Growth Section  -->
                      <div class="growth-section-wrapper">
                        <h5>기업가치의 변화</h5>
                        <div class="growth-section-inner-wrapper">
                          <div class="growth-section-left">
                            <div class="growth-inner-left-wrapper">
                              <div class="growth-inner-left-left">
                                <div class="bottom-section bottom-arrow">
                                  <img src="
                                      {{ asset ('website/assets/images/arrow-right.svg') }}" class="right-arrow" alt="" />
                                  <div class="left">
                                    <div class="top">
                                      <p>컨설팅 전</p>
                                    </div>
                                    <div class="bottom">
                                      <h4>{{ $consulting->before_consulting }}</h4>
                                      <p>기업가치</p>
                                    </div>
                                  </div>
                                  <div class="right">
                                    <div class="top">
                                      <p>컨설팅 후</p>
                                    </div>
                                    <div class="bottom">
                                      <h4>{{ $consulting->current_value }}</h4>
                                      <p>{{ $consulting->current_value_date }}</p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="growth-section-right">
                            <div class="growth-percentege">
                              <h5>성장률</h5>
                              <div class="g-percentege">
                                <h1>{{ $consulting->expectation_growth_rate }}</h1>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Growth Section  -->
                      <!-- Corporate  -->
                      <div class="corporate-wrapper">
                        <h2 class="corporate-title">기업가치 현황</h2>
                        @if($consulting->evs)
                        @foreach ($consulting->evs as $key => $evs)
                        <!-- Corporate Box  -->
                        <div class="corporate-box {{ $key == 0 ? 'corporate-box-first' : null }}">
                          <span class="date">{{$evs->date}}</span>
                          <h6>{{$evs->title}}</h6>
                        </div>
                        <!-- Corporate Box  -->
                        @endforeach
                        @endif
                      </div>
                      <!-- Corporate  -->
                    </div>
                  </div>
                  <div class="third-content" id="news">
                    <div class="third-content-inner-wrapper">
                      <h2 class="third-title">새로운 소식</h2>
                      @if($consulting_news)
                      @foreach ($consulting_news as $n)

                      @php
                      $date = Carbon\Carbon::parse($n->news->date)->format('d m');
                      $date_year = Carbon\Carbon::parse($n->news->date)->format('Y');
                      @endphp

                      <!-- Box  -->
                      <div class="third-content-in-wrapper">
                        <div class="third-content-in-left">
                          <div class="lefttxt">
                            <h3>{{$date}}</h3>
                            <p>{{$date_year}}</p>
                          </div>
                        </div>
                        <div class="third-content-in-right">
                          <h6> {{ $n->news->tag->keyword }}</h6>
                          <h5>
                            <a href="{{ url ('news') }}/{{$n->news->id}}">
                              {{ $n->news->title }}
                            </a>
                          </h5>
                          <div class="third-content-img">
                            <a href="{{ url ('news') }}/{{$n->news->id}}">
                              <img src="{{ $n->news->images[0] }}" alt="" />
                            </a>
                          </div>
                        </div>
                      </div>
                      <!-- Box  -->
                      @endforeach
                      @endif
                      <!-- Load More  -->
                      <!-- <div class="loadmore-wrapper">
                        <a href="#" class="loadmore-btn">더 보기</a>
                      </div> -->
                      <!-- Load More  -->
                    </div>
                  </div>
                  <div class="fourth-content" id="questions">
                    <div class="fourth-content-inner-wrapper">
                      <h2 class="fourth-title">자주묻는질문</h2>
                      <!-- Accordion Section  -->
                      <div class="naccordion-section">
                        <div class="accordion myaccordion" id="accordionExample">
                          @if($consulting->qa)
                          @foreach ($consulting->qa as $qa)
                          <div class="accordion-item naccordion-item">
                            <h2 class="accordion-header" id="heading{{$qa->id}}">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$qa->id}}" aria-expanded="false" aria-controls="collapse{{$qa->id}}">
                                {{$qa->question}}
                              </button>
                            </h2>
                            <div id="collapse{{$qa->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$qa->id}}" data-bs-parent="#accordionExample">
                              <div class="accordion-body">
                                <p>
                                  {{$qa->answer}}
                                </p>
                              </div>
                            </div>
                          </div>
                          @endforeach
                          @endif
                        </div>
                      </div>
                      <!-- Accordion Section  -->
                      <div class="fourth-baner-section">
                        <h3>원하시는 답이 없으신가요?</h3>
                        <a href="{{ url('contact-us') }}">문의하기</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="bottom-content-inner-right">
              <h3>기업정보</h3>
              <!-- Info Box  -->
              <div class="infoo-box">
                <p>최고 경영자</p>
                <h5>{{ $consulting->ceo_name }}</h5>
              </div>
              <div class="infoo-box">
                <p>설립일</p>
                <h5>{{ $consulting->founding_date }}</h5>
              </div>
              <div class="infoo-box">
                <p>자본금</p>
                <h5>{{ $consulting->capital }}</h5>
              </div>
              <div class="infoo-box">
                <p>총 발행 주식 수</p>
                <h5>{{ $consulting->total_shares }}</h5>
              </div>
              <div class="infoo-box">
                <p>통일주권 발행 유무</p>
                <h5>{{ $consulting->unified_stocks }}</h5>
              </div>
              <!-- Info Box  -->

              <!-- Keyword Box  -->
              <div class="keyword-box">
                <h6>키워드</h6>
                <div class="keyword-wrapper">
                  @if($consulting->keyword)
                  @php
                  $keywords = explode(",", $consulting->keyword);
                  @endphp
                  @foreach ($keywords as $keyword)
                  <p class="first-key">{{ $keyword }}</p>
                  @endforeach
                  @endif
                </div>
              </div>
              <!-- Keyword Box  -->

              <!-- Link Box  -->
              <div class="link-box">
                <a href="{{ $consulting->company_website }}" class="first-link">
                  <span>회사 홈페이지</span>
                  <span class="righttxt">바로가기</span>
                </a>
                <a href="{{ url('newsroom') }}" class="second-link">
                  <span class="lefttxt">보도자료</span>
                  <span>확인하기</span>
                </a>
              </div>
              <!-- Link Box  -->

              <!-- Graph Box  -->
              <div class="graph-box">
                <h3>주주구성</h3>
                <div class="graph-wrapper">
                  <canvas id="myChart" width="250" height="210" aria-label="chart" role="img"></canvas>
                </div>
                <div class="graph-percent-wrapper">
                  <?php
                  $shareholder_color = [];
                  $shareholder_percent = []; ?>
                  @if($consulting->shareholders)
                  @foreach ($consulting->shareholders as $key => $shareholder)
                  <?php $color = str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT); ?>
                  <div class="graph-percent-inner">
                    <p class="first-percent shareholder-<?php echo $key; ?>">{{ $shareholder->ceo }}</p>
                    <span>{{ $shareholder->percent }}%</span>
                  </div>
                  <style>
                    .shareholder-<?php echo $key; ?>::after {
                      background: <?php echo '#' . $color; ?> !important;
                    }
                  </style>
                  <?php
                  $shareholder_color[] = '"#' . $color . '"';
                  $shareholder_percent[] = $shareholder->percent;
                  ?>
                  @endforeach
                  @endif
                </div>
              </div>
              <!-- Graph Box  -->

              <!-- Document  -->
              <div class="document-wrapper">
                <h2>참고자료</h2>
                <ul class="pdf-document">
                  @if($consulting->attachment)
                  @foreach ($consulting->attachment as $key => $attachment)
                  <li style="cursor: default">
                    <a href="{{ $attachment->attachment }}" style="display: block; text-decoration: none">
                      <img src="{{ asset ('website/assets/images/copy.svg') }}" alt="" />
                      <span>{{ $attachment->name }}</span>
                    </a>
                  </li>
                  @endforeach
                  @endif
                </ul>
                <ul class="lte">
                  <li>
                    <span>3G/LTE 네트워크 환경에서 다운로드 시 과도한 데이터
                      요금이 부과될 수 있습니다.</span>
                  </li>
                </ul>
              </div>
              <!-- Document  -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bottom Section  -->


  <!-- Footer  -->

  <div class="myfooter">
    <div class="mycontainer">
      <div class="footer-inner">
        <div class="left-section">
          <div class="logo">
            <a href="/"><img src="{{ asset ('website/assets/images/logo-white.svg') }}" alt="" /></a>
          </div>
          <p class="top">
            상장예정기업 전문 컨설팅 기업<br />
            (주)세븐스톡 홀딩스
          </p>
          <p class="bottom">
            대표자 : 송영봉 | 사업자 등록번호 : 109-86-46874<br />통신판매업신고번호
            : 제2016 서울 강남 0411호
          </p>
          <span><img src="{{ asset ('website/assets/images/phonefooter.svg') }}" alt="" />&nbsp;
            <span id="footerphone">02-529-1001</span></span>
          <div class="popupphone" id="popupphone">
            <span class="fpopuptext" id="fpopuptext">copied</span>
          </div>
        </div>
        <div class="right-section">
          <div class="left">
            <h2>상담이 필요하신가요?</h2>
            <p>
              성함과 핸드폰 번호를 남겨주시면<br />
              빠른 시일 내에 연락 드리도록 하겠습니다.
            </p>
          </div>
          <div class="right">
            @include('website.layouts.partials.footer-mini-contact-form')
            <!-- 투자자 -->
            <!-- 기업 -->
          </div>
        </div>
      </div>
      <div class="footer-bottom copyright-border">
        <div class="left">
          <ul>
            <li><a href="#" class="white-16-100">이용약관</a></li>
            <li>
              <a href="#" class="white-16-100">개인정보 취급방식</a>
            </li>
            <li><a href="#" class="white-16-100">회사소개서</a></li>
          </ul>
        </div>

        <div class="right">
          <p class="white-16-100">
            Copyright © 2021 Sevenstock Holdings Inc. All rights are
            reserved.
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Back to top  -->
  <button onclick="topFunction()" id="toTopBtn" class="contoTopBtn" title="Go to top">
    <img src="{{ asset ('website/assets/images/fast-forward.svg') }}" alt="Arrow up" />
  </button>
  <!-- Back to top  -->
  <div class="mphone-outside-wrapper">
    <div class="n-container">
      <div class="mobilephone-wrapper">
        <a href="tel:832 939 8280"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp; 02-529-1001</a>
      </div>
    </div>
  </div>

  <script src="{{ asset('website/js/chart.js') }}"></script>
  <script>
    //   Consulting page button
    let business = document.getElementById("business-link");
    let consulting = document.getElementById('consulting-link');
    let news = document.getElementById('news-link');
    let questions = document.getElementById('questions-link');

    // Select Consulting page button
    let selectbusiness = document.getElementById("select-business-link");
    let selectconsulting = document.getElementById('select-consulting-link');
    let selectnews = document.getElementById('select-news-link');
    let selectquestions = document.getElementById('select-questions-link');

    //   Consulting page content
    let business_content = document.getElementById("business-introduction");
    let consulting_content = document.getElementById('consulting');
    let news_content = document.getElementById('news');
    let questions_content = document.getElementById('questions');

    business.addEventListener('click', function() {
      business_content.style.display = "block";
      consulting_content.style.display = "none";
      news_content.style.display = "none";
      questions_content.style.display = "none";
    });
    consulting.addEventListener('click', function() {
      consulting_content.style.display = "block";
      business_content.style.display = "none";
      news_content.style.display = "none";
      questions_content.style.display = "none";
    });
    news.addEventListener('click', function() {
      news_content.style.display = "block";
      business_content.style.display = "none";
      consulting_content.style.display = "none";
      questions_content.style.display = "none";
    });
    questions.addEventListener('click', function() {
      questions_content.style.display = "block";
      business_content.style.display = "none";
      consulting_content.style.display = "none";
      news_content.style.display = "none";
    });
    //   Consulting page


    // Seelect Consulting page
    selectbusiness.addEventListener('click', function() {
      business_content.style.display = "block";
      consulting_content.style.display = "none";
      news_content.style.display = "none";
      questions_content.style.display = "none";
    });
    selectconsulting.addEventListener('click', function() {
      consulting_content.style.display = "block";
      business_content.style.display = "none";
      news_content.style.display = "none";
      questions_content.style.display = "none";
    });
    selectnews.addEventListener('click', function() {
      news_content.style.display = "block";
      business_content.style.display = "none";
      consulting_content.style.display = "none";
      questions_content.style.display = "none";
    });
    selectquestions.addEventListener('click', function() {
      questions_content.style.display = "block";
      business_content.style.display = "none";
      consulting_content.style.display = "none";
      news_content.style.display = "none";
    });
    // Seelect Consulting page

    // Select Menu
    var selectField = document.getElementById("selectField");
    var selectText = document.getElementById("selectText");
    var options = document.getElementsByClassName("options");
    var list = document.getElementById("ul-list");
    var arrowIcon = document.getElementById("arrowIcon");

    selectField.onclick = function() {
      list.classList.toggle("select-hide");
      arrowIcon.classList.toggle("rotateicon");
    }
    for (option of options) {
      option.onclick = function() {
        selectText.innerHTML = this.textContent;
        list.classList.toggle("select-hide");
        arrowIcon.classList.toggle("rotateicon");
      }
    }
    // Footer phone copy
    var fphone = document.getElementById("footerphone");
    var fpopuptext = document.getElementById("fpopuptext");
    fphone.addEventListener("click", () => {
      fpopuptext.classList.add('popactive');
      copyToclipboard();
    });
    fpopuptext.addEventListener("animationend", () => {
      fpopuptext.classList.remove('popactive');
    });

    function copyToclipboard() {
      const textrea = document.createElement("textarea");
      textrea.setAttribute("readonly", "");
      textrea.style.position = 'absolute';
      textrea.value = fphone.innerText;
      document.body.appendChild(textrea);
      textrea.select();
      document.execCommand('copy');
      document.body.removeChild(textrea);
    }
    // Footer phone copy





    // Chart
    var ctx = document.getElementById("myChart").getContext("2d");
    // Creating Chart Class Object
    var myChart = new Chart(ctx, {
      // Type of Chart - bar, line, pie, doughnut, radar, polarArea
      type: "doughnut",

      // The data for our dataset
      data: {
        // Data Labels
        // labels: ["Python", "JavaScript", "PHP", "Java", "C#", "C++"],

        datasets: [
          // Data Set 1
          {
            //  Chart Label
            label: "Chart",

            // Actual Data
            data: [<?php echo implode(",", $shareholder_percent); ?>],

            // Background Color
            backgroundColor: [
              <?php echo implode(",", $shareholder_color); ?>
            ],

            // Border Color
            borderColor: [
              <?php echo implode(",", $shareholder_color); ?>
            ],

            // Border Width
            borderWidth: 0,
            spacing: 3,
          },

          // Data Set 2
          // {
          //   //  Chart Label
          //   label: "Framework",

          //   // Actual Data
          //   data: [10, 8, 3, 7, 8, 9],

          //   // Background Color
          //   backgroundColor: [
          //     "rgba(255, 97, 132, 0.2)",
          //     "rgba(54, 16, 235, 0.2)",
          //     "rgba(255, 26, 86, 0.2)",
          //     "rgba(75, 12, 192, 0.2)",
          //     "rgba(153, 2, 255, 0.2)",
          //     "rgba(255, 19, 64, 0.2)",
          //   ],
          // },
        ],
      },

      // Configuration options go here
      options: {
        // Set Responsiveness By Default Its True
        // When Its True Canvas Width Height won't work
        responsive: false,

        // Set Padding
        layout: {
          padding: {
            left: 72,
            right: 0,
            top: 0,
            bottom: 0,
          },
        },

        // Configure ToolTips
        tooltips: {
          enabled: true, // Enable/Disable ToolTip By Default Its True
          backgroundColor: "red", // Set Tooltip Background Color
          titleFontFamily: "Noto Sans KR", // Set Tooltip Title Font Family
          titleFontSize: 30, // Set Tooltip Font Size
          titleFontStyle: "bold italic",
          titleFontColor: "yellow",
          titleAlign: "center",
          titleSpacing: 3,
          titleMarginBottom: 50,
          bodyFontFamily: "Noto Sans KR",
          bodyFontSize: 20,
          bodyFontStyle: "italic",
          bodyFontColor: "black",
          bodyAlign: "center",
          bodySpacing: 3,
        },

        // Custom Chart Title
        title: {
          display: true,
          text: "Custom Chart Title",
          position: "bottom",
          fontSize: 25,
          fontFamily: "Comic Sans MS",
          fontColor: "red",
          fontStyle: "bold italic",
          padding: 20,
          lineHeight: 5,
        },

        // Legends Configuration
        legend: {
          display: false,
          position: "bottom", // top left bottom right
          align: "end", // start end center
          labels: {
            fontColor: "red",
            fontSize: 16,
            boxWidth: 20,
          },
        },

        animation: {
          duration: 2000,
          easing: "easeInOutCubic",
        },

        // We have Three Events - events which take string array, onHover and Onclick which take function
        // Example of events
        // This chart will not respond to mousemove, etc
        // mousemove, mouseout, click, touchstart, touchmove
        // events: ["click"],

        // onClick Example
        // onClick: function () {
        //   console.log("On Click");
        // },

        // onHover Example - It will work
        // onHover: function () {
        //   console.log("On Hover");
        // },
      },
    });

    // Chart
  </script>
  <style>
    .top-section-wrapper .top-section-inner-wrapper .top-section-inner-left h2::after {
      background: url(<?php echo $consulting->icon_inner ?>) no-repeat center center;
      background-size: cover;
    }

    .top-section-wrapper .top-section-inner-wrapper .top-section-inner-right .top-right-list-box p {
      padding-left: 40px;
    }

    .top-section-wrapper .top-section-inner-wrapper .top-section-inner-right .top-right-list-box p::after {
      display: none;
    }

    .big-graph .new-graph {
      position: relative;
    }

    .big-graph .new-graph .point {
      position: relative;
      max-width: 124px;
    }

    .big-graph .new-graph .point .point-top {
      z-index: 9;
      position: relative;
      background: #E9E9F1;
      border: 1px solid #838291;
      box-sizing: border-box;
      border-radius: 8px;
      text-align: right;
      padding: 0px 10px 10px 10px;
      width: 124px;
      height: 61px;
    }

    @media (max-width: 600px) {
      .big-graph .new-graph .point .point-top {
        height: 58px;
        width: 110px;
      }
    }

    @media (max-width: 560px) {
      .big-graph .new-graph .point .point-top {
        height: 48px;
        width: 85px;
        padding: 0px 5px 5px 5px;
      }
    }

    @media (max-width: 425px) {
      .big-graph .new-graph .point .point-top {
        width: 78px;
      }
    }

    .big-graph .new-graph .point .point-top h6 {
      font-weight: 500;
      font-size: 12px;
      line-height: 26px;
      text-align: right;
      color: #2A263C;
      margin-bottom: 0;
    }

    .big-graph .new-graph .point .point-top h2 {
      font-style: normal;
      font-weight: 500;
      font-size: 20px;
      line-height: 26px;
      text-align: right;
      color: #2A263C;
      margin-bottom: 0;
    }

    @media (max-width: 600px) {
      .big-graph .new-graph .point .point-top h2 {
        font-size: 16px;
      }
    }

    @media (max-width: 560px) {
      .big-graph .new-graph .point .point-top h2 {
        font-size: 15px;
        line-height: 10px;
      }
    }

    @media (max-width: 425px) {
      .big-graph .new-graph .point .point-top h2 {
        font-size: 14px;
      }
    }

    .big-graph .new-graph .point .point-top .tringle .triangleimag {
      width: 21px !important;
      height: 11px !important;
      position: absolute;
      left: 50%;
      top: 100%;
      transform: translateX(-50%);
    }

    .big-graph .new-graph .point .dashline .dash-image {
      width: 1px !important;
      position: absolute;
      left: 50%;
      top: 67px;
      z-index: 1;
      transform: translateX(-50%);
    }

    @media (max-width: 560px) {
      .big-graph .new-graph .point .dashline .dash-image {
        top: 50px;
      }
    }

    .big-graph .new-graph .point .red-dot {
      width: 20px;
      height: 20px;
      background: #B92727;
      box-shadow: 0px 0px 15px #000000;
      border-radius: 55px;
      margin: 40px auto 0 auto;
    }

    @media (max-width: 560px) {
      .big-graph .new-graph .point .red-dot {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        margin: 30px auto 0 auto;
      }
    }

    .big-graph .new-graph #point1 {
      position: absolute;
      left: 210px;
      top: 237px;
    }

    @media (max-width: 1280px) {
      .big-graph .new-graph #point1 {
        left: 185px;
        top: 207px;
      }
    }

    @media (max-width: 1152px) {
      .big-graph .new-graph #point1 {
        left: 145px;
        top: 156px;
      }
    }

    @media (max-width: 1024px) {
      .big-graph .new-graph #point1 {
        left: 226px;
        top: 260px;
      }
    }

    @media (max-width: 800px) {
      .big-graph .new-graph #point1 {
        left: 148px;
        top: 161px;
      }
    }

    @media (max-width: 600px) {
      .big-graph .new-graph #point1 {
        left: 114px;
        top: 111px;
      }
    }

    @media (max-width: 560px) {
      .big-graph .new-graph #point1 {
        left: 126px;
        top: 133px;
      }
    }

    @media (max-width: 480px) {
      .big-graph .new-graph #point1 {
        left: 95px;
        top: 90px;
      }
    }

    @media (max-width: 425px) {
      .big-graph .new-graph #point1 {
        left: 83px;
        top: 72px;
      }
    }

    @media (max-width: 414px) {
      .big-graph .new-graph #point1 {
        left: 72px;
        top: 61px;
      }
    }

    .big-graph .new-graph #point2 {
      position: absolute;
      left: 365px;
      top: 158px;
    }

    @media (max-width: 1280px) {
      .big-graph .new-graph #point2 {
        left: 330px;
        top: 130px;
      }
    }

    @media (max-width: 1152px) {
      .big-graph .new-graph #point2 {
        left: 270px;
        top: 90px;
      }
    }

    @media (max-width: 1024px) {
      .big-graph .new-graph #point2 {
        left: 385px;
        top: 180px;
      }
    }

    @media (max-width: 800px) {
      .big-graph .new-graph #point2 {
        left: 275px;
        top: 90px;
      }
    }

    @media (max-width: 600px) {
      .big-graph .new-graph #point2 {
        left: 215px;
        top: 53px;
      }
    }

    @media (max-width: 560px) {
      .big-graph .new-graph #point2 {
        left: 215px;
        top: 90px;
      }
    }

    @media (max-width: 480px) {
      .big-graph .new-graph #point2 {
        left: 177px;
        top: 47px;
      }
    }

    @media (max-width: 425px) {
      .big-graph .new-graph #point2 {
        left: 160px;
        top: 30px;
      }
    }

    @media (max-width: 414px) {
      .big-graph .new-graph #point2 {
        left: 140px;
        top: 25px;
      }
    }

    .big-graph .new-graph #point3 {
      position: absolute;
      left: 475px;
      top: 25px;
    }

    @media (max-width: 1280px) {
      .big-graph .new-graph #point3 {
        left: 270px;
        top: 7px;
      }
    }

    @media (max-width: 1152px) {
      .big-graph .new-graph #point3 {
        left: 350px;
        top: -10px;
      }
    }

    @media (max-width: 1024px) {
      .big-graph .new-graph #point3 {
        left: 515px;
        top: 24px;
      }
    }

    @media (max-width: 800px) {
      .big-graph .new-graph #point3 {
        left: 355px;
        top: -8px;
      }
    }

    @media (max-width: 600px) {
      .big-graph .new-graph #point3 {
        left: 280px;
        top: -22px;
      }
    }

    @media (max-width: 560px) {
      .big-graph .new-graph #point3 {
        left: 288px;
        top: 2px;
      }
    }

    @media (max-width: 480px) {
      .big-graph .new-graph #point3 {
        left: 230px;
        top: -18px;
      }
    }

    @media (max-width: 425px) {
      .big-graph .new-graph #point3 {
        left: 197px;
        top: -20px;
      }
    }

    @media (max-width: 414px) {
      .big-graph .new-graph #point3 {
        left: 182px;
        top: -25px;
      }
    }

    .big-graph .new-graph #point4 {
      position: absolute;
      left: 628px;
      top: -70px;
    }

    @media (max-width: 1280px) {
      .big-graph .new-graph #point4 {
        left: 565px;
        top: -74px;
      }
    }

    @media (max-width: 1152px) {
      .big-graph .new-graph #point4 {
        left: 466px;
        top: -79px;
      }
    }

    @media (max-width: 1024px) {
      .big-graph .new-graph #point4 {
        left: 668px;
        top: -67px;
      }
    }

    @media (max-width: 800px) {
      .big-graph .new-graph #point4 {
        left: 473px;
        top: -80px;
      }
    }

    @media (max-width: 600px) {
      .big-graph .new-graph #point4 {
        left: 375px;
        top: -82px;
      }
    }

    @media (max-width: 560px) {
      .big-graph .new-graph #point4 {
        left: 387px;
        top: -61px;
      }
    }

    @media (max-width: 480px) {
      .big-graph .new-graph #point4 {
        left: 306px;
        top: -66px;
      }
    }

    @media (max-width: 425px) {
      .big-graph .new-graph #point4 {
        left: 272px;
        top: -66px;
      }
    }

    @media (max-width: 414px) {
      .big-graph .new-graph #point4 {
        left: 247px;
        top: -66px;
      }
    }
  </style>
  @endsection