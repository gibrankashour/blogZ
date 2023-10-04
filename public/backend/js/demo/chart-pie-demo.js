$(function () {
  // Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#858796';

  $.ajax({url: "http://localhost/blogz/public/api/pie-chart", type: 'GET', success: function(result){

    // Pie Chart Example
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: result.labels,
        datasets: [{
          data: result.data,
          backgroundColor: ['#4e73df', '#f6c23e', '#36b9cc'],
          hoverBackgroundColor: ['#2e59d9', '#e3b33a', '#2c9faf'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },

        cutoutPercentage: 80,
      },
    });
    
    },error :function(){
      // Pie Chart Example
      var ctx = document.getElementById("myPieChart");
      var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ["Failed to connect to server"],
          datasets: [{
            data: [1],
            backgroundColor: ['#e74a3b'],
            hoverBackgroundColor: ['#ff4230'],
            hoverBorderColor: "rgba(255, 66, 48, 1)",
          }],
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
          },
          
          cutoutPercentage: 80,
        },
      });
  }});

});
