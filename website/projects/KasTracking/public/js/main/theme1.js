$(function(e){
    'use strict'  
      /*sparkline*/
      var randomizeArray = function (arg) {
          var array = arg.slice();
          var currentIndex = array.length,
          temporaryValue, randomIndex;
          while (0 !== currentIndex) {
              randomIndex = Math.floor(Math.random() * currentIndex);
              currentIndex -= 1;
  
              temporaryValue = array[currentIndex];
              array[currentIndex] = array[randomIndex];
              array[randomIndex] = temporaryValue;
          }
          return array;
      }
  
      /*----simplebar2 JS ----*/
          var scrollbar3 = document.getElementById('scrollbar3')
          new SimpleBar(scrollbar3);
      /*-----simplebar2 JS -----*/
      
  
});


function reportChart(dataX, dataPemasukan, dataPengeluaran, chartElement){
  var chartdata = [
    {
        name: 'Pemasukan',
        type: 'line',
        smooth:true,
        data: dataPemasukan,
        itemStyle: {
            normal: { barBorderRadius: [50 ,50, 0 ,0],
                    color: new echarts.graphic.LinearGradient(
                        0, 0, 0, 1,
                        [
                            {offset: 0, color: '#38CB89'},
                            {offset: 1, color: '#38CB89'}
                        ]
                    )
            }
        },
    },
    {
        name: 'Pengeluaran',
        type: 'line',
        smooth:true,
        data: dataPengeluaran,
        itemStyle: {
            normal: { barBorderRadius: [50 ,50, 0 ,0],
                    color: new echarts.graphic.LinearGradient(
                        0, 0, 0, 1,
                        [
                            {offset: 0, color: '#EF4B4B'},
                            {offset: 1, color: '#EF4B4B'}

                        ]
                    )
            }
        },
    }
  ];
  var chart = document.getElementById(chartElement);
  var barChart = echarts.init(chart);
  var option = {
      grid: {
        top: '6',
        right: '0',
        bottom: '17',
      },
      xAxis: {
        data: dataX,
        axisLine: {
          lineStyle: {
            color: 'rgba(67, 87, 133, .09)'
          }
        },
        axisLabel: {
          fontSize: 10,
          color: '#8e9cad',
          margin: 5
        }
      },
      tooltip: {
          show: true,
          showContent: true,
          alwaysShowContent: true,
          triggerOn: 'mousemove',
          trigger: 'axis',
          axisPointer:
          {
              label: {
                  show: false,
              }
          }
      },
      yAxis: {
        splitLine: {
          lineStyle: {
            color: 'rgba(67, 87, 133, .09)'
          }
        },

        axisLine: {
          lineStyle: {
            color: 'rgba(67, 87, 133, .09)'
          }
        },

        axisLabel: {
          fontSize: 10,
          color: '#8e9cad',
        },
      },

      series: chartdata,
  };
  barChart.setOption(option);
}