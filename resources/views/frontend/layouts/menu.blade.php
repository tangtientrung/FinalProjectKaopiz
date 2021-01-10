<div class="container d-flex align-items-center">

      <nav class="nav-menu d-none d-lg-block">

        <ul>
          <li class="active"><a href="/">Trang chủ</a></li>
          @foreach($category as $c)
          
          <li 
          @if(count($c->sub_category)>0)
          {{"class=drop-down"}}
          @endif
          ><a href="/danh-muc/{{$c->slug_category}}">{{$c->category_name}}</a> 
            <ul>
              @foreach($c->sub_category as $cd)
              <li><a href="/danh-muc/{{$c->slug_category}}/{{$cd->slug_sub_category}}">{{$cd->sub_category_name}}</a></li>
              @endforeach
            </ul>
          </li>
          
          
          @endforeach
          <li style="margin-left: 600px"><div >
            <div class="search_box pull-right">
              <form action="/tim-kiem" method="get" autocomplete="off">
                @csrf
                <input type="text" name="search" placeholder="Tìm kiếm..." value="{{ old('search') }}"/>
              </form>
              
            </div>
          </div>
        </li>
        </ul>
        
      </nav><!-- .nav-menu -->
    </div>