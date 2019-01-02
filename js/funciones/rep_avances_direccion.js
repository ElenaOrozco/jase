$(document).ready(function(){ 
  generar_grafica();
  //general_grafica_general();
});

function generar_grafica(){
    console.log(retorno);
    j= 0
    var direcciones = new Array()
    var entregados_totales = new Array()
    var entregados_obligados = new Array()
    var preregistrados = new Array()
    $.each(retorno, function(i, item) {
        console.log(item);
        console.log(item.Abreviatura);
        console.log(item.entregados_totales);
        console.log(item.entregados_obligados);
        direcciones[j] = item.Abreviatura
        entregados_totales[j] = item.entregados_totales
        entregados_obligados[j] = item.entregados_obligados
        preregistrados[j] = item.preregistrados_direccion
        j++;
    });
    
    console.log(direcciones)
    console.log(entregados_totales)
    console.log(entregados_obligados)
    
    var popCanvas = document.getElementById("popChart");
    Chart.defaults.global.defaultFontFamily = "Lato";
    Chart.defaults.global.defaultFontSize = 18;
    Chart.defaults.global.defaultFontColor = 'blue';
    
    
    

    var totalesData = {
      label: 'Recibidos',
      data: entregados_totales,
      backgroundColor: 'rgba(255, 99, 132, 0.6)',
      borderWidth: 0,
      yAxisID: "y-axis-totales"
    };

    var obligadosData = {
      label: 'Recibidos Obligados',
      data: entregados_obligados,
      backgroundColor: 'rgba(54, 162, 235, 0.6)',
      borderWidth: 0,
      yAxisID: "y-axis-totales"
    };
    
    var preData = {
      label: 'Preregistrados',
      data: preregistrados,
      backgroundColor: 'rgba(193,46,12,0.2)',
      borderWidth: 0,
      yAxisID: "y-axis-totales"
    };

    var direccionesData = {
      labels: direcciones,
      datasets: [preData,totalesData, obligadosData]
    };

    var chartOptions = {
      scales: {
        xAxes: [{
          barPercentage: 1,
          categoryPercentage: 1
        }],
        yAxes: [{
          id: "y-axis-totales"
        }, {
          id: "y-axis-totales"
        }, {
          id: "y-axis-totales"
        }]
      }
    };

    var barChart = new Chart(popCanvas, {
    type: 'bar',
    data: direccionesData,
    options: chartOptions
});
}


function generar_grafica_general(){
    console.log(retorno);
    j= 0
    var direcciones = new Array()
    var entregados_totales = new Array()
    var entregados_obligados = new Array()
    var por_entregar = newArray()
    $.each(retorno, function(i, item) {
        console.log(item);
        console.log(item.Abreviatura);
        console.log(item.entregados_totales);
        console.log(item.entregados_obligados);
        direcciones[j] = item.Abreviatura
        entregados_totales[j] = item.entregados_totales
        entregados_obligados[j] = item.entregados_obligados
        por_entregar[j] = item.por_entregar
        j++;
    });
    
    console.log(direcciones)
    console.log(entregados_totales)
    console.log(entregados_obligados)
    
    var popCanvas = document.getElementById("popChart");
    Chart.defaults.global.defaultFontFamily = "Lato";
    Chart.defaults.global.defaultFontSize = 18;
    Chart.defaults.global.defaultFontColor = 'blue';
    
    
    

    var totalesData = {
      label: 'Total Entregados',
      data: entregados_totales,
      backgroundColor: 'rgba(255, 99, 132, 0.6)',
      borderWidth: 0,
      yAxisID: "y-axis-totales"
    };

    var obligadosData = {
      label: 'Entregados Responsables',
      data: entregados_obligados,
      backgroundColor: 'rgba(54, 162, 235, 0.6)',
      borderWidth: 0,
      yAxisID: "y-axis-totales"
    };
    
    var generalData = {
      label: 'Total a Entregar',
      data: entregados_obligados,
      backgroundColor: 'rgba(54, 162, 235, 0.6)',
      borderWidth: 0,
      yAxisID: "y-axis-totales"
    };

    var direccionesData = {
      labels: direcciones,
      datasets: [totalesData, obligadosData, generalData]
    };

    var chartOptions = {
      scales: {
        xAxes: [{
          barPercentage: 1,
          categoryPercentage: 1
        }],
        yAxes: [{
          id: "y-axis-totales"
        }, {
          id: "y-axis-totales"
        }, {
          id: "y-axis-totales"
        }]
      }
    };

    var barChart = new Chart(popiCanvas, {
    type: 'bar',
    data: direccionesData,
    options: chartOptions
});
}