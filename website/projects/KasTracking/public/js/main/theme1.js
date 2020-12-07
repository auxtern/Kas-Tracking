$(function(e){
    'use strict'
  
      /* E-chart */
      var chartdata = [
          {
              name: 'Pemasukan',
              type: 'line',
              smooth:true,
              data: [100, 200, 300, 200, 100, 100, 200, 300, 400, 500, 100, 200, 800, 160],
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
              data: [90, 170, 190, 220, 170, 110, 190, 200, 170, 190, 250, 170, 110, 190],
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
      var chart = document.getElementById('echart1');
      var barChart = echarts.init(chart);
      var option = {
          grid: {
            top: '6',
            right: '0',
            bottom: '17',
            left: '25',
          },
          xAxis: {
            data: [ 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            axisLine: {
              lineStyle: {
                color: 'rgba(67, 87, 133, .09)'
              }
            },
            axisLabel: {
              fontSize: 10,
              color: '#8e9cad'
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
              color: '#8e9cad'
            }
          },
          series: chartdata,
          color:[ '#ef6430', '#2205bf']
      };
      barChart.setOption(option);
      /* E-chart */
  
  
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