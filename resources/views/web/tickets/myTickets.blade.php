@extends('web.layout')
 <?php
    use \App\Constants\TicketStatus;
 ?>
@section('content')   
    <section class="support controlpnal">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="tabscontrol">
                        <h2 class="text-center">لوحة التحكم</h2>
                        <ul class="tabs2 list-unstyled">
                            <li class="tab1 "><a class="" href="controlPanel.html"><img src="Images/Icons/favorite_red.png"
                                        alt="">المفضلة</a></li>
                            <li class="tab2 "><a class="" href="myorders.html"><img src="Images/Icons//my_orders_green.png"
                                        alt="">طلباتي</a></li>
                            <li class="tab3"><a class="" href="myshipping.html"><img src="Images/Icons/my_shipping_blue.png"
                                        alt="">بيانات
                                    الشحن</a></li>
                            <li class="tab4 "><a class="" href="mypayment.html"><img src="Images/Icons/my _payments_yallow.png.png"
                                        alt="">بطاقاتي</a></li>
                            <li class="tab5 active5"><a class="" href="#"><img src="Images/Icons/my_reports_white.png"
                                        alt="">البلاغات</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <!--  -->
                    <div class="head-support">
                        <div class="row">
                            <div class="col-lg-9">
                                <h3>{{ trans('tickets') }}</h3>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-block btn-support" data-toggle="modal" data-target="#report">{{ trans('new_ticket') }}</button>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="report" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                 
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="text-center">{{ trans('report_ticket') }}</h5>
                                            </div>
                                            <div class="col-12">
                                                <form>
                                                   <div class="row">
                                                       <div class="col-12">
                                                          <div class="check">
                                                                <input class="check2" type="checkbox">
                                                                <label>بخصوص متجر</label>
                                                          </div>
                                                       </div>
                                                       <div class="col-12">
                                                           <select name="" id="">
                                                               <option>المتجر</option>
                                                           </select>
                                                       </div>
                                                       <div class="col-12">
                                                           <input class="btn-block" type="text" placeholder="سبب المشكلة">
                                                       </div>
                                                       <div class="col-12">
                                                          <textarea class="btn-block" placeholder="توضيح"></textarea>
                                                        </div>
                                                   </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      
                                        <button type="button" class="btn btn-block btn-report"> ارسل</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  -->
                    <div class="support-table">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="head" scope="col">{{ trans('ticket_id') }}</th>
                                    <th class="head" scope="col">{{ trans('ticket_title') }}</th>
                                    <th class="head" scope="col">{{ trans('ticket_date') }}</th>
                                    <th class="head" scope="col">{{ trans('tickets') }}</th>
                                    <th class="head" scope="col">{{ trans('assignee') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $ticket)
                                <tr>
                                    <th scope="row">{{ $ticket->id }}</th>
                                    <td class="head"><p onclick='return details(this,{{$ticket->id}}, "{{$ticket->title}}","{{$ticket->description}}","{{$ticket->created_at}}", "{{$ticket->assignee->name}}", {{$ticket->status}})' >{{ $ticket->title }}</p></td>
                                    <td>{{ $ticket->created_at }}</td>
                                    <td><span class="{{ $ticket->status == 1 ? 'wiat' : 'done' }}">{{ $ticket->status == 1 ?  trans('pending')  :  trans('resolved')  }}</span></td>
                                    <td>{{ $ticket->assignee->name }}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <hr>

                     <div class="first-ticket">
                        <table class="table">
                            <thead>
                                <tr>
                                    
                                   <!--  <th class="head2" colspan="5">المتجر :لوريم إيبسوم</th> -->
                                    <th class="done text-left "><th class="done text-left"> {{ $list[0]['created_at'] }}</th></th>
                                </tr>
                            </thead>
                        </table>
                        <div class="support-content">
                            <div class="row">
                                <div class="col-12">
                                    <h3>{{ $list[0]['title'] }}</h3>
                                    <p>{{ $list[0]['description'] }}</p>
                                </div>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="">{{ $list[0]['id'] }}</th>
                                    <th class="head">{{ $list[0]['title'] }}</th>
                                    <th class="">{{ $list[0]['created_at'] }}</th>
                                    <th class="{{ $ticket->status ==  TicketStatus::PENDING  ? 'wiat' : 'done' }}">{{ $ticket->status ==  TicketStatus::PENDING  ?  trans('pending')  :  trans('resolved')  }}</th>

                                    <th class="">{{ $list[0]->assignee['name'] }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Tish table appear when the user click on ticket -->
                        <table class="table">
                            <thead>
                                <tr>
                                    
                                   <!--  <th class="head2" colspan="5">المتجر :لوريم إيبسوم</th> -->
                                    <th class="done text-left "><span class="created_at"></span></th>
                                </tr>
                            </thead>
                        </table>
                        <div class="support-content">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="title"></h3>
                                    <p  class="description"></p>
                                </div>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="id"></th>
                                    <th class="head title"></th>
                                    <th class="created_at"></th>
                                    <th class="status"></th>
                                    <th class="assignee"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>
    @stop
<script type="text/javascript">

function details(obj, id, title, description, created_at, assignee, status) {
    $('.first-ticket').hide();
    $('.id').html(id);
    $('.title').html(title);
    $('.description').html(description);
    $('.created_at').html(created_at);
    // $('.status').html(status);
    $('.assignee').html(assignee);
    if(status =='{{ TicketStatus::PENDING }}'){
      $('.status').html(status).addClass('wiat');
    }else{
       $('.status').html(status).addClass('done'); 
    }
}
</script>


