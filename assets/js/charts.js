// Visitors Chart (Doughnut)
new Chart(document.getElementById('visitorsChart'), {
  type: 'doughnut',
  data: {
    labels: ['Organic', 'Social', 'Direct'],
    datasets: [{
      data: [80, 60, 50],
      backgroundColor: ['#00ffc3','#007bff','#a020f0'],
    }]
  },
  options: { plugins: {legend:{labels:{color:'#fff'}}} }
});

// Revenue Chart (Bar)
new Chart(document.getElementById('revenueChart'), {
  type: 'bar',
  data: {
    labels: ['Jan','Feb','Mar','Apr','May','Jun'],
    datasets: [{
      label: 'Revenue',
      data: [50,60,80,40,70,90],
      backgroundColor:'#00ffc3'
    }]
  },
  options: { scales: {x:{ticks:{color:'#fff'}}, y:{ticks:{color:'#fff'}}} }
});

// Tasks Chart (Line)
new Chart(document.getElementById('tasksChart'), {
  type: 'line',
  data: {
    labels: ['Jan1','Jan16','Jan31','Feb8','Feb24'],
    datasets: [{
      label: 'Tasks',
      data: [100,200,150,220,180],
      borderColor:'#00ffc3',
      backgroundColor:'#00ffc355',
      fill:true,
      tension:0.3
    }]
  },
  options: { scales: {x:{ticks:{color:'#fff'}}, y:{ticks:{color:'#fff'}}} }
});
