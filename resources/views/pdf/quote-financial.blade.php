<html>
<head>
    <style>
        .page-break {
            page-break-after: always;
        }
        .pdf-cover-background {
            background-image: url({{asset("/images/cw_pdf_cover.jpg")}});
            height: 920PX;
            width: 1500PX;
            background-position: top;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
        }
        .slide-header {
            background-image: url({{asset("/images/cw_content_header.jpg")}});
            width: 100%;
            height: 130px;
            color: white;
            font-weight: bolder;
            background-position: top;
            background-repeat: no-repeat;
            background-size: 100%;
            position: relative;
        }
        .pdf-end-background {
            background-image: url({{asset("/images/cw_pdf_end.jpg")}});
            height: 920PX;
            width: 1500PX;
            background-position: top;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
        }
        .inquiry_header {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-weight: 600;
        }
        .inquiry_header h2{
            color: #0c283c;
        }
        .inquery-table h4{
            text-transform: capitalize;
            color: #0c283c;
        }
        .vue-form-wizard .wizard-tab-content {
            min-height: 100px;
            padding: 30px 0px !important;
        }
        .inquery-table-header {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .inquery-table .row {
            margin-left: 0px;
            margin-right: 0px;
        }
        .txt-black{
            color: black;
        }
        .card .row span {
            /* margin-top: 20px !important; */
        }
        .card .row span a{
            font-weight: 400;
            font-size: 12px;
        }
        .task-row {
            height: 40px;
            border: none !important;
            border-radius: 0px !important;
        }
        .task-row-card {
            border: none !important;
            border-radius: 0px !important;
            box-shadow: 0px 0px 15px 5px rgba(0,0,0,0.01);
        }
        .task-card-main{
            border: none !important;
            border-radius: 0px !important;
            box-shadow: 0px 0px 15px 5px rgba(0,0,0,0.04);
        }
        .align-center-left {
            display: flex;
            align-items: center;
        }
        .toggle-button:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 0.5px;
            background-color: #FFFFFF;
            transition: 0.4s;
            border-radius: 50%;
            border: 1px solid #36B1E5;
        }
        .vue-form-wizard * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }
        .toggle-button {
            width: 49px;
            height: 21px;
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 35px;
        }
        input:checked + .toggle-button:before {
            transform: translateX(24px);
        }
        .inquiry-selection-card {
            border-radius: 10px !important;
            border: none;
            min-height: 50px;
            background-color: white;
            box-shadow: 0px 0px 15px 5px rgba(0,0,0,0.06);
            justify-content: center;
        }
        .task-row-card {
            border: none !important;
            border-radius: 10px !important;
            box-shadow: 0px 0px 15px 5px rgb(0 0 0 / 1%);
        }
        .finish-button {
            background-color: #66d825 !important;
            border-color: #55b41e !important;
            color: white;
        }
        .small-preant-task{
            display: none;
        }
        .small-module-name{
            display: none;
        }
        .small-inquiry-selection-card{
            display: none;
        }
        .inquiry-selection-card{
            display: block;
        }
        .no-wrap-row{
            flex-wrap: unset !important;
        }
        .no-wrap-row p {
            margin-bottom: 0px !important;
            font-size: 12px;
            width: 100%;
        }
        .list-item-end{
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }
        .list-item-start{
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }
        .no-wrap-row i {
            font-size: 18px !important;
            color: rgb(190, 185, 190);
        }
        .small-task-row-card{
            display: none;
        }
        .task-row-card{
            display: block;
        }
        .list_item_column{
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }
        .completed-automation-text {
            height: 30px !important;
            width: 75px !important;
        }
        .help_popup{
            color: $primary-color !important;
            font-weight: 400 !important;
        }
        .vue-form-wizard.md .wizard-icon-circle {
            width: 50px !important;
            height: 50px !important;
        }
        .vue-form-wizard.md .wizard-navigation .wizard-progress-with-circle {
            top: 30px !important;
        }
        .vue-form-wizard.md .wizard-nav-pills > li.active > a .wizard-icon {
            font-size: 18px !important;
        }
        span.stepTitle {
            margin-top: 14px;
            font-size: 12px;
        }
        .vue-form-wizard .wizard-nav-pills > li > a {
            color: rgb(135 123 123 / 96%) !important;
        }
        .f-9{
            font-size: 9px;
        }
        .vue-form-wizard .wizard-icon-circle {
            border: none !important;
            color: white !important;
            background-color: #ABABAB !important;
        }
        .vue-form-wizard.md .wizard-icon-circle {
            font-size: 18px !important;
        }
        .vue-form-wizard .wizard-icon-circle .wizard-icon-container {
            border-radius: 50% !important;
        }
        .vue-form-wizard .wizard-tab-content {
            padding: 50px 0px !important;
        }
        .full-task-row article{
            background-color: #F4F6FA !important;
            color: #0C283C;
        }
        .full-task-row article:nth-of-type(2n){
            background-color: white !important;
        }
        thead { display: table-row-group !important;}
        /*tfoot { display: table-row-group !important;}*/
        /*tr { page-break-inside: avoid !important;}*/
        @font-face {
            font-family: 'Graphik';
            src: url({{asset("/fonts/graphik/Graphik-Semibold.woff2")}}) format('woff2'),
            url({{asset("/fonts/graphik/Graphik-Semibold.woff2")}}) format('woff');
            font-weight: 600;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Graphik';
            src: url({{asset("/fonts/graphik/Graphik-Regular.woff2")}}) format('woff2'),
            url({{asset("/fonts/graphik/Graphik-Regular.woff")}}) format('woff');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Graphik';
            src: url({{asset("/fonts/graphik/Graphik-Medium.woff2")}}) format('woff2'),
            url({{asset("/fonts/graphik/Graphik-Medium.woff")}}) format('woff');
            font-weight: 500;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Graphik';
            src: url({{asset("/fonts/graphik/Graphik-Light.woff2")}}) format('woff2'),
            url({{asset("/fonts/graphik/Graphik-Light.woff")}}) format('woff');
            font-weight: 300;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Graphik';
            src: url({{asset("/fonts/graphik/Graphik-Extralight.woff2")}}) format('woff2'),
            url({{asset("/fonts/graphik/Graphik-Extralight.woff")}}) format('woff');
            font-weight: 200;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Graphik';
            src: url({{asset("/fonts/graphik/Graphik-Bold.woff2")}}) format('woff2'),
            url({{asset("/fonts/graphik/Graphik-Bold.woff")}}) format('woff');
            font-weight: bold;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Graphik';
            src: url({{asset("/fonts/graphik/Graphik-Black.woff2")}}) format('woff2'),
            url({{asset("/fonts/graphik/Graphik-Black.woff")}}) format('woff');
            font-weight: 900;
            font-style: normal;
            font-display: swap;
        }
        body {
            font-family: 'Graphik' !important;
        }
        table {
            border-collapse: collapse !important;
        }
    </style>
</head>
<body style="width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
{{--    Cover Page--}}
<div class="pdf-cover-background">
    <div>
        <h1 style="padding-left: 180px; color: #0C283C; padding-top: 480px; font-weight: 500; font-size: 50px">Proposal</h1>
        <h1 style="padding-left: 50px; color: #0C283C; font-size: 36px; font-weight: 500">Cargowise One Consultation</h1>
    </div>
    <hr style="color: rgba(241,241,241,0.82); margin-left: 5%; margin-right: 65%;">
    <div style="padding-top: 90px; padding-left: 180px; width: 400px; display: flex; align-items: center">
        <table>
            <tr style="display: flex; align-items: center">
                <td style="color: #0C283C; font-weight: 300; font-size: 25px; text-align: center;">
                    {{ ($quote->client != null) ? $quote->client->name : '' }}
                </td>
            </tr>
            <tr>
                <td style="color: #0C283C; font-weight: 300; font-size: 25px; text-align: center;">
                    {{ ($quote->client != null) ? $quote->client->company->name : '' }}
                </td>
            </tr>
            <tr>
                <td style="color: #0C283C; font-weight: 300; font-size: 25px; text-align: center;">
                    Quotation {{ $quote->reference }}
                </td>
            </tr>
            <tr>
                <td style="color: #0C283C; font-weight: 300; font-size: 25px; text-align: center;">
                    {{ (($quote->enquiry != null)) ?  'Enquiry '.$quote->enquiry : '' }}
                </td>
            </tr>
            <tr>
                <td style="color: #0C283C; font-weight: 300; font-size: 25px; text-align: center;">
                    Valid Till {{ $quote->expires_at }}
                </td>
            </tr>
        </table>
    </div>
    <div class="page-break"></div>
</div>

{{--    First Images page--}}
<div >
    <img src="{{asset("/images/bar-charts-01.jpg")}}" alt="" width="1500px" height="920px">
    <div class="page-break"></div>
</div>

{{--    Second Images Page--}}
<div>
    <img src="{{asset("/images/bar-charts-02.jpg")}}" alt="" width="1500px" height="920px">
    <div class="page-break"></div>
</div>

{{--    process flow page--}}
<div>
    <img src="{{asset("/images/Process-Flow.jpg")}}" alt="" width="1500px" height="920px">
    <div class="page-break"></div>
</div>

{{--    Detailed Breakdown--}}
@php
    $i = 16;
    $productTemp = 0;
    $solutionTemp = 0;
    $projectsTotal = $quote->projects;
@endphp
@foreach($quote->products()->where('status',true)->orderBy('order')->get() as $product)
    @foreach($product->solutions()->where('status',true)->orderBy('order')->get() as $solution)
        @foreach($solution->projects()->where('status',true)->orderBy('order')->get() as $project)
            @if ($i == 16 || $productTemp != $product->id)
                @php
                    $i = 1;
                @endphp
                <div class="page-break"></div>
                <div class="slide-header">
                    <h1 style="padding-top: 50px; padding-left: 50px; font-weight: 500; font-size: 36px;">Detailed Breakdown - {{ $product->name }}</h1>
                </div>
                <div style="padding: 0; margin: 0;">
                    <table  width="100%" style="color: #153147" border="0">
                        <thead>
                        <tr style="height: 80px; background-color: #dcdcdc; font-weight: 400; font-size: 14px; ">
                            <td width="5%">&nbsp;</td>
                            <td width="50%"> SELECTED MODULES / TASKS</td>
                            <td width="20%" style="text-align: center;"> TOTAL HOURS</td>
                            <td width="20%" style="text-align: center;"> COST (USD)</td>
                            <td width="5%">&nbsp;</td>
                        </tr>
                        </thead>
                    </table>
                </div>
                @php
                    $i++;
                @endphp
            @endif
            @if ($solutionTemp != $project->solution->id)
                @if ($i == 15)
                    @php
                        $i = 1;
                    @endphp
                    <div class="page-break"></div>
                    <div class="slide-header">
                        <h1 style="padding-top: 50px; padding-left: 50px; font-weight: 500; font-size: 36px;">Detailed Breakdown - {{ $product->name }}</h1>
                    </div>
                    <div style="padding: 0; margin: 0;">
                        <table  width="100%" style="color: #153147" border="0">
                            <thead>
                            <tr style="height: 80px; background-color: #dcdcdc; font-weight: 400; font-size: 14px; ">
                                <td width="5%">&nbsp;</td>
                                <td width="50%"> SELECTED MODULES / TASKS</td>
                                <td width="20%" style="text-align: center;"> TOTAL HOURS</td>
                                <td width="20%" style="text-align: center;"> COST (USD)</td>
                                <td width="5%">&nbsp;</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    @php
                        $i++;
                    @endphp
                @endif
                <div style="padding: 0; margin: 0;">
                    <table width="100%" style="color: #153147" border="0">
                        <tbody>
                        <tr>
                            <td colspan="7">
                                <table width="100%" style="color: #153147" border="0">
                                    <thead>
                                    <tr>
                                        <table width="100%">
                                            <tbody style="padding-top: 20px;">
                                            <tr>
                                                <td width="5%" style="padding-top: 10px;padding-bottom: 10px">&nbsp;</td>
                                                <td width="50%" style="padding-top: 10px;padding-bottom: 10px; color: black;">{{ $project->solution->name }} (Total)</td>
                                                <td width="20%" style="text-align: center; padding-top: 10px;padding-bottom: 10px; color: black;">
                                                    {{ ((float)$project->solution->hours) }}
                                                </td>
                                                <td width="20%" style="text-align: center; padding-top: 10px;padding-bottom: 10px; color: black;">
                                                    {{ number_format(((float)$project->solution->cost),2) }}
                                                </td>
                                                <td width="5%" style="padding-top: 10px;padding-bottom: 10px">&nbsp;</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </tr>
                                    </thead>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                @php
                    $i++;
                @endphp
            @endif
            <div style="padding: 0; margin: 0;">
                <table width="100%" style="color: #153147" border="0">
                    <tbody>
                    <tr>
                        <td colspan="7">
                            <table width="100%" style="color: #153147" border="0">
                                <tbody>
                                <tr>
                                    <table width="100%">
                                        <tbody style="padding-top: 20px;">
                                        <tr>
                                            <td width="5%" style="padding-top: 10px;padding-bottom: 10px">&nbsp;</td>
                                            <td width="50%" style="padding-top: 10px;padding-bottom: 10px; color: #0c283c; padding-left: 20px;">{{ $project->name }}</td>
                                            <td width="20%" style="text-align: center;padding-top: 10px;padding-bottom: 10px; color: #0c283c;">
                                                {{ ((float)$project->total_hours) }}
                                            </td>
                                            <td width="20%" style="text-align: center;padding-top: 10px;padding-bottom: 10px; color: #0c283c;">
                                                {{ number_format(((float)$project->total_cost),2) }}
                                            </td>
                                            <td width="5%" style="padding-top: 10px;padding-bottom: 10px">&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            @php
                $productTemp = $product->id;
            @endphp
            @php
                $solutionTemp = $solution->id;
            @endphp
            @php
                $i++;
            @endphp
        @endforeach
    @endforeach
@endforeach
<div class="page-break"></div>

{{-- Pricing summary --}}
<div class="slide-header">
    <h1 style="padding-top: 50px; padding-left: 50px; font-weight: 500; font-size: 36px;">Pricing Summary</h1>
</div>
<div class="container" style="padding: 0; margin: 0;">
    <table width="100%" style="color: #153147">
        <thead>
            <tr style="height: 80px; background-color: #dcdcdc; font-weight: 400; font-size: 14px;">
                <td width="5%">&nbsp;</td>
                <td  width="30%"> SELECTED MODULE / TASKS</td>
                <td style="text-align: center">&nbsp;</td>
                <td style="text-align: center; padding-left: 20px;"> TASKS</td>
                <td style="text-align: center; padding-left: 20px;"> TOTAL HOURS</td>
                <td style="text-align: center; padding-left: 20px;"> COST (USD)</td>
                <td width="5%">&nbsp;</td>
            </tr>
        </thead>
        <div class="container" >
            <tbody>
            @foreach($quote->products()->where('status',true)->get() as $product)
                <tr style="height: 70px; font-size: 15px;">
                    <td width="5%">&nbsp;</td>
                    <td style="border-bottom: 1px solid #eef0f2; padding-left: 10px; font-weight: 500; font-size: 18px">
                        {{ $product->name }}
                    </td>
                    <td style="text-align: center; border-bottom: 1px solid #eef0f2;">&nbsp;</td>
                    <td style="text-align: center; border-bottom: 1px solid #eef0f2;">
                        {{ $product->projects }}
                    </td>
                    <td style="text-align: center; border-bottom: 1px solid #eef0f2;">
                        {{ ((float)$product->hours) }}
                    </td>
                    <td style="text-align: center; border-bottom: 1px solid #eef0f2; font-weight: 500; font-size: 18px">
                        {{ number_format(((float)$product->cost),2) }}
                    </td>
                    <td width="5%">&nbsp;</td>
                </tr>
            @endforeach
            <tr style="height: 50px; font-weight: 500; font-size: 18px">
                <td width="10%">&nbsp;</td>
                <td colspan="2" style="background-color: #ddf1fe; padding-left: 10px;">
                    Total
{{--                    Total (For 2 Countries and 3 Branches)--}}
                </td>
                <td style="text-align: center; background-color: #ddf1fe;">
                    {{ $quote->projects }}
                </td>
                <td style="text-align: center; background-color: #ddf1fe;">
                    {{ ((float)$quote->hours) }}
                </td>
                <td style="text-align: center; background-color: #ddf1fe;">
                    {{ number_format(((float)$quote->cost),2) }}
                </td>
                <td width="10%">&nbsp;</td>
            </tr>
            @if ($quote->discount != 0)
                <tr style="height: 50px; font-weight: 500; font-size: 18px">
                    <td width="10%">&nbsp;</td>
                    <td colspan="2" style="background-color: #edf2f8; padding-left: 10px;">
                        Discount
                    </td>
                    <td colspan="2" style="text-align: center; background-color: #edf2f8;"></td>
                    <td style="text-align: center; background-color: #edf2f8;">
                        {{ $quote->discount }}&nbsp;%
                    </td>
                    <td width="10%">&nbsp;</td>
                </tr>
                <tr style="height: 50px; font-weight: 500; font-size: 18px">
                    <td width="10%">&nbsp;</td>
                    <td colspan="2" style="background-color: #edf2f8; padding-left: 10px;">
                        Discount Amount
                    </td>
                    <td colspan="2" style="text-align: center; background-color: #edf2f8;"></td>
                    <td style="text-align: center; background-color: #edf2f8;">
                        ( {{ number_format($quote->discount_amount,2) }} )
                    </td>
                    <td width="10%">&nbsp;</td>
                </tr>
                <tr style="height: 50px; font-weight: 500; font-size: 18px">
                    <td width="10%">&nbsp;</td>
                    <td colspan="4" style="background-color: #ddf1fe; padding-left: 10px;">
                        Total Project Cost after Discount
                    </td>
                    <td style="text-align: center; background-color: #ddf1fe;">
                        {{ number_format($quote->total_cost,2) }}
                    </td>
                    <td width="10%">&nbsp;</td>
                </tr>
            @endif
            </tbody>
        </div>
    </table>
</div>
<div class="page-break"></div>

@if($quote->discount_note != null)
    <div class="slide-header">
        <h1 style="padding-top: 50px; padding-left: 50px; font-weight: 500; font-size: 36px;">Notes</h1>
    </div>
    <div style="word-wrap: break-word; overflow-wrap: break-word; hyphens: auto; margin: 30px 40px 20px 30px; line-height: 26px;  font-weight: 400; font-size: 13px">
        {{ $quote->discount_note }}
    </div>
@endif

@php
    $i = 0;
@endphp
@foreach(\App\Models\Term::all() as $term)
    @if ($i%24 == 0)
        <div class="page-break"></div>
        <div class="slide-header">
            <h1 style="padding-top: 50px; padding-left: 50px; font-weight: 500; font-size: 36px;">Terms and Conditions</h1>
        </div>
    @endif
    <ul>
        @php
            $i++;
        @endphp
        <li style="padding-left: 10px; margin-top: 20px; margin-bottom:20px; font-weight: 400; font-size: 15px">{{ $term->title }}
            <ul>
                @foreach($term->content as $content)
                    @php
                        $i++;
                    @endphp
                    <li style="height: 20px; font-size: 15px; font-weight: normal; margin-top: 8px; ">{{ $content['condition'] }}</li>
                @endforeach
            </ul>
        </li>
    </ul>
@endforeach
<div class="page-break"></div>

{{--    Last page--}}
<div class="pdf-end-background">
    <div class="page-break"></div>
</div>
</body>
</html>
