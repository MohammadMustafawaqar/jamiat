<div class="d-flex justify-content-between">
    <img src="{{asset('logo.png')}}" alt="LGO" height="90">
    <div class="text-center">
        <h2>{{__('lang.ministry')}}</h2>
        <h3>{{__('lang.directorate')}}</h3>
        <h3>{{__('lang.fee_office')}}</h3>
    </div>
    <img src="{{asset('logo.png')}}" alt="LGO" height="90">
</div>
<div class="table-responsive">
    <table class="table table-bordered">
        <tr>
            <th>{{__('lang.name')}}</th>
            <td>{{$topic->user->student->full_name}}</td>
            <td>{{__('lang.topic')}}</td>
        </tr>
        <tr>
            <th>{{__('lang.father_name')}}</th>
            <td>{{$topic->user->student->father_name}}</td>
            <td rowspan="2">{{$topic->title}}</td>
        </tr>
        <tr>
            <th>{{__('lang.grand_father_name')}}</th>
            <td>{{$topic->user->student->grand_father_name}}</td>
            {{-- <td colspan="2"></td> --}}
        </tr>
    </table>
</div>

<div class="d-flex justify-content-between">
    <div class="border p-4">{{__('lang.fee')}}: {{$topic->fee->amount}} افغانۍ</div>
    <div class="border p-1">
        <br>
        <br>
        <hr style="border:1px solid black;width:160px;">
    </div>
</div>