/* global Chart:false */

$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

  var $salesChart = $('#sales-chart')
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          data: [1000, 2000, 3000, 2500, 2700, 2500, 3000]
        },
        {
          backgroundColor: '#ced4da',
          borderColor: '#ced4da',
          data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              return '$' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })

  var $visitorsChart = $('#visitors-chart')
  // eslint-disable-next-line no-unused-vars
  function getRandomNumber(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
  }

  function generateRandomNumbers(quantity, min, max) {
      const randomNumbers = [];
      for (let i = 0; i < quantity; i++) {
          randomNumbers.push(getRandomNumber(min, max));
      }
      return randomNumbers;
  }

  const randomNumbers = generateRandomNumbers(7, 50, 200);
  const randomNumbers2 = generateRandomNumbers(7, 50, 200);

  function sumArray(array) {
      return array.reduce((accumulator, currentValue) => accumulator + currentValue, 0);
  }

  function compareSumsAndCalculatePercentage(array1, array2) {
      const sum1 = sumArray(array1);
      const sum2 = sumArray(array2);

      const sum1s = sum1 + sum2;
      const difference = sum1 - sum2;
      const percentage = ((sum1 / sum2) * 100)-100;
      

      return { sum1s, difference, percentage: percentage.toFixed(2)  };
  }
  const result = compareSumsAndCalculatePercentage(randomNumbers, randomNumbers2);
  
  function Visitors(valor){
    const soma1 = valor.sum1s;
    const difference = valor.difference;
    const percentage = valor.percentage;
    $('#nisit').text(soma1);
    if(difference<0){
      $('#visitdown').html(`<i class="fas fa-arrow-down"></i> ${percentage}%`);
      $("#visitup").remove();
    }else if(difference>0){
      $("#visitup").html(`<i class="fas fa-arrow-up"></i> ${percentage}%`);
      $("#visitdown").remove();
    }else{

    }
    
  }
  Visitors(result);
  console.log(result);

  var visitorsChart = new Chart($visitorsChart, {
    data: {
      labels: ['Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        type: 'line',
        data: randomNumbers,
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        pointBorderColor: '#007bff',
        pointBackgroundColor: '#007bff',
        fill: false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      },
      {
        type: 'line',
        data: randomNumbers2,
        backgroundColor: 'tansparent',
        borderColor: '#ced4da',
        pointBorderColor: '#ced4da',
        pointBackgroundColor: '#ced4da',
        fill: false
        // pointHoverBackgroundColor: '#ced4da',
        // pointHoverBorderColor    : '#ced4da'
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: 200
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
})

// lgtm [js/unused-local-variable]
