$(document).ready(function() {
  // Set the interval at which to fetch the data (in milliseconds)
  var interval = 5000;

  // Function to fetch the data for the first graph
  function fetchData1() {
    $.ajax({
      url: 'https://cloud.fatturapro.click/junior2023/graph1',
      dataType: 'json',
      headers: {
        'Authorization': 'Bearer ' + sessionStorage.getItem('token')
      },
      success: function(data) {
        // Plot the data on the first graph using a JavaScript library like D3.js or Highcharts
        plotData1(data);
      }
    });
  }

  // Function to fetch the data for the second graph
  function fetchData2() {
    $.ajax({
      url: 'https://cloud.fatturapro.click/junior2023/graph2',
      dataType: 'json',
      headers: {
        'Authorization': 'Bearer ' + sessionStorage.getItem('token')
      },
      success: function(data) {
        // Plot the data on the second graph using a JavaScript library like D3.js or Highcharts
        plotData2(data);
      }
    });
  }

  // Schedule the data fetching functions to run at the specified interval
  setInterval(fetchData1, interval);
  setInterval(fetchData2, interval);
});
