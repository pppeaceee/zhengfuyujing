// Chart.js scripts
// -- Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';
// -- Area Chart Example
var keys = [];
var datas = [];
$.ajax({
  url:"admin.php?controller=admin&method=warnData",
  async:false,
  type:'post',
  success:function(data){
    var data = JSON.parse(data);
    for(key in data){
      keys.push(key);
      datas.push(data[key]);
    }
  }
});
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: [keys[0], keys[1], keys[2], keys[3], keys[4], keys[5], keys[6], keys[7], keys[8], keys[9], keys[10], keys[11]],
    datasets: [{
      label: "数据量",
      lineTension: 0.3,
      backgroundColor: "rgba(2,117,216,0.2)",
      borderColor: "rgba(2,117,216,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 20,
      pointBorderWidth: 2,
      data: [datas[0], datas[1], datas[2], datas[3], datas[4], datas[5], datas[6], datas[7], datas[8], datas[9], datas[10], datas[11]],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 30000,
          maxTicksLimit: 5
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
// -- Bar Chart Example
var user_keys = [];
var user_datas = [];
$.ajax({
  url:"admin.php?controller=admin&method=userData",
  async:false,
  type:'post',
  success:function(data){
    var data = JSON.parse(data);
    for(key in data){
      user_keys.push(key);
      user_datas.push(data[key]);
    }
  }
});
var ctx = document.getElementById("myBarChart");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: [user_keys[0], user_keys[1], user_keys[2], user_keys[3], user_keys[4], user_keys[5],user_keys[6]],
    datasets: [{
      label: "浏览量",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
      data: [user_datas[0], user_datas[1], user_datas[2], user_datas[3], user_datas[4], user_datas[5],user_datas[6]],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 6
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 1000,
          maxTicksLimit: 5
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
// -- Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ["Blue", "Red", "Yellow", "Green"],
    datasets: [{
      data: [12.21, 15.58, 11.25, 8.32],
      backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745'],
    }],
  },
});
