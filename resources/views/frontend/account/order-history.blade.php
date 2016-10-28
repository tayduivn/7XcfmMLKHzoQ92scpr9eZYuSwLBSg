@extends('frontend.layout')
@include('frontend.partials.meta')
@section('header')
    @include('frontend.partials.main-header')
    @include('frontend.partials.home-menu')
  @endsection
@section('content')
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <div class="breadcrumb clearfix">
            <a class="home" href="{{ route('home') }}" title="Trở về trang chủ">Trang chủ</a>
            <span class="navigation-pipe">&nbsp;</span>
            <a href="" title="Đơn hàng của tôi">Đơn hàng của tôi</a>
        </div>
        <!-- ./breadcrumb -->
        <div class="row">
            <div class="col-sm-3" id="left_column">
              <!-- block category -->
                  <div class="block left-module">
                      <p class="title_block">Thông tin tài khoản</p>
                      <div class="block_content">
                          <!-- layered -->
                          <div class="layered layered-category">
                              <div class="layered-content">
                                  <ul class="tree-menu">
                                      <li {{ \Request::route()->getName() == "order-history" ? "class=active" : "" }}>
                                          <a href="{{ route('order-history') }}" title="Đơn hàng của tôi"> Đơn hàng của tôi</a>
                                      </li>
                                      <li>
                                          <a href="{{ route('user-logout') }}" title="Thoát tài khoản">Thoát tài khoản </a>
                                      </li>
                                  </ul>
                              </div>
                          </div>
                          <!-- ./layered -->
                      </div>
                  </div>
                  <!-- ./block category  -->
                  <!-- Banner silebar -->
                  @include('frontend.partials.banner-slidebar')
                  <!-- ./Banner silebar -->
            </div> 
            <div class="center_column col-xs-12 col-sm-9" id="center_column">
                    <h1 class="page-heading">
                        <span class="page-heading-title2">Danh sách đơn hàng của tôi</span>
                    </h1>
                               
                    <div class="dashboard-order have-margin">
                        <table class="table-responsive table table-bordered">
                            <thead>
                            <tr>
                                <th>
                                    <span class="hidden-xs hidden-sm hidden-md">Mã Đơn hàng</span>
                                    <span class="hidden-lg">Code</span>
                                </th>
                                <th>Ngày mua</th>
                                <th>Sản phẩm</th>
                                <th style="text-align:right">Tổng tiền</th>
                                <th>
                                    <span class="hidden-xs hidden-sm hidden-md">Trạng thái đơn hàng</span>
                                    <span class="hidden-lg">Trạng thái</span>
                                </th>
                                <!--                            <th></th>-->
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td style="text-align:center"><a href="/sales/order/view?code=24808316">24808316</a></td>
                                    <td>{{ date('d/m/Y', strtotime($order->created_at)) }}</td>
                                    <td>                                        
                                    @foreach($order->order_detail()->get() as $detail)
                                    
                                    <p>{{ Helper::getName($detail->sp_id, 'san_pham') }}</p>
                                    @endforeach
                                    </td>
                                    <td style="text-align:right">{{ number_format($order->tong_tien) }}&nbsp;₫</td>                                    
                                    <td style="text-align:center">
                                        <span class="order-status">
                                            {{ $status[$order->status] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
        </div><!-- /.page-content -->
    </div>
</div>
<style type="text/css">    
    .dashboard-order.have-margin {
        margin-bottom: 20px;
    }   
    table.table-responsive thead tr th {
        display: table-cell;
        padding: 8px;
        background: #f8f8f8;
        font-weight: 500;    
    }
    table.table-responsive tbody tr td{
        font-size: 14px !important;
    }
</style>
@endsection
<div class='clearfix'></div>
@include('frontend.partials.footer')
@section('javascript')
   <script type="text/javascript">
    $(document).ready(function() {

    });
  </script>
@endsection