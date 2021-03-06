@extends('master_layout.master_page_layout')
@section('content')
	 <!--start container-->
   	<div class="container">
      	<div id="invoice">
         	<div class="invoice-header">
            	<div class="row section">
               		<div class="col s12 m6 l6">
                  		<img class="invoice-logo" src="{{ URL::asset('images/a1-logo.png')}}" alt="company logo">
                  		<p>To,
	                     	<br>
	                     	<span class="strong"><a href="{{route('students.show',$invoice->student_id)}}">{{$invoice->studentInfo->stud_first_name}}&nbsp;{{$invoice->studentInfo->stud_last_name}}</a></span>
	                     	<br>
	                     	<span>{{$invoice->studentInfo->stud_address}}</span>
	                     	<br>
	                     	<span>{{$invoice->studentInfo->stud_mobile_no}}</span>
                  		</p>
               		</div>
               		<div class="col s12 m6 l6">
                  		<div class="invoce-company-address right-align">
                     		<span class="invoice-icon"><i class="mdi-social-location-city cyan-text"></i></span>
                 			<p>
                 				<span class="strong">A1 Driving School</span>
                        		<br>
                        		<span>A-1 Driving Bldg</span>
                        		<br>
                        		<span>#2 Sta. Lucia St., 1550</span>
                        		<br>
                        		<span>+63 (2) 532.2272</span>
                 			</p>
                  		</div>
                  		<div class="invoce-company-contact right-align">
                     		<span class="invoice-icon"><i class="mdi-communication-quick-contacts-mail cyan-text"></i></span>
                    	 	<p>
                          <span class="strong">www.a-1driving.com</span>
                            <br/>
                            <span>info@a-1driving.com</span>
                        </p>
                  		</div>
               		</div>
            	</div>
         	</div>
        	<div class="invoice-lable">
            	<div class="row">
               		<div class="col s12 m3 l3 red darken-2">
                  		<h4 class="white-text invoice-text">INVOICE</h4>
               		</div>
               		<div class="col s12 m9 l9 invoice-brief grey darken-4 white-text">
                  		<div class="row">
                     		<div class="col s12 m3 l3">
                       	 		<p class="strong">Total Due</p>
                        		<h4 class="header">₱ {{number_format($invoice->total_amount,2,'.',',')}}</h4>
                     		</div>
                     		<div class="col s12 m3 l2">
                        		<p class="strong">Invoice No</p>
                        		<!-- <h4 class="header">#{{sprintf("%'.07d\n", $invoice->id)}}</h4> -->
								<h4 class="header">INV-{{strtoupper(substr(md5($invoice->id), 0, 5))}}</h4>
                     		</div>
                     		<!-- <div class="col s12 m3 l4">
                        		<p class="strong">Due Date</p>
                        		<h4 class="header">{{date('d F, Y',strtotime($invoice->payment_due_date))}}</h4>
                     		</div> -->
                  		</div>
               		</div>
            	</div>
         	</div>
         	<div class="invoice-table">
            	<div class="row">
               		<div class="col s12 m12 l12">
                  		<table class="striped">
                     		<thead>
                        		<tr>
                           			<th data-field="item">Item</th>
                           			<th data-field="price">Total</th>
                        		</tr>
                     		</thead>
                     		<tbody>
							@php ($invoiceTotal = 0)
                     			@foreach($invoice->invoiceItemsInfo as $invoiceItem)
                        		<tr>
                           			<td>{{$invoiceItem->item->item_name}}</td>
                           			<td>{{number_format($invoiceItem->amount,2,'.',',')}}</td>
                        		</tr>
									@php ($invoiceTotal += $invoiceItem->amount)
                        		@endforeach
								<tr>
									<td class="grey darken-4 white-text">Subtotal</td>
									<td class="grey darken-4 strong white-text">₱ {{ number_format($invoiceTotal, 2, '.', ',') }}</td>
								</tr>
								<tr>
									<td class="grey darken-4 white-text">Discount</td>
									<td class="grey darken-4 strong white-text">{{ number_format(100 - (($invoice->total_amount / $invoiceTotal) * 100),0) }}%</td>
								</tr>
                        		<tr>
                           			<td class="grey darken-4 white-text">Grand Total</td>
                           			<td class="grey darken-4 strong white-text">₱ {{number_format($invoice->total_amount,2,'.',',')}}</td>
                        		</tr>
                     		</tbody>
                  		</table>
               		</div>
            	</div>
         	</div>
         	<!--div class="invoice-footer">
            	<div class="row">
               		<div class="col s12 m6 l6">
                  		<p class="strong">Payment Method</p>
                  		<p>Please make the cheque to: AMANDA ORTON</p>
                  		<p class="strong">Terms &amp; Condition</p>
                  		<ul>
                     		<li>You know, being a test pilot isn't always the healthiest business in the world.</li>
                     		<li>We predict too much for the next year and yet far too little for the next 10.</li>
                  		</ul>
               		</div>
               		<div class="col s12 m6 l6 center-align">
                  		<p>Approved By</p>
                  		<img src="../images/signature-scan.png" alt="signature">
                  		<p class="header">AMANDA ORTON</p>
                  		<p>Managing Director</p>
               		</div>
            	</div>
         	</div-->
          <div class="row">
            <div class="input-field col s12">
              {!! Form::open(['url'=>'pdf','method'=>'POST','target'=>'_blank','class'=>'col s12']) !!}
                @include('pdf.pdf_form',['category'=>'invoice','recordId'=>$invoice->id])
              {!! Form::close() !!}
            </div>
          </div>
          
      	</div>
    </div>

    <!-- Floating Action Button -->
    <div class="fixed-action-btn" style="bottom: 50px; right: 19px;">
        <a href="{{route('invoice.receipt.create',$invoice->id)}}" class="btn-floating btn-large red darken-2">
         	<i class="material-icons">receipt</i>
        </a>
        <ul>
        	<!--li><a href="app-widget.html" class="btn-floating red darken-2" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px) translateX(0px); opacity: 0;"><i class="large mdi-action-lock"></i></a></li-->
         </ul>
    </div>
     <!-- Floating Action Button -->
@endsection