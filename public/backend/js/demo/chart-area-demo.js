$(function () {
  // Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#858796';

  let colors = ['rgba(78, 115, 223, 1)', 'rgba(246, 194, 62, 1)'];
  let colorsOpcity = ['rgba(78, 115, 223, 0.2)', 'rgba(246, 194, 62, 0.2)'];
  

  $.ajax({url: "http://localhost/blogz/public/api/area-chart/week", type: 'GET', success: function(result){
    let datasets = [];
    result.datasets.forEach(function(currentValue, index){      
      datasets.push({
        label: currentValue.label,
        lineTension: 0.3,
        backgroundColor: colorsOpcity[index],
        borderColor: colors[index],
        pointRadius: 3,
        pointBackgroundColor: colors[index],
        pointBorderColor: colors[index],
        pointHoverRadius: 3,
        pointHoverBackgroundColor: colors[index],
        pointHoverBorderColor: colors[index],
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: currentValue.data,
      });
    });
      var ctx = document.getElementById("myAreaChart");
      var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: result.labels,
          datasets: datasets},
      });      
  },error :function(){
      var ctx = document.getElementById("myAreaChart");
      var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
            label: "Failed to connect to server",
            lineTension: 0.3,
            backgroundColor: "rgba(231, 74, 59, 0.05)",
            borderColor: "rgba(231, 74, 59, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(231, 74, 59, 1)",
            pointBorderColor: "rgba(231, 74, 59, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(231, 74, 59, 1)",
            pointHoverBorderColor: "rgba(231, 74, 59, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
          }]},
      });
  }});

  $('.area-chart-options a').on('click', function(event) {
      event.preventDefault();
      $(this).addClass('active').siblings().removeClass('active');
      $('.chart-area').html('<canvas id="myAreaChart"></canvas>');

      var timescale = 'http://localhost/blogz/public/api/area-chart/' + $(this).data('time');

      $.ajax({url: timescale, type: 'GET', success: function(result){
        let datasets = [];
        result.datasets.forEach(function(currentValue, index){      
          datasets.push({
            label: currentValue.label,
            lineTension: 0.3,
            backgroundColor: colorsOpcity[index],
            borderColor: colors[index],
            pointRadius: 3,
            pointBackgroundColor: colors[index],
            pointBorderColor: colors[index],
            pointHoverRadius: 3,
            pointHoverBackgroundColor: colors[index],
            pointHoverBorderColor: colors[index],
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: currentValue.data,
          });
        });
          var ctx = document.getElementById("myAreaChart");
          var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: result.labels,
              datasets: datasets},
          });      
      },error :function(){
          var ctx = document.getElementById("myAreaChart");
          var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
              datasets: [{
                label: "Failed to connect to server",
                lineTension: 0.3,
                backgroundColor: "rgba(231, 74, 59, 0.05)",
                borderColor: "rgba(231, 74, 59, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(231, 74, 59, 1)",
                pointBorderColor: "rgba(231, 74, 59, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(231, 74, 59, 1)",
                pointHoverBorderColor: "rgba(231, 74, 59, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
              }]},
          });
      }});
    }); 

});
