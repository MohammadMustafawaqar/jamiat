@extends('layouts.app')
@section('title','Dashboard')
@section('content')
<div class="app-title">
    <div>
        <h1><i class="bi bi-speedometer"></i> {{__('lang.dashboard')}}</h1>
        {{-- <p>Start a beautiful journey here</p> --}}
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        <li class="breadcrumb-item"><a href="#">{{__('lang.dashboard')}}</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-lg-6 col-xl-3">
        <div class="widget-small primary coloured-icon animate__animated animate__bounceInLeft"><i
                class="icon bi bi-people fs-1"></i>
            <div class="info">
                <h4>{{__('lang.user')}}</h4>
                <p><b class="counter" data-target="{{App\Models\User::count()}}" data-duration="1000">0</b></p>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-3">
        <div class="widget-small info coloured-icon animate__animated animate__bounceInUp"><i
                class="icon bi bi-house-check-fill fs-1"></i>
            <div class="info">
                <h4>{{__('lang.schools')}}</h4>
                <p><b class="counter" data-target="{{App\Models\School::count()}}" data-duration="1000">0</b></p>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-3">
        <div class="widget-small warning coloured-icon animate__animated animate__bounceInDown"><i
                class="icon bi bi-people fs-1"></i>
            <div class="info">
                <h4>{{__('lang.students')}}</h4>
                <p><b class="counter" data-target="{{App\Models\Student::count()}}" data-duration="1000">0</b></p>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-3">
        <div class="widget-small danger coloured-icon animate__animated animate__bounceInRight"><i
                class="icon bi bi-diagram-3 fs-1"></i>
            <div class="info">
                <h4>{{__('lang.categories')}}</h4>
                <p><b class="counter" data-target="{{App\Models\Category::count()}}" data-duration="1000">0</b></p>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="bg-white" id="pieChart" style="height: 400px;"></div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('admin/js/echarts.min.js')}}"></script>
<script type="text/javascript">
    var chartDom = document.getElementById('pieChart');
    var myChart = echarts.init(chartDom);
    var option = {
        tooltip: {
            trigger: 'item'
        },
        legend: {
            top: '5%',
            left: 'center'
        },
        series: [
            {
            name: 'Access From',
            type: 'pie',
            radius: ['40%', '70%'],
            avoidLabelOverlap: false,
            itemStyle: {
                borderRadius: 10,
                borderColor: '#fff',
                borderWidth: 2
            },
            label: {
                show: false,
                position: 'center'
            },
            emphasis: {
                label: {
                show: true,
                fontSize: 40,
                fontWeight: 'bold'
                }
            },
            labelLine: {
                show: false
            },
            data: {!! $chartData !!}
            }
        ]
    };
    myChart.setOption(option);



    // Function to animate counters
    function animateCounter(counterElement, targetValue, duration) {
        let currentValue = 0;
        const increment = targetValue / (duration / 10); // Calculate the increment step

        const counterInterval = setInterval(() => {
            currentValue += increment;
            if (currentValue >= targetValue) {
                currentValue = targetValue;
                clearInterval(counterInterval); // Stop the interval when target value is reached
            }
            counterElement.textContent = Math.floor(currentValue); // Update the displayed value
        }, 10); // Update every 10ms
    }

    // Automatically apply counter animation to all elements with the class 'counter'
    document.addEventListener('DOMContentLoaded', function () {
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const targetValue = parseInt(counter.getAttribute('data-target'));
            const duration = parseInt(counter.getAttribute('data-duration'));
            animateCounter(counter, targetValue, duration);
        });
    });
</script>
