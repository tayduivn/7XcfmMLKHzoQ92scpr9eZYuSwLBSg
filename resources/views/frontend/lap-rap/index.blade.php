@extends('frontend.layout')

@section('header')
    @include('frontend.partials.main-header')
    @include('frontend.partials.home-menu')
  @endsection

@include('frontend.partials.meta')
@section('content')
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <div class="breadcrumb clearfix">
            <a class="home" href="#" title="Return to Home">Home</a>
            <span class="navigation-pipe">&nbsp;</span>
            <span class="navigation_page">Tùy chọn cấu hình</span>
        </div>
        <!-- ./breadcrumb -->
        
        <!-- page heading-->
        <h2 class="page-heading">
            <span class="page-heading-title3">Tùy chọn cấu hình : "Máy bộ văn phòng"</span>
        </h2>
        <!-- ../page heading-->
        
        <!-- row -->
        <div class="row page-content buy-product-config">

            <p class="col-xs-12 txt-top"><i class="fa fa-remove"></i> Không có sản phẩn nào tương thích</p>

            <!-- Left colunm -->
            <div class="column col-xs-12 col-sm-3" id="left_column">
                <nav class="nav-choose-config">
                    <ul class="level1">
                        @if($cateList->count() > 0)
                        @foreach($cateList as $cate)
                        <li><a href="javascript:void(0)" class="choose-parent {{ $cate->slug }}" data-slug="{{ $cate->slug }}">{{ $cate->name }}</a></li>
                        @endforeach
                        @endif
                        
                    </ul>
                </nav><!-- ./layered -->
            </div>
            <!-- ./left colunm -->
            <!-- Center colunm-->
            <div class="center_column col-xs-12 col-sm-9" id="center_column">
              <form action="{{ route('mua-lap-rap') }}" method="POST" id="formLapRap">
                @if($cateList->count() > 0)
                @foreach($cateList as $cate)
                <?php $cate_id = $cate->id ;?>       
                <!-- config-list-->
                <div class="choose-config-list {{ $cate->slug }}" style="display:none" >
                    <input type="hidden" id="value-{{ $cate->slug }}" value="0">
                    <h3 class="tit">HÃY CHỌN {{ $cate->name }}</h3>
                    <div class="row header-box hidden-xs">
                        <div class="td col-sm-{{ $cate_id == 35 ? "6" : "9" }}">Sản phẩm</div>
                        @if($cate_id == 35)
                        <div class="td col-sm-3">Số lượng</div>
                        @endif
                        <div class="td col-sm-3 price">Thành tiền</div>
                    </div>
                    <div id="data-{{ $cate->slug }}">
                    <ul class="row" >
                        <li>
                            <div class="col-sm-{{ $cate_id == 35 ? "6" : "9" }} box-name"><label><input type="radio" class="select-lk radio-{{ $cate->slug }}" data-type="{{ $cate->slug }}" name="select[{{ $cate->id }}]"> Không chọn</label></div>
                            @if($cate_id == 35)
                            <div class="col-sm-3 quantity"></div>
                            @endif
                            <div class="col-sm-3 price"></div>
                        </li>
                        @if(isset($spFreeList[$cate_id]))
                        @foreach($spFreeList[$cate_id] as $sp)
                        <?php 
                        $price = $sp->is_sale == 1 && $sp->price_sale  > 0 ? $sp->price_sale : $sp->price;
                        ?>
                        <li>
                            <div class="col-sm-{{ $cate_id == 35 ? "6" : "9" }} box-name"><label><input type="radio" class="select-lk radio-{{ $cate->slug }}" data-type="{{ $cate->slug }}" name="select[{{ $cate->id }}]" value="{{ $sp->id }}"> {{ $sp->name }}</label></div>
                            @if($cate_id == 35)
                            <div class="col-sm-3 clearfix quantity">
                                <p class="txt-name hidden-lg">Số lượng:</p>
                                <div class="col-sm-3 clearfix quantity">
                                  <p class="txt-name hidden-lg">Số lượng:</p>
                                  
                                  <select class="form-control" style="width:70px;margin:auto">
                                      <option>
                                        0
                                      </option>

                                  </select>                                
                              </div>
                            </div>
                            @endif
                            <div class="col-sm-3 clearfix price">
                                <p class="txt-name hidden-lg">Giá:</p>
                                <span class="txt-num">{{ number_format($price) }} đ</span>
                            </div>
                        </li>   
                        @endforeach
                        @endif
                                              
                    </ul>
                    </div>
                    <p class="error" style="display:none">Vui lòng chọn 1 mục.</p>
                    <div class="button-group text-center mt10 pb10">
                        <button type="button" class="btn btn-default btn-sm">HỦY</button>
                        <button type="button" class="btn btn-default btn-sm btnOK" data-slug="{{ $cate->slug }}">OK</button>
                    </div>
                </div>
                <!-- ./config-list-->
                @endforeach
                @endif
                <div class="button-group-action">
                    <button type="button" class="btn" id="btnPreview">Xem cấu hình</button>
                  </div>

            </form>
            </div>
            <!-- ./ Center colunm -->
        </div>
        <!-- ./row-->
    </div>
</div>
@endsection

@include('frontend.partials.footer')

@section('javascript')
<script type="text/javascript">	
  $(document).ready(function(){
    $('.choose-config-list').eq(0).show();
    $('.choose-parent').eq(0).addClass('showing')
    $('a.choose-parent').click(function(){
      $('a.choose-parent').removeClass('showing');
      $(this).addClass('showing');
      $('.choose-config-list').hide();
      $('.' + $(this).data('slug')).show();
    });
    $('button.btnOK').click(function(){
      var obj = $('a.showing');      
      obj.parent().next().find('a').addClass('showing').click();
      obj.removeClass('showing');
    });
  });
  $(document).on('ifChecked', '.select-lk', function(){

      var obj = $(this);
      var value = obj.val();
      var type = obj.attr('data-type');
      $('#value-' + type).val(value);
      console.log(type);
      if(value > 0){ // co chon 
        if( type == "mainboard"){
            // get RAM
            if($('#value-ram').val() == 0){
              getRelated(value, 'ram'); 
            }
            if($('#value-card-man-hinh').val() == 0){
              getRelated(value, 'vga'); 
            }
            if($('#value-cpu').val() == 0){
              getRelated(value, 'cpu'); 
            }
        }else if( type == "card-man-hinh"){
            // get RAM
            if($('#value-ram').val() == 0){
              getRelated(value, 'ram'); 
            }
            if($('#value-mainboard').val() == 0){
              getRelated(value, 'vga'); 
            }
            if($('#value-cpu').val() == 0){
              getRelated(value, 'cpu'); 
            }
        }else if( type == "ram"){
            // get RAM
            if($('#value-mainboard').val() == 0){
              getRelated(value, 'ram'); 
            }
            if($('#value-card-man-hinh').val() == 0){
              getRelated(value, 'vga'); 
            }
            if($('#value-cpu').val() == 0){
              getRelated(value, 'cpu'); 
            }
        }else if( type == "cpu"){
            // get RAM
            if($('#value-ram').val() == 0){
              getRelated(value, 'ram'); 
            }
            if($('#value-card-man-hinh').val() == 0){
              getRelated(value, 'vga'); 
            }
            if($('#value-mainboard').val() == 0){
              getRelated(value, 'cpu'); 
            }
        }
      }
    });
  function getRelated(sp_id, type) {
        $.ajax({
          url: "{{route('lay-sp-tuong-thich')}}",
          method: "POST",
          data : {
            sp_id: sp_id,
            type : type,
            _token : "{{ csrf_token() }}"
          },
          success : function(data){
            if(type == "vga"){
              $('#data-card-man-hinh').html(data);
            }else{
              $('#data-' + type).html(data);  
            }
            
            $('input').iCheck({
              checkboxClass: 'icheckbox_square-red',
              radioClass: 'iradio_square-red',
              increaseArea: '20%' // optional
            });
          },
          error : function(e) {
            //alert( JSON.stringify(e));
          }
        });
      }
</script>
@endsection