<html>

<div>
  <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');

  console.log({{ Js::from($facility->popular_times->groupBy('day_of_week')[0]->pluck('occupancy_percentage')) }});

  var popular_times = {{ Js::from($facility->popular_times->groupBy('day_of_week')) }};

  console.log(popular_times);

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: Object.keys(popular_times[0]),
      datasets: [{
        label: '# of Votes',
        data: {{ Js::from($facility->popular_times->groupBy('day_of_week')[1]->pluck('occupancy_percentage')) }},
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

</html>